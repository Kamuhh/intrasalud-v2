<?php

namespace TeleMedApp\filters;

use App\baseClasses\KCBase;
use App\models\KCAppointment;
use TeleMedApp\models\KCTAppointmentZoomMapping;
use TeleMedApp\baseClasses\KCTZoomApi;

class KCTAppointmentFilters extends KCBase
{

	public function __construct()
	{

		add_filter('kct_create_appointment_meeting', [$this, 'createAppointmentMeeting']);

		add_filter('kct_delete_appointment_meeting', [$this, 'deleteAppointmentMeeting']);

		add_filter('kct_get_meeting_list', [$this, 'getMeetingList']);

		add_filter('kct_delete_patient_meeting', [$this, 'deletePatientMeetings']);

		add_filter('kct_send_zoom_link', [$this, 'sendZoomLinkEmail']);

		add_filter('kct_send_resend_zoomlink', [$this, 'resendZoomLinkEmail']);
	}

	public function getMeetingList($filterData)
	{
		global $wpdb;

		$appointment_ids = $filterData['appointment_ids'];

		$zoom_mapping_table = $wpdb->prefix . 'kc_' . 'appointment_zoom_mappings';
		$encounter_query = " SELECT * FROM $zoom_mapping_table WHERE appointment_id IN ($appointment_ids) ";

		return collect($wpdb->get_results($encounter_query, OBJECT));
	}

	public function createAppointmentMeeting($filterData)
	{

		$response = [
			'status'  => false,
			'message' => esc_html__('Meeting failed', 'kiviCare-telemed-addon')
		];

		$user_meta = get_option(KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting');

		$enableServerToServerOauth =get_option( KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_server_to_server_oauth_status');
		
		$doctor_zoom_oauth_config = get_user_meta(
			(int)$filterData['doctor_id']['id'],
			KIVI_CARE_TELEMED_PREFIX . "doctor_zoom_telemed_config",
			true
		);

		$doctor_zoom_server_to_server_oauth_config = get_user_meta((int)$filterData['doctor_id']['id'], 'zoom_server_to_server_oauth_config_data', true );
		$doctorZoomServerToServerOauthConfig = json_decode($doctor_zoom_server_to_server_oauth_config);

		if($enableServerToServerOauth === 'Yes'){
			if(empty($doctorZoomServerToServerOauthConfig) || empty($doctorZoomServerToServerOauthConfig -> enableServerToServerOauthconfig)){
				$response['status'] = false;
				$response['message'] = esc_html__('Zoom Server-to-Server OAuth is not configured.', 'kiviCare-telemed-addon');
				return $response;
			}
		}

		if (($user_meta && $user_meta['enableCal'] === 'Yes' && $doctor_zoom_oauth_config) || ($enableServerToServerOauth === 'Yes' && $doctorZoomServerToServerOauthConfig && !empty($doctorZoomServerToServerOauthConfig -> enableServerToServerOauthconfig) )) {

			if ($doctor_zoom_oauth_config) {
				$doctor_zoom_oauth_config->doctor_id = (int)$filterData['doctor_id']['id'];
			}
			$tzString = get_option('timezone_string');

			$appointmentZoomObj = new KCTAppointmentZoomMapping();

			$mappingData = $appointmentZoomObj->get_by(['appointment_id' => (int)$filterData['appointment_id']], '=', true);

			$display_user_name = __('Meeting','kiviCare-telemed-addon');
			if(!is_array($filterData['patient_id']) && !empty($filterData['patient_id']) ){
				$display_user_name = get_userdata((int)$filterData['patient_id'])->display_name;
				$display_user_name = !empty($display_user_name) ? $display_user_name : 'Meeting';
			}
			$create_meeting_arr = array(
				'userId'                    => 'me',
				'meetingTopic'              => !empty($filterData['patient_id']['label']) ? $filterData['patient_id']['label'] : $display_user_name,
				'agenda'                    => $filterData['description'],
				'start_date'                => $filterData['appointment_start_date'] . ' ' . $filterData['appointment_start_time'],
				'timezone'                  => $tzString,
				'duration'                  => $filterData['time_slot'],
			);

			if($enableServerToServerOauth === 'Yes'){
				$create_meeting_arr['isEnableServerToServerOauth'] = $enableServerToServerOauth;
				$create_meeting_arr['zoomServerToServerOauthConfig'] = $doctorZoomServerToServerOauthConfig;
				$user_meta['client_id'] = "";
				$user_meta['client_secret'] = "";
			}

			if (empty($mappingData)) {
				$meeting_created = (new KCTZoomApi($user_meta['client_id'], $user_meta['client_secret'], $doctor_zoom_oauth_config))->createAMeeting($create_meeting_arr);
			} else {
				$create_meeting_arr['meeting_id'] = $mappingData->zoom_id;
				$meeting_created = (new KCTZoomApi($user_meta['client_id'], $user_meta['client_secret'], $doctor_zoom_oauth_config))->updateMeetingInfo($create_meeting_arr);
			}

			if (!empty($mappingData) && !empty($meeting_created) && is_array($meeting_created)) {
				$response['status'] = $meeting_created['status'];
				$response['message'] = esc_html__('Meeting updated successfully', 'kiviCare-telemed-addon');
				return  $response;
			}

			if (!empty($meeting_created)) {
				if(is_array($meeting_created)){
					$meeting_created = (OBJECT) $meeting_created;
				}
				$meeting = is_object($meeting_created) ? $meeting_created : json_decode($meeting_created);

				if (isset($meeting->meetings)) {
					if ($meeting->code == 124) {
						$response['status'] = false;
						$response['message'] = esc_html__('Invalid access token', 'kiviCare-telemed-addon');
						return $response;
					}
				}

				if (isset($meeting->id)) {

					$data = [
						'zoom_uuid' => $meeting->uuid,
						'zoom_id' => $meeting->id,
						'appointment_id' => $filterData['appointment_id'],
						'start_url' => $meeting->start_url,
						'join_url' => $meeting->join_url,
						'password' => (!empty($meeting->password) && $meeting->password !== NULL ? $meeting->password : 'kivi123'),
						'created_at' => current_time('Y-m-d H:i:s'),
					];

					$appointmentZoomObj->insert($data);

					unset($data['password']);
					unset($data['zoom_id']);
					unset($data['zoom_uuid']);
					// hook for zoom appointment book
					do_action( 'kc_zoom_appointment_book', $data );
					$response['status'] = true;
					$response['data']['join_url'] = $meeting->start_url;
					$response['message'] = esc_html__('Meeting has been created', 'kiviCare-telemed-addon');
				}
			} else {
				$response['status'] = false;
				$response['message'] = esc_html__('Zoom appointment has not been generated.', 'kiviCare-telemed-addon');
			}
		}

		return $response;	
	}

	public function sendMeetingInvitation($filterData)
	{
		$user_meta = get_option(KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting');

		$filterData['appointment_id'] = (int)$filterData['appointment_id'];
		if ($user_meta) {
			
			$mappingData = (new KCTAppointmentZoomMapping())->get_by(['appointment_id' => $filterData['appointment_id']], '=', true);


			if (isset($mappingData->zoom_id)) {
				$meeting_created = (new KCTZoomApi($user_meta['client_id'], $user_meta['client_secret']))->getInvitationByMeeting($mappingData->zoom_id);

				$meeting_created = json_decode($meeting_created);

				if (isset($meeting_created->invitation)) {
					$userData = get_userdata((int)$filterData['patient_id']);
					if (isset($userData->data->user_email)) {
						wp_mail($userData->data->user_email, "Zoom invitation", $meeting_created->invitation);
					}
				}
			}
		}
	}

	public function deleteAppointmentMeeting($filterData)
	{

		$appointment_id = isset($filterData['id']) ? (int)$filterData['id'] : (int)$filterData;
		$appointment = (new KCAppointment())->get_by([
			'id' => $appointment_id
		], '=', true);


		$user_meta = get_option(KIVI_CARE_TELEMED_PREFIX . 'zoom_telemed_setting');

		if ($user_meta) {
			$mappingData = (new KCTAppointmentZoomMapping())->get_by(['appointment_id' => (int)$appointment_id], '=', true);

			if (!empty($mappingData)) {
				(new KCTZoomApi($user_meta['client_id'], $user_meta['client_secret']))->deleteAMeeting($mappingData->zoom_id);
				(new KCTAppointmentZoomMapping())->delete(['appointment_id' => (int)$appointment_id]);
			}
		}

		return [
			'status' => true,
			'message' => esc_html__('Meeting has been deleted', 'kiviCare-telemed-addon')
		];
	}

	public function deletePatientMeetings($filterData)
	{

		if (isset($filterData['patient_id'])) {
			$filterData['patient_id'] = (int)$filterData['patient_id'];
			$appointment_list = collect((new KCAppointment())->get_by(['patient_id' => $filterData['patient_id']]));
		} elseif ($filterData['doctor_id']) {
			$filterData['doctor_id'] = (int)$filterData['doctor_id'];
			$appointment_list = collect((new KCAppointment())->get_by(['doctor_id' => $filterData['doctor_id']]));
		} else {
			$appointment_list = collect([]);
		}

		$app_ids = $appointment_list->pluck('id')->toArray();

		foreach ($app_ids as $app_id) {
			$this->deleteAppointmentMeeting([
				'id' => $app_id
			]);
		}

		return [
			'status' => true,
			'message' => esc_html__('Meetings has been deleted', 'kiviCare-telemed-addon')
		];
	}

	public function sendZoomLinkEmail($filterData)
	{
		$status = false;
		if (!empty($filterData) && !empty($filterData['appointment_id'])) {
			$filterData['appointment_id'] = (int)$filterData['appointment_id'];
			$status =  kcCommonEmailFunction($filterData['appointment_id'], 'Telemed', 'zoom_doctor');
			$status2 =  kcCommonEmailFunction($filterData['appointment_id'], 'Telemed', 'zoom_patient');
			$smsResponse = kcSendAppointmentZoomSms($filterData['appointment_id']);
			if ($status && $status2) {
				$status = true;
			} else {
				$status = false;
			}
		}
		return [
			'status' => $status,
			'message' => esc_html__('Meetings has email', 'kiviCare-telemed-addon')
		];
	}

	public function resendZoomLinkEmail($filterData)
	{
		if (!empty($filterData) && !empty($filterData['id'])) {
			$filterData['id'] = (int)$filterData['id'];
			$status =  kcCommonEmailFunction($filterData['id'], 'Telemed', 'zoom_doctor');
			$status2 =  kcCommonEmailFunction($filterData['id'], 'Telemed', 'zoom_patient');
			$smsResponse = kcSendAppointmentZoomSms($filterData['id']);
			if ($status && $status2) {
				return  true;
			} else {
				return false;
			}
		}
		return false;
	}
}
