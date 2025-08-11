(function ($) {
    "use strict";
    $(document).ready(function () {
        Servicesliderslider();
    });
})(jQuery);


function Servicesliderslider() {
    var $sliders = jQuery(document).find('.kivicare-service-slider-2');
    if ($sliders.length > 0) {

        $sliders.each(function (e) {

            let slider = jQuery(this);
            var swSpace = {
                1200: 30,
                1500: 30
            };

            var breakpoint = {
                0: {
                    slidesPerView: 1,
                    centeredSlides: false,
                    virtualTranslate: false
                },
                576: {
                    slidesPerView: 1,
                    centeredSlides: false,
                    virtualTranslate: false
                },
                768: {
                    slidesPerView: 2,
                    centeredSlides: false,
                    virtualTranslate: false
                },
                1200: {
                    slidesPerView: 2.3,
                    spaceBetween: swSpace["1200"],
                },
                1500: {
                    slidesPerView: 2.3,
                    spaceBetween: swSpace["1500"],
                },
            }

            var sw_config = {
                loop: true,
                speed: 1000,
                loopedSlides: 3,
                spaceBetween: 30,
                slidesPerView: 2.3,
                centeredSlides: true,
                autoplay: true,
                virtualTranslate: true,
                on: {
                    slideChangeTransitionStart: function () {
                        var currentElement = jQuery(this.el);
                        if (jQuery(window).width() > 1199) {

                            var innerTranslate = -(327 + swSpace[this.currentBreakpoint]) * (this.activeIndex) + 357;
                            currentElement.find(".swiper-wrapper").css({
                                "transform": "translate3d(" + innerTranslate + "px, 0, 0)"
                            });

                            currentElement.find('.swiper-slide:not(.swiper-slide-active)').css({
                                width: "327px"
                            });

                            currentElement.find('.swiper-slide.swiper-slide-active').css({
                                width: "685px"
                            });
                        }
                    },
                    resize: function () {
                        var currentElement = jQuery(this.el);
                        if (jQuery(window).width() > 1199) {
                            if (currentElement.data("loop")) {
                                var innerTranslate = -(327 + swSpace[this.currentBreakpoint]) * this.loopedSlides + 357;

                                currentElement.find(".swiper-wrapper").css({
                                   "transform": "translate3d(" + innerTranslate + "px, 0, 0)"
                                });
                            }
                            currentElement.find('.swiper-slide:not(.swiper-slide-active)').css({
                                width: "327px"
                            });
                            currentElement.find('.swiper-slide.swiper-slide-active').css({
                                width: "685px"
                            });
                        }
                    },
                    init: function () {
                        var currentElement = jQuery(this.el);
                        currentElement.find('.swiper-slide').css({
                            'max-width': 685
                        });
                    }
                },
                breakpoints: breakpoint,
            };
            var swiper = new Swiper(slider[0], sw_config);
        });

    }

}