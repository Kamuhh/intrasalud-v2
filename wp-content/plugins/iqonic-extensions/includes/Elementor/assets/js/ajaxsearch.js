(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {

        jQuery('.iq-ajax-search').each(function () {

            jQuery(this).find('.search-toggle').on('click', function () {
                jQuery(this).parent().toggleClass('iq-show');
                jQuery(this).toggleClass('active');
                jQuery(this).siblings('.search-box').find('.search__input').focus();
            });
            jQuery(this).find('.search__input').keyup(  _.debounce(function () {

                let keyword = jQuery(this).val();
                let form = jQuery(this);
                console.log(keyword);

                if (keyword == "") {
                    jQuery(this).siblings('.datafetch').html('');
                } else {
                    jQuery.ajax({
                        url: iqonic_loadmore_params.ajaxurl,
                        data: {
                            action: 'data_fetch_search',
                            keyword: keyword
                        },
                        type: 'POST',
                        success: function (data) {
                            form.siblings('.datafetch').html(data);
                        }
                    });
                }
            },500));
        });
    });

    jQuery(window).on('click', function (e) {
        if (!jQuery(e.target).closest(".iq-ajax-search").length) {
            jQuery('.iq-ajax-search.iq-show').removeClass('iq-show');
        }
    });
})(jQuery);
