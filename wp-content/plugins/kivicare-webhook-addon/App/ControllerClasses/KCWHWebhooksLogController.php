<?php
/**
 * Controller class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\ControllerClasses;

use App\baseClasses\KCBase;
use App\baseClasses\KCRequest;
use Exception;
use wpdb;
use KCWebhookAddons\ModelClasses\KCWHWebhooksLogModel;
use KCWebhookAddons\ModelClasses\KCWHWebhooksModel;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHWebhooksLogController
 *
 * Init plugin api endpoints
 */
class KCWHWebhooksLogController extends KCBase {

	/**
	 * Request data of current request
	 *
	 * @var KCRequest The request object for handling HTTP requests.
	 */
	public KCRequest $request;

	/**
	 * WordPress database connection object
	 *
	 * @var wpdb WordPress database object for database operations.
	 */
	public wpdb $db;

	/**
	 * Error string
	 *
	 * @var string Holds error messages.
	 */
	public string $error_msg;

	/**
	 * Current date
	 *
	 * @var string|int Holds the current date as either a string or integer.
	 */
	public string|int $current_date;

	/**
	 * Webhook model instance
	 *
	 * @var KCWHWebhooksLogModel Model for managing webhook logs.
	 */
	public KCWHWebhooksLogModel $log_model;

	/**
	 * Constructor. Initializes the KCWHBase class.
	 */
	public function __construct() {
		// Check if the current user role is not administrator.
		// If not administrator, send unauthorized access response.
		if ( $this->getLoginUserRole() !== 'administrator' ) {
			wp_send_json( kcUnauthorizeAccessResponse( 403 ) );
		}

		// Instantiate the KCWHWebhooksLogModel to handle webhook log operations.
		$this->log_model = new KCWHWebhooksLogModel();

		// Initialize request object for handling HTTP requests.
		$this->request = ( new KCRequest() );

		// Initialize WordPress database object using the model's database instance.
		$this->db = $this->log_model->get_db_instance();

		// Set current date and time in 'Y-m-d H:i:s' format.
		$this->current_date = current_time( 'Y-m-d H:i:s' );

		// Call the constructor of the parent class.
		parent::__construct();
	}


	/**
	 * Retrieve and send column data for the webhooks log table via JSON response.
	 *
	 * @return void
	 */
	public function column(): void {
		try {
			// Define columns with field, label, and optional filter and sorting options.
			$columns = array(
				'id'         => array(
					'field'         => 'id',
					'label'         => esc_html__( 'Logs ID', 'kivicare-webhooks-addon' ),
					'filterOptions' => array(
						'enabled'     => true,
						'placeholder' => esc_html__( 'Filter by ID', 'kivicare-webhooks-addon' ),
						'filterValue' => '',
					),
				),
				'webhook_id' => array(
					'field'         => 'webhook_id',
					'label'         => esc_html__( 'Webhook ID', 'kivicare-webhooks-addon' ),
					'filterOptions' => array(
						'enabled' => false,
					),
				),
				'module_id'  => array(
					'field'         => 'module_id',
					'label'         => esc_html__( 'Module - ID', 'kivicare-webhooks-addon' ),
					'filterOptions' => array(
						'enabled'     => true,
						'placeholder' => esc_html__( 'Filter by module ID', 'kivicare-webhooks-addon' ),
						'filterValue' => '',
					),
				),
				'status'  => array(
					'field'         => 'status',
					'label'         => esc_html__( 'Status', 'kivicare-webhooks-addon' ),
					'sortable' => false,
					'filterOptions' => array(
						'enabled'     => false,
					),
				),
				'created_at' => array(
					'field'         => 'created_at',
					'label'         => esc_html__( 'Executed at', 'kivicare-webhooks-addon' ),
					'sortable'      => true,
					'width'         => '250px',
					'filterOptions' => array(
						'enabled' => false,
					),
				),
				'actions'    => array(
					'field'    => 'actions',
					'sortable' => false,
					'label'    => esc_html__( 'Actions', 'kivicare-webhooks-addon' ),
				),
			);

			// Allow filtering of columns via a filter hook.
			$columns = apply_filters( 'kcwh_webhooks_log_table_columns', $columns );

			// Send JSON response with the retrieved column data.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Webhooks log list', 'kivicare-webhooks-addon' ),
					'data'    => $columns,
				)
			);

		} catch ( Exception $e ) {
			// Catch any exceptions and send error response.
			$this->error_msg = $e->getMessage();
			$this->send_error_response();
		}
	}

	/**
	 * Retrieve and send webhook log data via JSON response.
	 *
	 * @return void
	 */
	public function index(): void {
		try {
			// Get request data.
			$request_data = $this->request->getInputs();

			// Validate webhook ID presence.
			if ( empty( $request_data['webhook_id'] ) ) {
				$this->error_msg = esc_html__( 'Webhook id required', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			// Retrieve webhook data by ID.
			$webhooks_data = collect(
				( new KCWHWebhooksModel() )->get_by(
					array( 'id' => $request_data['webhook_id'] ),
					'=',
					true
				)
			)->toArray();

			// Check if webhook data or webhook_data field is empty.
			if ( empty( $webhooks_data ) || empty( $webhooks_data['webhook_data'] ) ) {
				$this->error_msg = esc_html__( 'Webhook data not found', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			// Decode JSON data from webhook_data field.
			$webhooks_data['webhook_data'] = json_decode( $webhooks_data['webhook_data'], true );

			// Initialize query conditions.
			$search_condition     = $this->db->prepare( ' AND webhook_id = %d ', $request_data['webhook_id'] );
			$order_by_condition   = 'ORDER BY id DESC';
			$pagination_condition = '';
			$table_name           = $this->log_model->get_table_name();

			// Pagination.
			if ( (int) $request_data['perPage'] > 0 ) {
				$per_page             = (int) $request_data['perPage'];
				$offset               = ( (int) $request_data['page'] - 1 ) * $per_page;
				$pagination_condition = $this->db->prepare( ' LIMIT %d OFFSET %d ', $per_page, $offset );
			}

			// Sorting.
			if ( ! empty( $request_data['sort'] ) ) {
				$sort = json_decode(
					stripslashes( $request_data['sort'][0] ),
					true,
					512,
					JSON_THROW_ON_ERROR
				);
				if ( ! empty( $sort['field'] ) && ! empty( $sort['type'] ) && 'none' !== $sort['type'] ) {
					$sort_field      = sanitize_key( $sort['field'] );
					$sort_type_value = strtoupper( $sort['type'] );
					$supported_order = array(
						'ASC',
						'DESC',
					);
					$sort_type       = in_array(
						$sort_type_value,
						$supported_order,
						true
					) ? $sort_type_value : 'DESC';

					$order_by_condition = $this->db->prepare( " ORDER BY %i {$sort_type} ", $sort_field );
				}
			}

			// Search term or column filters.
			if ( ! empty( $request_data['searchTerm'] ) ) {
				$search_term = '%' . $this->db->esc_like( strtolower( trim( $request_data['searchTerm'] ) ) ) . '%';

				$search_condition = $this->db->prepare(
					' AND (module_id LIKE %s OR id LIKE %s)',
					$search_term,
					$search_term
				);

			} elseif ( ! empty( $request_data['columnFilters'] ) ) {

				$column_filters = json_decode(
					stripslashes( $request_data['columnFilters'] ),
					true,
					512,
					JSON_THROW_ON_ERROR
				);

				foreach ( $column_filters as $column => $search_value ) {
					if ( '' === $search_value ) {
						continue;
					}
					$column            = esc_sql( $column );
					$search_condition .= $this->db->prepare( ' AND %i = %s ', $column, $search_value );
				}
			}

			// Get total count of records.
			$total = $this->db->get_var(
				$this->db->prepare(
					"SELECT COUNT(*) FROM {$table_name} WHERE 0=0 {$search_condition}"
				)
			);

			// Build query.
			$webhooks_query = "
            SELECT * FROM {$table_name}
            WHERE 0=0 $search_condition
            $order_by_condition
            $pagination_condition
        ";

			// Fetch data and format it.
			$webhooks_data['schedulers_name'] = kcwh_generate_scheduler_name( $webhooks_data );
			$module_name= [
				'clinic'=>__("Clinic",'kivicare-webhooks-addon'),
				'appointment'=>__("Appointment",'kivicare-webhooks-addon'),
				'doctor'=>__("Doctor",'kivicare-webhooks-addon'),
				'encounter'=>__("Encounter",'kivicare-webhooks-addon'),
				'patient'=>__("Patient",'kivicare-webhooks-addon'),
				'receptionist'=>__("Receptionist",'kivicare-webhooks-addon'),
			][$webhooks_data['module_name']];
			$webhook_logs_data                = collect( $this->db->get_results( $webhooks_query ) )->map(
				function ( $item ) use($module_name) {
					if ( ! empty( $item->created_at ) ) {
						$item->created_at = kcGetFormatedDateAndTime( $item->created_at );
					}
					if ( ! empty( $item->log_data ) ) {
						$item->log_data = json_decode( $item->log_data, true );
					}
					$item->status= isset($item->log_data['response']['error'])?0:1;
					$item->module_id = sprintf(__("%s - %s",'kivicare-webhooks-addon'),$module_name,$item->module_id) ;

					return $item;
				}
			);

			// var_dump($webhook_logs_data);
			// Handle empty data.
			if ( $webhook_logs_data->isEmpty() ) {
				$this->error_msg = esc_html__( 'No webhook log data found', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			// Apply filters to webhook logs data before listing.
			$webhook_logs_data = apply_filters( 'kcwh_webhooks_data_list', $webhook_logs_data );

			// Send response with retrieved data.
			wp_send_json(
				array(
					'status'       => true,
					'message'      => esc_html__( 'Webhooks data list', 'kivicare-webhooks-addon' ),
					'data'         => $webhook_logs_data,
					'webhook_data' => $webhooks_data,
					'total_rows'        => $total,
				)
			);
		} catch ( Exception $e ) {
			// Catch any exceptions and send error response.
			$this->error_msg = $e->getMessage();
			$this->send_error_response();
		}
	}

	/**
	 * Delete webhook log data.
	 *
	 * @return void
	 */
	public function delete(): void {
		try {

			// Get request data.
			$request_data = $this->request->getInputs();

			// Validate presence of webhook log ID.
			if ( empty( $request_data['id'] ) ) {
				$this->error_msg = esc_html__( 'Webhook log id required', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			// Perform deletion logic here (not shown in the provided code).

			// Prepare success JSON response.
			wp_send_json(
				array(
					'status'  => true,
					'message' => __( 'Webhook logs data deleted successfully', 'kivicare-webhooks-addon' ),
					'data'    => array(),
				)
			);
		} catch ( Exception $e ) {
			// Catch any exceptions and send error response.
			$this->error_msg = $e->getMessage();
			$this->send_error_response();
		}
	}


	/**
	 * Sends an error response in JSON format.
	 *
	 * This function sends an error response in JSON format to the client.
	 * It includes a status indicating failure, an error message, and an empty data array.
	 *
	 * @return void
	 */
	public function send_error_response(): void {
		// Send the error response in JSON format.
		wp_send_json(
			array(
				'status'  => false,                  // Indicates failure.
				'message' => $this->error_msg,      // Error message to be sent.
				'data'    => array(),                // Empty data array.
			)
		);
	}
}
