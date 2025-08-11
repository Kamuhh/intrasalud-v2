<?php
/**
 * Appointment filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use App\models\KCAppointment;
use App\models\KCAppointmentServiceMapping;
use App\models\KCClinic;
use App\models\KCPatientEncounter;
use App\models\KCService;
use KCWebhookAddons\BaseClasses\KCWHAbstractController;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHAppointmentFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHAppointmentFilter extends KCWHAbstractController {

	/**
	 * Appointments data array with appointment id as array key
	 *
	 * @var array Holds fetched appointment data for caching.
	 */
	public static array $appointments_data = array();

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
	 * Add module appointment list for webhooks addon.
	 *
	 * @param array $modules The existing modules array.
	 *
	 * @return array The modified modules array.
	 */
	public static function webhooks_module_list( array $modules ): array {
		$modules[] = array(
			'value' => 'appointment',
			'text'  => esc_html__( 'Appointment', 'kivicare-webhooks-addon' ),
		);
		return $modules;
	}

	/**
	 * Adds appointment-related events to the list of module events for the webhooks addon.
	 *
	 * This function modifies the existing events array by adding appointment-related events,
	 *  If the $with_dynamic_keys parameter is true, dynamic keys are also included in each event.
	 *
	 * @param array $events The existing events array.
	 * @param bool  $with_dynamic_keys Whether to include dynamic keys in the events. Defaults to true.
	 *
	 * @return array The modified events array including appointment-related events.
	 */
	public static function webhooks_module_event_list( array $events = array(), bool $with_dynamic_keys = true ): array {
		// retrieve and sort dynamic keys for the current class.
		$dynamic_keys          = self::get_and_sort_dynamic_keys( $with_dynamic_keys, self::class );
		$events['appointment'] = array(
			array(
				'value'        => 'kc_appointment_book',
				'text'         => esc_html__( 'Add appointment', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_appointment_update',
				'text'         => esc_html__( 'Update appointment', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_appointment_delete',
				'text'         => esc_html__( 'Delete appointment', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => self::get_delete_event_dynamic_keys( '{{appointment_id}}' ),
			),
			array(
				'value'        => 'kc_appointment_status_update',
				'text'         => esc_html__( 'Update appointment Status', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
			array(
				'value'        => 'kc_appointment_payment_complete',
				'text'         => esc_html__( 'Appointment payment complete', 'kivicare-webhooks-addon' ),
				'dynamic_keys' => $dynamic_keys,
			),
		);
		return $events;
	}

	/**
	 * Get dynamic keys for appointment-related webhook data.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return array An array of dynamic keys mapped to their corresponding values.
	 */
	public static function get_dynamic_keys( array $webhook_data = array() ): array {

		$appointment_data = array();
		$appointment_id   = '';
		// Fetch appointment data if module_id(appointment id) is present in webhook_data.
		if ( ! empty( $webhook_data['module_id'] ) ) {
			self::fetch_data_from_db( $webhook_data ); // method fetches data from the database.
			$appointment_id   = $webhook_data['module_id'];
			$appointment_data = ! empty( self::$appointments_data[ $appointment_id ] ) ? self::$appointments_data[ $appointment_id ] : array();
		}

		// Define dynamic keys based on appointment data.
		$dynamic_keys = array(
			'{{appointment_date}}'       => ! empty( $appointment_data['appointment_start_date'] ) ? kcGetFormatedDate($appointment_data['appointment_start_date']) : '',
			'{{appointment_id}}'         => ! empty( $appointment_data['id'] ) ? $appointment_data['id'] : $appointment_id,
			'{{appointment_status}}'     => isset( $appointment_data['status'] ) ? $appointment_data['status'] : '',
			'{{appointment_end_time}}'   => ! empty( $appointment_data['appointment_end_time'] ) ? $appointment_data['appointment_end_time'] : '',
			'{{appointment_start_time}}' => ! empty( $appointment_data['appointment_start_time'] ) ? kcGetFormatedTime($appointment_data['appointment_start_time']) : '',
			'{{appointment_created_at}}' => ! empty( $appointment_data['created_at'] ) ? $appointment_data['created_at'] : '',
			'{{clinic_id}}'              => ! empty( $appointment_data['clinic_id'] ) ? $appointment_data['clinic_id'] : '',
			'{{clinic_address}}'         => ! empty( $appointment_data['clinic_address'] ) ? $appointment_data['clinic_address'] : '',
			'{{clinic_contact_number}}'  => ! empty( $appointment_data['clinic_contact_number'] ) ? $appointment_data['clinic_contact_number'] : '',
			'{{clinic_email}}'           => ! empty( $appointment_data['clinic_email'] ) ? $appointment_data['clinic_email'] : '',
			'{{clinic_name}}'            => ! empty( $appointment_data['clinic_name'] ) ? $appointment_data['clinic_name'] : '',
			'{{doctor_contact_number}}'  => ! empty( $appointment_data['doctor_contact_number'] ) ? $appointment_data['doctor_contact_number'] : '',
			'{{doctor_id}}'              => ! empty( $appointment_data['doctor_id'] ) ? $appointment_data['doctor_id'] : '',
			'{{doctor_email}}'           => ! empty( $appointment_data['doctor_email'] ) ? $appointment_data['doctor_email'] : '',
			'{{doctor_name}}'            => ! empty( $appointment_data['doctor_name'] ) ? $appointment_data['doctor_name'] : '',
			'{{encounter_id}}'           => ! empty( $appointment_data['encounter_id'] ) ? $appointment_data['encounter_id'] : '',
			'{{patient_id}}'             => ! empty( $appointment_data['patient_id'] ) ? $appointment_data['patient_id'] : '',
			'{{patient_contact_number}}' => ! empty( $appointment_data['patient_contact_number'] ) ? $appointment_data['patient_contact_number'] : '',
			'{{patient_email}}'          => ! empty( $appointment_data['patient_email'] ) ? $appointment_data['patient_email'] : '',
			'{{patient_name}}'           => ! empty( $appointment_data['patient_name'] ) ? $appointment_data['patient_name'] : '',
			'{{service_names}}'          => ! empty( $appointment_data['service_names'] ) ? $appointment_data['service_names'] : '',
		);

		$dynamic_keys = self::custom_form_dynamic_keys( $dynamic_keys, 'appointment_module', $webhook_data );

		$dynamic_keys = self::custom_fields_dynamic_keys( $dynamic_keys, 'appointment_module', $webhook_data );

		// Merge with common dynamic keys.
		$dynamic_keys = array_merge( $dynamic_keys, kcwh_common_dynamic_keys( ! empty( $appointment_data ),$webhook_data ) );

		// Apply filter to modify dynamic keys if needed.
		return apply_filters( 'kcwh_webhooks_appointment_dynamic_keys', $dynamic_keys, $appointment_data );
	}

	/**
	 * Fetches appointment data from the database and stores it in static property for caching.
	 *
	 * @param array $webhook_data The webhook data array containing module_id and other relevant data.
	 * @return void
	 */
	public static function fetch_data_from_db( array $webhook_data ): void {

		// Return early if module_id is empty or data already fetched.
		if ( empty( $webhook_data['module_id'] ) || ! empty( self::$appointments_data[ $webhook_data['module_id'] ] ) ) {
			return;
		}

		$appointment_id = (int) $webhook_data['module_id'];

		global $wpdb;
		$appointments_table                = ( new KCAppointment() )->get_table_name();
		$clinics_table                     = ( new KCClinic() )->get_table_name();
		$encounter_table                   = ( new KCPatientEncounter() )->get_table_name();
		$appointment_service_mapping_table = ( new KCAppointmentServiceMapping() )->get_table_name();
		$services_table                    = ( new KCService() )->get_table_name();
		$users_table                       = $wpdb->prefix . 'users';
		$usermeta_table                    = $wpdb->prefix . 'usermeta';

		// Prepare SQL query.
        // @codingStandardsIgnoreStart
		$sql = $wpdb->prepare(
			"
            SELECT 
                a.*, 
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
                CONCAT( '+',c.country_calling_code,' ', c.telephone_no) AS clinic_contact_number,
                pe.id AS encounter_id,
                (
                    SELECT GROUP_CONCAT(s.name SEPARATOR ', ') 
                        FROM $appointment_service_mapping_table asm
                        LEFT JOIN $services_table s ON asm.service_id = s.id
                        WHERE asm.appointment_id = a.id
                )
                AS service_names
            FROM 
                $appointments_table a
            LEFT JOIN 
                $users_table doctors ON a.doctor_id = doctors.ID 
            LEFT JOIN 
                $usermeta_table db ON a.doctor_id = db.user_id 
                AND db.meta_key = 'basic_data'
            LEFT JOIN 
                $usermeta_table dc ON a.doctor_id = dc.user_id 
                AND dc.meta_key = 'country_calling_code'
            LEFT JOIN 
                $encounter_table pe ON a.id = pe.appointment_id 
            LEFT JOIN 
                $users_table patients ON a.patient_id = patients.ID 
            LEFT JOIN 
                $usermeta_table pb ON a.patient_id = pb.user_id 
                AND pb.meta_key = 'basic_data'
            LEFT JOIN 
                $usermeta_table pc ON a.patient_id = pc.user_id 
                AND pc.meta_key = 'country_calling_code'
            LEFT JOIN 
                $clinics_table c ON a.clinic_id = c.id 
            WHERE 
                a.id = %d
        ",
			$appointment_id
		);

		// Execute SQL query.
		$appointment_data = $wpdb->get_row( $sql, ARRAY_A );
        // @codingStandardsIgnoreEnd
		if ( empty( $appointment_data ) ) {
			return;
		}

		$appointment_data = self::format_user_contact_number( $appointment_data );

		// Store fetched data in static property for caching.
		self::$appointments_data[ $appointment_id ] = $appointment_data;
	}
}
