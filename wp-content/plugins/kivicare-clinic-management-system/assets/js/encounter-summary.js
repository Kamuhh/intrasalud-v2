(function () {
  const G = window.kcGlobals || {};
  const hasREST = !!G.apiBase;
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';
  if (G.debug) console.log('[kc] boot; hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl);

  // --- Captura global del último encounter_id observado ---
  window.__KC_LAST_ENCOUNTER_ID__ = window.__KC_LAST_ENCOUNTER_ID__ || null;

  function extractId(str) {
    if (!str) return null;
    // 1) parámetros comunes
    let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i);
    if (m) return m[1];
    m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i);
    if (m) return m[1];
    // 2) cuerpos x-www-form-urlencoded
    m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i);
    if (m) return m[1];
    m = String(str).match(/\bid\s*=\s*(\d+)/i);
    if (m) return m[1];
    // 3) hash/paths tipo #/encounter/178 o #encounter_id=178
    m = String(str).match(/(?:encounter|consulta|encuentro)[\/=#-]+(\d+)/i);
    if (m) return m[1];
    return null;
  }

  // --- Espiamos XHR/fetch para aprender el ID que usa la SPA ---
  (function hookXHRAndFetch(){
    try {
      // XHR
      const _open = XMLHttpRequest.prototype.open;
      const _send = XMLHttpRequest.prototype.send;
      XMLHttpRequest.prototype.open = function(method, url) {
        this.__kc_url = url;
        return _open.apply(this, arguments);
      };
      XMLHttpRequest.prototype.send = function(body) {
        try {
          const id = extractId(this.__kc_url) || extractId(typeof body === 'string' ? body : '');
          if (id) { window.__KC_LAST_ENCOUNTER_ID__ = id; if (G.debug) console.log('[kc] XHR id=', id); }
        } catch(e){}
        return _send.apply(this, arguments);
      };

      // fetch
      if (window.fetch) {
        const _fetch = window.fetch;
        window.fetch = function(input, init) {
          try {
            const url  = typeof input === 'string' ? input : (input && input.url) || '';
            const body = init && typeof init.body === 'string' ? init.body : '';
            const id = extractId(url) || extractId(body);
            if (id) { window.__KC_LAST_ENCOUNTER_ID__ = id; if (G.debug) console.log('[kc] fetch id=', id); }
          } catch(e){}
          return _fetch.apply(this, arguments);
        };
      }
    } catch(e) {
      if (G.debug) console.warn('[kc] hookXHRAndFetch error', e);
    }
  })();

  // --- Resolver encounter_id combinando DOM, hash, XHR/fetch ---
  function findEncounterId() {
    // 0) último detectado por tráfico de red
    if (window.__KC_LAST_ENCOUNTER_ID__) return window.__KC_LAST_ENCOUNTER_ID__;

    // 1) DOM directo
    const domEl = document.querySelector('[data-encounter-id]');
    if (domEl) return domEl.getAttribute('data-encounter-id');

    // 2) Controles ocultos típicos
    const hidden = document.querySelector('[name="encounter_id"], #encounter_id, input[data-name="encounter_id"]');
    if (hidden && hidden.value) return hidden.value;

    // 3) URL search y hash
    const qs = new URLSearchParams(window.location.search);
    if (qs.get('encounter_id')) return qs.get('encounter_id');
    if (qs.get('id')) return qs.get('id');

    const h = window.location.hash || '';
    const hid = extractId(h);
    if (hid) return hid;

    // 4) Mirar recursos cargados recientemente (por si la SPA ya disparó peticiones)
    try {
      const entries = performance.getEntriesByType('resource');
      for (let i = entries.length - 1; i >= 0; i--) {
        const n = entries[i].name || '';
        const id = extractId(n);
        if (id) return id;
      }
    } catch(e){}

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
    // Si ya existe cualquier botón "Resumen de atención", solo asegurar clase/ID
    let summaryBtns = Array.from(document.querySelectorAll('button, a, [role="button"]'))
      .filter(el => (el.textContent || '').toLowerCase().includes('resumen')
                 && (el.textContent || '').toLowerCase().includes('atención'));

    // Si no hay, clonar al lado de "Detalles de la factura"
    if (summaryBtns.length === 0) {
      const billBtn = Array.from(document.querySelectorAll('button, a, [role="button"]'))
        .find(el => {
          const t = (el.textContent || '').toLowerCase();
          return t.includes('detalle') && t.includes('factura');
        });

      if (billBtn) {
        const b = document.createElement(billBtn.tagName.toLowerCase() === 'a' ? 'a' : 'button');
        b.type = 'button';
        b.className = (billBtn.className || '') + ' js-kc-open-summary';
        b.style.marginLeft = '6px';
        b.textContent = 'Resumen de atención';
        billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
        summaryBtns = [b];
      }
    }

    // Asegurar clase y data-id en todos los candidatos
    const id = findEncounterId();
    summaryBtns.forEach(btn => {
      btn.classList.add('js-kc-open-summary');
      if (id && !btn.getAttribute('data-encounter-id')) btn.setAttribute('data-encounter-id', id);
    });
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

  // Boot + observar cambios de la SPA (reintenta enganchar y detectar ID)
  function boot(){ hookButton(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(() => hookButton());
  mo.observe(document.documentElement, { childList: true, subtree: true });

  // Diagnóstico rápido
  window.kcSummaryDiag = function(){
    console.log('[kc] diag: hasREST=', hasREST, 'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl,
      'encounterId=', findEncounterId(), 'lastId=', window.__KC_LAST_ENCOUNTER_ID__);
    console.log('[kc] buttons:', document.querySelectorAll('.js-kc-open-summary').length);
  };
})();
