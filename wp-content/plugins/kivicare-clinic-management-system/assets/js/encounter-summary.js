(function () {
  const G = window.kcGlobals || {};
  const hasREST = !!G.apiBase;
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';
  if (G.debug) console.log('[kc] boot; hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl);

  // === util: extraer ID de diversos strings (url, body, hash) ===
  function extractId(str) {
    if (!str) return null;
    let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i); if (m) return m[1];
    m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i);               if (m) return m[1];
    m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i);           if (m) return m[1];
    m = String(str).match(/\bid\s*=\s*(\d+)/i);                     if (m) return m[1];
    m = String(str).match(/(?:encounter|consulta|encuentro)[\/#=-]+(\d+)/i); if (m) return m[1];
    return null;
  }

  // === “recordamos” el último ID visto por XHR/fetch (SPA) ===
  window.__KC_LAST_ENCOUNTER_ID__ = window.__KC_LAST_ENCOUNTER_ID__ || null;
  (function hookXHRAndFetch(){
    try {
      const _open = XMLHttpRequest.prototype.open;
      const _send = XMLHttpRequest.prototype.send;
      XMLHttpRequest.prototype.open = function(method, url){ this.__kc_url = url; return _open.apply(this, arguments); };
      XMLHttpRequest.prototype.send = function(body){
        try { const id = extractId(this.__kc_url) || extractId(typeof body==='string'?body:''); if (id) window.__KC_LAST_ENCOUNTER_ID__ = id; } catch(e){}
        return _send.apply(this, arguments);
      };
      if (window.fetch) {
        const _fetch = window.fetch;
        window.fetch = function(input, init){
          try {
            const url  = typeof input==='string' ? input : (input && input.url) || '';
            const body = init && typeof init.body==='string' ? init.body : '';
            const id = extractId(url) || extractId(body);
            if (id) window.__KC_LAST_ENCOUNTER_ID__ = id;
          } catch(e){}
          return _fetch.apply(this, arguments);
        };
      }
    } catch(e){ if (G.debug) console.warn('[kc] hookXHRAndFetch error', e); }
  })();

  // === detectar el ID combinando varias fuentes ===
  function findEncounterId() {
    if (window.__KC_LAST_ENCOUNTER_ID__) return window.__KC_LAST_ENCOUNTER_ID__;
    const el = document.querySelector('[data-encounter-id]');
    if (el) return el.getAttribute('data-encounter-id');
    const hidden = document.querySelector('[name="encounter_id"],#encounter_id,input[data-name="encounter_id"]');
    if (hidden && hidden.value) return hidden.value;
    const qs = new URLSearchParams(window.location.search);
    if (qs.get('encounter_id')) return qs.get('encounter_id');
    if (qs.get('id')) return qs.get('id');
    const hid = extractId(window.location.hash || '');
    if (hid) return hid;
    try {
      const entries = performance.getEntriesByType('resource');
      for (let i = entries.length - 1; i >= 0; i--) {
        const id = extractId(entries[i].name || '');
        if (id) return id;
      }
    } catch(e){}
    return null;
  }

  // === endpoints REST y AJAX ===
  const REST = {
    summary: id => `${G.apiBase}/encounter/summary?encounter_id=${encodeURIComponent(id)}`,
    email:   () => `${G.apiBase}/encounter/summary/email`,
    headers: m => (m==='GET') ? {'X-WP-Nonce': G.nonce}
                              : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8','X-WP-Nonce': G.nonce},
  };
  const AJAX = {
    summary: id => `${ajaxUrl}?action=kc_encounter_summary&encounter_id=${encodeURIComponent(id)}`,
    email:   () => `${ajaxUrl}?action=kc_encounter_summary_email`,
    headers: () => ({'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}),
  };

  // === pedir JSON con fallback (REST -> AJAX) ===
  function fetchJSONWithFallback(restUrl, restHeaders, ajaxUrl2, ajaxHeaders){
    return fetch(restUrl, {credentials:'include', headers:restHeaders})
      .then(r => r.ok ? r.json() : Promise.reject(new Error('rest not ok')))
      .catch(() => fetch(ajaxUrl2, {credentials:'include', headers:ajaxHeaders}).then(r => r.json()));
  }

  // === crear/enganchar botón ===
  function hookButton() {
    // ya existe?
    let summaryBtns = Array.from(document.querySelectorAll('button, a, [role="button"]'))
      .filter(el => (el.textContent || '').toLowerCase().includes('resumen')
                 && (el.textContent || '').toLowerCase().includes('atención'));

    // si no, clonar al lado de "Detalles de la factura"
    if (summaryBtns.length === 0) {
      const billBtn = Array.from(document.querySelectorAll('button, a, [role="button"]'))
        .find(el => {
          const t = (el.textContent || '').toLowerCase();
          return t.includes('detalle') && t.includes('factura');
        });
      if (billBtn) {
        const b = document.createElement(billBtn.tagName.toLowerCase()==='a' ? 'a' : 'button');
        b.type = 'button';
        b.className = (billBtn.className || '') + ' js-kc-open-summary';
        b.style.marginLeft = '6px';
        b.textContent = 'Resumen de atención';
        billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
        summaryBtns = [b];
      }
    }

    const id = findEncounterId();
    summaryBtns.forEach(btn => {
      btn.classList.add('js-kc-open-summary');
      if (id && !btn.getAttribute('data-encounter-id')) btn.setAttribute('data-encounter-id', id);
    });

    // si aún no hay botón visible, añadimos uno fijo (debug)
    if (!document.querySelector('.js-kc-open-summary')) {
      const fixed = document.createElement('button');
      fixed.type = 'button';
      fixed.className = 'button button-primary js-kc-open-summary';
      fixed.textContent = 'Resumen de atención';
      fixed.style.position = 'fixed'; fixed.style.right = '16px'; fixed.style.bottom = '16px'; fixed.style.zIndex = '999999';
      fixed.setAttribute('data-encounter-id', id || '');
      document.body.appendChild(fixed);
    }
  }

  // === abrir modal con fallback REST/AJAX y compat json (status|success) ===
  function openSummary(id) {
    if (!id) id = findEncounterId();
    if (!id) { alert('No se pudo detectar el ID del encuentro'); return; }

    const restUrl = REST.summary(id);
    const ajaxUrl2 = AJAX.summary(id);
    if (G.debug) console.log('[kc] openSummary id=', id, 'url=', restUrl);

    fetchJSONWithFallback(restUrl, REST.headers('GET'), ajaxUrl2, AJAX.headers())
      .then(json => {
        const ok = (json && (json.status === 'success' || json.success === true));
        const data = json && (json.data || json); // wp_send_json_success pone el payload en data
        if (!ok || !data || !data.html) {
          alert((json && json.message) || 'No se pudo cargar');
          if (G.debug) console.warn('[kc] response:', json);
          return;
        }
        const old = document.querySelector('.kc-modal.kc-modal-summary'); if (old) old.remove();
        const wrap = document.createElement('div'); wrap.innerHTML = data.html; document.body.appendChild(wrap);

        wrap.querySelectorAll('.js-kc-summary-close').forEach(b => b.addEventListener('click', () => wrap.remove()));
        wrap.addEventListener('click', e => { if (e.target.classList.contains('kc-modal')) wrap.remove(); });
        document.addEventListener('keydown', function esc(e){ if (e.key==='Escape'){ wrap.remove(); document.removeEventListener('keydown', esc);} });

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
          // email también con fallback
          const restEmail = REST.email();
          const ajaxEmail = AJAX.email();
          fetchJSONWithFallback(restEmail, REST.headers('POST'), ajaxEmail, AJAX.headers())
            .then(resp => {
              const ok2 = resp && (resp.status === 'success' || resp.success === true);
              alert(ok2 ? 'Enviado' : (resp && resp.message) || 'No se pudo enviar');
            })
            .catch(() => alert('No se pudo enviar'));
        });
      })
      .catch(err => {
        console.warn('[kc] network error', err);
        alert('Error de red');
      });
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

  // Boot + observar SPA
  function boot(){ hookButton(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(() => hookButton());
  mo.observe(document.documentElement, { childList: true, subtree: true });

  // Diagnóstico
  window.kcSummaryDiag = function(){
    console.log('[kc] diag: hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl,
      'encounterId=', findEncounterId(), 'lastId=', window.__KC_LAST_ENCOUNTER_ID__);
    console.log('[kc] buttons:', document.querySelectorAll('.js-kc-open-summary').length);
  };
})();
