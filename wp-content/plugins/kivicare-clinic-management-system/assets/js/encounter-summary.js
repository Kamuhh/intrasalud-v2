(function(){
  const G = window.kcGlobals || {};
  if(!G.apiBase){ console.error('kcGlobals.apiBase no definido'); return; }

  // 1) Inyectar el botón en cada fila, pegado al de "Detalles de la factura"
  function injectButtons(){
    // evita duplicados
    document.querySelectorAll('.js-kc-open-summary').forEach(el=>el.remove());

    // criterio 1: clonar el botón de factura y renombrar
    document.querySelectorAll('button, a').forEach(btn=>{
      const label = (btn.textContent||'').trim().toLowerCase();
      if(label==='detalles de la factura' || label==='detalle de la factura'){
        const row = btn.closest('tr') || btn.parentElement;
        if(!row) return;

        // detectar encounter_id en la fila
        let id =
          row.getAttribute('data-encounter-id') ||
          (row.querySelector('[data-encounter-id]') && row.querySelector('[data-encounter-id]').getAttribute('data-encounter-id')) ||
          (row.querySelector('[name="encounter_id"]') && row.querySelector('[name="encounter_id"]').value) ||
          (btn.getAttribute('data-encounter-id')) || '';

        // último intento: buscar en href ?encounter_id=XX
        if(!id && btn.href){
          const m = btn.href.match(/[?&]encounter_id=(\d+)/);
          if(m) id = m[1];
        }
        if(!id) return;

        // crear botón
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'button button-secondary js-kc-open-summary';
        b.setAttribute('data-encounter-id', id);
        b.style.marginLeft = '6px';
        b.textContent = 'Resumen de atención';

        // insertar a la derecha del de factura
        btn.parentNode.insertBefore(b, btn.nextSibling);
      }
    });
  }

  // 2) Abrir modal
  function openSummary(id){
    fetch(`${G.apiBase}/encounter/summary?encounter_id=${encodeURIComponent(id)}`,{
      credentials:'include',
      headers:{'X-WP-Nonce': G.nonce}
    })
    .then(r=>r.json())
    .then(json=>{
      if(json?.status!=='success' || !json?.data?.html){
        alert(json?.message||'No se pudo cargar');
        return;
      }
      const old=document.querySelector('.kc-modal.kc-modal-summary'); if(old) old.remove();
      const wrap=document.createElement('div'); wrap.innerHTML=json.data.html; document.body.appendChild(wrap);

      // cerrar
      wrap.querySelectorAll('.js-kc-summary-close').forEach(b=>b.addEventListener('click',()=>wrap.remove()));
      wrap.addEventListener('click',e=>{ if(e.target.classList.contains('kc-modal')) wrap.remove(); });
      document.addEventListener('keydown',function esc(e){ if(e.key==='Escape'){ wrap.remove(); document.removeEventListener('keydown',esc); } });

      // imprimir
      const printBtn=wrap.querySelector('.js-kc-summary-print');
      if(printBtn){
        printBtn.addEventListener('click',()=>{
          const node=wrap.querySelector('.kc-modal__dialog');
          const w=window.open('','_blank'); if(!w) return;
          w.document.write('<html><head><title>Resumen de atención</title>');
          document.querySelectorAll('link[rel="stylesheet"]').forEach(l=>w.document.write(l.outerHTML));
          w.document.write('</head><body>'+node.outerHTML+'</body></html>');
          w.document.close(); w.focus(); w.print();
        });
      }

      // correo
      const emailBtn=wrap.querySelector('.js-kc-summary-email');
      if(emailBtn){
        emailBtn.addEventListener('click',()=>{
          const to=prompt('Correo de destino',''); if(!to) return;
          fetch(`${G.apiBase}/encounter/summary/email`,{
            method:'POST', credentials:'include',
            headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8','X-WP-Nonce':G.nonce},
            body:`encounter_id=${encodeURIComponent(id)}&to=${encodeURIComponent(to)}`
          }).then(r=>r.json()).then(resp=>{
            alert(resp?.status==='success'?'Enviado':(resp?.message||'No se pudo enviar'));
          }).catch(()=>alert('Error de red'));
        });
      }
    })
    .catch(()=>alert('Error de red'));
  }

  // delegación de eventos
  document.addEventListener('click',e=>{
    const btn=e.target.closest('.js-kc-open-summary');
    if(btn){
      e.preventDefault();
      const id=btn.getAttribute('data-encounter-id');
      if(id) openSummary(id);
    }
  });

  // inyectar al cargar y cuando cambie la tabla (SPA)
  const boot = ()=>injectButtons();
  document.addEventListener('DOMContentLoaded', boot);
  const obs = new MutationObserver(()=>injectButtons());
  obs.observe(document.documentElement, {childList:true, subtree:true});
})();
