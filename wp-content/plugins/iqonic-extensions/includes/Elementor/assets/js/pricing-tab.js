(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        pricingTab();
    });
})(jQuery);

function pricingTab() {
    jQuery('.kivicare-service-list .price-content:first,.kivicare-service-list .service-name:first').addClass('active');
    jQuery(document).find('.kivicare-service-list').on('click', '.switch', function () {
        if(jQuery('.kivicare-service-list .service-name:first').hasClass("active")) {
            jQuery('.kivicare-service-list .service-name:first').removeClass("active");
        } else {
            jQuery('.kivicare-service-list .service-name:first').addClass("active");
        }
        if(jQuery('.kivicare-service-list .service-name:last').hasClass("active")) {
            jQuery('.kivicare-service-list .service-name:last').removeClass("active");
        } else {
            jQuery('.kivicare-service-list .service-name:last').addClass("active");
        }
        var hoverServImg = jQuery('.service-name.active').data("price");
        jQuery('.kivicare-service-list .price-content').removeClass("active");
        jQuery('.price-wrapper').find('.price-content.' + hoverServImg).addClass("active");
    });
}