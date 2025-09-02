<?php
/** 
 * Esta plantilla genera un PDF en tamaño Carta
 * con membrete y pie repetidos. Se apoya en $payload
 * (asociativo) pasado desde el controlador, extraído por
 * kc_build_encounter_summary_payload().
 */
$P   = $payload;
$esc = fn($s) => esc_html((string)($s ?? ''));
$li  = fn($arr) => empty($arr) ? '<div class="muted">No se encontraron registros</div>'
                              : '<ul>'.implode('', array_map(fn($i) => '<li>'.$esc($i['title'] ?? '').'</li>', $arr)).'</ul>';
$rx  = function($arr) use ($esc) {
    if (empty($arr)) return '<div class="muted">No se encontró receta</div>';
    $rows = '';
    foreach ($arr as $r) {
        $rows .= '<tr><td>'.$esc($r['name'] ?? '').'</td><td>'.$esc($r['frequency'] ?? '').'</td><td>'.$esc($r['duration'] ?? '').'</td></tr>';
    }
    return '<table class="tbl"><thead><tr><th>Nombre</th><th>Frecuencia</th><th>Duración</th></tr></thead><tbody>'.$rows.'</tbody></table>';
};
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Resumen de la atención</title>
<style>
@page { size: letter; margin: 24mm 20mm 30mm 20mm; }
body { font-family: Arial, sans-serif; font-size: 12px; color:#222; margin:0; }
.header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6mm; }
.header .left { display:flex; align-items:flex-start; gap:10px; }
.header .logo img { height:40px; }
.header .clinic-meta { font-size:11px; color:#666; line-height:1.3; }
.title { text-align:center; font-size:20px; font-weight:700; margin-bottom:6mm; text-transform: uppercase; }
.section-title { font-weight:700; background:#f2f2f2; padding:6px; border-top:1px solid #ccc; border-bottom:1px solid #ccc; margin-top:8mm; }
.section-content { padding:6px 0; }
.tbl { width:100%; border-collapse:collapse; margin-top:4px; }
.tbl th,.tbl td { border:1px solid #ddd; padding:6px 8px; font-size:11px; }
.tbl th { background:#f6f6f6; }
.muted { color:#666; font-style:italic; }
.page-break { page-break-before:always; }
.footer { text-align:center; margin-top:12mm; font-size:11px; line-height:1.4; }
.footer .line { border-top:1px solid #ccc; width:220px; margin:0 auto 4px; }
</style>
</head>
<body>

<!-- Encabezado único -->
<div class="header">
  <div class="left">
    <?php if ($P['clinic']['logo']): ?>
      <div class="logo"><img src="<?php echo esc_url($P['clinic']['logo']); ?>" alt="Logo"></div>
    <?php endif; ?>
    <div class="clinic-meta">
      <strong><?php echo $esc($P['clinic']['name']); ?></strong><br>
      <?php echo $esc($P['clinic']['addr']); ?><br>
      Paciente: <?php echo $esc($P['patient']['name']); ?> &nbsp;&nbsp; C.I.: <?php echo $esc($P['patient']['dni']); ?>
    </div>
  </div>
  <div style="text-align:right;font-size:11px;">
    Fecha: <?php echo $esc($P['date']); ?><br>
    <?php echo $esc($P['patient']['email']); ?>
  </div>
</div>

<!-- Título principal -->
<div class="title">Resumen de la atención</div>

<!-- Sección: Detalles del paciente -->
<div class="section-title">DETALLES DEL PACIENTE</div>
<div class="section-content">
  <div style="display:flex; flex-wrap:wrap; gap:20px;">
    <div><strong>Nombre:</strong> <?php echo $esc($P['patient']['name']); ?></div>
    <div><strong>C.I.:</strong> <?php echo $esc($P['patient']['dni']); ?></div>
    <div><strong>Correo:</strong> <?php echo $esc($P['patient']['email']); ?></div>
  </div>
</div>

<!-- Sección: Detalles de la consulta -->
<div class="section-title">DETALLES DE LA CONSULTA</div>
<div class="section-content">
  <div style="display:flex; flex-wrap:wrap; gap:20px;">
    <div><strong>Fecha:</strong> <?php echo $esc($P['date']); ?></div>
    <div><strong>Clínica:</strong> <?php echo $esc($P['clinic']['name']); ?></div>
    <div><strong>Doctor:</strong> <?php echo $esc($P['doctor']['name']); ?></div>
  </div>
  <?php if(!empty($P['enc']['desc'])): ?>
    <div style="margin-top:4px;"><strong>Descripción:</strong> <span class="muted"><?php echo $esc($P['enc']['desc']); ?></span></div>
  <?php endif; ?>
</div>

<!-- Sección: Diagnósticos -->
<div class="section-title">DIAGNÓSTICOS</div>
<div class="section-content">
  <?php echo $li($P['diagnoses']); ?>
</div>

<!-- Sección: Indicaciones -->
<div class="section-title">INDICACIONES</div>
<div class="section-content">
  <?php echo $li($P['indications']); ?>
</div>

<!-- Sección: Receta médica -->
<div class="section-title">RECETA MÉDICA</div>
<div class="section-content">
  <?php echo $rx($P['prescriptions']); ?>
</div>

<!-- Segunda página: Órdenes clínicas -->
<div class="page-break"></div>
<div class="title">Órdenes clínicas</div>
<div class="section-content">
  <?php echo $li($P['orders']); ?>
</div>

<!-- Pie de página con firma -->
<div class="footer">
  <?php if ($P['doctor']['sign']): ?>
    <img src="<?php echo esc_url($P['doctor']['sign']); ?>" alt="Firma" style="height:55px;display:block;margin:0 auto 4px;">
  <?php endif; ?>
  <div class="line"></div>
  <div><?php echo $esc($P['doctor']['name']); ?></div>
  <?php if($P['doctor']['spec']): ?>
    <div style="color:#666;"><?php echo $esc($P['doctor']['spec']); ?></div>
  <?php endif; ?>
  <div style="color:#444;">
    <?php
      $cred = [];
      if ($P['doctor']['mpps']) $cred[] = 'MPPS: '.$P['doctor']['mpps'];
      if ($P['doctor']['cm'])   $cred[] = 'CM: '.$P['doctor']['cm'];
      if ($P['doctor']['ci'])   $cred[] = 'C.I. '.$P['doctor']['ci'];
      echo esc_html(implode(' · ', $cred));
    ?>
  </div>
</div>

</body>
</html>
