(function () {
  const G = window.kcGlobals || {};
  const hasREST = !!(G.apiBase);
  const ajaxUrl = (G.ajaxUrl || '/wp-admin/admin-ajax.php');
  if (G.debug) console.log('[kc] boot; hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl);

  function endpoints() {
    if (hasREST) {
      return {
        summary: id => `${G.apiBase}/encounter/summary?encounter_id=${encodeURIComponent(id)}`,
        email:   () => `${G.apiBase}/encounter/summary/email`,
        headers: (m) => (m === 'GET') ? {'X-WP-Nonce': G.nonce} :
          {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8','X-WP-Nonce': G.nonce}
      };
    }
    return {
      summary: id => `${ajaxUrl}?action=kc_encounter_summary&encounter_id=${encodeURIComponent(id)}`,
      email:   () => `${ajaxUrl}?action=kc_encounter_summary_email`,
      headers: () => ({'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'})
    };
  }
  const EP = endpoints();

  function injectButtons() {
    document.querySelectorAll('.js-kc-open-summary').forEach(el => el.remove());

    const candidates = document.querySelectorAll('button, a');
    candidates.forEach(btn => {
      const label = (btn.textContent || '').toLowerCase();
      if (!label) return;

      // detectar "Detalles de la factura" de forma flexible
      if (label.includes('detalle') && label.includes('factura')) {
        const row = btn.closest('tr') || btn.parentElement;
        if (!row) return;

        let id =
          row.getAttribute('data-encounter-id') ||
          (row.querySelector('[data-encounter-id]') && row.querySelector('[data-encounter-id]').getAttribute('data-encounter-id')) ||
          (row.querySelector('[name="encounter_id"]') && row.querySelector('[name="encounter_id"]').value) ||
          (btn.getAttribute('data-encounter-id')) || '';

        if (!id && btn.href) {
          const m = btn.href.match(/[?&]encounter_id=(\d+)/);
          if (m) id = m[1];
        }
        if (!id) return;

        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'button button-secondary js-kc-open-summary';
        b.setAttribute('data-encounter-id', id);
        b.style.marginLeft = '6px';
        b.textContent = 'Resumen de atención';
        btn.parentNode.insertBefore(b, btn.nextSibling);
      }
    });
  }

  function openSummary(id) {
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

  document.addEventListener('click', e => {
    const btn = e.target.closest('.js-kc-open-summary');
    if (btn) { e.preventDefault(); const id = btn.getAttribute('data-encounter-id'); if (id) openSummary(id); }
  });

  function boot(){ injectButtons(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(() => injectButtons());
  mo.observe(document.documentElement, { childList: true, subtree: true });

  // Diagnóstico rápido
  window.kcSummaryDiag = function(){
    console.log('[kc] diag: hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl);
    console.log('[kc] buttons:', document.querySelectorAll('.js-kc-open-summary').length);
  };
})();
