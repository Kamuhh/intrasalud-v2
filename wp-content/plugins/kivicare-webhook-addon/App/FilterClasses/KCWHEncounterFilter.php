<?php
/**
 * Filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use App\models\KCClinic;
use App\models\KCPatientEncounter;
use KCWebhookAddons\BaseClasses\KCWHAbstractController;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHEncounterFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHEncounterFilter extends KCWHAbstractController {


	/**
	 * Encounters data array with encounter id as array key
	 *
	 * @var array Holds fetched encounters data for caching.
	 */
	public static array $encounters_data = array();

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
	 * Add module encounter list for webhooks addon.
	 *
	 * @param array $modules The existing modules array.
	 *
	 * @return array The modified modules array.
	 */
	public static function webhooks_module_list( array $modules ): array {
		$modules[] = array(
			'value' => 'encounter',
			'text'  => esc_html__( 'Encounter', 'kivicare-webhooks-addon' ),
		);
		return $modules;
	}

	/**
	 * Adds encounter-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding encounter-related events,
	 *  If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including encounter-related events.
	 */
	public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array {
		// retrieve and sort dynamic keys for the current class.
		$dynamic_keys        = self::get_and_sort_dynamic_keys( $with_dynamic_keys, self::class );
		$events['encounter'] = array(
			array(
				'value'        => 'kc_encounter_save',
				'text'         => esc_html__( 'Add encounter', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_encounter_update',
				'text'         => esc_html__( 'Update encounter', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_encounter_delete',
				'text'         => esc_html__( 'Delete encounter', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => self::get_delete_event_dynamic_keys( '{{encounter_id}}' ),
			),
		);
		return $events;
	}

	/**
	 * Get dynamic keys for encounter-related webhook data.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return array An array of dynamic keys mapped to their corresponding values.
	 */
	public static function get_dynamic_keys( array $webhook_data = array() ): array {

		$encounter_data = array();
		$encounter_id   = '';
		// Fetch encounter data if module_id(encounter id) is present in webhook_data.
		if ( ! empty( $webhook_data['module_id'] ) ) {
			self::fetch_data_from_db( $webhook_data ); // method fetches data from the database.
			$encounter_id   = $webhook_data['module_id'];
			$encounter_data = ! empty( self::$encounters_data[ $encounter_id ] ) ? self::$encounters_data[ $encounter_id ] : array();
		}

		// Define dynamic keys based on appointment data.
		$dynamic_keys = array(
			'{{encounter_id}}'           => ! empty( $encounter_data['id'] ) ? $encounter_data['id'] : $encounter_id,
			'{{encounter_date}}'         => ! empty( $encounter_data['encounter_date'] ) ? kcGetFormatedDate($encounter_data['encounter_date']) : '',
			'{{encounter_status}}'       => isset( $encounter_data['status'] ) ? $encounter_data['status'] : '',
			'{{encounter_description}}'  => ! empty( $encounter_data['description'] ) ? $encounter_data['description'] : '',
			'{{encounter_template_id}}'  => ! empty( $encounter_data['template_id'] ) ? $encounter_data['template_id'] : '',
			'{{encounter_added_by}}'     => ! empty( $encounter_data['added_by'] ) ? $encounter_data['added_by'] : '',
			'{{encounter_created_at}}'   => ! empty( $encounter_data['created_at'] ) ? $encounter_data['created_at'] : '',
			'{{clinic_id}}'              => ! empty( $encounter_data['clinic_id'] ) ? $encounter_data['clinic_id'] : '',
			'{{clinic_contact_number}}'  => ! empty( $encounter_data['clinic_contact_number'] ) ? $encounter_data['clinic_contact_number'] : '',
			'{{clinic_email}}'           => ! empty( $encounter_data['clinic_email'] ) ? $encounter_data['clinic_email'] : '',
			'{{clinic_name}}'            => ! empty( $encounter_data['clinic_name'] ) ? $encounter_data['clinic_name'] : '',
			'{{doctor_id}}'              => ! empty( $encounter_data['doctor_id'] ) ? $encounter_data['doctor_id'] : '',
			'{{doctor_contact_number}}'  => ! empty( $encounter_data['doctor_contact_number'] ) ? $encounter_data['doctor_contact_number'] : '',
			'{{doctor_email}}'           => ! empty( $encounter_data['doctor_email'] ) ? $encounter_data['doctor_email'] : '',
			'{{doctor_name}}'            => ! empty( $encounter_data['doctor_name'] ) ? $encounter_data['doctor_name'] : '',
			'{{appointment_id}}'         => ! empty( $encounter_data['appointment_id'] ) ? $encounter_data['appointment_id'] : '',
			'{{patient_id}}'             => ! empty( $encounter_data['patient_id'] ) ? $encounter_data['patient_id'] : '',
			'{{patient_contact_number}}' => ! empty( $encounter_data['patient_contact_number'] ) ? $encounter_data['patient_contact_number'] : '',
			'{{patient_email}}'          => ! empty( $encounter_data['patient_email'] ) ? $encounter_data['patient_email'] : '',
			'{{patient_name}}'           => ! empty( $encounter_data['patient_name'] ) ? $encounter_data['patient_name'] : '',

		);

		$dynamic_keys = self::custom_form_dynamic_keys( $dynamic_keys, 'encounter_module', $webhook_data );

		$dynamic_keys = self::custom_fields_dynamic_keys( $dynamic_keys, 'encounter_module', $webhook_data );

		// Merge with common dynamic keys.
		$dynamic_keys = array_merge( $dynamic_keys, kcwh_common_dynamic_keys( ! empty( $encounter_data ),$webhook_data ) );

		// Apply filter to modify dynamic keys if needed.
		return apply_filters( 'kcwh_webhooks_appointment_dynamic_keys', $dynamic_keys, $encounter_data );
	}

	/**
	 * Fetches appointment data from the database and stores it in static property for caching.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return void
	 */
	public static function fetch_data_from_db( array $webhook_data ): void {

		// Return early if module_id is empty or data already fetched.
		if ( empty( $webhook_data['module_id'] ) || ! empty( self::$encounters_data[ $webhook_data['module_id'] ] ) ) {
			return;
		}

		$encounter_id = (int) $webhook_data['module_id'];

		global $wpdb;
		$encounter_table = ( new KCPatientEncounter() )->get_table_name();
		$clinics_table   = ( new KCClinic() )->get_table_name();
		$users_table     = $wpdb->prefix . 'users';
		$usermeta_table  = $wpdb->prefix . 'usermeta';

		// Prepare SQL query.
        // @codingStandardsIgnoreStart
		$sql = $wpdb->prepare(
			"
            SELECT 
                e.*, 
                doctors.display_name AS doctor_name, 
                doctors.user_email AS doctor_email, 
                patients.display_name AS patient_name, 
                patients.user_email AS patient_email, 
                dc.meta_value AS doctor_country_code,
                db.meta_value  AS doctor_basic_data,
                pc.meta_value AS patient_country_code,
                pb.meta_value AS patient_basic_data,
                CONCAT(
                    c.address, ', ', 
                    c.city, ', ', 
                    c.postal_code, ', ', 
                    c.country
                ) AS clinic_address, 
                c.email AS clinic_email, 
                c.name AS clinic_name, 
                CONCAT( '+',c.country_calling_code,' ', c.telephone_no) AS clinic_contact_number
            FROM 
                $encounter_table e
            LEFT JOIN 
                $users_table doctors ON e.doctor_id = doctors.ID 
            LEFT JOIN 
                $usermeta_table db ON e.doctor_id = db.user_id 
                AND db.meta_key = 'basic_data'
            LEFT JOIN 
                $usermeta_table dc ON e.doctor_id = dc.user_id 
                AND dc.meta_key = 'country_calling_code'
            LEFT JOIN 
                $encounter_table pe ON e.id = pe.appointment_id 
            LEFT JOIN 
                $users_table patients ON e.patient_id = patients.ID 
            LEFT JOIN 
                $usermeta_table pb ON e.patient_id = pb.user_id 
                AND pb.meta_key = 'basic_data'
            LEFT JOIN 
                $usermeta_table pc ON e.patient_id = pc.user_id 
                AND pc.meta_key = 'country_calling_code'
            LEFT JOIN 
                $clinics_table c ON e.clinic_id = c.id 
            WHERE 
                e.id = %d
        ",
			$encounter_id
		);

		// Execute SQL query.
		$encounter_data = $wpdb->get_row( $sql, ARRAY_A );
        // @codingStandardsIgnoreEnd
		if ( empty( $encounter_data ) ) {
			return;
		}

		$encounter_data = self::format_user_contact_number( $encounter_data );

		// Store fetched data in static property for caching.
		self::$encounters_data[ $encounter_id ] = $encounter_data;
	}
}
