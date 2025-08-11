<?php
/**
 * Abstract class webhooks module classes
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\BaseClasses;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

use App\baseClasses\KCBase;
use App\models\KCCustomForm;
use App\models\KCCustomFormData;

/**
 * Abstract Class KCWHAbstractController
 *
 * This class serves as a base for all webhook controllers in the KCWebhookAddons namespace.
 * It extends the KCBase class and defines several abstract methods that need to be implemented
 * by any subclass.
 */
abstract class KCWHAbstractController extends KCBase {

	/**
	 * Indicates if the KiviCare Pro plugin is active.
	 *
	 * @var bool|null
	 */
	public static bool|null $pro_plugin_active = null;

	/**
	 * Indicates if the Zoom Telemed plugin is active.
	 *
	 * @var bool|null
	 */
	public static bool|null $zoom_telemed_plugin_active = null;

	/**
	 * Class constructor.
	 *
	 * This constructor initializes the class by checking the status of the KiviCare Pro
	 * and Zoom Telemed plugins. It then calls the parent constructor.
	 */
	public function __construct() {
		// Check if the pro plugin status is not already set, and set it if null.
		if ( is_null( self::$pro_plugin_active ) ) {
			self::$pro_plugin_active = isKiviCareProActive();
		}

		// Check if the Zoom Telemed plugin status is not already set, and set it if null.
		if ( is_null( self::$zoom_telemed_plugin_active ) ) {
			self::$zoom_telemed_plugin_active = isKiviCareTelemedActive();
		}

		// Call the parent constructor.
		parent::__construct();
	}

	/**
	 * Initialize hooks for the specified child class.
	 *
	 * This function adds filters for the webhooks module list and event list using
	 * the methods from the provided child class, if those methods exist. It also
	 * triggers an action to add filters with the event list from the child class.
	 *
	 * @param string $child_class The name of the child class containing the methods for the hooks.
	 * @return void
	 */
	public static function initHooks( string $child_class ): void {
		// Add filter for webhooks module list using the child class method, if it exists.
		if ( method_exists( $child_class, 'webhooks_module_list' ) ) {
			add_filter( 'kcwh_webhooks_module_list', array( $child_class, 'webhooks_module_list' ) );
		}

		// Add filter for webhooks module event list using the child class method, if it exists.
		if ( method_exists( $child_class, 'webhooks_module_event_list' ) ) {
			add_filter( 'kcwh_webhooks_module_event_list', array( $child_class, 'webhooks_module_event_list' ) );

			// Trigger an action to add filters with the event list from the child class, without dynamic keys.
			do_action(
				'kcwh_webhooks_add_filter',
				call_user_func(
					array( $child_class, 'webhooks_module_event_list' ),
					array(), // Pass an empty array as the first parameter.
					false    // Pass false as the second parameter.
				)
			);
		}
	}

	/**
	 * Get a list of webhook modules.
	 *
	 * @param array $modules An array of modules to be processed.
	 * @return array A processed list of webhook modules.
	 */
	abstract public static function webhooks_module_list( array $modules ): array;

	/**
	 * Adds module-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding module-related events,
	 * If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including module-related events.
	 */
	abstract public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array;

	/**
	 * Get dynamic keys for a webhook.
	 * Used in get_and_sort_dynamic_keys function
	 *
	 * @param array $webhook_data An array of data related to the webhook.
	 * @return array An array of dynamic keys for the webhook.
	 */
	abstract public static function get_dynamic_keys( array $webhook_data = array() ): array;

	/**
	 * Fetch data from the database.
	 *
	 * @param array $webhook_data An array of data related to the webhook.
	 * @return void The fetched data from the database.
	 */
	abstract public static function fetch_data_from_db( array $webhook_data ): void;

	/**
	 * Add custom form dynamic keys to the provided dynamic keys array.
	 *
	 * This function retrieves custom form data for a given module, processes it,
	 * and adds it to the dynamic keys array.
	 *
	 * @param array  $dynamic_keys An array of dynamic keys to be modified.
	 * @param string $module_name The name of the module to retrieve custom forms for.
	 * @param array  $webhook_data An associative array containing webhook data, including the module ID.
	 * @return array The modified dynamic keys array with custom form data added.
	 */
	public static function custom_form_dynamic_keys( array $dynamic_keys, string $module_name, array $webhook_data ): array {
		// Apply filter to get the list of custom forms for the specified module type.
		$custom_forms = apply_filters( 'kivicare_custom_form_list', array(), array( 'type' => $module_name ) );

		// If no custom forms are found, return the original dynamic keys.
		if ( empty( $custom_forms ) ) {
			return $dynamic_keys;
		}

		// Retrieve the module ID from webhook data, if available.
		$module_id = ! empty( $webhook_data['module_id'] ) ? (int) $webhook_data['module_id'] : false;

		// Iterate over each custom form.
		foreach ( $custom_forms as $custom_form ) {
			// Skip custom forms without a name.
			if ( empty( $custom_form->name->text ) ) {
				continue;
			}

			// Format the custom form name.
			$name      = strtolower( str_replace( ' ', '_', trim( $custom_form->name->text ) ) );
			$form_data = '';

			// If a module ID is available, retrieve the form data for the specified module.
			if ( $module_id ) {
				$form_data_result = ( new KCCustomFormData() )->get_var(
					array(
						'form_id'   => $custom_form->id,
						'module_id' => $module_id,
					),
					'form_data'
				);
				$form_data        = ! empty( $form_data_result ) ? $form_data_result : '';
			}

			// Add the custom form data to the dynamic keys array.
			$dynamic_keys[ "{{custom_form_{$name}_data}}" ] = $form_data;
		}

		// Return the modified dynamic keys array.
		return $dynamic_keys;
	}

	/**
	 * Add custom fields dynamic keys to the provided dynamic keys array.
	 *
	 * This function checks if the pro plugin is active, retrieves custom field data
	 * for a given module, and adds this data to the dynamic keys array.
	 *
	 * @param array  $dynamic_keys An array of dynamic keys to be modified.
	 * @param string $module_name The name of the module to retrieve custom fields for.
	 * @param array  $webhook_data An associative array containing webhook data, including the module ID.
	 * @return array The modified dynamic keys array with custom fields data added.
	 */
	public static function custom_fields_dynamic_keys( array $dynamic_keys, string $module_name, array $webhook_data ): array {
		// Check if the pro plugin is active; if not, return the original dynamic keys.
		if ( ! self::$pro_plugin_active ) {
			return $dynamic_keys;
		}

		// Check if the module ID is provided; if not, set custom_fields_data to an empty string and return.
		if ( empty( $webhook_data['module_id'] ) ) {
			$dynamic_keys['{{custom_fields_data}}'] = '';
			return $dynamic_keys;
		}

		// Retrieve the module ID.
		$module_id = (int) $webhook_data['module_id'];

		// Get custom fields data for the specified module.
		$custom_fields_data = kcGetCustomFields( $module_name, $module_id );

		// If no custom fields data is found, return the original dynamic keys.
		if ( empty( $custom_fields_data ) ) {
			return $dynamic_keys;
		}

		// Initialize an array to store custom fields values.
		$custom_fields_value = array();

		// Iterate over the custom fields data and extract labels and field data.
		foreach ( $custom_fields_data as $custom_field ) {
			if ( ! empty( $custom_field['label'] ) ) {
				$custom_fields_value[ $custom_field['label'] ] = ! empty( $custom_field['field_data'] ) ? $custom_field['field_data'] : '';
			}
		}

		// Add the custom fields data to the dynamic keys array.
		$dynamic_keys['{{custom_fields_data}}'] = wp_json_encode( $custom_fields_value );

		// Return the modified dynamic keys array.
		return $dynamic_keys;
	}

	/**
	 * Sort and retrieve dynamic keys from a class method if specified.
	 *
	 * This function checks whether dynamic keys should be retrieved based on the
	 * $with_dynamic_keys parameter. If true, it checks if the specified class has
	 * the get_dynamic_keys method, retrieves the dynamic keys from that method,
	 * sorts them, and returns them as an array.
	 *
	 * @param bool   $with_dynamic_keys Whether to include dynamic keys. Defaults to false.
	 * @param string $class_name The class name from which to retrieve the dynamic keys.
	 *
	 * @return array The sorted array of dynamic keys if $with_dynamic_keys is true and the method exists, otherwise an empty array.
	 */
	public static function get_and_sort_dynamic_keys( bool $with_dynamic_keys, string $class_name ): array {
		$dynamic_keys = array();

		// Retrieve dynamic keys if $with_dynamic_keys is true and the method exists.
		if ( $with_dynamic_keys && method_exists( $class_name, 'get_dynamic_keys' ) ) {
			// Fetch dynamic keys from the specified class method.
			$dynamic_keys = call_user_func( array( $class_name, 'get_dynamic_keys' ) );
			$dynamic_keys = array_keys( $dynamic_keys );
			sort( $dynamic_keys );
		}

		// Return the sorted dynamic keys.
		return $dynamic_keys;
	}


	/**
	 * Get and sort dynamic keys for deleting an event.
	 *
	 * This function retrieves a list of common dynamic keys, adds a
	 * dynamic key, sorts the list, and returns the sorted array.
	 *
	 * @param string $dynamic_keys The dynamic key to add to the list of delete dynamic keys.
	 * @return array The sorted array of delete dynamic keys.
	 */
	public static function get_delete_event_dynamic_keys( string $dynamic_keys ): array {
		// Retrieve common dynamic keys.
		$delete_dynamic_keys = kcwh_common_dynamic_keys( false );

		// Get only the keys from the common dynamic keys array.
		$delete_dynamic_keys = array_keys( $delete_dynamic_keys );

		// Add the provided dynamic key to the array.
		$delete_dynamic_keys[] = $dynamic_keys;

		// Sort the array of dynamic keys.
		sort( $delete_dynamic_keys );

		// Return the sorted dynamic keys.
		return $delete_dynamic_keys;
	}


	/**
	 * Format user contact numbers for doctor and patient.
	 *
	 * This function processes the module data array to format and populate the
	 * contact numbers for the doctor and the patient. It includes the country
	 * code and the mobile number if available.
	 *
	 * @param array $module_data An associative array containing module data,
	 * including doctor and patient information.
	 * @return array The modified module data array with formatted contact numbers.
	 */
	public static function format_user_contact_number( array $module_data ): array {
		// Initialize contact numbers.
		$module_data['patient_contact_number'] = '';
		$module_data['doctor_contact_number']  = '';

		// Process doctor basic data.
		if ( ! empty( $module_data['doctor_basic_data'] ) ) {
			// Add country code prefix if available.
			$module_data['doctor_country_code'] = ! empty( $module_data['doctor_country_code'] ) ? '+' . $module_data['doctor_country_code'] . ' ' : '';

			// Decode JSON encoded doctor basic data.
			$module_data['doctor_basic_data'] = json_decode( $module_data['doctor_basic_data'], true );

			// Extract mobile number if available.
			$module_data['doctor_contact_number'] = ! empty( $module_data['doctor_basic_data']['mobile_number'] ) ? $module_data['doctor_basic_data']['mobile_number'] : '';

			// Format full contact number with country code.
			$module_data['doctor_contact_number'] = ! empty( $module_data['doctor_contact_number'] ) ? $module_data['doctor_country_code'] . $module_data['doctor_contact_number'] : '';
		}

		// Process patient basic data.
		if ( ! empty( $module_data['patient_basic_data'] ) ) {
			// Add country code prefix if available.
			$module_data['patient_country_code'] = ! empty( $module_data['patient_country_code'] ) ? '+' . $module_data['patient_country_code'] . ' ' : '';

			// Decode JSON encoded patient basic data.
			$module_data['patient_basic_data'] = json_decode( $module_data['patient_basic_data'], true );

			// Extract mobile number if available.
			$module_data['patient_contact_number'] = ! empty( $module_data['patient_basic_data']['mobile_number'] ) ? $module_data['patient_basic_data']['mobile_number'] : '';

			// Format full contact number with country code.
			$module_data['patient_contact_number'] = ! empty( $module_data['patient_contact_number'] ) ? $module_data['patient_country_code'] . $module_data['patient_contact_number'] : '';
		}

		return $module_data;
	}
}
