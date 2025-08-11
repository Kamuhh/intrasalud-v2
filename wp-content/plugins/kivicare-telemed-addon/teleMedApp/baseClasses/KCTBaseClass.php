<?php

namespace TeleMedApp\baseClasses;

class KCTBaseClass {

    public $lite_plugin_base_name;

    public function __construct()
    {
        $this->lite_plugin_base_name = 'kivicare-clinic-management-system/kivicare-clinic-management-system.php';
    }


    public static function iswoocommerceEnabled()
	{
		return class_exists( 'WooCommerce', false );
	}

	public function isWooCommerceActive () {

		if (!function_exists('get_plugins')) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
	
		$plugins = get_plugins();
	
		foreach ($plugins as $key => $value) {
	
			if($value['TextDomain'] === 'woocommerce') {
	
				return true ;
				
			}
			
		}
		return false ;
	}

}