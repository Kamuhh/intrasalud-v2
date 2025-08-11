<?php
/**
 * Filters class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\FilterClasses;

use App\baseClasses\KCBase;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHBaseFilter
 *
 * Filters for encounter body chart data.
 */
class KCWHBaseFilter extends KCBase {

	/**
	 * Class constructor.
	 *
	 * This constructor initializes the class by adding necessary filters and calling the parent constructor.
	 * It adds filters for route lists, language keys, and webhooks action lists.
	 */
	public function __construct() {
		// Call the parent constructor.
		parent::__construct();

		// Add filter to modify KiviCare route lists using the add_route method of this class.
		add_filter( 'kivicare_route_lists', array( self::class, 'add_route' ) );

		// Add filter to modify KiviCare language data using the add_language_key method of this class.
		add_filter( 'kivicare_language_data', array( self::class, 'add_language_key' ) );

		// Add filter to modify the webhooks action list using the get_webhooks_action_list method of this class.
		add_filter( 'kcwh_webhooks_action_list', array( self::class, 'get_webhooks_action_list' ) );
	}


	/**
	 * Add routes for body chart.
	 *
	 * @param array $routes The existing routes.
	 *
	 * @return array The modified routes.
	 */
	public static function add_route( array $routes ): array {
		$controller_namespace = 'KCWebhookAddons\\ControllerClasses\\';
		$new_routes           = array(
			'webhooks_column'     => array(
				'method'    => 'get',
				'action'    => 'KCWHWebhooksController@column',
				'namespace' => $controller_namespace,
			),
			'webhooks_list'       => array(
				'method'    => 'get',
				'action'    => 'KCWHWebhooksController@index',
				'namespace' => $controller_namespace,
			),
			'webhooks_save'       => array(
				'method'    => 'post',
				'action'    => 'KCWHWebhooksController@save',
				'namespace' => $controller_namespace,
			),
			'webhooks_edit'       => array(
				'method'    => 'get',
				'action'    => 'KCWHWebhooksController@edit',
				'namespace' => $controller_namespace,
			),
			'webhooks_clone'      => array(
				'method'    => 'post',
				'action'    => 'KCWHWebhooksController@clone',
				'namespace' => $controller_namespace,
			),
			'webhooks_delete'     => array(
				'method'    => 'post',
				'action'    => 'KCWHWebhooksController@delete',
				'namespace' => $controller_namespace,
			),
			'webhooks_log_column' => array(
				'method'    => 'get',
				'action'    => 'KCWHWebhooksLogController@column',
				'namespace' => $controller_namespace,
			),
			'webhooks_log_list'   => array(
				'method'    => 'get',
				'action'    => 'KCWHWebhooksLogController@index',
				'namespace' => $controller_namespace,
			),
			'webhooks_log_delete' => array(
				'method'    => 'post',
				'action'    => 'KCWHWebhooksLogController@delete',
				'namespace' => $controller_namespace,
			),
		);

		return array_merge( $routes, $new_routes );
	}

	/**
	 * Add language keys for body chart addon.
	 *
	 * @param array $lang The language keys array.
	 *
	 * @return array The modified language keys array.
	 */
	public static function add_language_key( array $lang ): array {
		$lang['webhooks'] = array(
			'webhooks'                                    => esc_html__( 'Webhooks', 'kivicare-webhooks-addon' ),
			'webhooks_list'                               => esc_html__( 'Webhooks list', 'kivicare-webhooks-addon' ),
			'new_webhook'                                 => esc_html__( 'New Webhooks', 'kivicare-webhooks-addon' ),
			'create_webhook'                              => esc_html__( 'Create Webhooks', 'kivicare-webhooks-addon' ),
			'edit_webhook'                                => esc_html__( 'Edit Webhooks', 'kivicare-webhooks-addon' ),
			'module_name'                                 => esc_html__( 'Module name', 'kivicare-webhooks-addon' ),
			'select_module_name'                          => esc_html__( 'Select module name', 'kivicare-webhooks-addon' ),
			'module_name_required'                        => esc_html__( 'Module name required', 'kivicare-webhooks-addon' ),
			'event_name'                                  => esc_html__( 'Event name', 'kivicare-webhooks-addon' ),
			'please_first_select_module'                  => esc_html__( 'select module', 'kivicare-webhooks-addon' ),
			'select_event_name'                           => esc_html__( 'Select event name', 'kivicare-webhooks-addon' ),
			'event_name_required'                         => esc_html__( 'Event name required', 'kivicare-webhooks-addon' ),
			'webhooks_method'                             => esc_html__( 'Webhooks method', 'kivicare-webhooks-addon' ),
			'select_webhooks_method'                      => esc_html__( 'Select webhooks method', 'kivicare-webhooks-addon' ),
			'webhooks_method_required'                    => esc_html__( 'Webhooks method required', 'kivicare-webhooks-addon' ),
			'url_placeholder'                             => esc_html__( 'https://example.webhooks.com/save/moduledata/', 'kivicare-webhooks-addon' ),
			'url_required'                                => esc_html__( 'Webhooks URL required', 'kivicare-webhooks-addon' ),
			'please_enter_valid_url'                      => esc_html__( 'Please enter valid Webhooks URL', 'kivicare-webhooks-addon' ),
			'dynamic_keys'                                => esc_html__( 'Keys', 'kivicare-webhooks-addon' ),
			'delete_header_data'                          => esc_html__( 'Delete header data', 'kivicare-webhooks-addon' ),
			'delete_query_parameter'                      => esc_html__( 'Delete query parameters', 'kivicare-webhooks-addon' ),
			'content_type'                                => esc_html__( 'Content type', 'kivicare-webhooks-addon' ),
			'select_content_type'                         => esc_html__( 'Select content type', 'kivicare-webhooks-addon' ),
			'json_data'                                   => esc_html__( 'JSON data', 'kivicare-webhooks-addon' ),
			'form_data'                                   => esc_html__( 'Form data', 'kivicare-webhooks-addon' ),
			'add_form_data'                               => esc_html__( 'Add form data', 'kivicare-webhooks-addon' ),
			'delete_form_data'                            => esc_html__( 'Delete form data', 'kivicare-webhooks-addon' ),
			'key_required'                                => esc_html__( 'Key required', 'kivicare-webhooks-addon' ),
			'value_required'                              => esc_html__( 'Value required', 'kivicare-webhooks-addon' ),
			'select_event_name_to_dynamic_key'            => esc_html__( 'Select event name to get dynamic keys', 'kivicare-webhooks-addon' ),
			'please_enter_valid_json'                     => esc_html__( 'Please enter valid json data', 'kivicare-webhooks-addon' ),
			'select_or_enter_value'                       => esc_html__( 'Select or enter value', 'kivicare-webhooks-addon' ),
			'loading'                                     => esc_html__( 'Loading.....', 'kivicare-webhooks-addon' ),
			'webhooks_log_list'                           => esc_html__( 'Webhooks logs list', 'kivicare-webhooks-addon' ),
			'id'                                          => esc_html__( 'ID', 'kivicare-webhooks-addon' ),
			'module_id'                                   => esc_html__( 'Module ID', 'kivicare-webhooks-addon' ),
			'webhooks_id'                                 => esc_html__( 'Webhooks ID', 'kivicare-webhooks-addon' ),
			'created_at'                                  => esc_html__( 'Created At', 'kivicare-webhooks-addon' ),
			'request'                                     => esc_html__( 'Request', 'kivicare-webhooks-addon' ),
			'response'                                    => esc_html__( 'Response', 'kivicare-webhooks-addon' ),
			'n_a'                                         => esc_html__( 'N/A', 'kivicare-webhooks-addon' ),
			'search_webhooks_log_data_global_placeholder' => esc_html__( 'Search webhooks log by id and module id ...', 'kivicare-webhooks-addon' ),
			'log_entry'                                   => esc_html__( ' log entry', 'kivicare-webhooks-addon' ),
			'view_logs'                                   => esc_html__( 'Logs list', 'kivicare-webhooks-addon' ),
			'delete_webhooks'                             => esc_html__( 'Press yes to delete webhooks', 'kivicare-webhooks-addon' ),
			'template_dynamic_key'                        => esc_html__( 'Template dynamic key', 'kivicare-webhooks-addon' ),
			'success'                       			  => esc_html__( 'Success', 'kivicare-webhooks-addon' ),
			'failed'                        			  => esc_html__( 'Fail', 'kivicare-webhooks-addon' ),

		);
		return $lang;
	}

	/**
	 * Get the list of webhooks actions.
	 *
	 * This function merges new HTTP actions (POST, GET, PUT, DELETE) with the existing actions.
	 *
	 * @param array $actions The existing actions.
	 *
	 * @return array The updated list of actions.
	 */
	public static function get_webhooks_action_list( array $actions ): array {

		// Define new HTTP actions.
		$new_actions = array(
			array(
				'value' => 'POST',
				'text'  => esc_html__( 'HTTPS POST', 'kivicare-webhooks-addon' ),
			),
			array(
				'value' => 'GET',
				'text'  => esc_html__( 'HTTPS GET', 'kivicare-webhooks-addon' ),
			),
			array(
				'value' => 'PUT',
				'text'  => esc_html__( 'HTTPS PUT', 'kivicare-webhooks-addon' ),
			),
			array(
				'value' => 'DELETE',
				'text'  => esc_html__( 'HTTPS DELETE', 'kivicare-webhooks-addon' ),
			),
		);

		// Merge existing actions with the new actions.
		return array_merge( $actions, $new_actions );
	}
}
