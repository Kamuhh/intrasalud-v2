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
use KCWebhookAddons\ModelClasses\KCWHWebhooksModel;
use KCWebhookAddons\TableClasses\KCWHWebhooksLogTable;
use JsonException;
use KCWebhookAddons\ModelClasses\KCWHWebhooksLogModel;
use wpdb;
defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHWebhooksController
 *
 * Init plugin api endpoints
 */
class KCWHWebhooksController extends KCBase {

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
	 * @var KCWHWebhooksModel Model for managing webhook logs.
	 */
	public KCWHWebhooksModel $model;
	/**
	 * Constructor. Initializes the KCWHBase class.
	 */
	public function __construct() {
		if ( $this->getLoginUserRole() !== 'administrator' ) {
			wp_send_json( kcUnauthorizeAccessResponse( 403 ) );
		}

		$this->model = new KCWHWebhooksModel();

		// Initialize request object.
		$this->request = ( new KCRequest() );

		// Initialize WordPress database object.
		$this->db = $this->model->get_db_instance();

		$this->current_date = current_time( 'Y-m-d H:i:s' );

		// Call the constructor of the parent class.
		parent::__construct();
	}


	/**
	 * Retrieves a list of body chart data for display.
	 *
	 * @return void
	 */
	public function column(): void {

		try {
			$columns = array(
				'id'          => array(
					'field'         => 'id',
					'label'         => esc_html__( 'ID', 'kivicare-webhooks-addon' ),
					'width'         => '100px',
					'filterOptions' => array(
						'enabled'     => true,
						'placeholder' => esc_html__( 'Filter by ID', 'kivicare-webhooks-addon' ),
						'filterValue' => '',
					),
				),
				'name'        => array(
					'field'         => 'name',
					'label'         => esc_html__( 'Name', 'kivicare-webhooks-addon' ),
					'width'         => '150px',
					'filterOptions' => array(
						'enabled'     => true,
						'placeholder' => esc_html__( 'Filter by name', 'kivicare-webhooks-addon' ),
						'filterValue' => '',
					),
				),
				'methods'     => array(
					'field'         => 'methods',
					'label'         => esc_html__( 'Action type', 'kivicare-webhooks-addon' ),
					'width'         => '150px',
					'filterOptions' => array(
						'enabled'             => true,
						'placeholder'         => esc_html__( 'Filter by action type', 'kivicare-webhooks-addon' ),
						'filterValue'         => '',
						'filterDropdownItems' => apply_filters( 'kcwh_webhooks_action_list', array() ),
					),
				),
				'module_name' => array(
					'field'         => 'module_name',
					'label'         => esc_html__( 'Module', 'kivicare-webhooks-addon' ),
					'width'         => '150px',
					'filterOptions' => array(
						'enabled'             => true,
						'placeholder'         => esc_html__( 'Filter by module', 'kivicare-webhooks-addon' ),
						'filterDropdownItems' => apply_filters( 'kcwh_webhooks_module_list', array() ),
						'filterValue'         => '',
					),
				),
				'event_name'  => array(
					'field'         => 'event_name',
					'label'         => esc_html__( 'Module event', 'kivicare-webhooks-addon' ),
					'width'         => '150px',
					'filterOptions' => array(
						'enabled'                 => true,
						'placeholder'             => esc_html__( 'Filter by module event', 'kivicare-webhooks-addon' ),
						'filterDropdownItemsCopy' => apply_filters( 'kcwh_webhooks_module_event_list', array() ),
						'filterDropdownItems'     => array(),
						'filterValue'             => '',
					),
				),
				'last_log'  => array(
					'field'         => 'last_log',
					'label'         => esc_html__( 'Last log', 'kivicare-webhooks-addon' ),
					'sortable'      => true,
					'width'         => '150px',
					'sortable' => false,
					'filterOptions' => array(
						'enabled' => false,
					),
				),
				'updated_at'  => array(
					'field'         => 'updated_at',
					'label'         => esc_html__( 'Updated at', 'kivicare-webhooks-addon' ),
					'sortable'      => true,
					'width'         => '150px',
					'filterOptions' => array(
						'enabled' => false,
					),
				),
				'status'      => array(
					'field'         => 'status',
					'label'         => esc_html__( 'Status', 'kivicare-webhooks-addon' ),
                    'width'         => '150px',
					'filterOptions' => array(
						'enabled'             => true,
						'placeholder'         => esc_html__( 'Filter by Status', 'kivicare-webhooks-addon' ),
						'filterDropdownItems' => array(
							array(
								'value' => '1',
								'text'  => esc_html__( 'Active', 'kivicare-webhooks-addon' ),
							),
							array(
								'value' => '0',
								'text'  => esc_html__( 'Inactive', 'kivicare-webhooks-addon' ),
							),
						),
						'filterValue'         => '',
					),
				),
				'actions'     => array(
					'field'    => 'actions',
					'sortable' => false,
					'label'    => esc_html__( 'Actions', 'kivicare-webhooks-addon' ),
				),
			);

			$columns = apply_filters( 'kcwh_webhooks_table_columns', $columns );

			// Send response with retrieved data.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Body chart list', 'kivicare-webhooks-addon' ),
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
	 * Handles the request to list webhook data with pagination, sorting, and filtering.
	 *
	 * @return void
	 */
	public function index(): void {
		try {
			// Get request data.
			$request_data = $this->request->getInputs();

			// Initialize conditions for query.
			$search_condition     = '';
			$order_by_condition   = 'ORDER BY id DESC';
			$pagination_condition = '';
			$table_name           = $this->model->get_table_name();

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
					' AND (module_name LIKE %s OR event_name LIKE %s OR name LIKE %s)',
					$search_term,
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
					$search_value = '%' . $this->db->esc_like( strtolower( trim( $search_value ) ) ) . '%';
					if ( '' === $search_value ) {
						continue;
					}
					$column            = esc_sql( $column );
					$search_condition .= $this->db->prepare( ' AND %i LIKE %s ', $column, $search_value );
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

			// Fetch data.
			$webhooks_data = collect( $this->db->get_results( $webhooks_query ) )->map(
				function ( $item ) {


					$webhooks_data = json_decode(array_pop((new KCWHWebhooksLogModel() )->get_var(
						array( 'webhook_id' => $item->id ),
						'log_data',
						false
					)),true) ;
					$item->last_log =  isset(  $webhooks_data['response']['error'])?0:1;
					
					if ( ! empty( $item->created_at ) ) {
						$item->created_at = kcGetFormatedDate( $item->created_at );
					}
					if ( ! empty( $item->updated_at ) ) {
						$item->updated_at = kcGetFormatedDate( $item->updated_at );
					}
					return $item;
				}
			);

			// Handle empty data.
			if ( $webhooks_data->isEmpty() ) {
				$this->error_msg = esc_html__( 'No body chart data found', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			// Apply filters to webhooks data before listing.
			$webhooks_data = apply_filters( 'kcwh_webhooks_data_list', $webhooks_data );

			// Send response with retrieved data.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Webhooks data list', 'kivicare-webhooks-addon' ),
					'data'    => $webhooks_data,
					'total_row'   => $total,
				)
			);
		} catch ( Exception $e ) {
			// Catch any exceptions and send error response.
			$this->error_msg = $e->getMessage();
			$this->send_error_response();
		}
	}

	/**
	 * Save webhook data.
	 *
	 * This method handles saving or updating webhook data based on request inputs.
	 *
	 * @throws Exception If there's an error during the process.
	 *
	 * @return void
	 */
	public function save(): void {
		try {
			// Get request data.
			$request_data = $this->request->getInputs();

			// Validate step 1 and step 2 data.
			$rules = array(
				'step_1' => 'required',
				'step_2' => 'required',
			);

			$message = array(
				'step_1' => esc_html__( 'Webhooks data required', 'kivicare-webhooks-addon' ),
				'step_2' => esc_html__( 'Webhooks data required', 'kivicare-webhooks-addon' ),
			);

			$errors = kcValidateRequest( $rules, $request_data, $message );

			if ( ! empty( $errors ) ) {
				$this->error_msg = $errors[0];
				$this->send_error_response();
			}

			// Merge step 1 and step 2 data.
			$request_data = array_merge( $request_data['step_1'], $request_data['step_2'] );

			// Validate merged data.
			$rules = array(
				'name'         => 'required',
				'module_name'  => 'required',
				'event_name'   => 'required',
				'status'       => 'required',
				'methods'      => 'required',
				'webhook_data' => 'required',
			);

			$errors = kcValidateRequest( $rules, $request_data, $message );

			if ( ! empty( $errors ) ) {
				$this->error_msg = $errors[0];
				$this->send_error_response();
			}

			// Format data for saving.
			$format_data = $this->formatSaveData( $request_data );

			if ( ! empty( $request_data['id'] ) ) {
				// Update existing webhook data.
				$result  = $this->model->update(
					$format_data,
					array( 'id' => (int) $request_data['id'] )
				);
				$message = $result
					? esc_html__( 'Webhook data updated successfully.', 'kivicare-webhooks-addon' )
					: esc_html__( 'Failed to update Webhook data.', 'kivicare-webhooks-addon' );
				do_action( 'kcwh_webhooks_update', $request_data['id'] );
				$webhook_id = $result;
			} else {
				// Insert new webhook data.
				$format_data['created_at'] = $this->current_date;
				$webhook_id                = $this->model->insert( $format_data );
				$message                   = $webhook_id
					? esc_html__( 'Webhook data saved successfully.', 'kivicare-webhooks-addon' )
					: esc_html__( 'Failed to save Webhook data.', 'kivicare-webhooks-addon' );
				do_action( 'kcwh_webhooks_save', $webhook_id );
			}

			// Determine status and prepare JSON response.
			$status = ! empty( $webhook_id );
			wp_send_json(
				array(
					'status'  => $status,
					'message' => $message,
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
	 * Edit webhook data.
	 *
	 * This method retrieves and prepares webhook data for editing based on request inputs.
	 *
	 * @throws Exception If there's an error during the process.
	 *
	 * @return void
	 */
	public function edit(): void {
		try {
			// Get request data.
			$request_data = $this->request->getInputs();

			// Check if 'id' parameter is provided.
			if ( empty( $request_data['id'] ) ) {
				$this->error_msg = esc_html__( 'Webhook id required', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			// Retrieve webhook data based on 'id'.
			$result = $this->model->get_by(
				array( 'id' => (int) $request_data['id'] ),
				'=',
				true
			);

			// If no data found for the given 'id', send error response.
			if ( empty( $result ) ) {
				$this->error_msg = esc_html__( 'Webhook data not found.', 'kivicare-webhooks-addon' );
				$this->send_error_response();
			}

			$result = collect( $result )->toArray();
			// Format retrieved data for editing.
			$result = $this->format_edit_data( $result );

			// Prepare JSON response with edited webhook data.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Webhook data found.', 'kivicare-webhooks-addon' ),
					'data'    => $result,
				)
			);
		} catch ( Exception $e ) {
			// Catch any exceptions and send error response.
			$this->error_msg = $e->getMessage();
			$this->send_error_response();
		}
	}

	/**
	 * Clone webhook data.
	 *
	 * This method clones an existing webhook record based on the provided 'id' parameter.
	 *
	 * @throws Exception If there's an error during the cloning process.
	 *
	 * @return void
	 */
	public function clone(): void {
		try {
			// Get request data.
			$request_data = $this->request->getInputs();

			// Check if 'id' parameter is provided.
			if ( empty( $request_data['id'] ) ) {
				$this->error_msg = esc_html__( 'Webhook id required', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			$id = (int) $request_data['id'];

			// Fetch the original webhook data.
			$original_webhook = collect(
				$this->model->get_by(
					array( 'id' => $id ),
					'=',
					true
				)
			)->toArray();

			// If no data found for the given 'id', send error response.
			if ( empty( $original_webhook ) ) {
				$this->error_msg = esc_html__( 'Failed to find the webhook data.', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			// Remove the ID to allow for insertion of a new row (cloning).
			unset( $original_webhook['id'] );
			$original_webhook['name'] = $original_webhook['name'] . esc_html__( ' - copy', 'kivicare-webhooks-addon' );

			// Insert the cloned data into the database.
			$webhook_id = $this->model->insert( $original_webhook );

			// If insertion fails, send error response.
			if ( ! $webhook_id ) {
				$this->error_msg = esc_html__( 'Failed to clone webhook data.', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			// Trigger action hook for webhook save.
			do_action( 'kcwh_webhooks_save', $webhook_id );

			// Prepare success JSON response.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Webhook data cloned successfully', 'kivicare-webhooks-addon' ),
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
	 * Update webhook data status.
	 *
	 * This method updates the status of a webhook data record based on the provided 'id' and 'value' parameters.
	 *
	 * @param array $request_data Optional. Array of request data containing 'id' and 'value'.
	 *                            If not provided, it defaults to using request inputs.
	 * @throws Exception If there's an error during the status update process.
	 *
	 * @return void
	 */
	public function update_status( array $request_data = array() ): void {
		try {
			// Get request data, either from parameter or from request inputs.
			$request_data = ! empty( $request_data ) ? $request_data : $this->request->getInputs();

			// Check if 'id' parameter is provided.
			if ( empty( $request_data['id'] ) ) {
				$this->error_msg = esc_html__( 'Webhook id required', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			$id = (int) $request_data['id'];

			// Determine status value based on 'value' parameter.
			$status = '1' === $request_data['value'] ? 1 : 0;

			// Update the status of the webhook data.
			$result = $this->model->update(
				array( 'status' => $status ),
				array( 'id' => $id )
			);

			// If update fails, send error response.
			if ( empty( $result ) ) {
				$this->error_msg = esc_html__( 'Failed to update status of webhook data.', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			// Trigger action hook for webhook save.
			do_action( 'kcwh_webhooks_save', $id );

			// Prepare success JSON response.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Webhook data status updated successfully', 'kivicare-webhooks-addon' ),
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
	 * Delete webhook data.
	 *
	 * This method deletes a webhook data record based on the provided 'id' parameter.
	 *
	 * @throws Exception If there's an error during the deletion process.
	 *
	 * @return void
	 */
	public function delete(): void {
		try {
			// Get request data.
			$request_data = $this->request->getInputs();

			// Check if 'id' parameter is provided.
			if ( empty( $request_data['id'] ) ) {
				$this->error_msg = esc_html__( 'Webhook id required', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			$id = (int) $request_data['id'];

			// Trigger action hook for webhook save before deletion.
			do_action( 'kcwh_webhooks_save', $id );

			// Delete the webhook data from the main table.
			$result = $this->model->delete( array( 'id' => $id ) );

			// Delete related log entries from the log table.
			( new KCWHWebhooksLogTable() )->delete( array( 'webhook_id' => $id ) );

			// If deletion fails, send error response.
			if ( empty( $result ) ) {
				$this->error_msg = esc_html__( 'Failed to delete webhook data.', 'kivicare-webhooks-addon' );
				$this->send_error_response();
				return;
			}

			// Prepare success JSON response.
			wp_send_json(
				array(
					'status'  => true,
					'message' => esc_html__( 'Webhook data deleted successfully', 'kivicare-webhooks-addon' ),
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

	/**
	 * Format data for saving webhook information.
	 *
	 * This method prepares and formats the data received from the request
	 * into a structured array suitable for saving webhook information.
	 *
	 * @param array $request_data The data received from the request.
	 * @return array Formatted data array ready for saving.
	 */
	public function formatSaveData( array $request_data ): array {
		// Extract the base URL from webhook_data['url'] if it contains a query string.
		if ( ! empty( $request_data['webhook_data']['url'] ) ) {
			$url = explode( '?', $request_data['webhook_data']['url'] );
			if ( ! empty( $url[0] ) ) {
				$request_data['webhook_data']['url'] = $url[0];
			}
		}

		// Prepare the formatted row data for saving.
		$row_data = array(
			'name'         => $request_data['name'],
			'module_name'  => $request_data['module_name'],
			'event_name'   => $request_data['event_name'],
			'methods'      => $request_data['methods'],
			'webhook_data' => wp_json_encode( $request_data['webhook_data'], JSON_THROW_ON_ERROR ),
			'user_id'      => get_current_user_id(),
			'status'       => 'yes' === $request_data['status'] ? 1 : 0,
			'updated_at'   => $this->current_date,
		);

		// Apply any filters to the formatted data before returning.
		return apply_filters( 'kcwh_webhooks_format_data', $row_data );
	}

	/**
	 * Format data for editing webhook information.
	 *
	 * This method formats the data retrieved from the database for editing
	 * webhook information into a structured array suitable for the editing form.
	 *
	 * @param array $result The data retrieved from the database for editing.
	 * @return array Formatted data array ready for editing form.
	 * @throws JsonException Throw exception if json_decode failed.
	 */
	public function format_edit_data( array $result ): array {
		// Initialize formatted data arrays for different steps or sections.
		$format_data = array(
			'step_1' => array(),
			'step_2' => array(),
		);

		// Loop through each key-value pair in $result and format accordingly.
		foreach ( $result as $key => $value ) {
			switch ( $key ) {
				case 'methods':
					// Place 'methods' in step 2 of formatted data.
					$format_data['step_2'][ $key ] = $value;
					break;
				case 'status':
					// Convert 'status' to 'yes' or 'no' and place in step 1 of formatted data.
					$format_data['step_1'][ $key ] = '1' === (string) $value ? 'yes' : 'no';
					break;
				case 'webhook_data':
					// Decode JSON-encoded 'webhook_data' and handle URL extraction if present.
					$format_data['step_2'][ $key ] = json_decode( $value, true, 512, JSON_THROW_ON_ERROR );
					if ( ! empty( $format_data['step_2'][ $key ]['url'] ) ) {
						$url = explode( '?', $format_data['step_2'][ $key ]['url'] );
						if ( ! empty( $url[0] ) ) {
							$format_data['step_2'][ $key ]['url'] = $url[0];
						}
					}
					break;
				default:
					// For other keys, place them in step 1 of formatted data.
					$format_data['step_1'][ $key ] = $value;
			}
		}

		// Apply any filters to the formatted data before returning.
		return apply_filters( 'kcwh_webhooks_edit_data', $format_data );
	}
}
