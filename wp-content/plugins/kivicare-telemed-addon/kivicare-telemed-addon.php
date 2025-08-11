<?php
/**
 * Plugin Name: KiviCare - Telemed add-on
 * Plugin URI: https://iqonic.design
 * Description: KiviCare - Telemed add-on is an impressive add-on for KiviCare - Clinic & Patient Management System (EHR) plugin.
 * Version: 2.2.0
 * Author: iqonic
 * Text Domain: kiviCare-telemed-addon
 * Domain Path: /languages
 * Author URI: http://iqonic.design/
 **/

use TeleMedApp\baseClasses\KCTActivate;
use TeleMedApp\baseClasses\KCTDeactivate;

defined( 'ABSPATH' ) or die( 'Something went wrong' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
} else {
    die( 'Something went wrong' );
}

if (!defined('KIVI_CARE_TELEMED_DIR'))
{
    define('KIVI_CARE_TELEMED_DIR', plugin_dir_path(__FILE__));
}

if (!defined('KIVI_CARE_TELEMED_DIR_URI'))
{
    define('KIVI_CARE_TELEMED_DIR_URI', plugin_dir_url(__FILE__));
}


if (!defined('KIVI_CARE_TELEMED_NAMESPACE'))
{
    define('KIVI_CARE_TELEMED_NAMESPACE', "kivi-care");
}

if (!defined('KIVI_CARE_TELEMED_PREFIX'))
{
    define('KIVI_CARE_TELEMED_PREFIX', "kiviCare_");
}

if (!defined('KIVI_CARE_TELEMED_REQUIRED_PLUGIN_VERSION'))
{
    define('KIVI_CARE_TELEMED_REQUIRED_PLUGIN_VERSION', "3.6.10");
}

if (!defined('KIVI_CARE_TELEMED_VERSION'))
{
    define('KIVI_CARE_TELEMED_VERSION', "2.2.0");
}

if (!defined('KIVI_CARE_TELEMED_BASE_PATH')){
    define('KIVI_CARE_TELEMED_BASE_PATH', plugin_basename(__FILE__));
}
/**
 * The code that runs during plugin activation
 */
register_activation_hook( __FILE__, [KCTActivate::class, 'activate'] );

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook( __FILE__, [KCTDeactivate::class, 'init'] );

(new KCTActivate)->init();


