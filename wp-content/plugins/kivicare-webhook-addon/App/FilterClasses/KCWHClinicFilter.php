<?php
/**
 * Filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use KCWebhookAddons\BaseClasses\KCWHAbstractController;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHClinicFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHClinicFilter extends KCWHAbstractController {

	/**
	 * Clinics data array with clinic id as array key
	 *
	 * @var array Holds fetched clinics data for caching.
	 */
	public static array $clinics_data = array();

	/**
	 * Class constructor.
	 *
	 * This constructor initializes the class by calling the parent constructor.
	 * If the KiviCare Pro plugin is active, it initializes hooks using the initHooks method.
	 */
	public function __construct() {
		// Call the parent constructor.
		parent::__construct();

		// Check if the KiviCare Pro plugin is active.
		if ( self::$pro_plugin_active ) {
			// Initialize hooks using the initHooks method of this class.
			self::initHooks( self::class );
		}
	}


	/**
	 * Add module clinic list for webhooks addon.
	 *
	 * @param array $modules The existing modules array.
	 *
	 * @return array The modified modules array.
	 */
	public static function webhooks_module_list( array $modules ): array {
		$modules[] = array(
			'value' => 'clinic',
			'text'  => esc_html__( 'Clinic', 'kivicare-webhooks-addon' ),
		);
		return $modules;
	}

	/**
	 * Adds clinic-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding clinic-related events,
	 *  If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including clinic-related events.
	 */
	public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array {
		// retrieve and sort dynamic keys for the current class.
		$dynamic_keys = self::get_and_sort_dynamic_keys( $with_dynamic_keys, self::class );

		$events['clinic'] = array(
			array(
				'value'        => 'kcpro_clinic_save',
				'text'         => esc_html__( 'Add clinic', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kcpro_clinic_update',
				'text'         => esc_html__( 'Update clinic', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kcpro_clinic_delete',
				'text'         => esc_html__( 'Delete clinic', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => self::get_delete_event_dynamic_keys( '{{clinic_id}}' ),
			),
		);
		return $events;
	}

	/**
	 * Get dynamic keys for clinic-related webhook data.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return array An array of dynamic keys mapped to their corresponding values.
	 */
	public static function get_dynamic_keys( array $webhook_data = array() ): array {

		$clinic_data = array();
		$clinic_id   = '';
		// Fetch clinic data if module_id(clinic id) is present in webhook_data.
		if ( ! empty( $webhook_data['module_id'] ) ) {
			self::fetch_data_from_db( $webhook_data ); // method fetches data from the database.
			$clinic_id   = $webhook_data['module_id'];
			$clinic_data = ! empty( self::$clinics_data[ $clinic_id ] ) ? self::$clinics_data[ $clinic_id ] : array();
		}

		// Define dynamic keys based on clinic data.
		$dynamic_keys = array(
			'{{clinic_id}}'                   => ! empty( $clinic_data['id'] ) ? $clinic_data['id'] : $clinic_id,
			'{{clinic_name}}'                 => ! empty( $clinic_data['name'] ) ? $clinic_data['name'] : '',
			'{{clinic_email}}'                => ! empty( $clinic_data['email'] ) ? $clinic_data['email'] : '',
			'{{clinic_contact_number}}'       => ! empty( $clinic_data['contact_number'] ) ? $clinic_data['contact_number'] : '',
			'{{clinic_specialization}}'       => ! empty( $clinic_data['specialties'] ) ? $clinic_data['specialties'] : '',
			'{{clinic_status}}'               => isset( $clinic_data['status'] ) ? $clinic_data['status'] : '',
			'{{clinic_profile_photo}}'        => ! empty( $clinic_data['clinic_profile'] ) ? $clinic_data['clinic_profile'] : '',
			'{{clinic_address}}'              => ! empty( $clinic_data['address'] ) ? $clinic_data['address'] : '',
			'{{clinic_city}}'                 => ! empty( $clinic_data['city'] ) ? $clinic_data['city'] : '',
			'{{clinic_country}}'              => ! empty( $clinic_data['country'] ) ? $clinic_data['country'] : '',
			'{{clinic_postal_code}}'          => ! empty( $clinic_data['postal_code'] ) ? $clinic_data['postal_code'] : '',
			'{{clinic_admin_id}}'             => ! empty( $clinic_data['clinic_admin_id'] ) ? $clinic_data['clinic_admin_id'] : '',
			'{{clinic_admin_first_name}}'     => ! empty( $clinic_data['first_name'] ) ? $clinic_data['first_name'] : '',
			'{{clinic_admin_last_name}}'      => ! empty( $clinic_data['last_name'] ) ? $clinic_data['last_name'] : '',
			'{{clinic_admin_email}}'          => ! empty( $clinic_data['user_email'] ) ? $clinic_data['user_email'] : '',
			'{{doctor_admin_contact_number}}' => ! empty( $clinic_data['clinic_admin_contact_number'] ) ? $clinic_data['clinic_admin_contact_number'] : '',
			'{{clinic_admin_dob}}'            => ! empty( $clinic_data['dob'] ) ? $clinic_data['dob'] : '',
			'{{clinic_admin_gender}}'         => ! empty( $clinic_data['gender'] ) ? $clinic_data['gender'] : '',
			'{{clinic_admin_profile_photo}}'  => ! empty( $clinic_data['profile_image'] ) ? $clinic_data['profile_image'] : '',
		);

		// Merge with common dynamic keys.
		$dynamic_keys = array_merge( $dynamic_keys, kcwh_common_dynamic_keys( ! empty( $clinic_data ) ,$webhook_data) );

		// Apply filter to modify dynamic keys if needed.
		return apply_filters( 'kcwh_webhooks_clinic_dynamic_keys', $dynamic_keys, $clinic_data );
	}

	/**
	 * Fetches clinic data from the database and stores it in static property for caching.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return void
	 */
	public static function fetch_data_from_db( array $webhook_data ): void {

		// Return early if module_id is empty or data already fetched.
		if ( empty( $webhook_data['module_id'] ) || ! empty( self::$clinics_data[ $webhook_data['module_id'] ] ) ) {
			return;
		}

		$clinic_id   = $webhook_data['module_id'];
		$clinic_data = apply_filters(
			'kcpro_edit_clinic',
			array(
				'clinic_id' => $clinic_id,
			)
		);
		if ( empty( $clinic_data['data'] ) ) {
			return;
		}
		$clinic_data                                = collect( $clinic_data['data'] )->toArray();
		$clinic_data['specialties']                 = ! empty( $clinic_data['specialties'] ) && is_array( $clinic_data['specialties'] ) ? wp_json_encode( $clinic_data['specialties'] ) : '';
		$clinic_country_calling_code                = ! empty( $clinic_data['country_calling_code'] ) ? '+' . $clinic_data['country_calling_code'] . ' ' : '';
		$clinic_data['contact_number']              = ! empty( $clinic_data['telephone_no'] ) ? $clinic_country_calling_code . $clinic_data['telephone_no'] : '';
		$clinic_admin_country_calling_code          = ! empty( $clinic_data['country_calling_code_admin'] ) ? '+' . $clinic_data['country_calling_code_admin'] . ' ' : '';
		$clinic_data['clinic_admin_contact_number'] = ! empty( $clinic_data['mobile_number'] ) ? $clinic_admin_country_calling_code . $clinic_data['mobile_number'] : '';

		// Store fetched data in static property for caching.
		self::$clinics_data[ $clinic_id ] = $clinic_data;
	}
}
