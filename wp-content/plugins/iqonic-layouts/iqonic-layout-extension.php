<?php

/**
 * Plugin Name:       Iqonic Layouts
 * Plugin URI:        https://iqonic.design/
 * Description:       Iqonic Layouts.
 * Version:           1.2.0
 * Author:            Iqonic Design.
 * Author URI:        https://iqonic.design/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iqonic-layouts
 * Domain Path:       /languages
 */

use Iqonic_Layouts\Classes\Iqonic_Layouts_Extension;
use Iqonic_Layouts\Classes\Iqonic_Layouts_Extension_Activator;
use Iqonic_Layouts\Classes\Iqonic_Layouts_Extension_Deactivator;

if (!defined('WPINC')) {
    die;
}

define('IQONIC_LAYOUTS_EXTENSION_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('IQONIC_LAYOUTS_EXTENSION_PLUGIN_URL', plugins_url('/', __FILE__));
if (!function_exists('get_plugin_data')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

if (!defined('IQONIC_LAYOUT_EXTENSION_VERSION')) {
    define('IQONIC_LAYOUT_EXTENSION_VERSION', '1.2.0');
}

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
} else {
    die('Something went wrong');
}

$GLOBALS['iqonic_layouts_config'] = require_once IQONIC_LAYOUTS_EXTENSION_PLUGIN_PATH . 'config.php';

register_activation_hook(__FILE__, [Iqonic_Layouts_Extension_Activator::class, 'activate']);
register_deactivation_hook(__FILE__,  [Iqonic_Layouts_Extension_Deactivator::class, 'deactivate']);

(new Iqonic_Layouts_Extension)->run();
