(function ($) {
    "use strict";
    $(document).ready(function () {
        MoreMenu();
    });

})(jQuery);

function MoreMenu() {
    /*------------------------
    More Menu
    --------------------------*/
    if (jQuery('.has-more-menu-attr').length > 0) {
        let menumoreItems = jQuery('.has-more-menu-attr .header-default-menu');
        menumoreItems.each(function () {
            let max_elem = jQuery(this).data("items");
            let max_text = jQuery(this).data("text");
            let items = jQuery(this).find('.menu-all-pages-container ul.sf-menu > li');
            let surplus = items.slice(max_elem, items.length);
            surplus.wrapAll('<li class="category more_menu" id="more_menu"><ul class="top-menu more_sub_menu sub-menu">');
            jQuery(this).find('.menu-all-pages-container ul.sf-menu .more_menu').prepend('<a href="#" class="sf-with-ul" data-depth="0"><span class="pull-xs-right hidden-md-up"><span data-target="#top_moremenu" data-toggle="collapse" class="navbar-toggler collapse-icons"><i class="material-icons add">&#xE313;</i><i class="material-icons remove">&#xE316;</i></span></span></span>' + max_text + '</a>');

            jQuery(this).find('.menu-all-pages-container ul.sf-menu .more_menu').mouseover(function () {
                    jQuery(this).children('div').css('display', 'block');
                })
                .mouseout(function () {
                    jQuery(this).children('div').css('display', 'none');
                });
        });
    }

    if (jQuery('.menu-style-two.kivicare-mobile-menu').length > 0) {
        jQuery('.menu-style-two nav.mobile-menu .sub-menu').css('display', 'none ');
        jQuery('.menu-style-two nav.mobile-menu .top-menu li .dropdown').hide();
        jQuery('.menu-style-two nav.mobile-menu .sub-menu').prev().prev().addClass('submenu');
        jQuery('.menu-style-two nav.mobile-menu .sub-menu').before('<span class="toggledrop"><i class="fas fa-chevron-right"></i></span>');

        if (jQuery(window).width() > 1199) {
            jQuery('.menu-style-two nav.mobile-menu ul > li.current-menu-parent').find('ul:first').slideDown();
            jQuery('.menu-style-two nav.mobile-menu ul > li.current-menu-parent').find('.toggledrop').addClass('active');
        }
        jQuery('.menu-style-two nav.mobile-menu .top-menu .menu-item .toggledrop').off('click');
        jQuery('.menu-style-two nav.mobile-menu .menu-item .toggledrop').on('click', function (e) {
            e.preventDefault();
            if (!jQuery(this).closest('ul').parent('li').find('.toggledrop').hasClass('active') && !jQuery(this).hasClass('active')) {
                if (jQuery(window).width() > 1199) {
                    jQuery('.menu-style-two nav.mobile-menu .menu-item .sub-menu,nav.mobile-menu .menu-item .children').hide();
                } else {
                    jQuery('.menu-style-two nav.mobile-menu .menu-item .sub-menu,nav.mobile-menu .menu-item .children').slideUp();
                }
                jQuery('.menu-style-two nav.mobile-menu .menu-item .toggledrop').removeClass('active');
                jQuery('.menu-style-two nav.mobile-menu .menu-item').removeClass('menu-clicked');
                jQuery(this).parent().addClass('menu-clicked');
            }
            jQuery(this).next('.children, .sub-menu').slideToggle();
            jQuery(this).toggleClass('active');
            jQuery('.menu-style-two nav.mobile-menu .menu-item').removeClass('current-menu-ancestor');
        });
    }
    
    if (jQuery('.kivicare-mobile-menu.menu-style-one').length > 0) {
        jQuery(document).on("click", '.custom-toggler', function () {
            if (jQuery('.kivicare-mobile-menu ').hasClass('menu-open')) {
                jQuery('.kivicare-mobile-menu ').toggleClass('open-delay');
                setTimeout(function () {
                    jQuery('.kivicare-mobile-menu ').toggleClass('menu-open');
                    jQuery('.kivicare-mobile-menu ').toggleClass('open-delay');
                }, 1000);
            } else {
                jQuery('.kivicare-mobile-menu ').toggleClass('menu-open');
            }
            jQuery('.opn-menu').toggleClass('kivicare-open');
        });
    }
    
}