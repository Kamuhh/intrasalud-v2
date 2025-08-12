(function () {
  const G = window.kcGlobals || {};
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';

  // persistimos la preferencia de usar AJAX si REST falló alguna vez
  let useAjaxOnly = (window.localStorage.getItem('kcSummaryUseAjax') === '1');

  function setAjaxOnly() {
    useAjaxOnly = true;
    try { window.localStorage.setItem('kcSummaryUseAjax','1'); } catch(e){}
  }

  // ===== util =====
  function extractId(str) {
    if (!str) return null;
    let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i); if (m) return m[1];
    m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i);               if (m) return m[1];
    m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i);           if (m) return m[1];
    m = String(str).match(/\bid\s*=\s*(\d+)/i);                     if (m) return m[1];
    m = String(str).match(/(?:encounter|consulta|encuentro)[\/#=-]+(\d+)/i); if (m) return m[1];
    return null;
  }

  // recordamos el último ID visto por XHR/fetch (SPA)
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
    } catch(e){}
  })();

  function findEncounterId() {
    if (window.__KC_LAST_ENCOUNTER_ID__) return window.__KC_LAST_ENCOUNTER_ID__;
    const el = document.querySelector('[data-encounter-id]'); if (el) return el.getAttribute('data-encounter-id');
    const hidden = document.querySelector('[name="encounter_id"],#encounter_id,input[data-name="encounter_id"]');
    if (hidden && hidden.value) return hidden.value;
    const qs = new URLSearchParams(window.location.search);
    if (qs.get('encounter_id')) return qs.get('encounter_id');
    if (qs.get('id'))           return qs.get('id');
    const hid = extractId(window.location.hash || ''); if (hid) return hid;
    try {
      const entries = performance.getEntriesByType('resource');
      for (let i = entries.length - 1; i >= 0; i--) {
        const id = extractId(entries[i].name || '');
        if (id) return id;
      }
    } catch(e){}
    return null;
  }

  // endpoints
  function hasREST() { return !!G.apiBase && !useAjaxOnly; }
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

  // fetch con fallback; si REST falla una vez, pasamos a AJAX-only permanente
  function fetchJSON(restUrl, restHeaders, ajaxUrl2, ajaxHeaders){
    if (!hasREST()) {
      return fetch(ajaxUrl2, {credentials:'include', headers:ajaxHeaders}).then(r=>r.json());
    }
    return fetch(restUrl, {credentials:'include', headers:restHeaders}).then(r=>{
      if (!r.ok) { setAjaxOnly(); return fetch(ajaxUrl2, {credentials:'include', headers:ajaxHeaders}).then(j=>j.json()); }
      return r.json();
    }).catch(()=>{
      setAjaxOnly();
      return fetch(ajaxUrl2, {credentials:'include', headers:ajaxHeaders}).then(r=>r.json());
    });
  }

  // ===== inyección del botón =====
  function hookButton() {
    // no tocar nada dentro de modales
    const isInModal = el => !!el.closest('.kc-modal');

    // evitar duplicados
    document.querySelectorAll('.js-kc-open-summary').forEach(el=>{
      if (isInModal(el)) el.remove();
    });

    // ya existe en la barra?
    let summaryBtns = Array.from(document.querySelectorAll('button, a, [role="button"]'))
      .filter(el => !isInModal(el))
      .filter(el => {
        const t = (el.textContent || '').toLowerCase();
        return t.includes('resumen') && t.includes('atención');
      });

    // si no existe, insertarlo a la derecha de “Detalles de la factura” (fuera de modales)
    if (summaryBtns.length === 0) {
      const billBtn = Array.from(document.querySelectorAll('button, a, [role="button"]'))
        .filter(el => !isInModal(el))
        .find(el => {
          const t = (el.textContent || '').toLowerCase();
          return t.includes('detalle') && t.includes('factura');
        });

      if (billBtn && !document.querySelector('.js-kc-open-summary')) {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'button button-secondary js-kc-open-summary';
        b.style.marginLeft = '6px';
        b.textContent = 'Resumen de atención';
        const id = findEncounterId(); if (id) b.setAttribute('data-encounter-id', id);
        billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
        summaryBtns = [b];
      }
    }

    // asegurar clase/ID en candidatos
    const id = findEncounterId();
    summaryBtns.forEach(btn => {
      btn.classList.add('js-kc-open-summary');
      if (id && !btn.getAttribute('data-encounter-id')) btn.setAttribute('data-encounter-id', id);
    });
  }

  function plainTextFromModal(modalNode){
    // genera texto simple para fallback de email
    const clone = modalNode.cloneNode(true);
    clone.querySelectorAll('style,script,.kc-modal__footer,.kc-modal__header,button').forEach(n=>n.remove());
    return clone.innerText.replace(/\n{3,}/g,'\n\n').trim();
  }

  function openSummary(id) {
    if (!id) id = findEncounterId();
    if (!id) { alert('No se pudo detectar el ID del encuentro'); return; }

    const restUrl = REST.summary(id);
    const ajaxUrl2 = AJAX.summary(id);

    fetchJSON(restUrl, REST.headers('GET'), ajaxUrl2, AJAX.headers())
      .then(json => {
        const ok = json && (json.status === 'success' || json.success === true);
        const data = json && (json.data || json);
        if (!ok || !data || !data.html) {
          alert((json && json.message) || 'No se pudo cargar');
          return;
        }

        // limpiar y agregar modal
        const old = document.querySelector('.kc-modal.kc-modal-summary'); if (old) old.remove();
        const wrap = document.createElement('div'); wrap.innerHTML = data.html; document.body.appendChild(wrap);

        // cierre
        wrap.querySelectorAll('.js-kc-summary-close').forEach(b => b.addEventListener('click', (ev) => { ev.stopPropagation(); wrap.remove(); }));
        wrap.addEventListener('click', e => { if (e.target.classList.contains('kc-modal')) wrap.remove(); });
        document.addEventListener('keydown', function esc(e){ if (e.key==='Escape'){ wrap.remove(); document.removeEventListener('keydown', esc);} });

        // imprimir (abre vista limpia y la cierra al terminar)
        const printBtn = wrap.querySelector('.js-kc-summary-print');
        if (printBtn) printBtn.addEventListener('click', (ev) => {
          ev.stopPropagation();
          const node = wrap.querySelector('.kc-modal__dialog');
          const w = window.open('', '_blank'); if (!w) return;
          w.document.write('<html><head><title>Resumen de atención</title>');
          document.querySelectorAll('link[rel="stylesheet"]').forEach(l => w.document.write(l.outerHTML));
          w.document.write('<style>@media print{.kc-modal__dialog{box-shadow:none;max-width:none;width:100%;}} .kc-modal__close{display:none}</style>');
          w.document.write('</head><body>' + node.outerHTML + '</body></html>');
          w.document.close(); w.focus();
          // cerrar después de imprimir (o si cancela)
          w.onafterprint = () => { try{ w.close(); }catch(e){} };
          setTimeout(()=>{ try{ w.close(); }catch(e){} }, 2000);
          w.print();
        });

        // correo: usa email del paciente si viene; si endpoint no existe, fallback a mailto:
        const emailBtn = wrap.querySelector('.js-kc-summary-email');
        const modalRoot = wrap.querySelector('.kc-modal.kc-modal-summary');
        const defaultEmail = modalRoot ? modalRoot.getAttribute('data-patient-email') : '';
        if (emailBtn) emailBtn.addEventListener('click', (ev) => {
          ev.stopPropagation();
          const to = defaultEmail || prompt('Correo de destino', '') || '';
          if (!to) return;

          const restEmail = REST.email();
          const ajaxEmail = AJAX.email();

          fetchJSON(restEmail, REST.headers('POST'), ajaxEmail, AJAX.headers())
            .then(resp => {
              const ok2 = resp && (resp.status === 'success' || resp.success === true);
              if (ok2) { alert('Enviado'); return; }
              // Fallback: mailto con el contenido visible
              const body = encodeURIComponent(plainTextFromModal(wrap.querySelector('.kc-modal__dialog')));
              const subject = encodeURIComponent('Resumen de la atención');
              window.location.href = `mailto:${encodeURIComponent(to)}?subject=${subject}&body=${body}`;
              alert('No se pudo enviar desde el sistema. Se abrió tu cliente de correo con el contenido.');
            })
            .catch(() => {
              const body = encodeURIComponent(plainTextFromModal(wrap.querySelector('.kc-modal__dialog')));
              const subject = encodeURIComponent('Resumen de la atención');
              window.location.href = `mailto:${encodeURIComponent(to)}?subject=${subject}&body=${body}`;
              alert('No se pudo enviar desde el sistema. Se abrió tu cliente de correo con el contenido.');
            });
        });
      })
      .catch(() => alert('Error de red'));
  }

  // eventos (evitamos burbujas que disparen otras acciones)
  document.addEventListener('click', e => {
    const btn = e.target.closest('.js-kc-open-summary');
    if (btn) {
      e.preventDefault();
      e.stopPropagation();
      openSummary(btn.getAttribute('data-encounter-id'));
    }
  }, true); // capture=true para “comernos” el click antes que otros handlers

  // iniciar y observar SPA
  function boot(){ hookButton(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(() => hookButton());
  mo.observe(document.documentElement, { childList: true, subtree: true });

  // diagnóstico
  window.kcSummaryDiag = function(){
    console.log('[kc] diag: useAjaxOnly=', useAjaxOnly, 'hasREST=', !!G.apiBase && !useAjaxOnly,
      'apiBase=', G.apiBase, 'ajaxUrl=', ajaxUrl, 'encounterId=', findEncounterId(),
      'buttons=', document.querySelectorAll('.js-kc-open-summary').length);
  };
})();
