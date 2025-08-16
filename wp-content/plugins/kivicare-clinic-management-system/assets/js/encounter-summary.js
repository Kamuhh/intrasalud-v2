(function () {
  const G = window.kcGlobals || {};
  const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';

  // Si REST falla una vez, persistimos usar admin-ajax para evitar 404 repetidos
  let useAjaxOnly = (window.localStorage.getItem('kcSummaryUseAjax') === '1');
  function setAjaxOnly(){ useAjaxOnly = true; try{ localStorage.setItem('kcSummaryUseAjax','1'); }catch(e){} }

  // ------------ util ------------
  function extractEncounterId(str){
    if(!str) return null;
    let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i); if(m) return m[1];
    m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i);               if(m) return m[1];
    m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i);           if(m) return m[1];
    m = String(str).match(/\bid\s*=\s*(\d+)/i);                     if(m) return m[1];
    m = String(str).match(/(?:encounter|consulta|encuentro)[\/#=-]+(\d+)/i); if(m) return m[1];
    return null;
  }
  function extractPatientId(str){
    if(!str) return null;
    let m = String(str).match(/[?&#]\s*patient_id\s*=\s*(\d+)/i); if(m) return m[1];
    m = String(str).match(/\bpatient_id\s*=\s*(\d+)/i);           if(m) return m[1];
    m = String(str).match(/(?:patient|paciente)[\/#=-]+(\d+)/i); if(m) return m[1];
    return null;
  }

  // recuerda los últimos IDs vistos (la UI es tipo SPA)
  window.__KC_LAST_ENCOUNTER_ID__ = window.__KC_LAST_ENCOUNTER_ID__ || null;
  window.__KC_LAST_PATIENT_ID__ = window.__KC_LAST_PATIENT_ID__ || null;
  (function hookNet(){
    try{
      const _open = XMLHttpRequest.prototype.open;
      const _send = XMLHttpRequest.prototype.send;
      XMLHttpRequest.prototype.open = function(m,u){ this.__kc_url=u; return _open.apply(this,arguments); };
      XMLHttpRequest.prototype.send = function(b){ try{
          const id=extractEncounterId(this.__kc_url)||extractEncounterId(typeof b==='string'?b:'');
          if(id) window.__KC_LAST_ENCOUNTER_ID__=id;
          const pid=extractPatientId(this.__kc_url)||extractPatientId(typeof b==='string'?b:'');
          if(pid) window.__KC_LAST_PATIENT_ID__=pid;
        }catch(e){} return _send.apply(this,arguments); };
      if(window.fetch){
        const _f = window.fetch;
        window.fetch = function(input,init){
          try{
            const url  = typeof input==='string' ? input : (input&&input.url)||'';
            const body = init && typeof init.body==='string' ? init.body : '';
            const id   = extractEncounterId(url)||extractEncounterId(body);
            if(id) window.__KC_LAST_ENCOUNTER_ID__ = id;
            const pid  = extractPatientId(url)||extractPatientId(body);
            if(pid) window.__KC_LAST_PATIENT_ID__ = pid;
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
    const hid = extractEncounterId(window.location.hash||''); if(hid) return hid;
    try{
      const entries = performance.getEntriesByType('resource');
      for(let i=entries.length-1;i>=0;i--){
        const id = extractEncounterId(entries[i].name||'');
        if(id) return id;
      }
    }catch(e){}
    return null;
  }

  function findPatientId(){
    if(window.__KC_LAST_PATIENT_ID__) return window.__KC_LAST_PATIENT_ID__;
    const el = document.querySelector('[data-patient-id]'); if(el) return el.getAttribute('data-patient-id');
    const hidden = document.querySelector('[name="patient_id"],#patient_id,input[data-name="patient_id"]');
    if(hidden && hidden.value) return hidden.value;
    const qs = new URLSearchParams(window.location.search);
    if(qs.get('patient_id')) return qs.get('patient_id');
    const hid = extractPatientId(window.location.hash||''); if(hid) return hid;
    return null;
  }

  // endpoints
  function hasREST(){ return !!G.apiBase && !useAjaxOnly; }
  const REST = {
    email:   () => `${G.apiBase}/encounter/summary/email`,
    headers: m => (m==='GET') ? {'X-WP-Nonce': G.nonce}
                              : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8','X-WP-Nonce': G.nonce},
  };
  const AJAX = {
    email:   () => `${ajaxUrl}?action=kc_encounter_summary_email`,
    headers: () => ({'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}),
  };

  // ---------- inyección del botón (SOLO creamos el nuestro y quitamos el antiguo) ----------
  function injectButtonOnce(){
    // localizar botones fuera de modales
    const buttons = Array.from(document.querySelectorAll('button,a,[role="button"]'))
      .filter(el => !el.closest('.kc-modal'));

    // 1) ELIMINAR cualquier botón legacy de “Resumen de la atención” que NO sea el nuestro
    buttons.forEach(el => {
      const t = (el.textContent || '').trim().toLowerCase();
      const isSummary = t === 'resumen de la atención' || (t.includes('resumen') && t.includes('atención'));
      const isOurs = el.matches('[data-kc-summary-btn="1"]');
      if (isSummary && !isOurs) el.remove();
    });

    // 2) Buscar “Detalles de la factura” para insertar nuestro botón al lado
    const billBtn = buttons.find(el => {
      const t = (el.textContent || '').toLowerCase();
      return t.includes('detalle') && t.includes('factura');
    });

    // 3) Si ya existe nuestro botón, refrescar IDs y salir
    let summaryBtn = document.querySelector('[data-kc-summary-btn="1"]');
    const currentId  = findEncounterId();
    const currentPid = findPatientId();
    if (summaryBtn) {
      if (currentId && !summaryBtn.getAttribute('data-encounter-id')) {
        summaryBtn.setAttribute('data-encounter-id', currentId);
      }
      if (currentPid && !summaryBtn.getAttribute('data-patient-id')) {
        summaryBtn.setAttribute('data-patient-id', currentPid);
      }
      return;
    }

     // 4) Crear NUESTRO botón si aún no existe
    if (billBtn) {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'button button-secondary js-kc-open-summary';
      b.style.marginLeft = '6px';
      b.setAttribute('data-kc-summary-btn', '1');
      if (currentId) b.setAttribute('data-encounter-id', currentId);
      if (currentPid) b.setAttribute('data-patient-id', currentPid);

      // Ícono + texto (usa Font Awesome si está cargado)
      b.innerHTML = '<span style="margin-right:6px;"></span>Resumen de la atención';

      billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
      summaryBtn = b;
    }
  }

  // ---------- modal ----------
  function plainTextFromModal(root){
    const clone=root.cloneNode(true);
    clone.querySelectorAll('style,script,.kc-modal__footer,.kc-modal__header,button').forEach(n=>n.remove());
    return clone.innerText.replace(/\n{3,}/g,'\n\n').trim();
  }

  function openSummary(id, pid){
    if(!id) id=findEncounterId();
    if(!pid) pid=findPatientId();
    if(!id){ alert('No se pudo detectar el ID del encuentro'); return; }
    const modal=document.querySelector('.kc-modal.kc-modal-summary');
    if(!modal){ alert('No se encontró el modal'); return; }

    if(window.kcLoadEncounterSummary){
      window.kcLoadEncounterSummary(id, pid);
    }

    modal.style.display='flex';

    modal.querySelectorAll('.js-kc-summary-close').forEach(b=>b.addEventListener('click',()=>{ modal.style.display='none'; }));
    modal.addEventListener('click',e=>{ if(e.target===modal) modal.style.display='none'; });
    document.addEventListener('keydown',function esc(e){ if(e.key==='Escape'){ modal.style.display='none'; document.removeEventListener('keydown',esc);} });

    const printBtn=modal.querySelector('.js-kc-summary-print');
    if(printBtn && !printBtn.dataset.bound){
      printBtn.dataset.bound='1';
      printBtn.addEventListener('click',(ev)=>{
        ev.stopPropagation();
        const node=modal.querySelector('.kc-modal__dialog');
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
    }

    const emailBtn = modal.querySelector('.js-kc-summary-email');
    if(emailBtn && !emailBtn.dataset.bound){
      emailBtn.dataset.bound='1';
      emailBtn.addEventListener('click',(ev)=>{
        ev.stopPropagation();
        const defaultEmail = document.getElementById('kc-sum-email').textContent || '';
        const to = defaultEmail || prompt('Correo de destino','') || '';
        if(!to) return;

        function postEmail(restUrl, ajaxUrl2, to){
          const body = new URLSearchParams();
          if(id) body.set('encounter_id', id);
          body.set('to', to);

          if(hasREST()){
            return fetch(restUrl, {
              method:'POST',
              credentials:'include',
              headers: REST.headers('POST'),
              body: body.toString(),
            })
            .then(r=>{ if(!r.ok){ setAjaxOnly(); throw new Error('REST failed'); } return r.json(); })
            .catch(()=> fetch(ajaxUrl2,{method:'POST',credentials:'include',headers:AJAX.headers(),body:body.toString()}).then(r=>r.json()));
          }
          return fetch(ajaxUrl2,{method:'POST',credentials:'include',headers:AJAX.headers(),body:body.toString()}).then(r=>r.json());
        }

        const restEmail = REST.email();
        const ajaxEmail = AJAX.email();

        postEmail(restEmail, ajaxEmail, to)
          .then(resp=>{
            const ok = resp && (resp.status==='success' || resp.success===true);
            if(ok){ alert('Enviado'); return; }
            throw new Error('Backend dijo que no');
          })
          .catch(()=>{
            const body = encodeURIComponent(plainTextFromModal(modal.querySelector('.kc-modal__dialog')));
            const subject = encodeURIComponent('Resumen de la atención');
            window.location.href = `mailto:${encodeURIComponent(to)}?subject=${subject}&body=${body}`;
            alert('No se pudo enviar desde el sistema. Se abrió tu cliente de correo con el contenido.');
          });
      });
    }
  }

  // Sólo manejamos NUESTRO botón
  document.addEventListener('click', e => {
    const btn = e.target.closest('[data-kc-summary-btn="1"]');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();
    const id = btn.getAttribute('data-encounter-id') || '';
    const pid = btn.getAttribute('data-patient-id') || '';
    openSummary(id, pid);
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
});
