<?php

/**
 * Plugin Name:       Iqonic Extensions
 * Plugin URI:        https://kivicare-wordpress.iqonic.design/
 * Description:       iqonic plugin provides custom team post type, gallery post type with related functionality.
 * Version:           2.2.19
 * Author:            Iqonic Design
 * Author URI:        https://iqonic.design/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iqonic
 * Domain Path:       /languages
 */
use Iqonic\Classes\Iqonic_Extension;
use Iqonic\Classes\Iqonic_Extension_Activator;
use Iqonic\Classes\Iqonic_Extension_Deactivator;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! function_exists('get_plugin_data') ){
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function iqonic_load_plugin_textdomain() {
    load_plugin_textdomain( 'iqonic', false, basename( __DIR__ ) . '/languages/' );
}

add_action( 'plugins_loaded', 'iqonic_load_plugin_textdomain' ); 

define( 'IQONIC_EXTENSION_PLUGIN_PATH', plugin_dir_path(__FILE__));
define( 'IQONIC_EXTENSION_PLUGIN_URL', plugins_url('/', __FILE__));
define( 'IQONIC_EXTENSION_VERSION',  '2.2.18' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
} else {
    die( 'Something went wrong' );
}

$GLOBALS['iqonic_config'] = require_once IQONIC_EXTENSION_PLUGIN_PATH . 'config.php';

register_activation_hook( __FILE__, [ Iqonic_Extension_Activator::class,'activate' ] );
register_deactivation_hook( __FILE__,  [ Iqonic_Extension_Deactivator::class,'deactivate' ]  );

( new Iqonic_Extension )->run();