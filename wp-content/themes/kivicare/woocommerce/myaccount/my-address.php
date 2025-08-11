<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 15.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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

$oldcol = 1;
$col    = 1;
?>

<p>
    <?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'kivicare' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
<div class="u-columns woocommerce-Addresses col2-set addresses">
    <?php endif; ?>
    <div class="row">

        <?php foreach ( $get_addresses as $name => $title ) : ?>

        <div class="u-column<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> col-lg-12 woocommerce-Address">
            <div class="woocommerce-Address-title title">
                <div class="kivicare-address-section">
                    <h4><?php echo wp_kses_post($title); ?></h4>
                    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>"
                        class="edit kivicare-btn">
                        <span class="kivicare-btn-line-holder">
                            <span class="kivicare-btn-line-hidden"></span>
                            <span class="kivicare-btn-text"><?php _e( 'Edit', 'kivicare' ); ?></span>
                            <span class="kivicare-btn-line"></span>
                            <i class="fas fa-chevron-right"></i>
                        </span>                    
                    </a>
                </div>
            </div>
            <address>  <?php
				$address = wc_get_account_formatted_address( $name );
				$customer = new WC_Customer($customer_id);

                if($name == 'billing'){
                
                    $billing_first_name = !empty($customer->get_billing_first_name()) ? $customer->get_billing_first_name() : '';
                    $billing_last_name = !empty($customer->get_billing_last_name()) ? $customer->get_billing_last_name() : '';
                    $name = trim($billing_first_name . ' ' . $billing_last_name);
                    $company    = !empty($customer->get_billing_company()) ? $customer->get_billing_company() : '';  
                    $country    = !empty($customer->get_billing_country()) ? $customer->get_billing_country() : ''; 
                    $address_2    = !empty($customer->get_billing_address_2()) ? $customer->get_billing_address_2() : ''; 

                }

                if($name == 'shipping'){

                    $shipping_first_name = !empty($customer->get_shipping_first_name()) ? $customer->get_shipping_first_name() : '';
				    $shipping_last_name = !empty($customer->get_shipping_last_name()) ? $customer->get_shipping_last_name() : '';
				    $name = trim($shipping_first_name . ' ' . $shipping_last_name);
                    $company    = !empty($customer->get_shipping_company()) ? $customer->get_shipping_company() : ''; 
                    $country    = !empty($customer->get_shipping_country()) ? $customer->get_shipping_country() : ''; 
                    $address_2    = !empty($customer->get_shipping_address_2()) ? $customer->get_shipping_address_2() : ''; 

                }
				
				$user_email = $customer->get_email(); 
				$billing_phone    = !empty($customer->get_billing_phone()) ? $customer->get_billing_phone() : ''; 
                 ?>
                
                <div class="table-responsive">
                    <table>
                        <tbody>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Name","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html($name); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Company","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html($company); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Country","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html($country); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Address","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html($address_2); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("E-mail","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html($user_email); ?></td>
                            </tr>
                            <tr>
                                <td class="label-name"><?php echo esc_html__("Phone","kivicare"); ?></td>
                                <td class="seprator"><span>:</span></td>
                                <td><?php echo esc_html($billing_phone); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </address>
        </div>

        <?php endforeach; ?>
    </div>
    <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
</div>
<?php endif;