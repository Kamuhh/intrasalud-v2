(function ($) {
    "use strict";
    $(window).ready(function () {
        if ($(document).find('.dropdown-hover').length > 0) {
            $(".kivicare-cart.dropdown-hover").hover(function () {
                if ($(window).width() > 767) {
                    var isHovered = $(this).is(":hover");
                    if (isHovered) {
                        $(this).find(".dropdown-menu").stop().fadeIn(300);
                    } else {
                        $(this).find(".dropdown-menu").stop().fadeOut(300);
                    }
                }
            });
            $(".kivicare-users-settings .dropdown-hover").hover(function () {
                var isHovered = $(this).is(":hover");
                if (this.getBoundingClientRect().x < 300)
                    $(this).find(".dropdown-menu").addClass('kivicare-open-right');
                else
                    $(this).find(".dropdown-menu").removeClass('kivicare-open-right');

                if (isHovered) {
                    $(this).find(".dropdown-menu").stop().fadeIn(300);
                } else {
                    $(this).find(".dropdown-menu").stop().fadeOut(300);
                }
            });

            $(document).on('click', ".dropdown-hover a.dropdown-cart", function () {
                if ($(window).width() < 768) {
                    $(this).closest('.dropdown-hover').find('.dropdown-menu-mini-cart').stop().fadeIn(300);
                }
            });
            $(document).on('click', ".dropdown-close", function () {
                if ($(window).width() < 768) {
                    $(this).closest('.dropdown-menu-mini-cart').stop().fadeOut(300);
                }
            });
        }

    });


    
})(jQuery);

