<?php
/**
 * Plugin Name: KiviCare - Clinic & Patient Management System (EHR)
 * Plugin URI: https://iqonic.design
 * Description: KiviCare is an impressive clinic and patient management plugin (EHR).
 * Version:3.6.11
 * Author: iqonic
 * Text Domain: kc-lang
 * Domain Path: /languages
 * Author URI: http://iqonic.design/
 **/
use App\baseClasses\KCActivate;
use App\baseClasses\KCDeactivate;
defined( 'ABSPATH' ) or die( 'Something went wrong' );

// ── Definir constantes si no existen (evita E_ERROR en entornos donde no las trae el core del plugin)
if ( ! defined('KC_PLUGIN_FILE') ) define('KC_PLUGIN_FILE', __FILE__);
if ( ! defined('KC_PLUGIN_DIR') )  define('KC_PLUGIN_DIR', plugin_dir_path(__FILE__));
if ( ! defined('KC_PLUGIN_URL') )  define('KC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
        require_once dirname( __FILE__ ) . '/vendor/autoload.php';
} else {
        die( 'Something went wrong' );
}

if (!defined('KIVI_CARE_DIR'))
{
	define('KIVI_CARE_DIR', plugin_dir_path(__FILE__));
}

if (!defined('KIVI_CARE_DIR_URI'))
{
	define('KIVI_CARE_DIR_URI', plugin_dir_url(__FILE__));
}

if (!defined('KIVI_CARE_BASE_NAME'))
{
    define('KIVI_CARE_BASE_NAME', plugin_basename(__FILE__));
}

if (!defined('KIVI_CARE_NAMESPACE'))
{
	define('KIVI_CARE_NAMESPACE', "kivi-care");
}

if (!defined('KIVI_CARE_PREFIX'))
{
	define('KIVI_CARE_PREFIX', "kiviCare_");
}

if (!defined('KIVI_CARE_VERSION'))
{
    define('KIVI_CARE_VERSION', "3.6.11");
}

// Include helper and initialization files
require_once KIVI_CARE_DIR . 'app/helpers/encounter-summary-helpers.php';
require_once KIVI_CARE_DIR . 'app/init/Capabilities.php';

/**
 * The code that runs during plugin activation
 */
register_activation_hook( __FILE__, [ KCActivate::class, 'activate'] );

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook( __FILE__, [KCDeactivate::class, 'deActivate'] );

( new KCActivate )->init();

( new KCDeactivate() );

do_action('kivicare_activate_init');

// === Encuentro: Resumen de atención ===
add_action('admin_enqueue_scripts', function () {
    if (($_GET['page'] ?? '') !== 'patient_encounter_details') {
        return;
    }
    $js  = KC_PLUGIN_DIR . 'assets/js/encounter-summary.js';
    $css = KC_PLUGIN_DIR . 'assets/css/encounter-summary.css';
    if (file_exists($js)) {
        wp_enqueue_script(
            'kc-encounter-summary',
            KC_PLUGIN_URL . 'assets/js/encounter-summary.js',
            [],
            filemtime($js),
            true
        );
        wp_localize_script('kc-encounter-summary', 'kcGlobals', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ]);
    }
    if (file_exists($css)) {
        wp_enqueue_style(
            'kc-encounter-summary',
            KC_PLUGIN_URL . 'assets/css/encounter-summary.css',
            [],
            filemtime($css)
        );
    }
});

add_action('admin_footer', function () {
    if (($_GET['page'] ?? '') !== 'patient_encounter_details') {
        return;
    }
    $encounter_id = isset($_GET['id']) ? absint($_GET['id']) : 0;
    if ($encounter_id) {
        echo kc_render_encounter_summary_html($encounter_id); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
});

add_action('wp_ajax_kc_encounter_summary_email', function () {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'No autorizado'], 401);
    }
    $encounter_id = isset($_POST['encounter_id']) ? absint($_POST['encounter_id']) : 0;
    $to = isset($_POST['to']) ? sanitize_email($_POST['to']) : '';
    if (!$encounter_id || empty($to) || !is_email($to)) {
        wp_send_json_error(['message' => 'Parámetros inválidos'], 400);
    }
    $body = kc_build_encounter_summary_text($encounter_id);
    $ok   = wp_mail($to, 'Resumen de atención', $body, ['Content-Type: text/plain; charset=UTF-8']);
    if (!$ok) {
        wp_send_json_error(['message' => 'No se pudo enviar el correo'], 500);
    }
    wp_send_json_success(['message' => 'Email enviado']);
});
