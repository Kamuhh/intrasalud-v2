<?php
/**
 * Filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use App\models\KCReceptionistClinicMapping;
use KCWebhookAddons\BaseClasses\KCWHAbstractController;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHreceptionistFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHReceptionistFilter extends KCWHAbstractController {


	/**
	 * Receptionists data array with receptionist id as array key
	 *
	 * @var array Holds fetched receptionists data for caching.
	 */
	public static array $receptionists_data = array();

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
	 * Add module receptionist list for webhooks addon.
	 *
	 * @param array $modules The existing modules array.
	 *
	 * @return array The modified modules array.
	 */
	public static function webhooks_module_list( array $modules ): array {
		$modules[] = array(
			'value' => 'receptionist',
			'text'  => esc_html__( 'Receptionist', 'kivicare-webhooks-addon' ),
		);
		return $modules;
	}

	/**
	 * Add receptionist-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding receptionist-related events,
	 * If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including receptionist-related events.
	 */
	public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array {
		// retrieve and sort dynamic keys for the current class.
		$dynamic_keys           = self::get_and_sort_dynamic_keys( $with_dynamic_keys, self::class );
		$events['receptionist'] = array(
			array(
				'value'        => 'kc_receptionist_save',
				'text'         => esc_html__( 'Add receptionist', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_receptionist_update',
				'text'         => esc_html__( 'Update receptionist', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_receptionist_delete',
				'text'         => esc_html__( 'Delete receptionist', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => self::get_delete_event_dynamic_keys( '{{receptionist_id}}' ),
			),
		);
		return $events;
	}

	/**
	 * Get dynamic keys for receptionist-related webhook data.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return array An array of dynamic keys mapped to their corresponding values.
	 */
	public static function get_dynamic_keys( array $webhook_data = array() ): array {

		$receptionist_data = array();
		$receptionist_id   = '';
		// Fetch receptionist data if module_id(receptionist id) is present in webhook_data.
		if ( ! empty( $webhook_data['module_id'] ) ) {
			self::fetch_data_from_db( $webhook_data ); // method fetches data from the database.
			$receptionist_id   = $webhook_data['module_id'];
			$receptionist_data = ! empty( self::$receptionists_data[ $receptionist_id ] ) ? self::$receptionists_data[ $receptionist_id ] : array();
		}

		// Define dynamic keys based on receptionist data.
		$dynamic_keys = array(
			'{{receptionist_address}}'              => ! empty( $receptionist_data['address'] ) ? $receptionist_data['address'] : '',
			'{{receptionist_city}}'                 => ! empty( $receptionist_data['city'] ) ? $receptionist_data['city'] : '',
			'{{receptionist_clinic_ids}}'           => ! empty( $receptionist_data['clinic_ids'] ) ? $receptionist_data['clinic_ids'] : '',
			'{{receptionist_contact_number}}'       => ! empty( $receptionist_data['contact_number'] ) ? $receptionist_data['contact_number'] : '',
			'{{receptionist_country}}'              => ! empty( $receptionist_data['country'] ) ? $receptionist_data['country'] : '',
			'{{receptionist_dob}}'                  => ! empty( $receptionist_data['dob'] ) ? $receptionist_data['dob'] : '',
			'{{receptionist_email}}'                => ! empty( $receptionist_data['user_email'] ) ? $receptionist_data['user_email'] : '',
			'{{receptionist_first_name}}'           => ! empty( $receptionist_data['first_name'] ) ? $receptionist_data['first_name'] : '',
			'{{receptionist_full_name}}'            => ! empty( $receptionist_data['display_name'] ) ? $receptionist_data['display_name'] : '',
			'{{receptionist_gender}}'               => ! empty( $receptionist_data['gender'] ) ? $receptionist_data['gender'] : '',
			'{{receptionist_id}}'                   => ! empty( $receptionist_data['ID'] ) ? $receptionist_data['ID'] : $receptionist_id,
			'{{receptionist_last_name}}'            => ! empty( $receptionist_data['last_name'] ) ? $receptionist_data['last_name'] : '',
			'{{receptionist_postal_code}}'          => ! empty( $receptionist_data['postal_code'] ) ? $receptionist_data['postal_code'] : '',
			'{{receptionist_profile_photo}}'        => ! empty( $receptionist_data['receptionist_profile_image'] ) ? $receptionist_data['receptionist_profile_image'] : '',
			'{{receptionist_status}}'               => isset( $receptionist_data['user_status'] ) ? $receptionist_data['user_status'] : '',
			'{{receptionist_registered_date_time}}' => ! empty( $receptionist_data['user_registered'] ) ? $receptionist_data['user_registered'] : '',
		);

		// Merge with common dynamic keys.
		$dynamic_keys = array_merge( $dynamic_keys, kcwh_common_dynamic_keys( ! empty( $receptionist_data ),$webhook_data ) );

		// Apply filter to modify dynamic keys if needed.
		return apply_filters( 'kcwh_webhooks_receptionist_dynamic_keys', $dynamic_keys, $receptionist_data );
	}

	/**
	 * Fetches receptionist data from the database and stores it in static property for caching.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return void
	 */
	public static function fetch_data_from_db( array $webhook_data ): void {

		// Return early if module_id is empty or data already fetched.
		if ( empty( $webhook_data['module_id'] ) || ! empty( self::$receptionists_data[ $webhook_data['module_id'] ] ) ) {
			return;
		}

		$receptionist_id = (int) $webhook_data['module_id'];

		$result = get_userdata( $receptionist_id );
		if ( empty( $result ) ) {
			return;
		}
		unset( $result->user_pass );
		$receptionist_data = collect( $result->data )->toArray();
		$patient_meta_data = get_user_meta( $receptionist_id );
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
						$receptionist_data[ $item_key ] = is_array( $item_value ) ? wp_json_encode( $item_value ) : $item_value;
					}
					break;
				case 'receptionist_profile_image':
					$receptionist_data[ $key ] = wp_get_attachment_url( $data );
					break;
				default:
					$receptionist_data[ $key ] = $data;
			}
		}
		$receptionist_data['country_calling_code'] = ! empty( $receptionist_data['country_calling_code'] ) ? '+' . $receptionist_data['country_calling_code'] . ' ' : '';
		$receptionist_data['contact_number']       = ! empty( $receptionist_data['mobile_number'] ) ? $receptionist_data['country_calling_code'] . $receptionist_data['mobile_number'] : '';
		$receptionist_data['clinic_ids']           = collect(
			( new KCReceptionistClinicMapping() )->get_by(
				array( 'receptionist_id' => $receptionist_id ),
			)
		)->pluck( 'clinic_id' )->implode( ',' );
		// Store fetched data in static property for caching.
		self::$receptionists_data[ $receptionist_id ] = $receptionist_data;
	}
}
