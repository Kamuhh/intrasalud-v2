(function () {

    "use strict";
    // Init elements after creation
    jQuery(window).on('elementor/frontend/init', function () {
        if (typeof window.elementorFrontend !== 'undefined' && typeof window.elementorFrontend.hooks !== 'undefined') {
            // If Elementor is in the Editor's Preview mode
            if (elementorFrontend.isEditMode()) {
                elementorFrontend.hooks.addAction('frontend/element_ready/global', function () {
                    jQuery('.elementor-element.elementor-element-edit-mode.elementor-widget').addClass('hf-elementor-layout');
                });
            }
        }
    });
    jQuery(document).ready(function () {
        if (jQuery(".iqonic-custom-width").length > 0 && jQuery(".layouts-section-position-static").length > 0) {
            jQuery(".layouts-section-position-static").closest(".elementor > .elementor-section").addClass("column-has-position-static");
        }
        if (jQuery('.iqonic-megamenu-container').length > 0) {
            let megaMenus = jQuery('.iqonic-megamenu-container');
            setTimeout(function () {
                megaMenus.each(function () {
                    var $this = jQuery(this),
                        page_width = jQuery(window).width();
                    if ($this.hasClass('iqonic-full-width')) {
                        $this.css({
                            'width': page_width
                        });
                    }
                    if ($this.hasClass('iqonic-container-width')) {
                        let containerWidth = ($this.closest('.elementor-container').length > 0) ? $this.closest('.elementor-container').width() : $this.parents('li').eq(0).closest('header nav.header-offset').width();
                        $this.css({
                            'width': containerWidth
                        });
                    }
                });
            }, 350);
        }
    });

    jQuery(window).scroll(function () {
        // -----sticky menu
        if (jQuery('.default-hidden-enable').length > 0) {
            var scroll = jQuery(window).scrollTop();

            if (scroll > 400) {
                jQuery('.has-sticky.default-hidden-enable').removeClass('header-default-hidden');
            } else {
                jQuery('.has-sticky.default-hidden-enable').addClass('header-default-hidden');
            }

        }
    });
})();