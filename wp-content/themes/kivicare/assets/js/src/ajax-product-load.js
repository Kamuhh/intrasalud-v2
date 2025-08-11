(function (jQuery) {
    loadmore_product();
})(jQuery);

function loadmore_product(kivicare_option_product=jQuery('.kivicare-product-main-list').data('options')) {
    let canBeLoaded = true,
        bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
    if (kivicare_option_product == 'load_more') {
        jQuery('.kivicare_loadmore_product').unbind('click').click(function () {
            let button_load = jQuery(this).attr('data-loading-text');
            let button_text = jQuery(this).text();
            let button = jQuery(this),
                data = {
                    'action': 'loadmore_product',
                    'query': kivicare_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                    'page': kivicare_loadmore_params.current_page,
                    'is_grid': jQuery('.kivicare-product-view-buttons').find('.btn.active').hasClass('kivicare-view-grid')
                };
            jQuery.ajax({ // you can also use jQuery.post here
                url: kivicare_loadmore_params.ajaxurl, // AJAX handler
                data: data,
                type: 'POST',
                beforeSend: function (xhr) {
                    button.text(button_load); // change the button text, you can also add a preloader image
                },
                success: function (data) {
                    if (data) {
                        button.text(button_text).prev('div').append(data); // insert new posts
                        kivicare_loadmore_params.current_page++;
                        update_product_count();
                        jQuery('.kivicare-product-main-list').attr('data-pagedno', kivicare_loadmore_params.current_page);

                        if (kivicare_loadmore_params.current_page >= kivicare_loadmore_params.max_page)
                            button.remove(); // if last page, remove the button

                        wp.hooks.doAction("yith_wcwl_init_add_to_wishlist_components")

                    } else {
                        button.remove(); // if no data, remove the button as well
                    }
                }
            });
        });
    }

    if (kivicare_option_product == 'infinite_scroll') {
        jQuery(window).unbind('scroll').scroll(function () {

            //** search load more *//
            if (jQuery(document).scrollTop() > (jQuery(document).height() - bottomOffset) && canBeLoaded == true) {
                canBeLoaded = false;
                let data = {
                    'action': 'loadmore_product',
                    'query': kivicare_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                    'page': kivicare_loadmore_params.current_page,
                    'is_grid': jQuery('.kivicare-product-view-buttons').find('.btn.active').hasClass('kivicare-view-grid')
                };

                jQuery.ajax({ // you can also use jQuery.post here
                    url: kivicare_loadmore_params.ajaxurl, // AJAX handler
                    data: data,
                    type: 'POST',
                    beforeSend: function (xhr) {
                    },
                    success: function (data) {
                        if (data) {
                            jQuery(".loader-wheel-container").html('<div class="loader-wheel"><i><i><i><i><i><i><i><i><i><i><i><i></i></i></i></i></i></i></i></i></i></i></i></i></div>');
                            jQuery('.kivicare-product-main-list').find('.products').append(data);
                            update_product_count();
                            kivicare_loadmore_params.current_page++;
                            canBeLoaded = true; // the ajax is completed, now we can run it again
                            jQuery('.kivicare-product-main-list').attr('data-pagedno', kivicare_loadmore_params.current_page);

                            if (kivicare_loadmore_params.current_page >= kivicare_loadmore_params.max_page)
                                jQuery(".loader-wheel-container").html('');
                        }
                        else {
                            jQuery(".loader-wheel-container").html('');
                        }
                    }
                });
            }
        });

    }
}

function update_product_count(result_count_element = jQuery('.woocommerce-result-count'), per_paged = jQuery('.woocommerce-result-count').data('product-per-page')) {
    let text = result_count_element.text();
    let content_text_arr = text.trim().split(' ');
    let count_arr = content_text_arr[1].split('–');

    count_arr[1] = Number(count_arr[1]) + Number(per_paged);
    if (count_arr[1] > content_text_arr[3]) {
        count_arr[1] = content_text_arr[3];
    }
    content_text_arr[1] = count_arr.join('–')
    result_count_element.html(content_text_arr.join(' '));
}
