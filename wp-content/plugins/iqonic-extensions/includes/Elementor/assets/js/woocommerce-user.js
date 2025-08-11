/*----------------
Video Popup
---------------------*/
(function ($) {
    "use strict";
    $(document).ready(function () {
        callUserList();
    });
})(jQuery);

function callUserList() {
    if (jQuery(document).find('#btn-user-list').length > 0) {
        jQuery(document).find('#btn-user-list').each(function () {
            jQuery(document).on('click', '#btn-user-list', function () {
                jQuery('.kivicare-usermenu-dropdown li.header-user-rights , .kivicare-usermenu-dropdown .header-user-rights').toggleClass('kivicare-show');
                jQuery('header .kivicare-sub-dropdown.kivicare-user-dropdown').toggleClass('active');
                jQuery('.kivicare-usermenu-dropdown li.header-search-right , .kivicare-usermenu-dropdown .header-search-right, .search_form_wrap').removeClass('kivicare-show');
                jQuery('header .search-box, .search-box').removeClass('active');
            });
        });
    }
}