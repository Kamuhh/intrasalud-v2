(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        
        callSwiper();

    });
    
})(jQuery);

function callSwiper(){

    var sliders = [];

    if (jQuery('.swiper').length > 0) {
        jQuery('.swiper').each(function(index, element) {

            var sliderAutoplay = false
            var enable_autoplay = (jQuery(this).data('enable_autoplay')) ? jQuery(this).data('enable_autoplay') : "";

            if (enable_autoplay == 'yes') {
                var sliderAutoplay = {
                    delay: jQuery(this).data('autoplay'),
                    disableOnInteraction: false,
                }
            }

            jQuery(this).addClass('s' + index);
            var slider = new Swiper('.s' + index, {
                slidesPerView: jQuery(this).data('items'),
                spaceBetween: jQuery(this).data('spacebtslide'),
                loopedSlides: 3,
                speed: 1500,
                autoplay: sliderAutoplay,
                loop: jQuery(this).data('loop'),
                centeredSlides: jQuery(this).data('centered_slides'),
                pagination: {
                    el: '.swiper-pagination',
                    type: 'fraction',
                    renderFraction: function(currentClass, totalClass) {
                        return '<span class="' + currentClass + '"></span>' +
                            ' <span class="iq-swiper-line"></span> ' +
                            '<span class="' + totalClass + '"></span>';
                    },
                },

                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    // when window width is >= 0px
                    0: {
                        slidesPerView: jQuery(this).data("items-mobile"),

                    },
                    // when window width is >= 786px
                    786: {
                        slidesPerView: jQuery(this).data("items-tab"),

                    },
                    // when window width is >= 1023px
                    1023: {
                        slidesPerView: jQuery(this).data("items-laptop"),

                    },
                    1199: {
                        slidesPerView: jQuery(this).data("items"),
                    }
                }
            });
            sliders.push(slider);
            setTimeout(function () {
                window.dispatchEvent(new Event('resize'));
            }, 500);

        });
    }

}