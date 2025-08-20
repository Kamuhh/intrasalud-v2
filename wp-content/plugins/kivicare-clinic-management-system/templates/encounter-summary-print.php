<?php
// Variables esperadas: ver helper kc_render_encounter_letter()
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resumen de la atención</title>
<style>
  @page { size: letter; margin: 18mm 16mm 18mm 16mm; }
  body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color:#222; }
  .header { display:flex; align-items:center; gap:16px; margin-bottom:10px; }
  .header img { height:36px; }
  .header .clinic small { display:block; font-size:10px; color:#666; }
  .date { text-align:right; font-size:11px; color:#666; margin-top:-18px; }
  h3 { margin:12px 0 6px; font-size:14px; }
  .card { border:1px solid #ddd; border-radius:6px; padding:10px 12px; margin:10px 0; }
  .grid { display:grid; grid-template-columns: 1fr 1fr 1fr; gap:8px 16px; }
  .row { display:flex; gap:16px; }
  .muted { color:#666; }
  ul { margin:6px 0 0 18px; }
  table { width:100%; border-collapse: collapse; font-size:12px; }
  th, td { border:1px solid #ddd; padding:6px 8px; }
  th { background:#f6f6f6; text-align:left; }
  .page-break { page-break-before: always; }
  .footer { margin-top:40px; text-align:center; font-size:11px; }
  .sign { height:55px; margin:6px auto 2px; display:block; }
</style>
</head>
<body>

  <!-- Encabezado -->
  <div class="header">
    <?php if(!empty($clinic_logo)): ?>
      <img src="<?php echo esc_url($clinic_logo); ?>" alt="logo">
    <?php else: ?>
      <strong><?php echo esc_html($clinic_name); ?></strong>
    <?php endif; ?>
    <div class="clinic">
      <strong><?php echo esc_html($clinic_name); ?></strong>
      <small><?php echo esc_html($clinic_addr); ?></small>
    </div>
  </div>
  <div class="date">Fecha: <?php echo esc_html($today); ?></div>
    <!-- Datos del paciente -->
  <div class="card">
    <h3>Detalles del paciente</h3>
    <div class="grid">
      <div><strong>Nombre:</strong> <?php echo esc_html($patient['name'] ?? ''); ?></div>
      <div><strong>C.I.:</strong> <?php echo esc_html($patient['dni'] ?? ''); ?></div>
      <div><strong>Correo:</strong> <?php echo esc_html($patient['email'] ?? ''); ?></div>
      <div><strong>Género:</strong> <?php echo esc_html($patient['gender'] ?? ''); ?></div>
      <div><strong>Fecha de nacimiento:</strong> <?php echo esc_html($patient['dob'] ?? ''); ?></div>
    </div>
  </div>


  <!-- Datos de la consulta -->
  <div class="card">
    <h3>Detalles de la consulta</h3>
     <div class="grid">
      <div><strong>Fecha:</strong> <?php echo esc_html($encounter['encounter_date'] ?? $encounter['date'] ?? ''); ?></div>
      <div><strong>Clínica:</strong> <?php echo esc_html($clinic['name'] ?? ''); ?></div>
      <div><strong>Doctor:</strong> <?php echo esc_html($doctor['name'] ?? ''); ?></div>
      <div class="row" style="grid-column:1/-1;"><strong>Descripción:</strong>&nbsp;<span class="muted"><?php echo esc_html($encounter['description'] ?? ''); ?></span></div>
    </div>
  </div>

<!-- Diagnósticos -->
  <div class="card">
    <h3>Diagnóstico(s)</h3>
    <?php if(!empty($diagnoses)): ?>
      <ul>
        <?php foreach($diagnoses as $d): ?>
          <li><?php echo esc_html($d['title'] ?? ''); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <div class="muted">No se encontraron registros</div>
    <?php endif; ?>
  </div>

  <!-- Indicaciones -->
  <div class="card">
    <h3>Indicaciones</h3>
    <?php if(!empty($indications)): ?>
      <ul>
        <?php foreach($indications as $i): ?>
          <li><?php echo esc_html($i['title'] ?? ''); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <div class="muted">No se encontraron registros</div>
    <?php endif; ?>
  </div>

  <!-- Receta -->
  <div class="card">
    <h3>Receta médica</h3>
    <?php if(!empty($prescriptions)): ?>
      <table>
        <thead><tr><th>Nombre</th><th>Frecuencia</th><th>Duración</th></tr></thead>
        <tbody>
          <?php foreach($prescriptions as $p): ?>
          <tr>
            <td><?php echo esc_html($p['name'] ?? ''); ?></td>
            <td><?php echo esc_html($p['frequency'] ?? ''); ?></td>
            <td><?php echo esc_html($p['duration'] ?? ''); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="muted">No se encontró receta</div>
    <?php endif; ?>
  </div>

  <!-- Página 2: Órdenes clínicas -->
  <div class="page-break"></div>

  <div class="card">
    <h3>Órdenes clínicas</h3>
    <?php if(!empty($orders)): ?>
      <ul>
        <?php foreach($orders as $o): ?>
          <li><?php echo esc_html($o['title'] ?? ''); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <div class="muted">No se encontraron registros</div>
    <?php endif; ?>
  </div>

  <!-- Pie con firma del doctor -->
  <div class="footer">
    <?php if(!empty($doctor_signature)): ?>
      <img class="sign" src="<?php echo esc_url($doctor_signature); ?>" alt="firma">
    <?php endif; ?>
    <strong><?php echo esc_html($doctor['name'] ?? ''); ?></strong><br>
    <?php if(!empty($doc_spec)): ?>
      <span class="muted"><?php echo esc_html($doc_spec); ?></span><br>
    <?php endif; ?>
    <?php
      $cred = array_filter([
        !empty($doc_mpps) ? 'MPPS: '.$doc_mpps : '',
        !empty($doc_cm)   ? 'CM: '.$doc_cm     : '',
        !empty($doc_ci)   ? 'C.I.: '.$doc_ci   : '',
      ]);
      if(!empty($cred)) echo '<span class="muted">'.esc_html(implode(' · ', $cred)).'</span>';
    ?>
  </div>

</body>
</html>
