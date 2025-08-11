<?php

namespace ProApp\filters ;
use App\baseClasses\KCBase;
use DateTime;
use function Clue\StreamFilter\fun;

class KCProCommonFilters extends KCBase {

    /**
     * add all filters
     */
    public function __construct() {
        parent::__construct();
        add_filter('kcpro_get_module_list', [$this, 'getProModuleList']);
        add_filter('kcpro_patient_clinic_checkin_checkout', [$this, 'patientClinicCheckOut']);
        add_filter('kcpro_verify_appointment_timeslot', [$this, 'verifySelectTimeslot']);

        add_filter('kcpro_update_user_choose_language_updated',[$this, 'update_user_choose_language'],10,2);
    }

    /**
     * @param $data
     * @return mixed|string
     */
    public function getProModuleList ($data) {

        $modules = kcGetModules();

        if(count($modules->kivicare_pro_feature) > 0) {
            foreach ($modules->kivicare_pro_feature as $module ) {
                if(!isset($module->isProActive)) {
                    $module->isProActive = '1' ;
                }
            }
        }

        return $modules ;
    }

    /**
     * function to change clinic by patient
     *
     * @param $request_data
     *
     * @return array
     */
    public function patientClinicCheckOut($request_data){

        $status = false;
        $message = esc_html__("failed to Checkout Clinic",'kiviCare-clinic-&-patient-management-system-pro');
        $notification_send_result = [];
        //check if clinic id not empty
        if(!empty($request_data['data']) && !empty($request_data['data']['id'])){
            $clinic_id = (int)$request_data['data']['id'];
            global $wpdb;
            $user_id = get_current_user_id();
            $new_temp = [
                'patient_id' => $user_id,
                'clinic_id' => $clinic_id,
                'created_at' => current_time('Y-m-d H:i:s')
            ];
            //check if new clinic id is same as old patient clinic
            if(!empty($wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}kc_patient_clinic_mappings WHERE patient_id=%d AND clinic_id=%d",$user_id,$clinic_id)))){
                return[
                    'status' => true,
                    'message' => esc_html__("Patient Clinic Updated",'kiviCare-clinic-&-patient-management-system-pro'),
                    'notification' => []
                ];
            }

            //delete old patient clinic
            $wpdb->delete($wpdb->prefix.'kc_patient_clinic_mappings',['patient_id' => $user_id]);
            //add new clinic to patient
            $result =$wpdb->insert($wpdb->prefix.'kc_patient_clinic_mappings',$new_temp);

            //get patient data
            $patient_data = get_userdata( $user_id );

            $clinic_detail = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}kc_clinics WHERE id={$clinic_id}");
            
            if(str_starts_with(ltrim($clinic_detail->telephone_no), '+')){
                $clinic_number = !empty($clinic_detail->telephone_no) ? $clinic_detail->telephone_no : '';
                
            }
            else{
                $country_calling_code = $clinic_detail->country_calling_code;
                if(!empty($country_calling_code)){
                    $clinic_number =  !empty($clinic_detail->telephone_no) ? '+'.$country_calling_code.$clinic_detail->telephone_no : '';                    
                }
                else{
                    $clinic_number =  !empty($clinic_detail->telephone_no) ? $clinic_detail->telephone_no : '';         
                }
            }    
            
            $notification_data = [
                'user_email' => !empty($clinic_detail->email) ? $clinic_detail->email : '',
                'patient_name' => !empty($patient_data->display_name) ? $patient_data->display_name : '',
                'patient_email' => !empty($patient_data->user_email) ? $patient_data->user_email : '',
                'current_date' => current_time('Y-m-s'),
                'email_template_type' => 'patient_clinic_check_in_check_out',
                // 'clinic_number' => !empty($clinic_detail->telephone_no) ? $clinic_detail->telephone_no : '',
                'clinic_number' => $clinic_number,
            ];
            // send email to clinic.
            $notification_send_result = [
                "email" => kcSendEmail($notification_data),
                'sms/whatsapp' =>   apply_filters('kcpro_send_sms', [
                    'type' => 'patient_clinic_check_in_check_out',
                    'user_data' => $notification_data,
                ])
            ];

            if($result){
                do_action('kc_patient_update',$user_id);
                $status = true;
                $message = esc_html__("Patient clinic updated successfully",'kiviCare-clinic-&-patient-management-system-pro');
            }
        }else{
            $message = esc_html__("Clinic Not selected",'kiviCare-clinic-&-patient-management-system-pro');
        }

        return [
            'status' => $status,
            'message' => $message,
            'notification' => $notification_send_result
        ];
    }

    /**
     * function to get appointment end time based on service duration
     * @param $request_data
     * @return array
     */
    public function verifySelectTimeslot($request_data){

        global $wpdb;

        //get appointment day in short format
        $appointment_day = esc_sql(strtolower(date('l', strtotime($request_data['appointment_start_date'])))) ;
        $day_short = esc_sql(substr($appointment_day, 0, 3));

        $request_data['clinic_id']['id'] = (int)$request_data['clinic_id']['id'];
        $request_data['doctor_id']['id'] = (int)$request_data['doctor_id']['id'];

        //get doctor timeslot
        $doctor_session = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}kc_clinic_sessions WHERE `doctor_id` = %d AND `clinic_id` = %d  AND ( `day` = %s OR `day` = %s) ",$request_data['doctor_id']['id'],$request_data['clinic_id']['id'],$day_short,$appointment_day));
        //get service id of appointment
        $service_id = collect($request_data['visit_type'])->map(function($v){
            return (int)$v['service_id'];
        })->implode(',');
        $service_duration = 0;
        //check if service id is not empty
        if(!empty($service_id)){
            // get total duration of all appointment services
            $service_duration = $wpdb->get_var($wpdb->prepare("SELECT SUM(duration) FROM {$wpdb->prefix}kc_service_doctor_mapping WHERE service_id IN ({$service_id}) AND doctor_id=%d AND clinic_id=%d",$request_data['doctor_id']['id'],$request_data['clinic_id']['id']));
        }
        //service duration change to doctor session if service duration empty
        $service_duration = !empty($service_duration) ? $service_duration  : $doctor_session[0]->time_slot ;
        //format appointment end time
        $end_time             = strtotime( "+" . $service_duration . " minutes", strtotime($request_data['appointment_start_time'])  );

        return [
            'status' => true,
            'end_time' =>$end_time
        ];
    }
    public function update_user_choose_language($default_value,$request) {
        
        if( isset($request['choose_language']['lang']) && ($request['choose_language'] !== get_user_locale() ||  $request['choose_language'] !== get_locale()) ){
            return update_user_meta(get_current_user_id(), 'locale',$request['choose_language']['lang'] ) !== false;
        }
        return $default_value;
    }
}


