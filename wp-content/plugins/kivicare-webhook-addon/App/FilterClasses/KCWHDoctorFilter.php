<?php
/**
 * Filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use App\models\KCDoctorClinicMapping;
use KCWebhookAddons\BaseClasses\KCWHAbstractController;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHDoctorFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHDoctorFilter extends KCWHAbstractController {


	/**
	 * Doctors data array with doctor id as array key
	 *
	 * @var array Holds fetched doctors data for caching.
	 */
	public static array $doctors_data = array();

	/**
	 * Class constructor.
	 *
	 * This constructor initializes the class by calling the parent constructor
	 * and initializing hooks using the initHooks method.
	 */
	public function __construct() {
		// Call the parent constructor.
		parent::__construct();

		// Initialize hooks using the initHooks method of this class.
		self::initHooks( self::class );
	}

	/**
	 * Add module doctor list for webhooks addon.
	 *
	 * @param array $modules The existing modules array.
	 *
	 * @return array The modified modules array.
	 */
	public static function webhooks_module_list( array $modules ): array {
		$modules[] = array(
			'value' => 'doctor',
			'text'  => esc_html__( 'Doctor', 'kivicare-webhooks-addon' ),
		);
		return $modules;
	}

	/**
	 * Adds doctor-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding doctor-related events,
	 *  If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including doctor-related events.
	 */
	public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array {
		// retrieve and sort dynamic keys for the current class.
		$dynamic_keys     = self::get_and_sort_dynamic_keys( $with_dynamic_keys, self::class );
		$events['doctor'] = array(
			array(
				'value'        => 'kc_doctor_save',
				'text'         => esc_html__( 'Add doctor', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_doctor_update',
				'text'         => esc_html__( 'Update doctor', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_doctor_delete',
				'text'         => esc_html__( 'Delete doctor', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => self::get_delete_event_dynamic_keys( '{{doctor_id}}' ),
			),
		);
		return $events;
	}

	/**
	 * Get dynamic keys for doctor-related webhook data.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return array An array of dynamic keys mapped to their corresponding values.
	 */
	public static function get_dynamic_keys( array $webhook_data = array() ): array {

		$doctor_data = array();
		$doctor_id   = '';
		// Fetch doctor data if module_id(doctor id) is present in webhook_data.
		if ( ! empty( $webhook_data['module_id'] ) ) {
			self::fetch_data_from_db( $webhook_data ); // method fetches data from the database.
			$doctor_id   = $webhook_data['module_id'];
			$doctor_data = ! empty( self::$doctors_data[ $doctor_id ] ) ? self::$doctors_data[ $doctor_id ] : array();
		}

		$specialization_labels = '';
		if(!empty($doctor_data['specialties'])){
			$specialties = json_decode($doctor_data['specialties'], true);
			$specialization_labels = $specialties ? '"' . implode('", "', array_column($specialties, 'label')) . '"' : '';
		}

		// Define dynamic keys based on doctor data.
		$dynamic_keys = array(
			'{{doctor_address}}'              => ! empty( $doctor_data['address'] ) ? $doctor_data['address'] : '',
			'{{doctor_city}}'                 => ! empty( $doctor_data['city'] ) ? $doctor_data['city'] : '',
			'{{doctor_clinic_ids}}'           => ! empty( $doctor_data['clinic_ids'] ) ? $doctor_data['clinic_ids'] : '',
			'{{doctor_contact_number}}'       => ! empty( $doctor_data['contact_number'] ) ? $doctor_data['contact_number'] : '',
			'{{doctor_country}}'              => ! empty( $doctor_data['country'] ) ? $doctor_data['country'] : '',
			'{{doctor_description}}'          => ! empty( $doctor_data['doctor_description'] ) ? $doctor_data['doctor_description'] : '',
			'{{doctor_dob}}'                  => ! empty( $doctor_data['dob'] ) ? $doctor_data['dob'] : '',
			'{{doctor_experience}}'           => ! empty( $doctor_data['no_of_experience'] ) ? $doctor_data['no_of_experience'] : '',
			'{{doctor_email}}'                => ! empty( $doctor_data['user_email'] ) ? $doctor_data['user_email'] : '',
			'{{doctor_first_name}}'           => ! empty( $doctor_data['first_name'] ) ? $doctor_data['first_name'] : '',
			'{{doctor_full_name}}'            => ! empty( $doctor_data['display_name'] ) ? $doctor_data['display_name'] : '',
			'{{doctor_gender}}'               => ! empty( $doctor_data['gender'] ) ? $doctor_data['gender'] : '',
			'{{doctor_id}}'                   => ! empty( $doctor_data['ID'] ) ? $doctor_data['ID'] : $doctor_id,
			'{{doctor_last_name}}'            => ! empty( $doctor_data['last_name'] ) ? $doctor_data['last_name'] : '',
			'{{doctor_postal_code}}'          => ! empty( $doctor_data['postal_code'] ) ? $doctor_data['postal_code'] : '',
			'{{doctor_profile_photo}}'        => ! empty( $doctor_data['doctor_profile_image'] ) ? $doctor_data['doctor_profile_image'] : '',
			'{{doctor_qualification}}'        => ! empty( $doctor_data['qualifications'] ) ? $doctor_data['qualifications'] : '',
			'{{doctor_signature}}'            => ! empty( $doctor_data['doctor_signature'] ) ? $doctor_data['doctor_signature'] : '',
			'{{doctor_specialization}}'       => $specialization_labels,
			'{{doctor_status}}'               => isset( $doctor_data['user_status'] ) ? $doctor_data['user_status'] : '',
			'{{doctor_registered_date_time}}' => ! empty( $doctor_data['user_registered'] ) ? $doctor_data['user_registered'] : '',
		);

		$dynamic_keys = self::custom_form_dynamic_keys( $dynamic_keys, 'doctor_module', $webhook_data );

		$dynamic_keys = self::custom_fields_dynamic_keys( $dynamic_keys, 'doctor_module', $webhook_data );

		$dynamic_keys = self::telemed_zoom_dynamic_keys( $dynamic_keys, $webhook_data );

		// Merge with common dynamic keys.
		$dynamic_keys = array_merge( $dynamic_keys, kcwh_common_dynamic_keys( ! empty( $doctor_data ) ,$webhook_data) );

		// Apply filter to modify dynamic keys if needed.
		return apply_filters( 'kcwh_webhooks_doctor_dynamic_keys', $dynamic_keys, $doctor_data );
	}

	/**
	 * Fetches doctor data from the database and stores it in static property for caching.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return void
	 */
	public static function fetch_data_from_db( array $webhook_data ): void {

		// Return early if module_id is empty or data already fetched.
		if ( empty( $webhook_data['module_id'] ) || ! empty( self::$doctors_data[ $webhook_data['module_id'] ] ) ) {
			return;
		}

		$doctor_id = $webhook_data['module_id'];

		$result = get_userdata( $doctor_id );
		if ( empty( $result ) ) {
			return;
		}
		unset( $result->user_pass );
		$doctor_data      = collect( $result->data )->toArray();
		$doctor_meta_data = get_user_meta( $doctor_id );
		foreach ( $doctor_meta_data as $key => $value ) {
			$data = is_array( $value ) ? ( ! empty( $value[0] ) ? $value[0] : '' ) : $value;
			if ( empty( $data ) ) {
				continue;
			}
			switch ( $key ) {
				case 'basic_data':
					$basic_data = json_decode( $data, true );
					if ( empty( $basic_data ) ) {
						break;
					}
					foreach ( $basic_data as $item_key => $item_value ) {
						$doctor_data[ $item_key ] = is_array( $item_value ) ? wp_json_encode( $item_value ) : $item_value;
					}
					break;
				case 'doctor_profile_image':
					$doctor_data[ $key ] = wp_get_attachment_url( $data );
					break;
				default:
					$doctor_data[ $key ] = $data;
			}
		}
		$doctor_data['country_calling_code'] = ! empty( $doctor_data['country_calling_code'] ) ? '+' . $doctor_data['country_calling_code'] . ' ' : '';
		$doctor_data['contact_number']       = ! empty( $doctor_data['mobile_number'] ) ? $doctor_data['country_calling_code'] . $doctor_data['mobile_number'] : '';
		$doctor_data['clinic_ids']           = collect(
			( new KCDoctorClinicMapping() )->get_by(
				array( 'doctor_id' => $doctor_id ),
			)
		)->pluck( 'clinic_id' )->implode( ',' );
		// Store fetched data in static property for caching.
		self::$doctors_data[ $doctor_id ] = $doctor_data;
	}

	/**
	 * Add Zoom Telemed dynamic keys to the provided dynamic keys array.
	 *
	 * This function checks if the Zoom Telemed plugin is active, retrieves Zoom configuration data
	 * for a given doctor, and adds the relevant data to the dynamic keys array.
	 *
	 * @param array $dynamic_keys An array of dynamic keys to be modified.
	 * @param array $webhook_data An associative array containing webhook data, including the module ID.
	 * @return array The modified dynamic keys array with Zoom Telemed data added.
	 */
	public static function telemed_zoom_dynamic_keys( array $dynamic_keys, array $webhook_data ): array {
		// Retrieve the doctor ID from webhook data, defaulting to -1 if not available.
		$doctor_id = ! empty( $webhook_data['module_id'] ) ? $webhook_data['module_id'] : -1;

		// Check if the Zoom Telemed plugin is active.
		if ( self::$zoom_telemed_plugin_active ) {
			$config_data = array();

			// If the module ID is available, get the Zoom configuration data.
			if ( ! empty( $webhook_data['module_id'] ) ) {
				$config_data = apply_filters(
					'kct_get_zoom_configuration',
					array(
						'user_id' => $doctor_id,
					)
				);
			}

			// Check if the configuration data is valid and the status is true.
			if ( isset( $config_data['status'] ) && $config_data['status'] ) {
				// Convert the configuration data to an array.
				$config_data['data'] = collect( $config_data['data'] )->toArray();

				// Add Zoom configuration data to the dynamic keys array.
				$dynamic_keys['{{doctor_zoom_enable}}']     = ! empty( $config_data['data']['enableTeleMed'] ) ? $config_data['data']['enableTeleMed'] : 'false';
				$dynamic_keys['{{doctor_zoom_api_key}}']    = ! empty( $config_data['data']['api_key'] ) && 'null' !== $config_data['data']['api_key'] ? $config_data['data']['api_key'] : '';
				$dynamic_keys['{{doctor_zoom_secret_key}}'] = ! empty( $config_data['data']['api_secret'] ) && 'null' !== $config_data['data']['api_secret'] ? $config_data['data']['api_secret'] : '';
				$dynamic_keys['{{doctor_zoom_id}}']         = ! empty( $config_data['data']['zoom_id'] ) && 'null' !== $config_data['data']['zoom_id'] ? $config_data['data']['zoom_id'] : '';
			}
		}

		return $dynamic_keys;
	}
}
