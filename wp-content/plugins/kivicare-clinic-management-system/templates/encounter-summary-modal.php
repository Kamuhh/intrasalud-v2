<div class="kc-modal kc-modal-summary" role="dialog" aria-modal="true">
  <div class="kc-modal__dialog">
    <div class="kc-modal__header">
      <h3>Resumen de la atención</h3>
      <button type="button" class="kc-modal__close js-kc-summary-close" aria-label="Cerrar">×</button>
    </div>

    <div class="kc-modal__body">
      <section class="kc-card">
        <div class="kc-card__header">Detalles del paciente</div>
        <div class="kc-card__body">
          <div class="kc-grid kc-grid-3">
            <div><strong>Nombre:</strong> <?= esc_html($patient['name'] ?? '') ?></div>
            <div><strong>C.I.:</strong> <?= esc_html($patient['dni'] ?? '') ?></div>
            <div><strong>Correo:</strong> <?= esc_html($patient['email'] ?? '') ?></div>
            <div><strong>Género:</strong> <?= esc_html($patient['gender'] ?? '') ?></div>
            <div><strong>Fecha de nacimiento:</strong> <?= esc_html($patient['dob'] ?? '') ?></div>
          </div>
        </div>
      </section>

      <section class="kc-card">
        <div class="kc-card__header">Detalles de la consulta</div>
        <div class="kc-card__body">
          <div class="kc-grid kc-grid-3">
            <div><strong>Fecha:</strong> <?= esc_html($encounter['encounter_date'] ?? $encounter['date'] ?? '') ?></div>
            <div><strong>Clínica:</strong> <?= esc_html($clinic['name'] ?? '') ?></div>
            <div><strong>Doctor:</strong> <?= esc_html($doctor['name'] ?? '') ?></div>
            <div class="kc-grid-span-3"><strong>Descripción:</strong> <?= esc_html($encounter['description'] ?? '') ?></div>
          </div>
        </div>
      </section>

      <section class="kc-card">
        <div class="kc-card__header">Diagnóstico(s)</div>
        <div class="kc-card__body">
          <?php if (!empty($diagnoses)) : ?>
            <ul class="kc-list">
              <?php foreach ($diagnoses as $d): ?>
                <li><?= esc_html(($d['code'] ?? '') . (isset($d['name']) ? ' - '.$d['name'] : '')) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?><p class="kc-empty">No se encontraron registros</p><?php endif; ?>
        </div>
      </section>

      <section class="kc-card">
        <div class="kc-card__header">Órdenes clínicas</div>
        <div class="kc-card__body">
          <?php if (!empty($orders)) : ?>
            <ul class="kc-list">
              <?php foreach ($orders as $o): ?>
                <li><?= esc_html($o['name'] ?? '') ?><?php if(isset($o['note'])) echo ' — '.esc_html($o['note']); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?><p class="kc-empty">No se encontraron registros</p><?php endif; ?>
        </div>
      </section>

      <section class="kc-card">
        <div class="kc-card__header">Indicaciones</div>
        <div class="kc-card__body">
          <?php if (!empty($indications)) : ?>
            <ul class="kc-list"><?php foreach ($indications as $i): ?><li><?= esc_html($i['text'] ?? '') ?></li><?php endforeach; ?></ul>
          <?php else: ?><p class="kc-empty">No se encontraron registros</p><?php endif; ?>
        </div>
      </section>

      <section class="kc-card">
        <div class="kc-card__header">Receta médica</div>
        <div class="kc-card__body">
          <?php if (!empty($prescriptions)) : ?>
            <table class="kc-table">
              <thead><tr><th>Nombre</th><th>Frecuencia</th><th>Duración</th></tr></thead>
              <tbody>
              <?php foreach ($prescriptions as $p): ?>
                <tr>
                  <td><?= esc_html($p['name'] ?? '') ?></td>
                  <td><?= esc_html($p['frequency'] ?? '') ?></td>
                  <td><?= esc_html($p['duration'] ?? '') ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?><p class="kc-empty">No se encontró receta</p><?php endif; ?>
        </div>
      </section>
    </div>

    <div class="kc-modal__footer">
      <button type="button" class="button button-secondary js-kc-summary-email"><span class="dashicons dashicons-email"></span> Correo electrónico</button>
      <button type="button" class="button button-secondary js-kc-summary-print"><span class="dashicons dashicons-print"></span> Imprimir</button>
      <button type="button" class="button button-primary js-kc-summary-close"><span class="dashicons dashicons-no"></span> Cerrar</button>
    </div>
  </div>
</div>
