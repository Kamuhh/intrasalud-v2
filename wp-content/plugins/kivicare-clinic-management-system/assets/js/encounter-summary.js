(function () {
    const G = window.kcGlobals || {};
    const ajaxUrl = G.ajaxUrl || '/wp-admin/admin-ajax.php';

    // Si REST falla una vez, persistimos usar admin-ajax para evitar 404 repetidos
    let useAjaxOnly = (window.localStorage.getItem('kcSummaryUseAjax') === '1');
    function setAjaxOnly() { useAjaxOnly = true; try { localStorage.setItem('kcSummaryUseAjax', '1'); } catch (e) { } }

    // ------------ util ------------
    function extractId(str) {
        if (!str) return null;
        let m = String(str).match(/[?&#]\s*encounter_id\s*=\s*(\d+)/i); if (m) return m[1];
        m = String(str).match(/[?&#]\s*id\s*=\s*(\d+)/i); if (m) return m[1];
        m = String(str).match(/\bencounter_id\s*=\s*(\d+)/i); if (m) return m[1];
        m = String(str).match(/\bid\s*=\s*(\d+)/i); if (m) return m[1];
        m = String(str).match(/(?:encounter|consulta|encuentro)[\/#=-]+(\d+)/i); if (m) return m[1];
        return null;
    }

    // recuerda el último encounter_id visto (la UI es tipo SPA)
    window.__KC_LAST_ENCOUNTER_ID__ = window.__KC_LAST_ENCOUNTER_ID__ || null;
    (function hookNet() {
        try {
            const _open = XMLHttpRequest.prototype.open;
            const _send = XMLHttpRequest.prototype.send;
            XMLHttpRequest.prototype.open = function (m, u) { this.__kc_url = u; return _open.apply(this, arguments); };
            XMLHttpRequest.prototype.send = function (b) { try { const id = extractId(this.__kc_url) || extractId(typeof b === 'string' ? b : ''); if (id) window.__KC_LAST_ENCOUNTER_ID__ = id; } catch (e) { } return _send.apply(this, arguments); };
            if (window.fetch) {
                const _f = window.fetch;
                window.fetch = function (input, init) {
                    try {
                        const url = typeof input === 'string' ? input : (input && input.url) || '';
                        const body = init && typeof init.body === 'string' ? init.body : '';
                        const id = extractId(url) || extractId(body);
                        if (id) window.__KC_LAST_ENCOUNTER_ID__ = id;
                    } catch (e) { }
                    return _f.apply(this, arguments);
                };
            }
        } catch (e) { }
    })();

    function findEncounterId() {
        if (window.__KC_LAST_ENCOUNTER_ID__) return window.__KC_LAST_ENCOUNTER_ID__;
        const el = document.querySelector('[data-encounter-id]'); if (el) return el.getAttribute('data-encounter-id');
        const hidden = document.querySelector('[name="encounter_id"],#encounter_id,input[data-name="encounter_id"]');
        if (hidden && hidden.value) return hidden.value;
        const qs = new URLSearchParams(window.location.search);
        if (qs.get('encounter_id')) return qs.get('encounter_id');
        if (qs.get('id')) return qs.get('id');
        const hid = extractId(window.location.hash || ''); if (hid) return hid;
        try {
            const entries = performance.getEntriesByType('resource');
            for (let i = entries.length - 1; i >= 0; i--) {
                const id = extractId(entries[i].name || '');
                if (id) return id;
            }
        } catch (e) { }
        return null;
    }

    // endpoints
    function hasREST() { return !!G.apiBase && !useAjaxOnly; }
    const REST = {
        summary: id => `${G.apiBase}/encounter/summary?encounter_id=${encodeURIComponent(id)}`,
        email: () => `${G.apiBase}/encounter/summary/email`,
        headers: m => (m === 'GET') ? { 'X-WP-Nonce': G.nonce }
            : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8', 'X-WP-Nonce': G.nonce },
    };
    const AJAX = {
        summary: id => `${ajaxUrl}?action=kc_encounter_summary&encounter_id=${encodeURIComponent(id)}`,
        email: () => `${ajaxUrl}?action=kc_encounter_summary_email`,
        headers: () => ({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }),
    };

    function fetchJSON(restUrl, restHeaders, ajaxUrl2, ajaxHeaders) {
        if (!hasREST()) {
            return fetch(ajaxUrl2, { credentials: 'include', headers: ajaxHeaders }).then(r => r.json());
        }
        return fetch(restUrl, { credentials: 'include', headers: restHeaders })
            .then(r => { if (!r.ok) { setAjaxOnly(); return fetch(ajaxUrl2, { credentials: 'include', headers: ajaxHeaders }).then(j => j.json()); } return r.json(); })
            .catch(() => { setAjaxOnly(); return fetch(ajaxUrl2, { credentials: 'include', headers: ajaxHeaders }).then(r => r.json()); });
    }

    // ---------- inyección del botón ----------
    function injectButtonOnce() {
        const buttons = Array.from(document.querySelectorAll('button,a,[role="button"]'))
            .filter(el => !el.closest('.kc-modal'));

        buttons.forEach(el => {
            const t = (el.textContent || '').trim().toLowerCase();
            const isSummary = t === 'resumen de la atención' || (t.includes('resumen') && t.includes('atención'));
            const isOurs = el.matches('[data-kc-summary-btn="1"]');
            if (isSummary && !isOurs) el.remove();
        });

        const billBtn = buttons.find(el => {
            const t = (el.textContent || '').toLowerCase();
            return t.includes('detalle') && t.includes('factura');
        });

        let summaryBtn = document.querySelector('[data-kc-summary-btn="1"]');
        const currentId = findEncounterId();
        if (summaryBtn) {
            if (currentId && !summaryBtn.getAttribute('data-encounter-id')) {
                summaryBtn.setAttribute('data-encounter-id', currentId);
            }
            return;
        }

        if (billBtn) {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'button button-secondary js-kc-open-summary';
            b.style.marginLeft = '6px';
            b.setAttribute('data-kc-summary-btn', '1');
            if (currentId) b.setAttribute('data-encounter-id', currentId);
            b.innerHTML = '<span style="margin-right:6px;"></span>Resumen de la atención';
            billBtn.parentNode.insertBefore(b, billBtn.nextSibling);
        }
    }

    // ---------- modal ----------
    function openSummary(id) {
        if (!id) id = findEncounterId();
        if (!id) { alert('No se pudo detectar el ID del encuentro'); return; }

        const restUrl = REST.summary(id);
        const ajaxUrl2 = AJAX.summary(id);

        fetchJSON(restUrl, REST.headers('GET'), ajaxUrl2, AJAX.headers())
            .then(json => {
                const ok = json && (json.status === 'success' || json.success === true);
                const data = json && (json.data || json);
                if (!ok || !data || !data.html) { alert((json && json.message) || 'No se pudo cargar'); return; }

                const old = document.querySelector('.kc-modal.kc-modal-summary'); if (old) old.remove();
                const wrap = document.createElement('div'); wrap.innerHTML = data.html; document.body.appendChild(wrap);

                wrap.querySelectorAll('.js-kc-summary-close').forEach(b => b.addEventListener('click', (ev) => { ev.stopPropagation(); wrap.remove(); }));
                wrap.addEventListener('click', e => { if (e.target.classList.contains('kc-modal')) wrap.remove(); });
                document.addEventListener('keydown', function esc(e) { if (e.key === 'Escape') { wrap.remove(); document.removeEventListener('keydown', esc); } });

                // ---- NUEVO HANDLER DE IMPRESIÓN ----
                const printBtn = wrap.querySelector('.js-kc-summary-print');
                if (printBtn) printBtn.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    const encounterId = findEncounterId();
                    if (!encounterId) { alert('No se pudo detectar el ID del encuentro.'); return; }
                    const pdfUrl = ajaxUrl + '?action=kc_encounter_summary_pdf&encounter_id=' + encodeURIComponent(encounterId);
                    window.open(pdfUrl, '_blank', 'noopener');
                });

                // correo se queda igual...
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
                    const to = defaultEmail || prompt('Correo de destino', '') || '';
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
                            alert('No se pudo enviar desde el sistema.');
                        });
                });
            })
            .catch(() => alert('Error de red'));
    }

    document.addEventListener('click', e => {
        const btn = e.target.closest('[data-kc-summary-btn="1"]');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        const id = btn.getAttribute('data-encounter-id') || '';
        openSummary(id);
    });

    function boot() { injectButtonOnce(); }
    document.addEventListener('DOMContentLoaded', boot);
    const mo = new MutationObserver(() => injectButtonOnce());
    mo.observe(document.documentElement, { childList: true, subtree: true });
})();
