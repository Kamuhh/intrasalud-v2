(function (jQuery) {
    "use strict";
    jQuery(document).on("woof_ajax_done", woof_ajax_done_handler);

    jQuery(document).ready(function () {
        /*------------------------
        Wocommerce Change btn Grid View
        --------------------------*/
        change_view_btn_event();
        /*-----------------------------------
        Wocommerce Product Skeleton Structure
        -------------------------------------*/
        jQuery.ajax({
            url: kivicare_loadmore_params.ajaxurl, // AJAX handler
            data: {
                'action': 'load_skeleton',
            },
            type: 'GET',
            success: function (res) {
                localStorage.setItem('product_grid_skeleton', res['data']['skeleton-grid']);
                localStorage.setItem('product_list_skeleton', res['data']['skeleton-list']);
            }
        });
        jQuery(document.body).on('woosq_loaded', function (event) {
            jQuery('.thumbnails').addClass('iq-rtl-direction');
        });

        orig = jQuery.fn.css;
        var ev = new jQuery.Event('stylechanged'),
            orig = jQuery.fn.css;
        jQuery.fn.css = function () {
            var ret = orig.apply(this, arguments);
            jQuery(this).trigger(ev);
            return ret; // must include this
        }

        setTimeout(function () {
            jQuery('.woof_info_popup').on('stylechanged', function () {
                jQuery(this).append('<div class="kivicare-show-loader-overlay"></div>');
            });
        }, 500);

    });

})(jQuery);

var can_loaded_product_view = true;

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function setCookie(cName, cValue, expDays = 1) {
    let date = new Date();
    date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    let domain = "domain=" + isSubdomain() ? "." + window.location.hostname : "" + window.location.hostname + ";";
    document.cookie = cName + "=" + cValue + "; " + expires + "; Path=/;" + domain;
}

function ajax_product(all_products, skeleton_view) {
    jQuery.ajax({
        url: window.location.href,
        data: {
            loaded_paged: kivicare_loadmore_params.current_page
        },
        type: 'POST',
        beforeSend: function (xhr) {
            if (skeleton_view == 'product_grid_skeleton') {
                let col_no = getCookie('product_view[col_no]');
                var grid_skeleton_structure = jQuery(localStorage.getItem(skeleton_view)).siblings('.column-' + col_no);

                for (let index = 0; index < col_no; index++) {
                    all_products.append(grid_skeleton_structure.clone());
                }
            } else {
                all_products.append(jQuery(localStorage.getItem(skeleton_view)));
            }
            can_loaded_product_view = false;
            jQuery('.woocommerce-pagination').addClass('hide');
            jQuery('.woocommerce-pagination').removeClass('show');
        },
       success: function (res) {
             if (res) {
                res = jQuery(res);
                jQuery('.products').replaceWith(res.find('.products'));
                all_products.find('.skeleton-main').remove();
                loadmore_product();
                can_loaded_product_view = true;
                
                //hide pagination on loading products
                jQuery('.woocommerce-pagination').removeClass('hide');
                jQuery('.woocommerce-pagination').addClass('show');
            }

            wp.hooks.doAction("yith_wcwl_init_add_to_wishlist_components")
            
        }
    });
}

var isSubdomain = function (url = window.location.hostname) {
    var regex = new RegExp(/^([a-z]+\:\/{2})?([\w-]+\.[\w-]+\.\w+)$/);
    return !!url.match(regex); // make sure it returns boolean
}
function change_view_btn_event() {
    jQuery('.kivicare-view-grid,.kivicare-listing').on('click', function () {
        let btn = jQuery(this);
        let products = btn.parents('.sorting-wrapper').next('.products');

        if (btn.hasClass('active') || jQuery("#woof_html_buffer").is(':visible') || !can_loaded_product_view) // Condition for Remove Same Button Click Event  And Chech Woof Ajax in on Load
            return;

        setCookie('product_view[col_no]', btn.hasClass('kivicare-view-grid') ? btn.data('grid') : '1');
        setCookie('product_view[is_grid]', btn.hasClass('kivicare-view-grid') ? '2' : '1');

        jQuery('.kivicare-product-view-buttons .btn').removeClass('active');
        btn.addClass('active');

        if (btn.hasClass('kivicare-listing')) { //Condition for check switch to list to grid
            products.find('.product').fadeOut(0, function () {
                jQuery(this).remove()
            });
            btn.parents('.product-grid-style').removeClass('product-grid-style').addClass('product-list-style')
            ajax_product(products, 'product_list_skeleton'); // Call Ajax Function for  get and Append data
        } else {
            if (btn.parents('.product-grid-style').length != 1) { //Condition for check switch to list to grid
                products.find('.product').fadeOut(0, function () {
                    jQuery(this).remove()
                });
                btn.parents('.product-list-style').removeClass('product-list-style').addClass('product-grid-style')
                ajax_product(products, 'product_grid_skeleton'); // Call Ajax Function for  get and Append data
            }
        }

        setTimeout(function () {
            if (typeof btn.data('grid') != 'undefined') {
                products.removeClass('columns-2 columns-3 columns-4').addClass('columns-' + btn.data('grid'));
            } else {
                products.removeClass(' columns-2 columns-3 columns-4');
            }
            products.addClass('animated-product');

        }, 100);
        products.removeClass('animated-product');

    });
}

function woo_ordering() {
    if (jQuery('select').length > 0) {
        jQuery('select').each(function () {
            jQuery(this).select2({
                width: '100%',
            });
        });
        jQuery('.select2-container').addClass('wide');
    }
}

function woof_ajax_done_handler(e) {
    change_view_btn_event();
    loadmore_product(jQuery('.kivicare-product-main-list').data('options'));

    kivicare_loadmore_params.current_page = 1;

    jQuery.ajax({
        url: kivicare_loadmore_params.ajaxurl,
        data: {
            'action': 'fetch_woof_filter_ajax_query',
        },
        type: 'POST',
        success: function (res) {
            res = JSON.parse(res);
            if (res) {
                kivicare_loadmore_params.posts = res['query'];
                kivicare_loadmore_params.max_page = res['max_page'];
            }
        }
    });

    woo_ordering();
}