<?php
/**
 * Filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use App\models\KCPatientClinicMapping;
use KCWebhookAddons\BaseClasses\KCWHAbstractController;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHDoctorFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHPatientFilter extends KCWHAbstractController {


	/**
	 * Patients data array with patient id as array key
	 *
	 * @var array Holds fetched patients data for caching.
	 */
	public static array $patients_data = array();

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
	 * Add module patient list for webhooks addon.
	 *
	 * @param array $modules The existing modules array.
	 *
	 * @return array The modified modules array.
	 */
	public static function webhooks_module_list( array $modules ): array {
		$modules[] = array(
			'value' => 'patient',
			'text'  => esc_html__( 'Patient', 'kivicare-webhooks-addon' ),
		);
		return $modules;
	}

	/**
	 * Adds patient-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding patient-related events,
	 *  If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including patient-related events.
	 */
	public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array {
		// retrieve and sort dynamic keys for the current class.
		$dynamic_keys      = self::get_and_sort_dynamic_keys( $with_dynamic_keys, self::class );
		$events['patient'] = array(
			array(
				'value'        => 'kc_patient_save',
				'text'         => esc_html__( 'Add patient', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_patient_update',
				'text'         => esc_html__( 'Update patient', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_patient_delete',
				'text'         => esc_html__( 'Delete patient', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => self::get_delete_event_dynamic_keys( '{{patient_id}}' ),
			),
		);
		return $events;
	}

	/**
	 * Get dynamic keys for patient-related webhook data.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return array An array of dynamic keys mapped to their corresponding values.
	 */
	public static function get_dynamic_keys( array $webhook_data = array() ): array {

		$patient_data = array();
		$patient_id   = '';
		// Fetch patient data if module_id(patient id) is present in webhook_data.
		if ( ! empty( $webhook_data['module_id'] ) ) {
			self::fetch_data_from_db( $webhook_data ); // method fetches data from the database.
			$patient_id   = $webhook_data['module_id'];
			$patient_data = ! empty( self::$patients_data[ $patient_id ] ) ? self::$patients_data[ $patient_id ] : array();
		}

		// Define dynamic keys based on patient data.
		$dynamic_keys = array(
			'{{patient_address}}'              => ! empty( $patient_data['address'] ) ? $patient_data['address'] : '',
			'{{patient_blood_group}}'          => ! empty( $patient_data['blood_group'] ) ? $patient_data['blood_group'] : '',
			'{{patient_city}}'                 => ! empty( $patient_data['city'] ) ? $patient_data['city'] : '',
			'{{patient_clinic_ids}}'           => ! empty( $patient_data['clinic_ids'] ) ? $patient_data['clinic_ids'] : '',
			'{{patient_contact_number}}'       => ! empty( $patient_data['contact_number'] ) ? $patient_data['contact_number'] : '',
			'{{patient_country}}'              => ! empty( $patient_data['country'] ) ? $patient_data['country'] : '',
			'{{patient_dob}}'                  => ! empty( $patient_data['dob'] ) ? $patient_data['dob'] : '',
			'{{patient_email}}'                => ! empty( $patient_data['user_email'] ) ? $patient_data['user_email'] : '',
			'{{patient_first_name}}'           => ! empty( $patient_data['first_name'] ) ? $patient_data['first_name'] : '',
			'{{patient_full_name}}'            => ! empty( $patient_data['display_name'] ) ? $patient_data['display_name'] : '',
			'{{patient_gender}}'               => ! empty( $patient_data['gender'] ) ? $patient_data['gender'] : '',
			'{{patient_id}}'                   => ! empty( $patient_data['ID'] ) ? $patient_data['ID'] : $patient_id,
			'{{patient_last_name}}'            => ! empty( $patient_data['last_name'] ) ? $patient_data['last_name'] : '',
			'{{patient_postal_code}}'          => ! empty( $patient_data['postal_code'] ) ? $patient_data['postal_code'] : '',
			'{{patient_profile_photo}}'        => ! empty( $patient_data['patient_profile_image'] ) ? $patient_data['patient_profile_image'] : '',
			'{{patient_status}}'               => isset( $patient_data['user_status'] ) ? $patient_data['user_status'] : '',
			'{{patient_registered_date_time}}' => ! empty( $patient_data['user_registered'] ) ? $patient_data['user_registered'] : '',
		);

		$dynamic_keys = self::custom_form_dynamic_keys( $dynamic_keys, 'patient_module', $webhook_data );

		$dynamic_keys = self::custom_fields_dynamic_keys( $dynamic_keys, 'patient_module', $webhook_data );

		// Merge with common dynamic keys.
		$dynamic_keys = array_merge( $dynamic_keys, kcwh_common_dynamic_keys( ! empty( $patient_data ),$webhook_data ) );

		// Apply filter to modify dynamic keys if needed.
		return apply_filters( 'kcwh_webhooks_patient_dynamic_keys', $dynamic_keys, $patient_data );
	}

	/**
	 * Fetches patient data from the database and stores it in static property for caching.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return void
	 */
	public static function fetch_data_from_db( array $webhook_data ): void {

		// Return early if module_id is empty or data already fetched.
		if ( empty( $webhook_data['module_id'] ) || ! empty( self::$patients_data[ $webhook_data['module_id'] ] ) ) {
			return;
		}

		$patient_id = (int) $webhook_data['module_id'];

		$result = get_userdata( $patient_id );
		if ( empty( $result ) ) {
			return;
		}
		unset( $result->user_pass );
		$patient_data      = collect( $result->data )->toArray();
		$patient_meta_data = get_user_meta( $patient_id );
		foreach ( $patient_meta_data as $key => $value ) {
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
						$patient_data[ $item_key ] = is_array( $item_value ) ? wp_json_encode( $item_value ) : $item_value;
					}
					break;
				case 'patient_profile_image':
					$patient_data[ $key ] = wp_get_attachment_url( $data );
					break;
				default:
					$patient_data[ $key ] = $data;
			}
		}
		$patient_data['country_calling_code'] = ! empty( $patient_data['country_calling_code'] ) ? '+' . $patient_data['country_calling_code'] . ' ' : '';
		$patient_data['contact_number']       = ! empty( $patient_data['mobile_number'] ) ? $patient_data['country_calling_code'] . $patient_data['mobile_number'] : '';
		$patient_data['clinic_ids']           = collect(
			( new KCPatientClinicMapping() )->get_by(
				array( 'patient_id' => $patient_id ),
			)
		)->pluck( 'clinic_id' )->implode( ',' );
		// Store fetched data in static property for caching.
		self::$patients_data[ $patient_id ] = $patient_data;
	}
}
