<?php

/**
 * Plugin Name: KiviCare - Clinic & Patient Management System Pro (EHR)
 * Plugin URI: https://kivicare.io
 * Description: KiviCare - Clinic & Patient Management System Pro (EHR) is an add on with extended feature for clinic and patient management (EHR) plugin.
 * Version: 2.5.9
 * Author: iqonic
 * Text Domain: kiviCare-clinic-&-patient-management-system-pro
 * Domain Path: /languages
 * Author URI: http://iqonic.design/
 **/

use ProApp\baseClasses\KCProActivate;
use ProApp\baseClasses\KCProDeactivate;

defined('ABSPATH') or die('Something went wrong');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
} else {
    die('Something went wrong');
}

if (!defined('KIVI_CARE_PRO_DIR')) {
    define('KIVI_CARE_PRO_DIR', plugin_dir_path(__FILE__));
}

if (!defined('KIVI_CARE_PRO_NAMESPACE')) {
    define('KIVI_CARE_PRO_NAMESPACE', "kivi-care-pro");
}

if (!defined('KIVI_CARE_PRO_PREFIX')) {
    define('KIVI_CARE_PRO_PREFIX', "kiviCare_");
}

if (!defined('KIVI_CARE_PRO_REQUIRED_PLUGIN_VERSION')) {
    define('KIVI_CARE_PRO_REQUIRED_PLUGIN_VERSION', '3.6.11');
}
if (!defined('KIVI_CARE_PRO_DIR_URI')) {
    define('KIVI_CARE_PRO_DIR_URI', plugin_dir_url(__FILE__));
}

if (!defined('KIVI_CARE_PRO_BASE_PATH')) {
    define('KIVI_CARE_PRO_BASE_PATH', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation
 */

register_activation_hook(__FILE__, [KCProActivate::class, 'activate']);

/**
 * The code that runs during plugin deactivation
 */

register_deactivation_hook(__FILE__, [KCProDeactivate::class, 'init']);

(new KCProActivate)->init();
