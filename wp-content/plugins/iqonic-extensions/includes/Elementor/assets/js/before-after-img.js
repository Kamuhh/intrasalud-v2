
(function ($) {
    "use strict";
    jQuery(window).on('elementor/frontend/init', function () {
        if (typeof window.elementorFrontend !== 'undefined' && typeof window.elementorFrontend.hooks !== 'undefined') {
            // If Elementor is in the Editor's Preview mode

            if (elementorFrontend.isEditMode()) {
                elementorFrontend.hooks.addAction('frontend/element_ready/widget', function (scope) {
                    if (scope.find(".kivicare-ba-img-container[data-orientation!='vertical']")) {
                        var h_selector = scope.find(".kivicare-ba-img-container[data-orientation!='vertical']");
                        call_ba_h(h_selector);
                    }
                    if (scope.find(".kivicare-ba-img-container[data-orientation='vertical']")) {
                        var v_selector = scope.find(".kivicare-ba-img-container[data-orientation='vertical']");
                        call_ba_v(v_selector);
                    }
                });
            }
        }
    });
    jQuery(window).load(function () {
        
        if (jQuery(".kivicare-ba-img-container[data-orientation!='vertical']").length > 0) {
            var h_selector = jQuery(".kivicare-ba-img-container[data-orientation!='vertical']");
            call_ba_h(h_selector);
        }
        if (jQuery(".kivicare-ba-img-container[data-orientation='vertical']").length > 0) {
            var v_selector = jQuery(".kivicare-ba-img-container[data-orientation='vertical']");
            call_ba_v(v_selector);
        }
        
    });

})(jQuery);
function call_ba_h(selector) {
    selector.twentytwenty({
        default_offset_pct: 0.5,
        no_overlay: true,
    });
}
function call_ba_v(selector) {
    
    selector.twentytwenty({
        default_offset_pct: 0.4,
        no_overlay: true,
        orientation: 'vertical'
    });
}
