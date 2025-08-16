(function(){
    function injectButton(){
        if(document.querySelector('[data-kc-summary-btn]')) return;
        var billBtn = Array.from(document.querySelectorAll('button,a')).find(function(el){
            var t = (el.textContent || '').toLowerCase();
            return t.includes('detalle') && t.includes('factura');
        });
        if(!billBtn) return;
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'button button-secondary js-kc-open-summary';
        b.textContent = 'Resumen de la atención';
        b.setAttribute('data-kc-summary-btn','1');
        billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
    }
    document.addEventListener('DOMContentLoaded', injectButton);
    var mo = new MutationObserver(injectButton);
    mo.observe(document.documentElement,{childList:true,subtree:true});

    function closeModal(modal){
        modal.style.display='none';
        document.body.classList.remove('kc-modal-open');
    }

    document.addEventListener('click', function(e){
        var openBtn = e.target.closest('.js-kc-open-summary,[data-kc-summary-btn]');
        if(openBtn){
            e.preventDefault();
            var modal = document.querySelector('.kc-modal-summary');
            if(modal){
                modal.style.display='block';
                document.body.classList.add('kc-modal-open');
            }
            return;
        }
var closeBtn = e.target.closest('.js-kc-summary-close');
        if(closeBtn){
            e.preventDefault();
            closeModal(closeBtn.closest('.kc-modal'));
            return;
        }
    }
if(e.target.classList.contains('kc-modal')){
            closeModal(e.target);
        }
    });

    document.addEventListener('click', function(e){
        var printBtn = e.target.closest('.js-kc-summary-print');
        if(!printBtn) return;
        e.preventDefault();
        var dialog = document.querySelector('.kc-modal-summary .kc-modal__dialog');
        if(!dialog) return;
        var w = window.open('', '_blank');
        if(!w) return;
        w.document.write('<html><head><title>Resumen de la atención</title>');
        document.querySelectorAll('link[rel="stylesheet"]').forEach(function(l){w.document.write(l.outerHTML);});
        w.document.write('<style>@media print{.kc-modal__dialog{box-shadow:none;max-width:none;width:100%;}} .kc-modal__footer,.kc-modal__close,button{display:none!important}</style>');
        w.document.write('</head><body>' + dialog.outerHTML + '</body></html>');
        w.document.close();
        w.focus();
        w.print();
        w.close();
    });

    document.addEventListener('click', function(e){
        var emailBtn = e.target.closest('.js-kc-summary-email');
        if(!emailBtn) return;
        e.preventDefault();
        var modal = document.querySelector('.kc-modal-summary');
        var encounterId = modal ? modal.getAttribute('data-encounter-id') : '';
        var defaultEmail = modal ? modal.getAttribute('data-patient-email') : '';
        var to = prompt('Correo de destino', defaultEmail) || '';
        if(!to) return;
        var body = new URLSearchParams();
        body.set('encounter_id', encounterId);
        body.set('to', to);
        fetch((window.kcGlobals && kcGlobals.ajaxUrl) + '?action=kc_encounter_summary_email', {
            method:'POST',
            credentials:'same-origin',
            headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},
            body: body.toString()
        })
        .then(function(r){return r.json();})
        .then(function(res){
            if(res && (res.success || res.status==='success')){
                alert('Enviado');
            }else{
                alert((res && res.message) || 'No se pudo enviar');
            }
        })
        .catch(function(){alert('No se pudo enviar');});
    });
})();
