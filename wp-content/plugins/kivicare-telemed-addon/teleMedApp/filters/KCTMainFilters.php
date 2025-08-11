<?php

namespace TeleMedApp\filters;

use Exception;
use TeleMedApp\baseClasses\KCTBaseClass;
use TeleMedApp\baseClasses\KCTHelper;
use WP_REST_Response;
use WP_User;

class KCTMainFilters extends KCTBaseClass
{

    public function __construct()
    {
        add_filter("kct_save_zoom_telemed_oauth_config", [$this, "saveZoomTelemedOauthConfig"]);
        add_filter("kct_get_zoom_telemed_oauth_config", [$this, "getZoomTelemedOauthConfig"]);
        add_filter("kct_generate_doctor_zoom_oauth_token", [$this, "generateDoctorZoomOauthToken"]);
        add_filter("kct_disconnect_doctor_zoom_oauth", [$this, "disconnectDoctorZoomOauth"]);
        add_filter("kct_save_zoom_telemed_server_to_server_oauth_status", [$this, "saveZoomTelemedServerToServerOauthStatus"]);
        add_filter("kct_disconnect_doctor_server_to_server_oauth", [$this, "disconnectDoctorZoomServerToServerOauth"]);
    }   
    public function saveZoomTelemedOauthConfig($data)
    {
        try {
            $config = array(
                'enableCal' => $data['enableCal'],
                'client_id' => $data['client_id'],
                'client_secret' => $data['client_secret'],
                'redirect_url' =>   add_query_arg(array(
                    'action'=> 'check_zoom_code',
                ),admin_url("admin-ajax.php")),
            );
            update_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting',$config);
            return [
                'message' => esc_html__('Zoom Telemed Setting Saved Successfully', 'kiviCare-telemed-addon')
            ];
        } catch (Exception $e) {
            return [
                'message' => esc_html($e->getMessage())
            ];
        }
    }

    public function generateDoctorZoomOauthToken($data)
    {
        $user = new WP_User(get_current_user_id());
        if (in_array(KIVI_CARE_TELEMED_PREFIX . "doctor", $user->roles)) {
            $doctor_id = get_current_user_id();
        } else {
            $doctor_id = !empty($data['doctor_id']) ? $data['doctor_id'] : get_current_user_id();
            unset($data['doctor_id']);
        }
        $zoom_telemed_setting = get_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting');

        $url = 'https://zoom.us/oauth/token';
        $headers = array(
            'Authorization' => 'Basic ' . base64_encode($zoom_telemed_setting['client_id'] . ':' . $zoom_telemed_setting['client_secret']),
            'Content-Type' => 'application/x-www-form-urlencoded',
        );

        if (!doing_filter("kct_get_zoom_telemed_oauth_config")) {
            unset($data['client_id']);
            unset($data['client_secret']);
        }
        $args = array(
            'headers' => $headers,
            'body' => $data,
        );


        $response = wp_remote_post($url, $args);

        if (!is_wp_error($response)) {
            if (wp_remote_retrieve_response_code($response) == 200) {
                $body = json_decode(wp_remote_retrieve_body($response));


                $doctor_result = update_user_meta(
                    $doctor_id,
                    KIVI_CARE_TELEMED_PREFIX . "doctor_zoom_telemed_config",
                    $body
                );
                update_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_connect', 'on');


                    return ([
                        "message" => __("Doctor is Connected To Zoom Telemed", 'kiviCare-telemed-addon'),
                        "status" => true
                    ]);
            }
        }

        return ([
            "message" => __(json_decode(wp_remote_retrieve_body($response))->reason, 'kiviCare-telemed-addon'),
            "status" => false
        ]);
    }

    function generateDoctorZoomServerToServerOauthToken($data) {
        $user = new WP_User(get_current_user_id());
    
        // Determine the doctor ID
        if (in_array(KIVI_CARE_TELEMED_PREFIX . "doctor", $user->roles)) {
            $doctor_id = get_current_user_id();
        }else {
            $doctor_id = !empty($data['doctor_id']) ? $data['doctor_id'] : get_current_user_id();
            unset($data['doctor_id']);
        }
    
        // Retrieve Zoom settings from WP options
        
        $account_id = $data['account_id'];
        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];
    
        // Validate required credentials
        if (empty($client_id) || empty($client_secret) || empty($account_id)) {
            return [
                "message" => __("Zoom server to server oauth credentials are missing. Please check your settings.", 'kiviCare-telemed-addon'),
                "status"  => false
            ];
        }
    
        // Zoom OAuth token request URL
        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $account_id;
    
        // Authorization headers
        $headers = [
            'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ];
    
        // Send request to Zoom API
        $response = wp_remote_post($url, [
            'headers' => $headers,
        ]);
    
        // Handle response
        if (is_wp_error($response)) {
            return [
                "message" => __("Failed to connect to Zoom API: " . $response->get_error_message(), 'kiviCare-telemed-addon'),
                "status"  => false
            ];
        }
    
        // Retrieve response body
        $body = json_decode(wp_remote_retrieve_body($response), true);
        $status_code = wp_remote_retrieve_response_code($response);

        if ($status_code === 200 && isset($body['access_token'])) {
            // Store access token in user meta for Zoom Telemed connection
            update_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . "doctor_zoom_telemed_server_to_server_oauth_config", $body);
            update_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_server_to_server_oauth_connect', 'on');
            
            return $body['access_token'];
        }
    
        // Handle errors from Zoom API
        return [
            "message" => __("Zoom API error: " . ($body['reason'] ?? 'Unknown error'), 'kiviCare-telemed-addon'),
            "status"  => false
        ];
    }

    public function disconnectDoctorZoomOauth()
    {

        $doctor_config =  get_user_meta(
            get_current_user_id(),
            KIVI_CARE_TELEMED_PREFIX . "doctor_zoom_telemed_config",
            true
        );


        $zoom_telemed_setting = get_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting');
        

        $url = 'https://zoom.us/oauth/revoke';
        $headers = array(
            'Authorization' => 'Basic ' . base64_encode($zoom_telemed_setting['client_id'] . ':' . $zoom_telemed_setting['client_secret']),
            'Content-Type' => 'application/x-www-form-urlencoded',
        );

        $args = array(
            'headers' => $headers,
            'body' => [
                "token" => $doctor_config->access_token
            ],
        );


        $response = wp_remote_post($url, $args);


        if (
            delete_user_meta(get_current_user_id(), KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_connect')
            && delete_user_meta(get_current_user_id(), KIVI_CARE_TELEMED_PREFIX . 'doctor_zoom_telemed_config')
            && isset(json_decode(wp_remote_retrieve_body($response))->status)
            && json_decode(wp_remote_retrieve_body($response))->status == "success"
        ) {
            return ([
                "message" => __("Doctor Disonnected Zoom Telemed Successfully", 'kiviCare-telemed-addon'),
            ]);
        }
        return ([
            "message" => __("SomeThing Went Wrong", 'kiviCare-telemed-addon'),
        ]);
    }
    public function getZoomTelemedOauthConfig()
    {
        $zoom_settings =get_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting');
        $enableServerToServerOauth =get_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_server_to_server_oauth_status');
        $zoom_redirect_url = add_query_arg(array(
            'action'=> 'check_zoom_code',
        ),admin_url("admin-ajax.php"));
        if(is_array($zoom_settings)){
            $zoom_settings['redirect_url'] = $zoom_redirect_url; 
        }
        if (empty($zoom_settings)) {
            $zoom_settings = [
                "enableCal" => 'no',
                "redirect_url" => $zoom_redirect_url ,
                "client_id" => "",
                "client_secret" => ""
            ];
        }
        $zoom_settings['enableServerToServerOauth'] = $enableServerToServerOauth;

        return $zoom_settings;
    }

    public function saveZoomTelemedServerToServerOauthStatus($data)
    {
        try {
            update_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_server_to_server_oauth_status',$data['status']);
            return [
                'message' => esc_html__('Zoom Telemed Server To Server Oauth Status Changed.', 'kiviCare-telemed-addon')
            ]; 
        } catch (Exception $e) {
            return [
                'message' => esc_html($e->getMessage())
            ];
        }
    }

    public function disconnectDoctorZoomServerToServerOauth()
    {
        $doctor_id = get_current_user_id();
        $doctor_zoom_server_to_server_oauth_config_data = get_user_meta($doctor_id, 'zoom_server_to_server_oauth_config_data', true);
        $doctor_zoom_server_to_server_oauth_config_data = !empty($doctor_zoom_server_to_server_oauth_config_data) ? json_decode($doctor_zoom_server_to_server_oauth_config_data, true) : [];

        if(!empty($doctor_zoom_server_to_server_oauth_config_data)){
            if(isset($doctor_zoom_server_to_server_oauth_config_data['enableServerToServerOauthconfig']) && ($doctor_zoom_server_to_server_oauth_config_data['enableServerToServerOauthconfig'] === 'true')){
                $connect_meta_key = KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_server_to_server_oauth_connect';
                $config_meta_key  = KIVI_CARE_TELEMED_PREFIX . 'doctor_zoom_telemed_server_to_server_oauth_config';

                $doctor_zoom_server_to_server_oauth_connect =  get_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . $connect_meta_key,true);
                $doctor_zoom_server_to_server_oauth_config =  get_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . $config_meta_key, true);

                if(!empty($doctor_zoom_server_to_server_oauth_connect)){
                    delete_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . $connect_meta_key);
                } else if (!empty($doctor_zoom_server_to_server_oauth_config)){
                    delete_user_meta($doctor_id, KIVI_CARE_TELEMED_PREFIX . $config_meta_key);
                }
               
                $doctor_zoom_server_to_server_oauth_config_data['enableServerToServerOauthconfig'] = false;
            
                // Save updated config
                update_user_meta($doctor_id, 'zoom_server_to_server_oauth_config_data', json_encode($doctor_zoom_server_to_server_oauth_config_data));

                return ([
                    "message" => __("Doctor Disonnected Zoom Server To Server Oauth Successfully", 'kiviCare-telemed-addon'),
                ]);
            }
        }
    }

}
