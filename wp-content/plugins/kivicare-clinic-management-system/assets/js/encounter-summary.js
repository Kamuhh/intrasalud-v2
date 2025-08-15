(function () {
  const G = window.kcGlobals || {};
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';

  // Si REST falla una vez, persistimos usar admin-ajax para evitar 404 repetidos
  let useAjaxOnly = (window.localStorage.getItem('kcSummaryUseAjax') === '1');
  function setAjaxOnly(){ useAjaxOnly = true; try{ localStorage.setItem('kcSummaryUseAjax','1'); }catch(e){} }

  // ------------ util ------------
  function extractId(str){
    if(!str) return null;
    let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i); if(m) return m[1];
    m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i);               if(m) return m[1];
    m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i);           if(m) return m[1];
    m = String(str).match(/\bid\s*=\s*(\d+)/i);                     if(m) return m[1];
    m = String(str).match(/(?:encounter|consulta|encuentro)[\/#=-]+(\d+)/i); if(m) return m[1];
    return null;
  }

  // recuerda el último encounter_id visto (la UI es tipo SPA)
  window.__KC_LAST_ENCOUNTER_ID__ = window.__KC_LAST_ENCOUNTER_ID__ || null;
  (function hookNet(){
    try{
      const _open = XMLHttpRequest.prototype.open;
      const _send = XMLHttpRequest.prototype.send;
      XMLHttpRequest.prototype.open = function(m,u){ this.__kc_url=u; return _open.apply(this,arguments); };
      XMLHttpRequest.prototype.send = function(b){ try{ const id=extractId(this.__kc_url)||extractId(typeof b==='string'?b:''); if(id) window.__KC_LAST_ENCOUNTER_ID__=id; }catch(e){} return _send.apply(this,arguments); };
      if(window.fetch){
        const _f = window.fetch;
        window.fetch = function(input,init){
          try{
            const url  = typeof input==='string' ? input : (input&&input.url)||'';
            const body = init && typeof init.body==='string' ? init.body : '';
            const id   = extractId(url)||extractId(body);
            if(id) window.__KC_LAST_ENCOUNTER_ID__ = id;
          }catch(e){}
          return _f.apply(this,arguments);
        };
      }
    }catch(e){}
  })();

  function findEncounterId(){
    if(window.__KC_LAST_ENCOUNTER_ID__) return window.__KC_LAST_ENCOUNTER_ID__;
    const el = document.querySelector('[data-encounter-id]'); if(el) return el.getAttribute('data-encounter-id');
    const hidden = document.querySelector('[name="encounter_id"],#encounter_id,input[data-name="encounter_id"]');
    if(hidden && hidden.value) return hidden.value;
    const qs = new URLSearchParams(window.location.search);
    if(qs.get('encounter_id')) return qs.get('encounter_id');
    if(qs.get('id'))           return qs.get('id');
    const hid = extractId(window.location.hash||''); if(hid) return hid;
    try{
      const entries = performance.getEntriesByType('resource');
      for(let i=entries.length-1;i>=0;i--){
        const id = extractId(entries[i].name||'');
        if(id) return id;
      }
    }catch(e){}
    return null;
  }

  // endpoints
  function hasREST(){ return !!G.apiBase && !useAjaxOnly; }
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

  function fetchJSON(restUrl, restHeaders, ajaxUrl2, ajaxHeaders){
    if(!hasREST()){
      return fetch(ajaxUrl2,{credentials:'include',headers:ajaxHeaders}).then(r=>r.json());
    }
    return fetch(restUrl,{credentials:'include',headers:restHeaders})
      .then(r=>{ if(!r.ok){ setAjaxOnly(); return fetch(ajaxUrl2,{credentials:'include',headers:ajaxHeaders}).then(j=>j.json()); } return r.json(); })
      .catch(()=>{ setAjaxOnly(); return fetch(ajaxUrl2,{credentials:'include',headers:ajaxHeaders}).then(r=>r.json()); });
  }

  // ---------- inyección del botón (SOLO creamos el nuestro y quitamos el antiguo) ----------
  function injectButtonOnce(){
    // localizar botones fuera de modales
    const all = Array.from(document.querySelectorAll('button,a,[role="button"]'))
      .filter(el => !el.closest('.kc-modal'));

    // 1) ELIMINAR el botón antiguo de “Resumen de la atención” (el azul oscuro),
    //    cualquier botón que diga “Resumen de la atención” y NO sea el nuestro.
    const legacyBtns = all.filter(el => {
      const t = (el.textContent || '').trim().toLowerCase();
      const isSummary = t === 'resumen de la atención' || (t.includes('resumen') && t.includes('atención'));
      const isOurs = el.matches('[data-kc-summary-btn="1"]');
      return isSummary && !isOurs;
    });
    legacyBtns.forEach(el => el.remove());

    // 2) Buscar “Detalles de la factura” como referencia para insertar nuestro botón al lado
    const billBtn = all.find(el => {
      const t = (el.textContent || '').toLowerCase();
      return t.includes('detalle') && t.includes('factura');
    });

    // si ya existe nuestro botón, actualizar encounter_id
    let summaryBtn = document.querySelector('[data-kc-summary-btn="1"]');
    const id = findEncounterId();
    if (summaryBtn && id && !summaryBtn.getAttribute('data-encounter-id')) {
      summaryBtn.setAttribute('data-encounter-id', id);
    }

     // si no existe, lo creamos al lado de “Detalles de la factura”
    if (!summaryBtn) {
      const bill = buttons.find(el => {
        const t = (el.textContent || '').toLowerCase();
        return t.includes('detalle') && t.includes('factura');
      });

      if (bill && !document.querySelector('[data-kc-summary-btn="1"]')) {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'button button-secondary js-kc-open-summary';
        b.style.marginLeft = '6px';
        b.setAttribute('data-kc-summary-btn', '1');

        // Ícono + texto
        b.innerHTML = '<span class="fa fa-print" style="margin-right:6px;"></span>Resumen de la atención';

    const id = findEncounterId();
        if (id) b.setAttribute('data-encounter-id', id);

        bill.parentNode.insertBefore(b, bill.nextSibling);
        summaryBtn = b;
      }
    }
  }

  // ---------- modal ----------
  function plainTextFromModal(root){
    const clone=root.cloneNode(true);
    clone.querySelectorAll('style,script,.kc-modal__footer,.kc-modal__header,button').forEach(n=>n.remove());
    return clone.innerText.replace(/\n{3,}/g,'\n\n').trim();
  }

  function openSummary(id){
    if(!id) id=findEncounterId();
    if(!id){ alert('No se pudo detectar el ID del encuentro'); return; }

    const restUrl = REST.summary(id);
    const ajaxUrl2= AJAX.summary(id);

    fetchJSON(restUrl,REST.headers('GET'),ajaxUrl2,AJAX.headers())
      .then(json=>{
        const ok = json && (json.status==='success' || json.success===true);
        const data = json && (json.data || json);
        if(!ok || !data || !data.html){ alert((json && json.message)||'No se pudo cargar'); return; }

        // limpiar y montar
        const old=document.querySelector('.kc-modal.kc-modal-summary'); if(old) old.remove();
        const wrap=document.createElement('div'); wrap.innerHTML=data.html; document.body.appendChild(wrap);

        // cerrar
        wrap.querySelectorAll('.js-kc-summary-close').forEach(b=>b.addEventListener('click',(ev)=>{ ev.stopPropagation(); wrap.remove(); }));
        wrap.addEventListener('click',e=>{ if(e.target.classList.contains('kc-modal')) wrap.remove(); });
        document.addEventListener('keydown',function esc(e){ if(e.key==='Escape'){ wrap.remove(); document.removeEventListener('keydown',esc);} });

        // imprimir (resumen)
        const printBtn=wrap.querySelector('.js-kc-summary-print');
        if(printBtn) printBtn.addEventListener('click',(ev)=>{
          ev.stopPropagation();
          const node=wrap.querySelector('.kc-modal__dialog');
          const w=window.open('','_blank'); if(!w) return;
          w.document.write('<html><head><title>Resumen de la atención</title>');
          document.querySelectorAll('link[rel="stylesheet"]').forEach(l=>w.document.write(l.outerHTML));
          w.document.write('<style>@media print{.kc-modal__dialog{box-shadow:none;max-width:none;width:100%;}} .kc-modal__close,.kc-modal__footer,.button,button,.dashicons{display:none!important}</style>');
          w.document.write('</head><body>'+node.outerHTML+'</body></html>');
          w.document.close(); w.focus();
          w.onafterprint = ()=>{ try{ w.close(); }catch(e){} };
          setTimeout(()=>{ try{ w.close(); }catch(e){} },2000);
          w.print();
        });

        // correo (POST con encounter_id y to) + fallback mailto
        const emailBtn = wrap.querySelector('.js-kc-summary-email');
        const modalRoot = wrap.querySelector('.kc-modal.kc-modal-summary');
        const defaultEmail = modalRoot ? modalRoot.getAttribute('data-patient-email') : '';
        const encounterId = findEncounterId();

        function postEmail(restUrl, ajaxUrl2, to) {
          const body = new URLSearchParams();
          if (encounterId) body.set('encounter_id', encounterId);
          body.set('to', to);

          if (hasREST()) {
            return fetch(restUrl, {
              method: 'POST',
              credentials: 'include',
              headers: REST.headers('POST'),
              body: body.toString(),
            })
              .then(r => {
                if (!r.ok) { setAjaxOnly(); throw new Error('REST failed'); }
                return r.json();
              })
              .catch(() => {
                return fetch(ajaxUrl2, {
                  method: 'POST',
                  credentials: 'include',
                  headers: AJAX.headers(),
                  body: body.toString(),
                }).then(r => r.json());
              });
          }

          return fetch(ajaxUrl2, {
            method: 'POST',
            credentials: 'include',
            headers: AJAX.headers(),
            body: body.toString(),
          }).then(r => r.json());
        }

        if (emailBtn) emailBtn.addEventListener('click', (ev) => {
          ev.stopPropagation();
          const to = defaultEmail || prompt('Correo de destino','') || '';
          if (!to) return;

          const restEmail = REST.email();
          const ajaxEmail = AJAX.email();

          postEmail(restEmail, ajaxEmail, to)
            .then(resp => {
              const ok = resp && (resp.status === 'success' || resp.success === true);
              if (ok) { alert('Enviado'); return; }
              throw new Error('Backend dijo que no');
            })
            .catch(() => {
              const body = encodeURIComponent(plainTextFromModal(wrap.querySelector('.kc-modal__dialog')));
              const subject = encodeURIComponent('Resumen de la atención');
              window.location.href = `mailto:${encodeURIComponent(to)}?subject=${subject}&body=${body}`;
              alert('No se pudo enviar desde el sistema. Se abrió tu cliente de correo con el contenido.');
            });
        });
      })
      .catch(()=>alert('Error de red'));
  }

  // Sólo manejamos NUESTRO botón
  document.addEventListener('click', e => {
    const btn = e.target.closest('[data-kc-summary-btn="1"]');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();
    const id = btn.getAttribute('data-encounter-id') || '';
    openSummary(id);
  });

  function boot(){ injectButtonOnce(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(() => injectButtonOnce());
  mo.observe(document.documentElement, { childList:true, subtree:true });
})();

// Fallback de impresión para "Detalle de la factura" (modal de factura, sin botones)
document.addEventListener('click', (e) => {
  const btn = e.target.closest('button, a');
  if (!btn) return;

  const modal = btn.closest('.kc-modal'); // solo si está dentro de una modal
  if (!modal) return;

  const titleEl = modal.querySelector('.kc-modal__header h3');
  const title = (titleEl && titleEl.textContent || '').toLowerCase();
  const isBill = /factura|bill|invoice/.test(title);

  const isPrintTrigger =
    btn.matches('.js-kc-bill-print, [data-kc-bill-print]') ||
    ((btn.textContent || '').toLowerCase().includes('imprimir'));

  if (!isBill || !isPrintTrigger) return;

  setTimeout(() => {
    const dialog = modal.querySelector('.kc-modal__dialog');
    if (!dialog) return;

    const clean = dialog.cloneNode(true);
    clean.querySelectorAll('.kc-modal__footer, .kc-modal__close, .button, button, .dashicons').forEach(n => n.remove());

    const w = window.open('', '_blank');
    if (!w) return;

    w.document.write('<html><head><title>Detalle de la factura</title>');
    document.querySelectorAll('link[rel="stylesheet"]').forEach(l => w.document.write(l.outerHTML));
    w.document.write('<style>@media print{.kc-modal__dialog{box-shadow:none;max-width:none;width:100%;}} .kc-modal__close,.kc-modal__footer,.button,button,.dashicons{display:none!important}</style>');
    w.document.write('</head><body>' + clean.outerHTML + '</body></html>');
    w.document.close(); w.focus();
    w.onafterprint = () => { try { w.close(); } catch(e){} };
    setTimeout(() => { try { w.close(); } catch(e){} }, 2000);
    w.print();
  }, 200);
});
