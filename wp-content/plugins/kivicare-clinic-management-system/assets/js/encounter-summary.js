(function () {
  const G = window.kcGlobals || {};
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';

  // Si alguna vez falla REST, recordamos usar solo admin-ajax para evitar 404 repetidos
  let useAjaxOnly = (window.localStorage.getItem('kcSummaryUseAjax') === '1');
  function setAjaxOnly(){ useAjaxOnly = true; try{ localStorage.setItem('kcSummaryUseAjax','1'); }catch(e){} }

  // -------- util ----------
  function extractId(str){
    if(!str) return null;
    let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i); if(m) return m[1];
    m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i);               if(m) return m[1];
    m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i);           if(m) return m[1];
    m = String(str).match(/\bid\s*=\s*(\d+)/i);                     if(m) return m[1];
    m = String(str).match(/(?:encounter|consulta|encuentro)[\/#=-]+(\d+)/i); if(m) return m[1];
    return null;
  }

  // recordamos último encounter_id visto en XHR/fetch (SPA)
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

  // ---------- inyección del botón (sin interferir con “Detalles de la factura”) ----------
  function hookButton(){
    // borrar botones nuestros que hayan quedado dentro de otros modales para no duplicar
    document.querySelectorAll('.kc-modal .js-kc-open-summary').forEach(el=>el.remove());

    // ¿ya hay un “Resumen de atención” visible fuera de modales?
    let btns = Array.from(document.querySelectorAll('button,a,[role="button"]'))
      .filter(el=>!el.closest('.kc-modal'))
      .filter(el => {
        const t=(el.textContent||'').toLowerCase();
        return t.includes('resumen') && t.includes('atención');
      });

    // si no existe, crear uno a la derecha de “Detalles de la factura” (pero SIN tocar el listener del de factura)
    if(btns.length===0){
      const billBtn = Array.from(document.querySelectorAll('button,a,[role="button"]'))
        .filter(el=>!el.closest('.kc-modal'))
        .find(el=>{ const t=(el.textContent||'').toLowerCase(); return t.includes('detalle') && t.includes('factura'); });

      if(billBtn && !document.querySelector('.js-kc-open-summary')){
        const b=document.createElement('button');
        b.type='button';
        b.className='button button-secondary js-kc-open-summary';
        b.style.marginLeft='6px';
        b.textContent='Resumen de atención';
        const id=findEncounterId(); if(id) b.setAttribute('data-encounter-id',id);
        billBtn.parentNode.insertBefore(b,billBtn.nextSibling);
        btns=[b];
      }
    }

    // asegurar data-id
    const id=findEncounterId();
    btns.forEach(b=>{ if(id && !b.getAttribute('data-encounter-id')) b.setAttribute('data-encounter-id',id); });
  }

  // ---------- abrir modal ----------
  function plainTextFromModal(modalNode){
    const clone=modalNode.cloneNode(true);
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

        // limpiar y montar modal
        const old=document.querySelector('.kc-modal.kc-modal-summary'); if(old) old.remove();
        const wrap=document.createElement('div'); wrap.innerHTML=data.html; document.body.appendChild(wrap);

        // cerrar
        wrap.querySelectorAll('.js-kc-summary-close').forEach(b=>b.addEventListener('click',(ev)=>{ ev.stopPropagation(); wrap.remove(); }));
        wrap.addEventListener('click',e=>{ if(e.target.classList.contains('kc-modal')) wrap.remove(); });
        document.addEventListener('keydown',function esc(e){ if(e.key==='Escape'){ wrap.remove(); document.removeEventListener('keydown',esc);} });

        // imprimir (cierra sola la ventana temporal)
        const printBtn=wrap.querySelector('.js-kc-summary-print');
        if(printBtn) printBtn.addEventListener('click',(ev)=>{
          ev.stopPropagation();
          const node=wrap.querySelector('.kc-modal__dialog');
          const w=window.open('','_blank'); if(!w) return;
          w.document.write('<html><head><title>Resumen de atención</title>');
          document.querySelectorAll('link[rel="stylesheet"]').forEach(l=>w.document.write(l.outerHTML));
          w.document.write('<style>@media print{.kc-modal__dialog{box-shadow:none;max-width:none;width:100%;}} .kc-modal__close{display:none}</style>');
          w.document.write('</head><body>'+node.outerHTML+'</body></html>');
          w.document.close(); w.focus();
          w.onafterprint = ()=>{ try{ w.close(); }catch(e){} };
          setTimeout(()=>{ try{ w.close(); }catch(e){} },2000);
          w.print();
        });

        // correo: usa email del paciente si viene; si backend falla -> mailto con contenido
        const emailBtn=wrap.querySelector('.js-kc-summary-email');
        const modalRoot=wrap.querySelector('.kc-modal.kc-modal-summary');
        const defaultEmail = modalRoot ? modalRoot.getAttribute('data-patient-email') : '';
        if(emailBtn) emailBtn.addEventListener('click',(ev)=>{
          ev.stopPropagation();
          const to = defaultEmail || prompt('Correo de destino','') || '';
          if(!to) return;

          const restEmail = REST.email();
          const ajaxEmail = AJAX.email();

          fetchJSON(restEmail,REST.headers('POST'),ajaxEmail,AJAX.headers())
            .then(resp=>{
              const ok2 = resp && (resp.status==='success' || resp.success===true);
              if(ok2){ alert('Enviado'); return; }
              const body=encodeURIComponent(plainTextFromModal(wrap.querySelector('.kc-modal__dialog')));
              const subject=encodeURIComponent('Resumen de la atención');
              window.location.href = `mailto:${encodeURIComponent(to)}?subject=${subject}&body=${body}`;
              alert('No se pudo enviar desde el sistema. Se abrió tu cliente de correo con el contenido.');
            })
            .catch(()=>{
              const body=encodeURIComponent(plainTextFromModal(wrap.querySelector('.kc-modal__dialog')));
              const subject=encodeURIComponent('Resumen de la atención');
              window.location.href = `mailto:${encodeURIComponent(to)}?subject=${subject}&body=${body}`;
              alert('No se pudo enviar desde el sistema. Se abrió tu cliente de correo con el contenido.');
            });
        });
      })
      .catch(()=>alert('Error de red'));
  }

  // Solo manejamos clicks de NUESTRO botón (no tocamos el de factura)
  document.addEventListener('click', e=>{
    const btn = e.target.closest('.js-kc-open-summary');
    if(btn){ e.preventDefault(); e.stopPropagation(); openSummary(btn.getAttribute('data-encounter-id')); }
  }, false); // <- sin capture para no interceptar otros

  // boot + observar SPA
  function boot(){ hookButton(); }
  document.addEventListener('DOMContentLoaded', boot);
  const mo = new MutationObserver(()=>hookButton());
  mo.observe(document.documentElement,{childList:true,subtree:true});

  // helper de diagnóstico
  window.kcSummaryDiag = function(){
    console.log('[kc] diag: useAjaxOnly=',useAjaxOnly,'hasREST=',!!G.apiBase && !useAjaxOnly,
      'apiBase=',G.apiBase,'ajaxUrl=',ajaxUrl,'encounterId=',findEncounterId(),
      'buttons=',document.querySelectorAll('.js-kc-open-summary').length);
  };
})();
