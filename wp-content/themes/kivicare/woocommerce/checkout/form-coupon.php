<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 15.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="woocommerce-form-coupon-toggle">
    <?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'kivicare' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'kivicare' ) . '</a>' ), 'notice' ); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

    <p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'kivicare' ); ?></p>

    <p class="form-row form-row-first">
        <input type="text" name="coupon_code" class="input-text"
            placeholder="<?php esc_attr_e( 'Coupon code', 'kivicare' ); ?>" id="coupon_code" value="" />
    </p>

	<!-- apply coupon button -->
    <p class="form-row form-row-last">
        <button type="submit" class="iq-new-btn-style iq-button-style-2 button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'kivicare' ); ?>">
            <span class="iq-btn-text-holder"><?php esc_html_e( 'Apply Coupon', 'kivicare' ); ?></span>
            <span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>           
        </button>
    </p>
    <div class="clear"></div>
</form>