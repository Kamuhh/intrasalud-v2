<?php
/**
 * Base class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\BaseClasses;

defined( 'ABSPATH' ) || die( 'Something went wrong' );
/**
 * Class KCWHBase
 *
 * Init plugin
 */
class KCWHBase {

	/**
	 * Data related to dependent plugins.
	 *
	 * @var  array|false
	 */
	public static array|false $dependent_plugin_data;

	/**
	 * Initializes the KCWHBase class.
	 *
	 * This method is called when the class is initialized.
	 * Add any initialization code here.
	 *
	 * @return void
	 */
	public static function init(): void {
		add_action( 'init', array( self::class, 'check_lite_plugin_condition' ), 11 );
		add_action( 'admin_init', array( self::class, 'admin_notice' ) );
		add_action( 'init', array( self::class, 'plugin_loaded' ) );
	}

	/**
	 * Call when plugin activate.
	 *
	 * @return void
	 */
	public static function activate(): void {
		// include all databases file.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		self::load_classes( 'App/TableClasses/', 'KCWebhookAddons\\TableClasses\\' );
	}

	/**
	 * Load plugin pot language file.
	 *
	 * @return void
	 */
	public static function plugin_loaded(): void {
		// translate language.
		load_plugin_textdomain( 'kivicare-webhooks-addon', false, dirname( KIVI_CARE_WEBHOOK_ADDONS_BASE_NAME ) . '/languages' );
	}

	/**
	 * Checks the conditions for the Lite plugin and takes appropriate actions.
	 *
	 * @return void
	 */
	public static function check_lite_plugin_condition(): void {
		// Include the necessary file if it doesn't exist.
		if ( ! function_exists( 'get_plugins' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Set specific Lite plugin data.
		self::set_dependent_plugin_data();

		// Check if the dependent plugin is active and has the required version.
		if ( class_exists( 'App\baseClasses\KCActivate' )
			&& version_compare( self::$dependent_plugin_data['Version'], KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_REQUIRED_VERSION, '>=' ) ) {
			// Load all required files.
			add_action( 'kcwh_webhooks_add_filter', 'kcwh_webhooks_add_filter' );
			self::load_classes( 'App/FilterClasses/', 'KCWebhookAddons\\FilterClasses\\' );
			kcwh_load_wehbhook_core_hook();
		} else {
			// Deactivate the plugin.
			deactivate_plugins( KIVI_CARE_WEBHOOK_ADDONS_BASE_NAME );
		}
	}

	/**
	 * Displays an admin notice based on the state of a dependent plugin.
	 *
	 * @return void
	 */
	public static function admin_notice(): void {
		// Include the necessary file if it doesn't exist.
		if ( ! function_exists( 'get_plugins' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Set specific lite plugin data.
		self::set_dependent_plugin_data();
		// Check if the lite plugin is installed.
		if ( empty( self::$dependent_plugin_data['Version'] ) ) {
			// Lite plugin is not installed.
			self::show_admin_notice( 'install' );
		} elseif ( ! class_exists( 'App\baseClasses\KCActivate' ) ) {
			// Lite plugin is installed but not activated.
			self::show_admin_notice( 'activated' );
		} elseif ( version_compare( self::$dependent_plugin_data['Version'], KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_REQUIRED_VERSION, '<' ) ) {
			// Lite plugin is installed and activated, but needs an update.
			self::show_admin_notice( 'update' );
		}
	}


	/**
	 * Displays an admin notice based on the specified action type.
	 *
	 * @param string $action The type of admin notice to display ('update', 'activated', 'install').
	 *
	 * @return void
	 */
	public static function show_admin_notice( string $action ): void {
		$message = '';
		$button  = '';
		switch ( $action ) {
			case 'update':
				// Create update URL.
				$updatation_url = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'upgrade-plugin',
							'plugin' => KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH,
						),
						admin_url( 'update.php' )
					),
					'upgrade-plugin_' . KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH
				);

				$message     = '<strong>' . esc_html__( 'KiviCare - Webhooks addon requires KiviCare - Clinic & Patient Management System(EHR) plugin to be updated. Please update KiviCare - Clinic & Patient Management System (EHR) for KiviCare - Webhooks addon to continue.', 'kivicare-webhooks-addon' ) . '</strong>';
				$button_text = esc_html__( 'Update KiviCare - Clinic & Patient Management System (EHR)', 'kivicare-webhooks-addon' );
				$button      = "<p><a href='{$updatation_url}' class='button-primary'> {$button_text} </a></p>";
				break;
			case 'activated':
				// Create plugin activation URL.
				$activation_url = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'activate',
							'plugin' => KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH,
						),
						admin_url( 'plugins.php' )
					),
					'activate-plugin_' . KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH
				);

				$message     = '<strong>' . esc_html__( 'KiviCare - Webhooks addon requires KiviCare - Clinic & Patient Management System(EHR) plugin to be activated. Please activate KiviCare - Clinic & Patient Management System (EHR) for KiviCare - Webhooks addon to continue.', 'kivicare-webhooks-addon' ) . '</strong>';
				$button_text = esc_html__( 'Activate KiviCare - Clinic & Patient Management System (EHR)', 'kivicare-webhooks-addon' );
				$button      = "<p><a href='{$activation_url}' class='button-primary'> {$button_text} </a></p>";
				break;
			case 'install':
				// Create plugin installation URL.
				$installation_url = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							's'      => 'kivicare-clinic-management-system',
							'tab'    => 'search',
							'type'   => 'term',
						),
						admin_url( 'plugin-install.php' )
					),
					'install-plugin_' . KIVI_CARE_WEBHOOK_ADDONS_LITE_PLUGIN_PATH
				);

				$message     = '<strong>' . esc_html__( 'KiviCare - Webhooks addon requires KiviCare - Clinic & Patient Management System(EHR) plugin to be installed and activated. Please install KiviCare - Clinic & Patient Management System (EHR) for KiviCare - Webhooks addon to continue.', 'kivicare-webhooks-addon' ) . '</strong>';
				$button_text = esc_html__( 'Install KiviCare - Clinic & Patient Management System (EHR)', 'kivicare-webhooks-addon' );
				$button      = "<p><a href='{$installation_url}' class='button-primary'> {$button_text} </a></p>";
				break;
		}

		// Unset activate message from the plugin page.
		$activate = isset( $_GET['activate'] ) ? sanitize_text_field( wp_unslash( $_GET['activate'] ) ) : '';
		$wpnonce  = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
		if ( $activate && $wpnonce && wp_verify_nonce( $wpnonce, 'activate_plugin_' . $activate ) ) {
			unset( $_GET['activate'] );
		}

		// Print the message.
		add_action(
			'admin_notices',
			function () use ( $message, $button ) {
				printf( '<div class="error"><p>%1$s</p>%2$s</div>', wp_kses_post( $message ), wp_kses_post( $button ) );
			}
		);

		// Deactivate the plugin.
		deactivate_plugins( KIVI_CARE_WEBHOOK_ADDONS_BASE_NAME );
	}


	/**
	 * Set the data of the dependent plugin.
	 *
	 * @return void
	 */
	public static function set_dependent_plugin_data(): void {
		// set dependent plugin data.
		self::$dependent_plugin_data = array(
			'Version' => defined( 'KIVI_CARE_VERSION' ) ? KIVI_CARE_VERSION : '',
		);
	}


	/**
	 * Load classes from the specified file path with the given namespace.
	 *
	 * @param string $file_path      The path to the file containing the classes.
	 * @param string $class_namespace The namespace of the classes to be loaded.
	 *
	 * @return void
	 */
	public static function load_classes( string $file_path, string $class_namespace ): void {
		// Filter class directory path.
		$folder_path = KIVI_CARE_WEBHOOK_ADDONS_DIR . $file_path;
		// Get all files from the filter class folder.
		$files = scandir( $folder_path );
		// Check if there are files.
		if ( false !== $files ) {
			// Iterate through the files.
			foreach ( $files as $file ) {
				if ( in_array( $file, array( '.', '..' ), true ) ) {
					continue;
				}
				// Extract class name from file name.
				$class_name = pathinfo( $file, PATHINFO_FILENAME );
				// Build the full class name.
				$full_class_name = $class_namespace . $class_name;
				// Check if the class exists before trying to instantiate it.
				if ( class_exists( $full_class_name ) ) {
					// Instantiate the class.
					( new $full_class_name() );
				}
			}
		}
	}
}
