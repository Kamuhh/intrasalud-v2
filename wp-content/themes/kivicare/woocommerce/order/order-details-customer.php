<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 15.7.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => esc_html__( 'Billing address', 'kivicare' ),
		'shipping' => esc_html__( 'Shipping address', 'kivicare' ),
	), $customer_id );
} else {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => esc_html__( 'Billing address', 'kivicare' ),
	), $customer_id );
}
?>
<section class="woocommerce-customer-details">

    <?php if ( $show_shipping ) : ?>

    <section
        class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses d-flex flex-wrap">
        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-md-6 col-12">

            <?php endif; ?>

            <h4 class="woocommerce-column__title"><?php esc_html_e( 'Billing address ', 'kivicare' ); ?></h4>
            <address>
                <div class="table-responsive">
                    <table>
                        <tbody>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Name","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html( $order->get_billing_company() ); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Company","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html( $order->get_billing_company() ); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Country","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html( $order->get_billing_country() ); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Address","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html( $order->get_billing_address_2() ); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("E-mail","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html( $order->get_billing_email() ); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Phone","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </address>
            <?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
    </section>