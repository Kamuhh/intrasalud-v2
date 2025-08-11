(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {

        callSlickSlider();

    });
    
})(jQuery);

function callSlickSlider(){

    /*------------------------
        Slick Slider
    --------------------------*/
    jQuery('.slider.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        centerMode: true,
        focusOnSelect: true,
        asNavFor: '.slider-nav',
    });

    jQuery('.slider.slider-nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        arrows: true,
        centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '30',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: ['nav-arrow'],
                    centerMode: true,
                    centerPadding: '15',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 320,
                settings: {
                    arrows: ['nav-arrow'],
                    centerMode: true,
                    centerPadding: '15',
                    slidesToShow: 1
                }
            }

    ],
    });

}