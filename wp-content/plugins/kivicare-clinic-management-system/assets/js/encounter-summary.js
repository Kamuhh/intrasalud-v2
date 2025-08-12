(function(){
  const g = window.kcGlobals || {};
  if(!g.apiBase){ console.error('kcGlobals.apiBase no definido'); return; }

  function openSummary(id){
    fetch(`${g.apiBase}/encounter/summary?encounter_id=${encodeURIComponent(id)}`,{
      credentials:'include',
      headers:{'X-WP-Nonce': g.nonce}
    })
    .then(r=>r.json())
    .then(json=>{
      if(json?.status!=='success' || !json?.data?.html){ alert(json?.message||'No se pudo cargar'); return; }
      const old=document.querySelector('.kc-modal.kc-modal-summary'); if(old) old.remove();
      const wrap=document.createElement('div'); wrap.innerHTML=json.data.html; document.body.appendChild(wrap);
      wrap.querySelectorAll('.js-kc-summary-close').forEach(b=>b.addEventListener('click',()=>wrap.remove()));
      wrap.addEventListener('click',e=>{ if(e.target.classList.contains('kc-modal')) wrap.remove(); });
      document.addEventListener('keydown',function esc(e){ if(e.key==='Escape'){ wrap.remove(); document.removeEventListener('keydown',esc); } });
      const printBtn=wrap.querySelector('.js-kc-summary-print');
      if(printBtn){ printBtn.addEventListener('click',()=>{
        const node=wrap.querySelector('.kc-modal__dialog'); const w=window.open('','_blank'); if(!w) return;
        w.document.write('<html><head><title>Resumen de atención</title>');
        document.querySelectorAll('link[rel="stylesheet"]').forEach(l=>w.document.write(l.outerHTML));
        w.document.write('</head><body>'+node.outerHTML+'</body></html>'); w.document.close(); w.focus(); w.print();
      });}
      const emailBtn=wrap.querySelector('.js-kc-summary-email');
      if(emailBtn){ emailBtn.addEventListener('click',()=>{
        const to=prompt('Correo de destino',''); if(!to) return;
        fetch(`${g.apiBase}/encounter/summary/email`,{
          method:'POST', credentials:'include',
          headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8','X-WP-Nonce':g.nonce},
          body:`encounter_id=${encodeURIComponent(id)}&to=${encodeURIComponent(to)}`
        }).then(r=>r.json()).then(resp=>{
          alert(resp?.status==='success'?'Enviado':(resp?.message||'No se pudo enviar'));
        }).catch(()=>alert('Error de red'));
      });}
    })
    .catch(()=>alert('Error de red'));
  }

  document.addEventListener('click',e=>{
    const btn=e.target.closest('.js-kc-open-summary');
    if(btn){ e.preventDefault(); const id=btn.getAttribute('data-encounter-id'); if(id) openSummary(id); }
  });
})();
