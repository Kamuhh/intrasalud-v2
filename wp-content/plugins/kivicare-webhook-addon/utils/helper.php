<?php
/**
 * Custom helper functions file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 */

use KCWebhookAddons\ControllerClasses\KCWHWebhooksController;
use KCWebhookAddons\ModelClasses\KCWHWebhooksModel;
use KCWebhookAddons\ModelClasses\KCWHWebhooksLogModel;

/**
 * Load core webhook hooks.
 *
 * This function registers core webhook-related actions and loads all webhook hooks.
 */
function kcwh_load_wehbhook_core_hook(): void {
	// Register action to handle module value status change.
	add_action( 'kc_change_module_value_status', 'kc_update_webhook_status' );

	// Load all webhook hooks.
	kcwh_load_all_webhooks_hooks();
}


/**
 * Update webhook status.
 *
 * Delegates the status update operation to the appropriate method in the KCWHWebhooksController.
 *
 * @param array $request_data The data containing 'id' and 'value' to update webhook status.
 * @throws Exception If there's an error during the status update process.
 */
function kc_update_webhook_status( array $request_data ): void {
	// Instantiate the KCWHWebhooksController and call its update_status method.
	( new KCWHWebhooksController() )->update_status( $request_data );
}


/**
 * Adds webhooks to WordPress hooks based on the provided events' data.
 *
 * This function takes an array of events data, flattens it, and adds a WordPress action
 * for each event. When the action is triggered, it calls the `kcwh_call_webhooks` function
 * with the event data and module ID.
 *
 * @param array $events_data Array of events data to be processed.
 *
 * @return void
 */
function kcwh_webhooks_add_filter( array $events_data ): void {
	// Flatten the events data array to a single level.
	$events_data = collect( $events_data )->flatten( 1 );

	// Loop through each event data.
	foreach ( $events_data as $event_data ) {
		// Add a WordPress action for each event.
		add_action(
			$event_data['value'], // The event name to hook into.
			function ( $module_id ) use ( $event_data ) {
				$module_id = (int) $module_id;
				// Callback function to call webhooks when the action is triggered.
				kcwh_call_webhooks( $event_data, $module_id );
			}
		);
	}
}

/**
 * Calls webhooks based on the event data and module ID.
 *
 * This function checks if the event data is valid and retrieves all webhooks associated with the event name.
 * It then schedules the webhook actions if they are not already scheduled.
 *
 * @param array $event_data The event data containing the event name.
 * @param int   $module_id The ID of the module triggering the webhook.
 *
 * @return void
 */
function kcwh_call_webhooks( array $event_data, int $module_id ): void {
	// Check if the event name is empty and return early if it is.
	if ( empty( $event_data['value'] ) ) {
		return;
	}

	// Instantiate the webhooks model.
	$model_instance = new KCWHWebhooksModel();

	// Retrieve all webhooks for the given event name and convert them to an array.
	$all_webhooks = collect(
		$model_instance->get_by(
			array(
				'event_name' => $event_data['value'],
				'status'     => 1,
			)
		)
	)->map(
		function ( $v ) {
			return collect( $v )->toArray();
		}
	)->toArray();

	// Return early if no webhooks are found.
	if ( empty( $all_webhooks ) ) {
		return;
	}

	// Loop through each webhook and schedule the action if not already scheduled.
	foreach ( $all_webhooks as $webhook ) {
		// Generate a unique scheduler name for the webhook.
		$scheduler_name = kcwh_generate_scheduler_name( $webhook );

		// Define the scheduler parameters.
		$scheduler_params = array(
			(int) $module_id,
			(int) $webhook['id'],
			get_current_user_id(),
		);

		// Check if the scheduled action does not already exist.
		if ( ! as_next_scheduled_action( $scheduler_name, $scheduler_params, 'kivicare' ) ) {
			// If not scheduled, schedule a single action to be executed immediately.
			as_schedule_single_action( time(), $scheduler_name, $scheduler_params, 'kivicare' );
		}
	}
}

/**
 * Loads all webhooks and sets up WordPress actions for each webhook.
 *
 * This function retrieves all webhooks from the database, decodes their data, and sets up
 * WordPress actions for each webhook. When the action is triggered, it calls the
 * `kcwh_send_https_request` function with the webhook data.
 *
 * @return void
 */
function kcwh_load_all_webhooks_hooks(): void {
	// Retrieve all webhooks and decode their JSON data.
	$all_webhooks = collect(
		( new KCWHWebhooksModel() )->get_by(
			array( 'status' => 1 )
		)
	)->map(
		function ( $v ) {
			$v->webhook_data = json_decode( $v->webhook_data, true );
			// Add methods to webhook data if it's an array.
			if ( is_array( $v->webhook_data ) ) {
				$v->webhook_data['methods'] = $v->methods;
			}
			return collect( $v )->toArray();
		}
	)->toArray();

	// Return early if no webhooks are found.
	if ( empty( $all_webhooks ) ) {
		return;
	}

	// Loop through each webhook data and set up the corresponding action.
	foreach ( $all_webhooks as $webhook_data ) {
		// Generate a unique scheduler name for the webhook.
        $scheduler_name = kcwh_generate_scheduler_name( $webhook_data );
		// Add an action for the scheduler name.
        add_action(
            $scheduler_name,
            function ( $module_id, $webhook_id, $user_id ) use ( $webhook_data ) { // Add $user_id parameter
				// Add module ID and webhook ID to the webhook data.
                $webhook_data['module_id'] = $module_id;
                $webhook_data['id']        = $webhook_id;
                $webhook_data['user_id']   = $user_id; // Store user ID in webhook data
				// Send the HTTPS request.
                kcwh_send_https_request( $webhook_data );
            },
            10,
            3 // Update to accept 3 parameters
        );
    }
}


/**
 * Generates a unique scheduler name for a webhook.
 *
 * This function creates a unique scheduler name by converting the webhook name to lowercase,
 * replacing spaces with underscores, and appending the webhook ID.
 *
 * @param array $webhook_data The webhook data containing the name and ID.
 *
 * @return string The generated scheduler name.
 */
function kcwh_generate_scheduler_name( array $webhook_data ): string {
	// Convert the webhook name to lowercase, replace spaces with underscores, and trim any whitespace.
	$webhook_name = strtolower( str_replace( ' ', '_', trim( $webhook_data['name'] ) ) );

	// Return the formatted scheduler name.
	return "kivicare_webhook_{$webhook_name}_{$webhook_data['id']}";
}

/**
 * Loads the Action Scheduler library.
 *
 * This function requires the Action Scheduler library from the specified directory.
 * The Action Scheduler library is used for scheduling and managing asynchronous tasks in WordPress.
 *
 * @return void
 */
function kcwh_load_action_scheduler(): void {
	// Require the Action Scheduler library.
	require_once KIVI_CARE_WEBHOOK_ADDONS_DIR . '/libraries/action-scheduler/action-scheduler.php';
}

/**
 * Generates an array of common dynamic keys and their values.
 *
 * @param bool $value Whether to use the current values or return empty strings.
 *
 * @return array The array of dynamic keys and their corresponding values.
 */
function kcwh_common_dynamic_keys( bool $value, array $webhook_data = array() ): array {
    // Return the array with dynamic keys and their values, defaulting to current values if $value is true.
	$user_id = !empty($webhook_data['user_id']) ? $webhook_data['user_id'] : get_current_user_id();
    return array(
        '{{current_date}}'      => $value ? current_time( 'Y-m-d' ) : '',
        '{{current_date_time}}' => $value ? current_time( 'Y-m-d H:i:s' ) : '',
        '{{current_time}}'      => $value ? current_time( 'H:i:s' ) : '',
        '{{current_user_id}}'   => $value ? $user_id : '',
    );
}

/**
 * Sends an HTTPS request based on provided webhook data and logs the request and response/error.
 *
 * @param array $webhook_data The data containing module_id, id, and webhook_data for the request.
 */
function kcwh_send_https_request( array $webhook_data ): void {
	// Validate required fields.
	$rules = array(
		'module_id'    => 'required',
		'id'           => 'required',
		'webhook_data' => 'required',
	);

	$errors = kcValidateRequest( $rules, $webhook_data );
	if ( ! empty( $errors ) ) {
		// If validation fails, log errors and return.
		return;
	}

	// Extract data from webhook_data.
	$module_id         = (int) $webhook_data['module_id'];
	$webhook_id        = (int) $webhook_data['id'];
	$http_request_data = $webhook_data['webhook_data'];

	// Validate HTTP request data fields.
	$rules = array(
		'methods' => 'required',
		'url'     => 'required',
	);

	$errors = kcValidateRequest( $rules, $http_request_data );
	if ( ! empty( $errors ) ) {
		// If validation fails, log errors and return.
		$log_data = array(
			'errors' => $errors,
		);
		kcwh_insert_log_data( $webhook_id, $module_id, $log_data );
		return;
	}

	// Replace dynamic keys in URL, headers, query parameters, and form data.
	$dynamic_keys             = kcwh_get_module_dynamic_keys( $webhook_data );
	$search_dynamic_keys      = ! empty( $dynamic_keys ) ? array_keys( $dynamic_keys ) : array();
	$replace_dynamic_keys     = ! empty( $dynamic_keys ) ? $dynamic_keys : array();
	$http_request_data['url'] = esc_url( kcwh_replace_dynamic_keys( $search_dynamic_keys, $replace_dynamic_keys, $http_request_data['url'] ) );
    $map_with_keys_array = array();
	if ( ! empty( $http_request_data['headers'] ) ) {
        $map_with_keys_array[] = 'headers';
		$http_request_data['headers'] = kcwh_replace_dynamic_keys( $search_dynamic_keys, $replace_dynamic_keys, $http_request_data['headers'] );
	}
	if ( ! empty( $http_request_data['query_parameters'] ) ) {
        $map_with_keys_array[] = 'query_parameters';
		$http_request_data['query_parameters'] = kcwh_replace_dynamic_keys( $search_dynamic_keys, $replace_dynamic_keys, $http_request_data['query_parameters'] );
	}
	if ( ! empty( $http_request_data['form_data'] ) ) {
        $map_with_keys_array[] = 'form_data';
		$http_request_data['form_data'] = kcwh_replace_dynamic_keys( $search_dynamic_keys, $replace_dynamic_keys, $http_request_data['form_data'] );
	}
	if ( ! empty( $http_request_data['json_data'] ) ) {
		$http_request_data['json_data'] = kcwh_replace_dynamic_keys( $search_dynamic_keys, $replace_dynamic_keys, $http_request_data['json_data'] );

	}
	foreach ( $map_with_keys_array as $value) {
		if( is_array( $http_request_data[$value] ) ){
			$http_request_data[$value] = collect( $http_request_data[$value] )->mapWithKeys(function ($item) {
				return array( $item['key'] => $item['value'] );
			})->toArray();
		}
	}

	// Set up the request arguments.
	$args = array(
		'method'  => $http_request_data['methods'],
		'headers' => ! empty( $http_request_data['headers'] ) ? $http_request_data['headers'] : array(),
	);

	if ( $http_request_data['content_type']['value'] === 'form_data' && ! empty( $http_request_data['form_data'] ) ) {
		// If form data exists, set body as form data.
		$args['body'] = $http_request_data['form_data'];
	} elseif ( $http_request_data['content_type']['value'] === 'json_data' && ! empty( $http_request_data['json_data'] ) ) {
		// If JSON data exists, encode it and set content type.
		$args['body']                    = wp_json_encode( $http_request_data['json_data'] );
		$args['headers']['Content-Type'] = 'application/json';
	}

	if ( ! empty( $http_request_data['query_parameters'] ) ) {
		// Append query parameters to the URL.
		$http_request_data['url'] = add_query_arg( $http_request_data['query_parameters'], $http_request_data['url'] );
	}

	$args['timeout'] = apply_filters('kcwh_webhooks_request_timeout', 60 );
	
	// Send the HTTP request.
	$response = wp_remote_request( $http_request_data['url'], $args );

	// Check for errors in response.
	// If error, retrieve error message and log it.
	// If successful, retrieve response body and strip HTML tags.
	$log_data_response = is_wp_error( $response ) ?
		array(
			'error' => $response->get_error_message(),
		)
		: wp_strip_all_tags( wp_remote_retrieve_body( $response ) );

	$log_data = array(
		'request'  => $http_request_data,
		'response' => $log_data_response,
	);
	// Insert log data into database.
	kcwh_insert_log_data( $webhook_id, $module_id, $log_data );
}

/**
 * Retrieves dynamic keys specific to the module from a filter class method.
 *
 * This function dynamically loads a filter class based on the module name provided
 * in $webhook_data and calls a static method named 'get_dynamic_keys' to retrieve
 * dynamic keys specific to that module.
 *
 * @param array $webhook_data The webhook data containing module_name and other necessary information.
 * @return array Associative array of dynamic keys and their values.
 */
function kcwh_get_module_dynamic_keys( array $webhook_data ): array {
	// Define the method name to call within the filter class.
	$method_name = 'get_dynamic_keys';

	// Construct the full namespace and class name based on the module name.
	$full_class_name  = 'KCWebhookAddons\\FilterClasses\\';
	$module_name      = ucfirst( $webhook_data['module_name'] );
	$full_class_name .= "KCWH{$module_name}filter";

	// Check if the class exists and the method is callable before calling it.
	return class_exists( $full_class_name ) && method_exists( $full_class_name, $method_name ) ?
		$full_class_name::$method_name( $webhook_data ) : array();
}

/**
 * Recursively replaces dynamic keys in the given content.
 *
 * @param array|string        $search The value being searched for.
 * @param array|string        $replace The replacement value.
 * @param object|array|string $content The content to search and replace within.
 * @return array|object|string The content with the replacements made.
 */
function kcwh_replace_dynamic_keys( array|string $search, array|string $replace, object|array|string $content): object|array|string {
	if ( empty( $content ) ) {
		return $content;
	}

	if ( is_array( $content ) ) {
		// If content is an array, apply replacements recursively.
		foreach ( $content as $key => $value ) {
			$content[ $key ] = kcwh_replace_dynamic_keys( $search, $replace, $value );
		}
	} elseif ( is_object( $content ) ) {
		// If content is an object, apply replacements to its properties recursively.
		foreach ( $content as $key => $value ) {
			$content->$key = kcwh_replace_dynamic_keys( $search, $replace, $value );
		}
	} elseif ( is_string( $content ) ) {
		// If content is a string, perform the replacement.
		$content = str_replace( $search, $replace, $content );
	}

	return $content;
}


/**
 * Insert log data into the database for a specific webhook and module.
 *
 * @param int   $webhook_id The ID of the webhook associated with the log data.
 * @param int   $module_id The ID of the module associated with the log data.
 * @param array $log_data The log data to be inserted, including request, response, and other relevant information.
 */
function kcwh_insert_log_data( int $webhook_id, int $module_id, array $log_data ): void {

	// Prepare data to be inserted into the database.
	$data = array(
		'webhook_id' => $webhook_id,
		'module_id'  => $module_id,
		'log_data'   => wp_json_encode( $log_data ), // Convert log_data array to JSON string.
		'created_at' => current_time( 'Y-m-d H:i:s' ), // Get current datetime.
	);

	// Insert data into the database using KCWHWebhooksLogModel.
	( new KCWHWebhooksLogModel() )->insert( $data );
}
