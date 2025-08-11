<?php
// Wooocmerce popup Jquery
function kivicare_load_js_css(){
    wp_enqueue_script('sweetalert2', IQONIC_EXTENSION_PLUGIN_URL . 'includes/assets/js/sweetalert2.js', array('jquery'), true);
}
add_action('wp_enqueue_scripts', 'kivicare_load_js_css');

add_action('wp_ajax_loadmore_product_widget', 'kivicare_loadmore_product_widget_ajax_handler');
add_action('wp_ajax_nopriv_loadmore_product_widget', 'kivicare_loadmore_product_widget_ajax_handler');
if (!function_exists('kivicare_loadmore_product_widget_ajax_handler')) {
    function kivicare_loadmore_product_widget_ajax_handler()
    {
        $args = isset($_POST['query']) ? (array)json_decode(str_replace("\\", "", $_POST['query'])) : false;
        $args['paged'] = isset($_POST['current_page']) ? (int) $_POST['current_page'] + 1 : 1;
        $woo_column = isset($_POST['woo_grid']) ? $_POST['woo_grid'] : '';

        $wp_query = new WP_Query($args);
        if ($wp_query->have_posts()) {
            ob_start();
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                if ($woo_column == 'list') {
                    locate_template('/template-parts/wocommerce/entry-listing.php', true, false, $args = array('id' => get_the_ID()));
                } else {
                    locate_template('/template-parts/wocommerce/entry.php', true, false, $args = array('id' => get_the_ID()));
                }
            }
            $data = ob_get_clean();
            wp_send_json_success($data, 200);
            wp_reset_postdata();
        } else {
            wp_send_json_error("No Found", 404);
        }

        die;
    }
}

// Wooocmerce add to cart popup
add_action('wp_ajax_kivicare_ajax_add_to_cart', 'kivicare_ajax_add_to_cart');
add_action('wp_ajax_nopriv_kivicare_ajax_add_to_cart', 'kivicare_ajax_add_to_cart');
function kivicare_ajax_add_to_cart()
{
    $product_id  = $_POST['product_id'];
    global $woocommerce;
    $woocommerce->cart->add_to_cart($product_id);
    die();
}

//you have to change according to above mini cart shortcode function.
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start();
?>
    <a href="#" class="dropdown-back" data-toggle="dropdown">
        <i class="fas fa-shopping-cart"></i>
        <div class="basket-item-count" style="display: inline;">
            <span class="cart-items-count count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        </div>
    </a>
<?php $fragments['a.dropdown-back'] = ob_get_clean();
    return $fragments;
});

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start();
?>
    <div class="dropdown-menu dropdown-menu-mini-cart">
        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
<?php $fragments['ul.dropdown-menu'] = ob_get_clean();
    return $fragments;
});

if ( class_exists( 'WooCommerce' ) ){
add_action('wp_footer', 'ajax_added_to_cart_popup_script');
}
function ajax_added_to_cart_popup_script()
{
    $added_to_cart_text = esc_html__("Added to cart!", "kivicare");
    $checkout_text = esc_html__("Checkout", "kivicare");
    $continue_text = esc_html__("Continue shopping", "kivicare");
?>

    <script type="text/javascript">
        jQuery(function($) {

            // On "added_to_cart" live event
            $(document.body).on('added_to_cart', function(a, b, c, d) {

                var prod_id = d.data('product_id'), // Get the product name
                    prod_qty = d.data('quantity'), // Get the quantity
                    prod_name = d.data('product_name'); // Get the product name

                Swal.fire({
                    title: '<?php echo $added_to_cart_text; ?>',
                    text: prod_name,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--color-theme-primary)',
                    cancelButtonColor: 'var(--color-theme-secondary)',
                    confirmButtonText: '<span class="iq-btn-text-holder"><?php echo $checkout_text; ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>',
                    cancelButtonText: '<span class="iq-btn-text-holder"><?php echo $continue_text; ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>',
                    customClass: {
                        confirmButton: 'popup-btn-checkout iq-new-btn-style iq-button-style-2',
                        cancelButton: 'popup-btn-continue iq-new-btn-style iq-button-style-2',
                    },
                    showClass: {
                        popup: 'animated fadeIn',
                    },
                    hideClass: {
                        popup: 'animated fadeOut',
                    }
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '<?php echo wc_get_checkout_url(); ?>';
                    }
                });
            });

        });
    </script>
<?php
}

/* woocommerce register shortcode */
add_shortcode('iqonic-signup-form', 'iqonic_woocommerce_registration');
function iqonic_woocommerce_registration($attr)
{

    if (is_admin()) return;
    if (is_user_logged_in()) return;
    ob_start();

    $args = shortcode_atts(array(
        'btn_text_string' => '',
        'button_text' => 'Sign Up',
        'url' => '#',
    ), $attr);

    do_action('woocommerce_before_customer_login_form'); ?>
    <form id="register-form" method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

        <?php do_action('woocommerce_register_form_start'); ?>

        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" placeholder="<?php echo esc_attr('Enter Your Username *', 'iqonic'); ?>" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                                                                                                    ?>
            </p>

        <?php endif; ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php echo esc_attr('Your email id *', 'iqonic'); ?>" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                                                                            ?>
        </p>

        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php echo esc_attr('Enter Your Password *', 'iqonic'); ?>" />
            </p>

        <?php endif; ?>

        <?php if (wc_get_page_id('terms') > 0) {
        ?>
            <div class="form-row terms wc-terms-and-conditions kivicare-check">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input type="checkbox" required class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true); ?> id="terms" /> <span class="text-check"><?php printf(__('By creating an account, you agree to the <a href="%s" target="_blank" class="woocommerce-terms-and-conditions-link">Terms and Conditions</a>', 'iqonic'), esc_url(wc_get_page_permalink('terms'))); ?></span> <span class="required">*</span><span class="checkmark"></span>
                </label>
                <input type="hidden" name="terms-field" value="1" />
            </div>
        <?php }  ?>

        <?php do_action('woocommerce_register_form'); ?>

        <p class="woocommerce-FormRow form-row sign-up-btn">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <!-- register button  -->
            <button type="submit" class="iq-new-btn-style iq-button-style-2 woocommerce-Button" name="register" value="<?php esc_attr_e('Register', 'iqonic'); ?>">
                <span class="iq-btn-text-holder"><?php esc_html_e('Register', 'iqonic'); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
            </button>
        </p>

        <div class="woocommerce-sign-in-btn">
            <p class="btn-text-string"><?php echo esc_html($args['btn_text_string']); ?></p>
            <p class="sign_in_text mb-0 ms-2">
                <a class="iq-button iq-btn-link iq-btn-link-new has-icon btn-icon-right" href=" <?php echo esc_url($args['url']); ?>"><?php echo esc_html($args['button_text']);  ?></a>
            </p>
        </div>

        <?php do_action('woocommerce_register_form_end'); ?>

    </form>
<?php
    return ob_get_clean();
}
/* woocommerce login shortcode */
add_shortcode('iqonic-login-form', 'iqonic_woocommerce_login_form');
function iqonic_woocommerce_login_form($attr)
{
    if (is_admin()) return;
    if (is_user_logged_in()) return;
    ob_start();
    
    $args = shortcode_atts(array(
        'btn_text_string' => '',
        'button_text' => 'Sign Up',
        'url' => '#',

    ), $attr); ?>
    
    <form class="woocommerce-form woocommerce-form-login login" method="post">

        <?php do_action('woocommerce_login_form_start'); ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" required class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" required name="password" id="password" autocomplete="current-password" />
        </p>

        <?php do_action('woocommerce_login_form'); ?>

        <div class="login-inner">
            <div class="kivicare-check">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><span class="checkmark"></span>
                    <span class="text-check"><?php esc_html_e('Remember me', 'iqonic'); ?></span>
                </label>
            </div>
            <p class="woocommerce-LostPassword lost_password">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Forgot Password?', 'iqonic'); ?></a>
            </p>
        </div>

        <p class="form-row form-submit-btn">
            <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            <!-- login button -->
            <button type="submit" class="iq-new-btn-style iq-button-style-2 woocommerce-Button" name="login" value="<?php esc_attr_e('Log in', 'iqonic'); ?>">
                <span class="iq-btn-text-holder"><?php esc_html_e('Log in', 'iqonic'); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
            </button>
        </p>

        <div class="sign-link d-flex align-items-center">
            <p class="my-0"><?php echo esc_html($args['btn_text_string']); ?></p>
            <h5 class="sign_up_text mb-0 ms-2"><a class="iq-button iq-btn-link iq-btn-link-new has-icon btn-icon-right" href="<?php echo esc_url($args['url']); ?>"><?php echo esc_html($args['button_text']);  ?></a></h5>
        </div>

        <?php do_action('woocommerce_login_form_end'); ?>

    </form>
<?php
    return ob_get_clean();
}

/* woocommerce lost password form */

add_shortcode('iqonic-lost-password-form', 'iqonic_woocommerce_lost_password_form');
function iqonic_woocommerce_lost_password_form()
{

    if (is_admin()) return;
    if (is_user_logged_in()) return;
    ob_start();
    ?>

    <form method="post" class="woocommerce-ResetPassword lost_reset_password">

        <p>
            <?php echo apply_filters('woocommerce_lost_password_message', esc_html__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'kivicare')); ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="user_login"><?php esc_html_e('Username or email', 'kivicare'); ?></label>
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
        </p>

        <div class="clear"></div>

        <?php do_action('woocommerce_lostpassword_form'); ?>

        <p class="woocommerce-form-row form-row">
            <input type="hidden" name="wc_reset_password" value="true" />
            <!-- reset password button -->
            <button type="submit" class="iq-new-btn-style iq-button-style-2 woocommerce-Button" value="<?php esc_attr_e('Reset password', 'kivicare'); ?>">
                <span class="iq-btn-text-holder"><?php esc_html_e('Reset password', 'kivicare'); ?></span>
                <span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
            </button>
        </p>

        <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>

    </form>
<?php

    return ob_get_clean();
}
