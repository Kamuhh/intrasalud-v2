(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        
        callOwlCarousel();
		window.dispatchEvent(new Event('resize'));

    });
    
})(jQuery);

function callOwlCarousel(){

    jQuery('.owl-carousel').each(function() {

        var jQuerycarousel = jQuery(this);
        let is_rtl = false;
        if(document.getElementsByTagName("html")[0].getAttribute('dir') == "rtl") {
            is_rtl = true;
        }
        jQuerycarousel.owlCarousel({
            items: jQuerycarousel.data("items"),
            loop: jQuerycarousel.data("loop"),
            margin: jQuerycarousel.data("margin"),
            nav: jQuerycarousel.data("nav"),
            dots: jQuerycarousel.data("dots"),
            autoplay: jQuerycarousel.data("autoplay"),
            autoplayTimeout: jQuerycarousel.data("autoplay-timeout"),
            navText: ["<i aria-hidden='true' class='ion ion-ios-arrow-back'></i>", "<i aria-hidden='true' class='ion ion-ios-arrow-forward'></i>"],
            responsiveClass: true,
            autoplaySpeed: 1000,
            smartSpeed: 1000,
            dotsEach: jQuerycarousel.data("doteach"),
            center: jQuerycarousel.data("centermode"),
            rtl: is_rtl,
            responsive: {
                // breakpoint from 0 up
                0: {
                    dotsEach: 1,
                    items: jQuerycarousel.data("items-mobile-sm"),
                    nav: false,
                    dots: true,
                },
                // breakpoint from 480 up
                480: {
                    dotsEach: 2,
                    items: jQuerycarousel.data("items-mobile"),
                    nav: false,
                    dots: true,
                },
                // breakpoint from 786 up
                768: {
                    dotsEach: 3,
                    items: jQuerycarousel.data("items-tab"),
                    dots: true,
                },
                // breakpoint from 1023 up
                1023: {
                    dotsEach: 1,
                    items: jQuerycarousel.data("items-laptop"),
                },
                1199: {
                    dotsEach: jQuerycarousel.data("doteach"),
                    items: jQuerycarousel.data("items"),
                }
            }
        });
    });
    
}