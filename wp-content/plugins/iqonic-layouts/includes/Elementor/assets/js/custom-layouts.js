/*------------------------
Custom Layout
--------------------------*/
(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        if (jQuery('.iqonic-custom-layouts').length > 0) {
            var container = jQuery('.iqonic-custom-layouts');
            container.each(function () {
                let id = '#' + jQuery(this).attr('id');
                let click_element=jQuery('a[href=' + id + '] , a[data-target="'+ id + '"]');
                click_element.on('click', function (e) {
                    e.preventDefault();
                    jQuery(id).show().toggleClass('hidden-custom-layout open');
                    
                });

            });
            jQuery('.hidden-custom-layout').css('display', '');
            jQuery('body').on('click', '.iqonic-custom-layouts.open button.btn-close', function (e) {
                jQuery(this).closest('.iqonic-custom-layouts').toggleClass('hidden-custom-layout open');
            });
        }
    });
})(jQuery);