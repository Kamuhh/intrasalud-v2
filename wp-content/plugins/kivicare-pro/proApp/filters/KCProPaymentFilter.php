<?php
namespace ProApp\filters ;

use ProApp\baseClasses\KCProHelper;
use ProApp\filters\KCProGoogleCalenderFilters; 
use App\baseClasses\KCBase;
use App\models\KCAppointment;
use App\models\KCAppointmentServiceMapping;

class KCProPaymentFilter extends KCBase {
    
    public function __construct() {
        add_filter( 'kcpro_change_woocommerce_module_status',     [ $this, 'changeWooCommercePaymentStatus']);
        add_filter( 'kcpro_get_woocommerce_module_status',        [ $this, 'getWooCommercePaymentStatus']);
        add_filter('kcpro_woocommerce_add_to_cart', 'kivicareWooocommerceAddToCart');
        if(function_exists('kcWoocommerceFillCheckoutFields')){
            add_filter('woocommerce_checkout_fields', 'kcWoocommerceFillCheckoutFields');
        }
        add_action('woocommerce_order_status_completed', 'kivicareWoocommercePaymentComplete', 10, 1);
        add_action('woocommerce_order_status_changed', 'kivicareWooOrderStatusChangeCustom', 10, 4);
        add_action('woocommerce_checkout_update_order_meta', 'kivicareSaveToPostMeta', 10, 1);
        add_filter('woocommerce_get_cart_item_from_session', 'kivicareGetCartItemsFromSession', 1, 3);
        add_action('before_delete_post', 'kivicareServiceDeleteOnProductDelete');
        add_action('woocommerce_update_product', 'kivicareServiceUpdateOnProductUpdated', 10, 1);
        add_filter('woocommerce_product_data_panels', 'kivicareServiceWooProductTabContent');
        add_action('woocommerce_admin_order_data_after_order_details', 'kivicareWoocommerceOrderDataAfterOrderDetails', 10, 1);
        add_filter('woocommerce_product_data_tabs', 'kivicareServiceDetailOnWooProductTabs');
        add_action('woocommerce_thankyou', 'kivicareCheckoutRedirectWidgetPayment');
    }
    // check is woocommerce installed
    public static function woocommerceIsEnabled() {
		return class_exists( 'WooCommerce', false );
	}


    // change woocommerce payment status (Active/Inactive)
    public function changeWooCommercePaymentStatus ($data) {
        return (new KCProHelper)->updateOption('woocommerce_payment', $data['status']);
    }
    // woocommerce payment status
    public function getWooCommercePaymentStatus () {
        return (new KCProHelper)->getOption('woocommerce_payment');
    }

}