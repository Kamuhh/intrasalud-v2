(function () {
  const G = window.kcGlobals || {};
  const hasREST = !!G.apiBase;
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';
  if (G.debug) console.log('[kc] boot; hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl);

  // --- Resolver encounter_id de forma robusta (DOM, URL, Performance API) ---
  function findEncounterId() {
    // 1) DOM directo
    const domIdEl = document.querySelector('[data-encounter-id]');
    if (domIdEl) return domIdEl.getAttribute('data-encounter-id');

    // 2) Controles ocultos comunes
    const hidden = document.querySelector('[name="encounter_id"], #encounter_id, input[data-name="encounter_id"]');
    if (hidden && hidden.value) return hidden.value;

    // 3) URL query (SPA a veces deja ?id= o ?encounter_id=)
    const qs = new URLSearchParams(window.location.search);
    if (qs.get('encounter_id')) return qs.get('encounter_id');
    if (qs.get('id')) return qs.get('id');

    // 4) Performance API: detectar las peticiones que carga la SPA
    try {
      const entries = performance.getEntriesByType('resource');
      for (let i = entries.length - 1; i >= 0; i--) {
        const n = entries[i].name || '';
        if (n.includes('admin-ajax.php')
            && (n.includes('patient_encounter_details')
                || n.includes('patient_bill_detail')
                || n.includes('prescription_list')
                || n.includes('get_patient_report'))) {
          const m = n.match(/[?&](encounter_id|id)=(\d+)/);
          if (m) return m[2];
        }
      }
    } catch (e) {}

    return null;
  }

  // --- Endpoints REST o admin-ajax (fallback) ---
  function endpoints() {
    if (hasREST) {
      return {
        summary: id => `${G.apiBase}/encounter/summary?encounter_id=${encodeURIComponent(id)}`,
        email:   () => `${G.apiBase}/encounter/summary/email`,
        headers: m => (m === 'GET')
          ? {'X-WP-Nonce': G.nonce}
          : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8','X-WP-Nonce': G.nonce}
      };
    }
    return {
      summary: id => `${ajaxUrl}?action=kc_encounter_summary&encounter_id=${encodeURIComponent(id)}`,
      email:   () => `${ajaxUrl}?action=kc_encounter_summary_email`,
      headers: () => ({'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'})
    };
  }
  const EP = endpoints();

  // --- Inyección/enganche del botón ---
  function hookButton() {
    // 1) Si ya existe el botón "Resumen de atención" en la barra, lo enganchamos
    let summaryBtn = Array.from(document.querySelectorAll('button, a, [role="button"]'))
      .find(el => (el.textContent || '').toLowerCase().includes('resumen')
               && (el.textContent || '').toLowerCase().includes('atención'));

    if (!summaryBtn) {
      // 2) Si no existe, buscamos "Detalles de la factura" para clonar su contenedor y crear uno nuevo
      const billBtn = Array.from(document.querySelectorAll('button, a, [role="button"]'))
        .find(el => {
          const t = (el.textContent || '').toLowerCase();
          return t.includes('detalle') && t.includes('factura');
        });

      if (billBtn && !document.querySelector('.js-kc-open-summary')) {
        const b = document.createElement(billBtn.tagName.toLowerCase() === 'a' ? 'a' : 'button');
        b.type = 'button';
        b.className = (billBtn.className || '') + ' js-kc-open-summary';
        b.style.marginLeft = '6px';
        b.textContent = 'Resumen de atención';
        billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
        summaryBtn = b;
      }
    }

    // 3) Si lo tenemos, garantizamos la clase y data-id
    if (summaryBtn) {
      summaryBtn.classList.add('js-kc-open-summary');
      if (!summaryBtn.getAttribute('data-encounter-id')) {
        const id = findEncounterId();
        if (id) summaryBtn.setAttribute('data-encounter-id', id);
      }
    }

    // 4) Fallback extremo: si no pudimos ponerlo en la barra, creamos un botón fijo para depurar
    if (!document.querySelector('.js-kc-open-summary')) {
      const fixed = document.createElement('button');
      fixed.type = 'button';
      fixed.className = 'button button-primary js-kc-open-summary';
      fixed.textContent = 'Resumen de atención';
      fixed.style.position = 'fixed';
      fixed.style.right = '16px';
      fixed.style.bottom = '16px';
      fixed.style.zIndex = '999999';
      fixed.setAttribute('data-encounter-id', findEncounterId() || '');
      document.body.appendChild(fixed);
    }
  }

  function openSummary(id) {
    if (!id) id = findEncounterId();
    if (!id) { alert('No se pudo detectar el ID del encuentro'); return; }

    if (G.debug) console.log('[kc] openSummary id=', id, 'url=', EP.summary(id));
    fetch(EP.summary(id), { credentials: 'include', headers: EP.headers('GET') })
      .then(r => r.json())
      .then(json => {
        if (!json || json.status !== 'success' || !json.data || !json.data.html) {
          alert((json && json.message) || 'No se pudo cargar');
          if (G.debug) console.warn('[kc] response:', json);
          return;
        }
        const old = document.querySelector('.kc-modal.kc-modal-summary'); if (old) old.remove();
        const wrap = document.createElement('div'); wrap.innerHTML = json.data.html; document.body.appendChild(wrap);

        wrap.querySelectorAll('.js-kc-summary-close').forEach(b => b.addEventListener('click', () => wrap.remove()));
        wrap.addEventListener('click', e => { if (e.target.classList.contains('kc-modal')) wrap.remove(); });
        document.addEventListener('keydown', function esc(e) { if (e.key === 'Escape') { wrap.remove(); document.removeEventListener('keydown', esc); } });

        const printBtn = wrap.querySelector('.js-kc-summary-print');
        if (printBtn) printBtn.addEventListener('click', () => {
          const node = wrap.querySelector('.kc-modal__dialog');
          const w = window.open('', '_blank'); if (!w) return;
          w.document.write('<html><head><title>Resumen de atención</title>');
          document.querySelectorAll('link[rel="stylesheet"]').forEach(l => w.document.write(l.outerHTML));
          w.document.write('</head><body>' + node.outerHTML + '</body></html>');
          w.document.close(); w.focus(); w.print();
        });

        const emailBtn = wrap.querySelector('.js-kc-summary-email');
        if (emailBtn) emailBtn.addEventListener('click', () => {
          const to = prompt('Correo de destino', ''); if (!to) return;
          fetch(EP.email(), {
            method: 'POST',
            credentials: 'include',
            headers: EP.headers('POST'),
            body: `encounter_id=${encodeURIComponent(id)}&to=${encodeURIComponent(to)}`
          })
            .then(r => r.json())
            .then(resp => { alert(resp && resp.status === 'success' ? 'Enviado' : (resp && resp.message) || 'No se pudo enviar'); })
            .catch(() => alert('Error de red'));
        });
      })
      .catch(() => alert('Error de red'));
  }

  // Delegación de eventos
  document.addEventListener('click', e => {
    const btn = e.target.closest('.js-kc-open-summary');
    if (btn) {
      e.preventDefault();
      const id = btn.getAttribute('data-encounter-id');
      openSummary(id);
    }
  });

  // Boot + observar cambios de la SPA
  function boot(){ hookButton(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(() => hookButton());
  mo.observe(document.documentElement, { childList: true, subtree: true });

  // Diagnóstico rápido
  window.kcSummaryDiag = function(){
    console.log('[kc] diag: hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl, 'encounterId=', findEncounterId());
    console.log('[kc] buttons:', document.querySelectorAll('.js-kc-open-summary').length);
  };
})();
