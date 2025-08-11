function iq_hf_layout_open_layout_editor($el) {
    window.open($el.getAttribute('href'));
}
function iq_hf_layout_change_layout_value($layout_el) {
    let iq_hf_layout_select_layout = $layout_el.getAttribute('data-value');
    let iq_hf_layout_layout_type = $layout_el.parentElement.getAttribute('data-layout-type');

    jQuery.get(iq_layout_params.ajaxURL, {
        action: 'iq_change_page_layout',
        layout_type: iq_hf_layout_layout_type,
        page_id: iq_layout_params.page_ID,
        layout: iq_hf_layout_select_layout

    }).catch(function (er) {
        console.log(er);

    }).then(function (res) {
        console.log(res);
        elementor.reloadPreview()
    });
}

function iq_hf_layout_toggle_dropdown(btn) {
    jQuery(btn.parentElement.nextElementSibling.querySelector('.iq-layout-selector')).slideToggle();
}

