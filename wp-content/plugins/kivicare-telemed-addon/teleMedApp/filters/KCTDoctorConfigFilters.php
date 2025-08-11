<?php

namespace TeleMedApp\filters;

use App\baseClasses\KCBase;
use TeleMedApp\baseClasses\KCTZoomApi;

class KCTDoctorConfigFilters extends KCBase {

	public function __construct() {
		// Filter to save zoom configuration for user...
		add_filter('kct_save_zoom_configuration', [$this, 'saveZoomConfiguration']);

		add_filter('kct_get_zoom_configuration', [$this, 'getZoomConfiguration']);

		add_filter('kct_save_zoom_server_to_server_oauth_configuration', [$this, 'saveZoomServerToServerOauthConfiguration']);
		add_filter('kct_get_zoom_server_to_server_oaut_configuration', [$this, 'getZoomServerToServerOauthConfiguration']);
	}

	public function getZoomConfiguration( $filterData ) {

		$user_meta = get_user_meta( (int)$filterData['user_id'], 'zoom_config_data', true );

		if ( $user_meta ) {
			$user_meta = json_decode( $user_meta );
		} else {
			$user_meta = [];
		}

		return [
			'status'  => true,
			'message' => esc_html__( 'Configuration saved', 'kiviCare-telemed-addon' ),
			'data'    => $user_meta
		];
	}

	public function getZoomServerToServerOauthConfiguration( $filterData ) {

		$user_meta = get_user_meta( (int)$filterData['user_id'], 'zoom_server_to_server_oauth_config_data', true );

		if ( !empty($user_meta) ) {
			$user_meta = json_decode( $user_meta );
			$user_meta->enableServerToServerOauthconfig = isset( $user_meta->enableServerToServerOauthconfig ) && ($user_meta->enableServerToServerOauthconfig === "true") ? 'Yes' : 'No';
		} else {
			$user_meta = [];
		}
		
		return [
			'status'  => true,
			'message' => esc_html__( 'Configuration Server To Server Oauth', 'kiviCare-telemed-addon' ),
			'data'    => $user_meta
		];
	}

	public function saveZoomConfiguration($filterData) {
		$res = json_decode((new KCTZoomApi( $filterData['api_key'], $filterData['api_secret']))->listUsers());
		global $wpdb;
		$doctor_email = $wpdb->get_var("SELECT user_email FROM {$wpdb->base_prefix}users WHERE ID={$filterData['user_id']}");
		if( isset($res->users[0]->id)){
			$zoom_id = $res->users[0]->id;
		}else{
			$zoom_id = $filterData['zoom_id'];
		}

        $enable = $filterData['enableTeleMed'];
        $status = true;
        $message = esc_html__('Configuration saved', 'kiviCare-telemed-addon');

		if (isset($res->code) && $res->code === 124) {
            $enable = 'false';
            $status = false;
            $message = esc_html__('Invalid access token', 'kiviCare-telemed-addon');
		}

		foreach($res->users as $key => $users){
			if($users->email === $doctor_email ){
				$zoom_id  = $users->id;
				continue;
			}
			
		}

        $temp = [
            'enableTeleMed' => $enable,
            'api_key' => isset($filterData['api_key']) && $filterData['api_key'] !== null ? $filterData['api_key'] : "",
            'api_secret' => isset($filterData['api_secret']) && $filterData['api_secret'] !== null ? $filterData['api_secret'] : "",
            'zoom_id' => $zoom_id,
        ];

        update_user_meta((int)$filterData['user_id'], 'zoom_config_data', json_encode($temp));
        if( $enable === 'true'){
            update_user_meta((int)$filterData['user_id'],'telemed_type','zoom');
        }

		return [
			'status' => $status,
            'message' => $message
		];
	}


	public function saveZoomServerToServerOauthConfiguration($filterData) {

		global $wpdb;

        $enable = $filterData['enableServerToServerOauthconfig'];
        $status = true;
        $message = esc_html__('Zoom Telemed Server To Server Oauth Setting Saved Successfully.', 'kiviCare-telemed-addon');

        $temp = [
            'enableServerToServerOauthconfig' => $enable,
            'account_id' => isset($filterData['account_id']) && $filterData['account_id'] !== null ? $filterData['account_id'] : "",
            'client_id' => isset($filterData['client_id']) && $filterData['client_id'] !== null ? $filterData['client_id'] : "",
            'client_secret' => isset($filterData['client_secret']) && $filterData['client_secret'] !== null ? $filterData['client_secret'] : "",
        ];

        update_user_meta((int)$filterData['user_id'], 'zoom_server_to_server_oauth_config_data', json_encode($temp));
		
		if( $enable === 'true'){
            update_user_meta((int)$filterData['user_id'],'telemed_type','zoom');
        }

		return [
			'status' => $status,
            'message' => $message
		];
	}

	
}