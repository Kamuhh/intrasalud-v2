<?php
/**
 * Plugin Name: KiviCare - Webhooks addon
 * Plugin URI: https://iqonic.design
 * Description: KiviCare Webhooks addon is Webhook/HTTPs addon of kivicare clinic and patient management plugin (EHR).
 * Version: 1.0.1
 * Author: iqonic
 * Text Domain: kivicare-webhooks-addon
 * Domain Path: /languages
 * Author URI: http://iqonic.design/
 *
 * @package KiviCare_Webhooks_Addon
 **/

use KCWebhookAddons\BaseClasses\KCWHBase;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

// Require once the Composer Autoload.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	die( 'Something went wrong' );
}

if ( ! defined( 'KIVI_CARE_WEBHOOK_ADDONS_DIR' ) ) {
	define( 'KIVI_CARE_WEBHOOK_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'KIVI_CARE_WEBHOOK_ADDONS_BASE_NAME' ) ) {
	define( 'KIVI_CARE_WEBHOOK_ADDONS_BASE_NAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'KIVI_CARE_WEBHOOK_ADDONS_DIR_URI' ) ) {
	define( 'KIVI_CARE_WEBHOOK_ADDONS_DIR_URI', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH' ) ) {
	define( 'KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH', 'kivicare-clinic-management-system/kivicare-clinic-management-system.php' );
}

if ( ! defined( 'KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_REQUIRED_VERSION' ) ) {
	define( 'KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_REQUIRED_VERSION', '3.6.10' );
}

// Load action scheduler.
kcwh_load_action_scheduler();

// Activate plugin.
register_activation_hook( __FILE__, array( KCWHBase::class, 'activate' ) );

// Initialize base class.
KCWHBase::init();
