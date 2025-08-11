<?php


namespace TeleMedApp\baseClasses;

use \Firebase\JWT\JWT;
use stdClass;
use TeleMedApp\filters\KCTAppointmentFilters;
use TeleMedApp\filters\KCTMainFilters;
use WP_Error;

/**
 * Class Connecting Zoom APi V2
 *
 * @since   2.0
 * @author  Deepen
 * @modifiedn
 */
class KCTZoomApi
{

	/**
	 * Zoom API KEY
	 *
	 * @var
	 */
	public $zoom_api_key;

	/**
	 * Zoom API Secret
	 *
	 * @var
	 */
	public $zoom_api_secret;

	/**
	 * Zoom Access Token
	 *
	 * @var
	 */
	private $zoom_oauth_config;
	/**
	 * Hold my instance
	 *
	 * @var
	 */
	protected static $_instance;

	/**
	 * API endpoint base
	 *
	 * @var string
	 */
	private $api_url = 'https://api.zoom.us/v2/';

	/**
	 * Create only one instance so that it may not Repeat
	 *
	 * @since 2.0.0
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Zoom_Video_Conferencing_Api constructor.
	 *
	 * @param $zoom_api_key
	 * @param $zoom_api_secret
	 */
	public function __construct($zoom_api_key = '', $zoom_api_secret = '', $zoom_oauth_config = '')
	{
		$this->zoom_api_key    = $zoom_api_key;
		$this->zoom_api_secret = $zoom_api_secret;
		$this->zoom_oauth_config = $zoom_oauth_config;
	}

	/**
	 * Send request to API
	 *
	 * @param $calledFunction
	 * @param $data
	 * @param string $request
	 *
	 * @return array|bool|string|WP_Error
	 */
	protected function sendRequest($calledFunction, $data, $request = "GET")
	{
		$request_url = $this->api_url . $calledFunction;
		if ($data['is_enable_server_to_server_oauth'] === 'Yes'){
			$account_id = $data['zoom_server_to_server_oauth_config'] -> account_id;
			$client_id = $data['zoom_server_to_server_oauth_config'] -> client_id;
			$client_secret = $data['zoom_server_to_server_oauth_config'] -> client_secret;

			$access_token =  (new KCTMainFilters)->generateDoctorZoomServerToServerOauthToken([
				"account_id" => $account_id,
				"client_id" => $client_id,
				'client_secret' => $client_secret
			]);

		}else{
			$access_token = $this->generateJWTKey();
		}

		if($access_token === false){
			return false;
		}
		$args        = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $access_token,
				'Content-Type'  => 'application/json'
			)
		);

		if ($request == "GET") {
			$args['body'] = !empty($data) ? $data : array();
			$response     = wp_remote_get($request_url, $args);
		} else if ($request == "DELETE") {
			$args['body']   = !empty($data) ? json_encode($data) : array();
			$args['method'] = "DELETE";
			$response       = wp_remote_request($request_url, $args);
		} else if ($request == "PATCH") {
			$args['body']   = !empty($data) ? json_encode($data) : array();
			$args['method'] = "PATCH";
			$response       = wp_remote_request($request_url, $args);
		} else if ($request == "PUT") {
			$args['body']   = !empty($data) ? json_encode($data) : array();
			$args['method'] = "PUT";
			$response       = wp_remote_request($request_url, $args);
		} else {
			$args['body']   = !empty($data) ? json_encode($data) : array();
			$args['method'] = "POST";
			$response       = wp_remote_post($request_url, $args);
		}

		if (wp_remote_retrieve_response_code($response) === 204) {
			$response = ['status' => true, "response_code" => 204];
		} else if (wp_remote_retrieve_response_code($response) === 401 && json_decode(wp_remote_retrieve_body($response))->code == 124) {

			$result =  (new KCTMainFilters)->generateDoctorZoomOauthToken([
				'grant_type' => "refresh_token",
				"refresh_token" => $this->zoom_oauth_config->refresh_token,
				"client_id" => $this->zoom_oauth_config->client_id,
				'client_secret' => $this->zoom_oauth_config->client_secret,
				"doctor_id" => $this->zoom_oauth_config->doctor_id
			]);
			if ($result['status']) {
				$this->zoom_oauth_config = get_user_meta(
					$this->zoom_oauth_config->doctor_id,
					KIVI_CARE_TELEMED_PREFIX . "doctor_zoom_telemed_config",
					true
				);
				return  $this->sendRequest($calledFunction, $data, $request );
			} else {
				$response = wp_remote_retrieve_body($response);
			}
		} else {
			$response = wp_remote_retrieve_body($response);
		}

		if (!$response) {
			return false;
		}
		return $response;
	}

	//function to generate JWT
	private function generateJWTKey()
	{

		if (isset($this->zoom_oauth_config) && !empty($this->zoom_oauth_config)) {
			return $this->zoom_oauth_config->access_token;
		}
			return false;
	}

	/**
	 * Creates a User
	 *
	 * @param $postedData
	 *
	 * @return array|bool|string
	 */
	public function createAUser($postedData = array())
	{

		$createAUserArray              = array();
		$createAUserArray['action']    = $postedData['action'];
		$createAUserArray['user_info'] = array(
			'email'      => $postedData['email'],
			'type'       => $postedData['type'],
			'first_name' => $postedData['first_name'],
			'last_name'  => $postedData['last_name']
		);

		return $this->sendRequest('users', $createAUserArray, "POST");
	}

	/**
	 * User Function to List
	 *
	 * @param $page
	 * @param $params
	 *
	 * @return array
	 */
	public function listUsers($page = 1, $params = array())
	{
		$listUsersArray                = array();
		$listUsersArray['page_size']   = 300;
		$listUsersArray['page_number'] = absint($page);

		if (!empty($params)) {
			$listUsersArray = array_merge($listUsersArray, $params);
		}

		return $this->sendRequest('users', $listUsersArray, "GET");
	}

	/**
	 * Get A users info by user Id
	 *
	 * @param $user_id
	 *
	 * @return array|bool|string
	 */
	public function getUserInfo($user_id)
	{
		$getUserInfoArray = array();

		return $this->sendRequest('users/' . $user_id, $getUserInfoArray);
	}

	/**
	 * Delete a User
	 *
	 * @param $userid
	 *
	 * @return array|bool|string
	 */
	public function deleteAUser($userid)
	{
		$deleteAUserArray       = array();
		$deleteAUserArray['id'] = $userid;

		return $this->sendRequest('users/' . $userid, false, "DELETE");
	}

	/**
	 * Get Meetings
	 *
	 * @param $host_id
	 *
	 * @return array
	 */
	public function listMeetings($host_id)
	{
		$listMeetingsArray              = array();
		$listMeetingsArray['page_size'] = 300;

		return $this->sendRequest('users/' . $host_id . '/meetings', $listMeetingsArray, "GET");
	}

	/**
	 * Create A meeting API
	 *
	 * @param array $data
	 *
	 * @return array|bool|string|void|WP_Error
	 */
	public function createAMeeting($data = array())
	{
		$post_time  = $data['start_date'];
		$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

		// Check for required fields
		if (empty($data['meetingTopic']) || empty($data['start_date']) || empty($data['userId'])) {
			return array('error' => 'Required fields are missing: meetingTopic, start_date, or userId.');
		}
	
		$post_time  = $data['start_date'];
		$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));
	
		$createAMeetingArray = array();

		if (!empty($data['alternative_host_ids'])) {
			if (count($data['alternative_host_ids']) > 1) {
				$alternative_host_ids = implode(",", $data['alternative_host_ids']);
			} else {
				$alternative_host_ids = $data['alternative_host_ids'][0];
			}
		}

		$createAMeetingArray['topic']      = $data['meetingTopic'];
		$createAMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
		$createAMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
		$createAMeetingArray['start_time'] = $start_time;
		$createAMeetingArray['timezone']   = $data['timezone'];
		$createAMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
		$createAMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;
		$createAMeetingArray['settings']   = array(
			'meeting_authentication' => !empty($data['meeting_authentication']) ? true : false,
			'join_before_host'       => !empty($data['join_before_host']) ? true : false,
			'host_video'             => !empty($data['option_host_video']) ? true : false,
			'participant_video'      => !empty($data['option_participants_video']) ? true : false,
			'mute_upon_entry'        => !empty($data['option_mute_participants']) ? true : false,
			'auto_recording'         => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
			'alternative_hosts'      => isset($alternative_host_ids) ? $alternative_host_ids : ""
		);

		$createAMeetingArray['is_enable_server_to_server_oauth'] = $data['isEnableServerToServerOauth'];
		$createAMeetingArray['zoom_server_to_server_oauth_config'] = $data['zoomServerToServerOauthConfig'];
		
		if (!empty($createAMeetingArray)) {
			return $this->sendRequest('users/' . $data['userId'] . '/meetings', $createAMeetingArray, "POST");
		} else {
			return array('error' => 'Failed to create meeting: meeting data is empty.');
		}
	}	

	/**
	 * Updating Meeting Info
	 *
	 * @param array $data
	 *
	 * @return array|bool|string|void|WP_Error
	 */
	public function updateMeetingInfo($data = array())
	{
		$post_time  = $data['start_date'];
		$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

		$updateMeetingInfoArray = array();

		if (!empty($data['alternative_host_ids'])) {
			if (count($data['alternative_host_ids']) > 1) {
				$alternative_host_ids = implode(",", $data['alternative_host_ids']);
			} else {
				$alternative_host_ids = $data['alternative_host_ids'][0];
			}
		}

		$updateMeetingInfoArray['topic']      = $data['topic'];
		$updateMeetingInfoArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
		$updateMeetingInfoArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
		$updateMeetingInfoArray['start_time'] = $start_time;
		$updateMeetingInfoArray['timezone']   = $data['timezone'];
		$updateMeetingInfoArray['password']   = !empty($data['password']) ? $data['password'] : "";
		$updateMeetingInfoArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;
		$updateMeetingInfoArray['settings']   = array(
			'meeting_authentication' => !empty($data['meeting_authentication']) ? true : false,
			'join_before_host'       => !empty($data['join_before_host']) ? true : false,
			'host_video'             => !empty($data['option_host_video']) ? true : false,
			'participant_video'      => !empty($data['option_participants_video']) ? true : false,
			'mute_upon_entry'        => !empty($data['option_mute_participants']) ? true : false,
			'auto_recording'         => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
			'alternative_hosts'      => isset($alternative_host_ids) ? $alternative_host_ids : ""
		);
		if (!empty($updateMeetingInfoArray)) {
			return $this->sendRequest('meetings/' . $data['meeting_id'], $updateMeetingInfoArray, "PATCH");
		} else {
			return;
		}
	}

	/**
	 * Get a Meeting Info
	 *
	 * @param  [INT] $id
	 * @param  [STRING] $host_id
	 *
	 * @return array
	 */
	public function getMeetingInfo($id)
	{
		$getMeetingInfoArray = array();

		return $this->sendRequest('meetings/' . $id, $getMeetingInfoArray, "GET");
	}

	/**
	 * Delete A Meeting
	 *
	 * @param $meeting_id
	 *
	 * @return array|bool|string|WP_Error
	 */
	public function deleteAMeeting($meeting_id)
	{
		return $this->sendRequest('meetings/' . $meeting_id, false, "DELETE");
	}

	/**
	 * Delete a Webinar
	 *
	 * @param $webinar_id
	 *
	 * @return array|bool|string|WP_Error
	 */
	public function deleteAWebinar($webinar_id)
	{
		return $this->sendRequest('webinars/' . $webinar_id, false, "DELETE");
	}

	/*Functions for management of reports*/
	/**
	 * Get daily account reports by month
	 *
	 * @param $month
	 * @param $year
	 *
	 * @return bool|mixed
	 */
	public function getDailyReport($month, $year)
	{
		$getDailyReportArray          = array();
		$getDailyReportArray['year']  = $year;
		$getDailyReportArray['month'] = $month;

		return $this->sendRequest('report/daily', $getDailyReportArray, "GET");
	}

	/**
	 * Get ACcount Reports
	 *
	 * @param $zoom_account_from
	 * @param $zoom_account_to
	 *
	 * @return array
	 */
	public function getAccountReport($zoom_account_from, $zoom_account_to)
	{
		$getAccountReportArray              = array();
		$getAccountReportArray['from']      = $zoom_account_from;
		$getAccountReportArray['to']        = $zoom_account_to;
		$getAccountReportArray['page_size'] = 300;

		return $this->sendRequest('report/users', $getAccountReportArray, "GET");
	}

	public function registerWebinarParticipants($webinar_id, $first_name, $last_name, $email)
	{
		$postData               = array();
		$postData['first_name'] = $first_name;
		$postData['last_name']  = $last_name;
		$postData['email']      = $email;

		return $this->sendRequest('webinars/' . $webinar_id . '/registrants', $postData, "POST");
	}

	/**
	 * List webinars
	 *
	 * @param $userId
	 *
	 * @return bool|mixed
	 */
	public function listWebinar($userId)
	{
		$postData              = array();
		$postData['page_size'] = 300;

		return $this->sendRequest('users/' . $userId . '/webinars', $postData, "GET");
	}

	/**
	 * Create Webinar
	 *
	 * @param $userID
	 * @param array $data
	 *
	 * @return array|bool|string|void|WP_Error
	 */
	public function createAWebinar($userID, $data = array())
	{

		return $this->sendRequest('users/' . $userID . '/webinars', $postData, "POST");
	}

	/**
	 * Update Webinar
	 *
	 * @param $webinar_id
	 * @param array $data
	 *
	 * @return array|bool|string|void|WP_Error
	 */
	public function updateWebinar($webinar_id, $data = array())
	{

		return $this->sendRequest('webinars/' . $webinar_id, $postData, "PATCH");
	}

	/**
	 * Get Webinar Info
	 *
	 * @param $id
	 *
	 * @return array|bool|string|WP_Error
	 */
	public function getWebinarInfo($id)
	{
		$getMeetingInfoArray = array();

		return $this->sendRequest('webinars/' . $id, $getMeetingInfoArray, "GET");
	}

	/**
	 * List Webinar Participants
	 *
	 * @param $webinarId
	 *
	 * @return bool|mixed
	 */
	public function listWebinarParticipants($webinarId)
	{
		$postData              = array();
		$postData['page_size'] = 300;

		return $this->sendRequest('webinars/' . $webinarId . '/registrants', $postData, "GET");
	}

	/**
	 * Get recording by meeting ID
	 *
	 * @param $meetingId
	 *
	 * @return bool|mixed
	 */
	public function recordingsByMeeting($meetingId)
	{
		return $this->sendRequest('meetings/' . $meetingId . '/recordings', false, "GET");
	}

	/**
	 * Get invitation by meeting ID
	 *
	 * @param $meetingId
	 *
	 * @return bool|mixed
	 */
	public function getInvitationByMeeting($meetingId)
	{
		return $this->sendRequest('meetings/' . $meetingId . '/invitation', false, "GET");
	}

	/**
	 * Get all recordings by USER ID ( REQUIRES PRO USER )
	 *
	 * @param $host_id
	 * @param $data array
	 *
	 * @return bool|mixed
	 */
	public function listRecording($host_id, $data = array())
	{
		$from = date('Y-m-d', strtotime('-1 year', time()));
		$to   = date('Y-m-d');

		$data['from'] = !empty($data['from']) ? $data['from'] : $from;
		$data['to']   = !empty($data['to']) ? $data['to'] : $to;

		return $this->sendRequest('users/' . $host_id . '/recordings', $data, "GET");
	}

	public function refreshToken()
	{
	}
}
