<?php

namespace ProApp\baseClasses;

use Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class KCProHelper extends KCProBase {

    /**
     *
     */
    public function __construct() {
        
    }

    /**
     * helper function to get options table value
     * @param $name
     * @return false|mixed|null
     */
    public function getOption ($name ) {
      return  get_option( KIVI_CARE_PRO_PREFIX . $name );
    }

    /**
     * helper function to update options table value
     * @param $name
     * @param $value
     * @param $autoload
     * @return bool
     */
    public function updateOption ($name, $value, $autoload = 'no' ) {
      return update_option( KIVI_CARE_PRO_PREFIX . $name, $value, $autoload );
    }

    /**
     * function to get google calendar client
     * @return Google_Client
     */
    public static function get_client(){
      $get_config =   get_option( KIVI_CARE_PRO_PREFIX . 'google_cal_setting',true);
      $gcal_client = new Google_Client();
      $gcal_client->setClientId(trim($get_config['client_id']));
      $gcal_client->setClientSecret(trim($get_config['client_secret']));
      $gcal_client->setAccessType("offline");        // offline access // it give a refersh token
      $gcal_client->setIncludeGrantedScopes(true);   // incremental auth
      $gcal_client->setApprovalPrompt('force');
      $gcal_client->addScope(Google_Service_Calendar::CALENDAR);
      $gcal_client->setRedirectUri('postmessage');
      return $gcal_client;
    }

    /**
     * function to get google calendar id of doctor
     * @param $doctor_id
     * @return mixed|string
     */
    public static function get_selected_calendar_id($doctor_id){
      $selected_calendar_id = get_user_meta( (int)$doctor_id,KIVI_CARE_PRO_PREFIX.'doctor_calender_id',);
      if(!$selected_calendar_id){
        $selected_calendar_id = 'primary';
        return $selected_calendar_id;
      }

      return $selected_calendar_id;
    }

    /**
     * @param $doctor_id
     * @return false|Google_Client
     */
    public static function get_authorized_client_for_doctor($doctor_id){
      $access_token = get_user_meta((int)$doctor_id, 'google_cal_access_token',true );
      if(!$access_token) return false;
  
      $client = self::get_client();
  
  
      $client->setAccessToken($access_token);
  
      if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            // printf("Open the following link in your browser:\n%s\n", $authUrl);
            // print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
  
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);
  
            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        $access_token = $client->getAccessToken();
       update_user_meta(KIVI_CARE_PRO_PREFIX.'doctor_calender_id', self::get_selected_calendar_id((int)$doctor_id), (int)$doctor_id);
       update_user_meta('google_cal_access_token', json_encode($access_token), (int)$doctor_id);
      }
  
      return $client;
  
  }
  
} 