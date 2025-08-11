<?php
namespace ProApp\baseClasses;
namespace ProApp\filters;
use App\baseClasses\KCBase;
use Exception;
use ProApp\baseClasses\KCProHelper;

use App\models\KCAppointment;
use App\models\KCClinic;
use App\models\KCAppointmentCalenderMapping;
use App\models\KCAppointmentServiceMapping;
use App\models\KCReceptionistClinicMapping;
use App\models\KCService;

use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use function Clue\StreamFilter\fun;

class KCProGoogleCalenderFilters extends KCBase {
    public $db;
    public function __construct() {
		global $wpdb;
        $this->db = $wpdb;
        add_filter('kcpro_saved_google_config', [$this, 'saveGoogleCalSetting']);
        add_filter('kcpro_edit_google_cal', [$this, 'editGoogleCalSetting']);

        add_filter('kcpro_connect_doctor', [$this, 'connectDoctor']);
        add_filter('kcpro_disconnect_doctor', [$this, 'disConnectDoctor']);

        add_filter('kcpro_save_appointment_event', [$this, 'addEventCalender']);
        add_filter('kcpro_remove_appointment_event', [$this, 'removeEventCalender']);

        add_filter('kcpro_save_google_event_template', [$this, 'saveGoogleEventTemplate']);


        add_filter('kcpro_patient_google_cal', [$this, 'savePatientCal']);
        add_filter('kcpro_patient_edit_google_cal', [$this, 'editPatientCal']);
        
    }
    public function saveGoogleCalSetting($setting){
        try{
            if(isset($setting)){
                $config = array(
                    'client_id' =>$setting['data']['client_id'],
                    'client_secret'=>$setting['data']['client_secret'],
                    'app_name'=>$setting['data']['app_name'],
                    'enableCal'=>$setting['data']['enableCal']
                );
                update_option( KIVI_CARE_PRO_PREFIX . 'google_cal_setting',$config );
                return [
                    'status' => true,
                    'message' => esc_html__('Google setting saved successfully', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Google setting not saved', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }

    }
    public function editGoogleCalSetting(){
        $get_googlecal_data = get_option(KIVI_CARE_PRO_PREFIX . 'google_cal_setting',true);

        if ( gettype($get_googlecal_data) != 'boolean' ) {
          return [
              'data'=> $get_googlecal_data,
              'status' => true,
          ];
        } else {
          return [
              'data'=> [],
              'status' => false,
          ];
        }
    }

    public function connectDoctor($conn){
        $client = KCProHelper::get_client();
        try{
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                }else{
                    $auth_code = $client->authenticate(trim($conn['code']));
                    $access_token = $client->getAccessToken();
                    $doctor_config = update_user_meta((int)$conn['id'], 'google_cal_access_token',json_encode($access_token) );
                    update_user_meta((int)$conn['id'], KIVI_CARE_PRO_PREFIX.'google_cal_connect','on' );
                    update_user_meta((int)$conn['id'],KIVI_CARE_PRO_PREFIX.'doctor_calender_id' ,KCProHelper::get_selected_calendar_id((int)$conn['id']) );
                    return [
                      'status' => true,
                      'message' => esc_html__('Google Calendar Connected', 'kiviCare-clinic-&-patient-management-system-pro')
                    ];
                }
            }
           
        }catch (\Throwable $th) {
          return [
            'status' => false,
            'message' => $th
          ];
        }
       
    }
    public function disConnectDoctor($id){
      try{
        $get_access_token = get_user_meta((int)$id['id'],'google_cal_access_token',true);
        if($get_access_token){
          delete_user_meta((int)$id['id'],'google_cal_access_token');
          delete_user_meta((int)$id['id'],KIVI_CARE_PRO_PREFIX.'doctor_calender_id');
          update_user_meta((int)$id['id'], KIVI_CARE_PRO_PREFIX.'google_cal_connect','off' );
        }
        return [
          'status' => true,
          'message' => esc_html__('Google Calendar Disconnected', 'kiviCare-clinic-&-patient-management-system-pro')
        ];
      }catch (\Throwable $th) {
        return [
          'status' => false,
          'message' => $th
        ];
      }
     
    }

    public function addEventCalender($eventData){
        global $wpdb;
        $eventData['appoinment_id'] = (int)$eventData['appoinment_id'];
        $appointment = (new KCAppointment())->get_by(['id' => $eventData['appoinment_id']], '=', true);
        $userCalendarEnable = $this->checkUserCalendarEnable($appointment);
        $doctor_enable = $userCalendarEnable['doctor'];
        $receptinist_enable = $userCalendarEnable['receptinist'];
        $receptinist_id = $userCalendarEnable['receptinist_id'];
        
        if (!empty($doctor_enable) || !empty($receptinist_enable)) {
            
            $appointment_service_name = $telemed_service = $calendar_user = [];
            $receptinist_client = $receptinist_calendar_id = $doctor_calendar_id = $doctor_client = false;
            $appointment_service = collect((new KCAppointmentServiceMapping())->get_by(['appointment_id' => $appointment->id], '=', false))->pluck('service_id')->toArray();       
            if (!empty($appointment_service)) {
                $appointment_service = implode(",", $appointment_service);
                $telemed_service = collect($wpdb->get_results("SELECT telemed_service FROM {$wpdb->prefix}kc_service_doctor_mapping WHERE clinic_id={$appointment->clinic_id} AND doctor_id={$appointment->doctor_id} AND  service_id IN ({$appointment_service})"))->pluck("telemed_service")->toArray();
                $appointment_service_name = collect($wpdb->get_results("SELECT name FROM {$wpdb->prefix}kc_services WHERE id IN ({$appointment_service})"))->pluck("name")->toArray();
            }
            
            if ((in_array("yes", $telemed_service))
            && (kcCheckDoctorTelemedType($eventData['appoinment_id']) == 'googlemeet')) {
                apply_filters('kcgm_save_appointment_event',['appoinment_id' => $eventData['appoinment_id'],'service' => implode(",", $appointment_service_name)]);
                $doctor_enable = false;
            }


            if (!empty($receptinist_enable)) {
                $receptinist_calendar_id = KCProHelper::get_selected_calendar_id($receptinist_id);
                $receptinist_client = KCProHelper::get_authorized_client_for_doctor($receptinist_id);
                $calendar_user[$receptinist_id] = [
                    'calendar_id' => $receptinist_calendar_id,
                    'client' => $receptinist_client
                ];
            }

            $appointment_service_name = implode(',', $appointment_service_name);
            if (!empty($doctor_enable)) {
                $doctor_calendar_id = KCProHelper::get_selected_calendar_id((int)$appointment->doctor_id);
                $doctor_client = KCProHelper::get_authorized_client_for_doctor((int)$appointment->doctor_id);
                $calendar_user[$appointment->doctor_id] = [
                    'calendar_id' => $doctor_calendar_id,
                    'client' => $doctor_client
                ];
            }
            if (($receptinist_client && $receptinist_calendar_id) || ($doctor_calendar_id && $doctor_client)) {

                $args['post_name'] = strtolower(KIVI_CARE_PRO_PREFIX . 'default_event_template');
                $args['post_type'] = strtolower(KIVI_CARE_PRO_PREFIX . 'gcal_tmp');

                $query = "SELECT * FROM {$wpdb->prefix}posts WHERE `post_name` = '" . $args['post_name'] . "' AND `post_type` = '" . $args['post_type'] . "' AND post_status = 'publish' ";
                $check_exist_post = $wpdb->get_row($query, ARRAY_A);

                if (empty($check_exist_post)) {
                    return [
                        'status' => false,
                        'message' => __('template post not exists','kiviCare-clinic-&-patient-management-system-pro')
                    ];
                }
                $calender_title = $check_exist_post['post_title'];
                $calender_content = $check_exist_post['post_content'];

                $clinicData = (new KCClinic())->get_by(['id' => (int)$appointment->clinic_id], '=', true);

                $clinicAddress = $clinicData->address . ',' . $clinicData->city . ',' . $clinicData->country;
                $content_data = kcCommonNotificationData($appointment,[],$appointment_service_name,'clinic');
                $calender_content = kcEmailContentKeyReplace($calender_content,  $content_data);
                $calender_title = kcEmailContentKeyReplace($calender_title,  $content_data);

                $patient_email = '';
                $get_patient_cal = get_option(KIVI_CARE_PRO_PREFIX . 'patient_cal_setting',true);
                if ( $get_patient_cal === 'true' || $get_patient_cal === true || $get_patient_cal === 1 || $get_patient_cal === '1' ) {
                    $patient_data = get_userdata((int)$appointment->patient_id);
                    if(!empty($patient_data->user_email)){
                        $patient_email = $patient_data->user_email;
                    }
                }

                try {

                    if ($appointment->status == '1') {
                        $timezone = get_option('timezone_string');

                        // If the timezone string is empty, fall back to the offset
                        if (empty($timezone)) {
                            $gmt_offset = get_option('gmt_offset');
                            $timezone = timezone_name_from_abbr('', $gmt_offset * 3600, 0);
                        }
                        
                        date_default_timezone_set($timezone);
                        $format = 'Y-m-d\TH:i:sP';
                        $start = date($format, strtotime($appointment->appointment_start_date . $appointment->appointment_start_time));
                        $end = date($format, strtotime($appointment->appointment_end_date . $appointment->appointment_end_time));

                        $event = new Google_Service_Calendar_Event(array(
                            'summary' => !empty($calender_title) ? $calender_title :  __('Appointment','kiviCare-clinic-&-patient-management-system-pro'),
                            'location' => $clinicAddress,
                            'description' => $calender_content,
                            'attendees' => array(
                                array('email' => $patient_email),
                            ),
                            'start' => array(
                                'dateTime' => $start,
                                'timeZone' => $timezone,
                            ),
                            'end' => array(
                                'dateTime' => $end,
                                'timeZone' => $timezone,
                            ),
                        ));

                        $eventReturn = '';
                        $gcalmapping = new KCAppointmentCalenderMapping();
                        foreach ($calendar_user as $user_id => $calendar_user_value) {

                            $google_calendar_event_id = $gcalmapping->get_by(['appointment_id' => $eventData['appoinment_id'], 'doctor_id' => $user_id], '=', true);
                            $google_cal_service = new Google_Service_Calendar($calendar_user_value['client']);
                            if (!empty($google_calendar_event_id)) {
                                $eventReturn = $google_cal_service->events->update($calendar_user_value['calendar_id'], $google_calendar_event_id->event_value, $event);
                            } else {
                                // new event in google cal
                                $eventReturn = $google_cal_service->events->insert($calendar_user_value['calendar_id'], $event);
                                $gcalmapping->save_event_key('google_calendar_event_id', $eventReturn->getId(), $eventData['appoinment_id'], $user_id);

                            }

                        }

                        return [
                            'status' => true,
                            'message' => (array)$eventReturn
                        ];

                    } else {
                        self::removeEventCalender($eventData);
                        return [
                            'status' => false,
                            'message' => $appointment->status
                        ];
                    }

                } catch (\Throwable $th) {
                    return [
                        'status' => false,
                        'message' => (array)$th
                    ];
                }
            }
        }

        return [
            'status' => false,
            'message' => 'calendar off'
        ];
    }

    public function removeEventCalender($data){
        $gcalmapping = new KCAppointmentCalenderMapping();
        $data['appoinment_id'] = (int)$data['appoinment_id'];
        $appointment = (new KCAppointment())->get_by(['id' => $data['appoinment_id']], '=', true);
        if (!empty($appointment)) {
            $google_calendar_event_id = $gcalmapping->get_by(['appointment_id' => $data['appoinment_id']], '=', true);
            if (!empty($google_calendar_event_id)) {
                $userCalendarEnable = $this->checkUserCalendarEnable($appointment);
                $doctor_enable = $userCalendarEnable['doctor'];
                $receptinist_enable = $userCalendarEnable['receptinist'];
                $receptinist_id = $userCalendarEnable['receptinist_id'];
                if (!empty($doctor_enable) || !empty($receptinist_enable)) {
                    $calendar_user = [];
                    $receptinist_client = $receptinist_calendar_id = $doctor_calendar_id = $doctor_client = false;

                    if (!empty($receptinist_enable)) {
                        $receptinist_calendar_id = KCProHelper::get_selected_calendar_id($receptinist_id);
                        $receptinist_client = KCProHelper::get_authorized_client_for_doctor($receptinist_id);
                        $calendar_user[$receptinist_id] = [
                            'calendar_id' => $receptinist_calendar_id,
                            'client' => $receptinist_client
                        ];
                    }

                    if (!empty($doctor_enable)) {
                        $doctor_calendar_id = KCProHelper::get_selected_calendar_id((int)$appointment->doctor_id);
                        $doctor_client = KCProHelper::get_authorized_client_for_doctor((int)$appointment->doctor_id);
                        $calendar_user[$appointment->doctor_id] = [
                            'calendar_id' => $doctor_calendar_id,
                            'client' => $doctor_client
                        ];
                    }

                    if (($receptinist_client && $receptinist_calendar_id) || ($doctor_calendar_id && $doctor_client)) {
                        foreach ($calendar_user as $user_id => $calendar_user_value) {
                            $cal_mapping_data = (new KCAppointmentCalenderMapping())->get_by(['appointment_id' => $data['appoinment_id'], 'doctor_id' => $user_id], '=', true);
                            if ($cal_mapping_data) {
                                try {
                                    $g_service = new Google_Service_Calendar($calendar_user_value['client']);
                                    $g_service->events->delete($calendar_user_value['calendar_id'], $cal_mapping_data->event_value);
                                    $gcalmapping->delete(['appointment_id' => $data['appoinment_id'], 'doctor_id' => $user_id]);
                                }catch (\Throwable $th){
                                    return [
                                        'status' => false,
                                        'message' => (array)$th
                                    ];
                                }
                            }
                        }

                    }
                }
            }
        }

    }

    public function saveGoogleEventTemplate($template){
      foreach ($template['data'] as $key => $value) {
        wp_update_post($value);
      }
  
      return [
        'status' => true,
        'message' => esc_html__('Google template  saved successfully.', 'kiviCare-clinic-&-patient-management-system-pro')
      ];
    }
    public function savePatientCal($data){  
      try{
        if(isset($data)){
           
            update_option( KIVI_CARE_PRO_PREFIX . 'patient_cal_setting',$data['data']['pCal'] );
            return [
                'status' => true,
                'message' => (!empty($data['data']['pCal']) && ($data['data']['pCal'] == 'true')) ? esc_html__('Patient Calender Enable', 'kiviCare-clinic-&-patient-management-system-pro') : esc_html__('Patient Calender Disabled', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }catch (Exception $e) {
        return [
            'status' => false,
            'message' => esc_html__('Patient Calender disable', 'kiviCare-clinic-&-patient-management-system-pro')
        ];
    }
    }
    public function editPatientCal(){  
      $get_patient_cal = get_option(KIVI_CARE_PRO_PREFIX . 'patient_cal_setting',true);

      if ( $get_patient_cal === 'true' || $get_patient_cal === true || $get_patient_cal === 1 || $get_patient_cal === '1' ) {
        return [
            'data'=> $get_patient_cal,
            'status' => true,
        ];
      } else {
        return [
            'data'=> [],
            'status' => false,
        ];
      }
   
    }
    public function checkUserCalendarEnable($appointment){
        $doctor_enable = get_user_meta((int)$appointment->doctor_id, KIVI_CARE_PRO_PREFIX.'google_cal_connect',true);
        $receptinist_id  = (new KCReceptionistClinicMapping())->get_var(['clinic_id'=>(int)$appointment->clinic_id] ,'receptionist_id');
        if(empty($receptinist_id)){
            $receptinist_id = 0;
        }else{
            $receptinist_id = (int)$receptinist_id;
        }
        $receptinist_enable = get_user_meta( $receptinist_id, KIVI_CARE_PRO_PREFIX.'google_cal_connect',true);

        return [
            "doctor" => $doctor_enable,
            "receptinist" =>$receptinist_enable,
            "receptinist_id" => $receptinist_id
        ];
    }
}