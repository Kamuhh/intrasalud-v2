<?php

namespace ProApp\filters;
use App\models\KCClinic;
use App\models\KCAppointment;
use App\models\KCBill;
use App\models\KCPatientReport;
use App\baseClasses\KCBase;
use Exception;
use WP_User;
use stdClass;
use Twilio\Rest\Client;
use function Crontrol\Event\get;
use Twilio\Exceptions\RestException;

class KCProLanaguageFilters extends KCBase {
    public $db;
	public function __construct() {
		global $wpdb;
        $this->db = $wpdb;
		add_filter('kcpro_update_language', [$this, 'updateLang']);
		add_filter('kcpro_change_themecolor', [$this, 'updateThemeColor']);
		add_filter('kcpro_change_mode', [$this, 'updateThemeMode']);
		add_filter('kcpro_upload_logo', [$this, 'uploadLogo']);
        add_filter('kcpro_upload_loader', [$this, 'uploadLoader']);
		add_filter('kcpro_save_sms_config', [$this, 'saveSmsConfig']);
        add_filter('kcpro_save_whatsapp_config', [$this, 'saveWhatsAppConfig']);
		add_filter('kcpro_edit_sms_config', [$this, 'getSmsConfig']);
        add_filter('kcpro_edit_whatsapp_config', [$this, 'getWhatsAppConfig']);
		add_filter('kcpro_send_sms', [$this, 'sendSMS']);
		add_filter('kcpro_get_prescription_print', [$this, 'getPrescriptionPrint']);
        add_filter('kcpro_get_encounter_print', [$this, 'getEncounterPrint']);
		add_filter('kcpro_get_doctor_wise_clinic', [$this, 'getDoctorWiseClinic']);
		add_filter('kcpro_save_sms_template', [$this, 'saveSMSTemplate']);
		add_filter('kcpro_get_json_file_data', [$this, 'getJosnData']);
		add_filter('kcpro_save_json_file_data', [$this, 'saveJosnData']);
		add_filter('kcpro_get_all_lang', [$this, 'getAllLang']);
        add_filter( 'kcpro_get_clinical_detail_in_prescription',[$this,'getEncounterPrescriptionClinicalInclude'] );
        add_filter( 'kcpro_edit_clinical_detail_in_prescription',[$this,'editEncounterPrescriptionClinicalInclude'] );
        add_filter( 'kcpro_edit_encounter_custom_field_in_prescription',[$this,'editEncounterCustomFieldInclude'] );
        add_filter('kcpro_send_sms_directly',[$this,'commonSendSms'],10,3);
        add_filter('kcpro_send_whatsapp_directly',[$this,'commonWhatsAppMessageSend'],10,2);
        add_filter('kcpro_save_widget_order_list',[$this,'saveWidgetOrderList']);
        add_filter('kcpro_get_widget_order_list',[$this,'getWidgetOrderList']);
        add_filter('kcpro_custom_notification_dynamic_keys_save',[$this,'customNotificationDynamicKeysSave'],10,2);
        add_filter('kcpro_custom_notification_dynamic_keys_list',[$this,'customNotificationDynamicKeysList'],10,2);
        add_filter('kcpro_custom_notification_api_configuration_list_save',[$this,'customNotificationApiConfigurationSave'],10,2);
        add_filter('kcpro_custom_notification_api_configuration_list',[$this,'customNotificationApiConfigurationList'],10,2);
        add_filter('kcpro_custom_notification_setting_get',[$this,'customNotificationSettingGet'],10,1);
        add_filter('kcpro_custom_notification_setting_save',[$this,'customNotificationSettingSave'],10,2);

        add_action("kcpro_refresh_dashboard_locale",[$this,'refresh_dashboard_locale']);
        add_action('kcpro_send_custom_notification_request', [$this, 'sendCustomNotificationRequest'],10,1);
    }

    public function updateLang($filterData){
        $upload_dir = wp_upload_dir(); 
        $dir_name = KIVI_CARE_PRO_PREFIX.'lang';
        $user_dirname = $upload_dir['basedir'] . '/' . $dir_name;
        $source_file =$user_dirname.'/'.$filterData['lang']['id'].'.json';
        $target_file = $user_dirname.'/temp.json';
        $lang_data = file_get_contents($source_file);
        if($lang_data !== null && $lang_data !== ''){
            file_put_contents($target_file,$lang_data);
        }
        try{
            if(isset($filterData['user_id'])){
                if(current_user_can('administrator')){
                    update_option( KIVI_CARE_PRO_PREFIX . 'admin_lang',$filterData['lang'] );
                    $data = get_option(KIVI_CARE_PRO_PREFIX . 'admin_lang');

                }else{
                    update_user_meta($filterData['user_id'], 'defualt_lang', $filterData['lang'] );
                    $data = get_user_meta($filterData['user_id'], 'defualt_lang');
                }
                return [
                    'data'=> $data,
                    'status' => true,
                    'message' => esc_html__('Language updated successfully', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Language updated', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function getPrescriptionPrint($printData){
        try{
            $qualifications = [];
            $university =[];
            if(isset($printData['encounter_id'])){
                $patient_encounter_table = $this->db->prefix . 'kc_' . 'patient_encounters';
                $clinics_table           = $this->db->prefix . 'kc_' . 'clinics';
                $users_table             = $this->db->base_prefix . 'users';
                $medical_history_table   = $this->db->prefix . 'kc_medical_history';
                $precriptionResults = $this->db->get_results("SELECT pre.* ,enc.*
                                                 FROM {$this->db->prefix}kc_prescription AS pre 
                                                 JOIN {$patient_encounter_table} AS enc ON enc.id=pre.encounter_id WHERE pre.encounter_id={$printData['encounter_id']}");
                $query = "
                    SELECT {$patient_encounter_table}.*,
                       doctors.display_name  AS doctor_name,
                       doctors.user_email AS doctor_email,    
                       patients.display_name AS patient_name,
                       patients.user_email AS patient_email,
                       {$clinics_table}.* 
                    FROM  {$patient_encounter_table}
                       LEFT JOIN {$users_table} doctors
                              ON {$patient_encounter_table}.doctor_id = doctors.id
                      LEFT JOIN {$users_table} patients
                              ON {$patient_encounter_table}.patient_id = patients.id
                       LEFT JOIN {$clinics_table}
                              ON {$patient_encounter_table}.clinic_id = {$clinics_table}.id
                    WHERE {$patient_encounter_table}.id = {$printData['encounter_id']} LIMIT 1";
        
                $encounter = $this->db->get_row( $query);
                $medical_history_data = [];
                if(get_option( KIVI_CARE_PRO_PREFIX . 'include_clinical_detail_in_print') == 'true'){
                    $medical_show = true;
                    if($this->getLoginUserRole() === 'kiviCare_patient' && get_option( KIVI_CARE_PRO_PREFIX . 'hide_clinical_detail_in_patient') == 'true'){
                        $medical_show = false;
                    }
                    if($medical_show){
                        $medical_history_data = collect($this->db->get_results( "SELECT * FROM {$medical_history_table} WHERE encounter_id={$printData['encounter_id']}"))->groupBy('type')->map(function ($type) {
                            return $type->pluck('title');
                        })->toArray();
                    }
                }
                if(!empty($medical_history_data) && is_array($medical_history_data)){
                    $temp = 0;
                    foreach($medical_history_data as $value){
                        $temp = is_array($value) && count($value) > $temp ? count($value) : $temp;
                    }
                    $medical_history_data['count'] = $temp;
                    $medical_history_data['show'] = (get_option( KIVI_CARE_PRO_PREFIX . 'include_clinical_detail_in_print') == 'true') ? 'true' : 'false';
                }
                if ( !empty( $encounter ) ) {
                    $encounter->medical_history = $medical_history_data;
                    $encounter->prescription = $precriptionResults;
                    $encounter->include_encounter_custom_field = get_option( KIVI_CARE_PRO_PREFIX . 'include_encounter_custom_field_in_print' , false);
                    $basic_data  = get_user_meta( (int)$encounter->doctor_id, 'basic_data', true );
                    $basic_data = json_decode($basic_data);
                    foreach ($basic_data->qualifications as $q) {
                        $qualifications[] =  $q->degree;
                        $qualifications[] =  $q->university;
                    }
                    $patient_basic_data = json_decode(get_user_meta( (int)$encounter->patient_id, 'basic_data', true ));
                    $encounter->patient_gender = !empty($patient_basic_data->gender)
                        ? ($patient_basic_data->gender === 'female'
                            ? 'F' : 'M') : '';
                    $encounter->patient_address = (!empty($patient_basic_data->address) ? $patient_basic_data->address : '');
                    $encounter->patient_city =  (!empty($patient_basic_data->city) ?  $patient_basic_data->city : '');
                    $encounter->patient_state =  (!empty($patient_basic_data->state) ? $patient_basic_data->state : '');
                    $encounter->patient_country =  (!empty($patient_basic_data->country) ?   $patient_basic_data->country : '');
                    $encounter->patient_postal_code =  (!empty($patient_basic_data->postal_code) ? $patient_basic_data->postal_code : '');
                    $encounter->contact_no = (!empty($patient_basic_data->mobile_number) ? $patient_basic_data->mobile_number : '');
                    $encounter->patient_add = $encounter->patient_address.','.$encounter->patient_city
                                              .','.$encounter->patient_state.','.$encounter->patient_country.','.$encounter->patient_postal_code;
                    $years = $months=  $days= 0;
                    $encounter->date = current_time('Y-m-d');
                    if(!empty($patient_basic_data->dob)){
                        $diff = abs(strtotime(current_time('Y-m-d')) - strtotime($patient_basic_data->dob));
                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)).esc_html__('Days','kiviCare-clinic-&-patient-management-system-pro');
                        $years = $years.esc_html__(' Years','kiviCare-clinic-&-patient-management-system-pro');
                        $months = $months.esc_html__('Days','kiviCare-clinic-&-patient-management-system-pro');
                    }
                    $encounter->patient_dob = !empty($patient_basic_data->dob) ? kcGetFormatedDate($patient_basic_data->dob) :'';
                    $encounter->patient_age =  $years === '0 Years' ? ($months === '0 Months' ? $days : $months ) : $years;
                    $encounter->qualifications = !empty($qualifications) ? '('.implode (", ", $qualifications).')' :'';
                    $encounter->clinic_address ="#{$encounter->clinic_id } ,{$encounter->address } ,{$encounter->city}" ;
                    $default_clinic_log = !empty($printData['clinic_default_logo']) ? $printData['clinic_default_logo'] : '';
                    $encounter->clinic_logo = !empty($encounter->profile_image) ? wp_get_attachment_url($encounter->profile_image) : $default_clinic_log;
                    return [
                        'data'=> kcPrescriptionHtml($encounter,$printData['encounter_id'], !empty($printData['print_type']) ? $printData['print_type'] : 'encounter'),
                        'status' => true,
                        'message' => esc_html__('Successfully print prescription', 'kiviCare-clinic-&-patient-management-system-pro')
                    ];
                } else {
                    return [
                        'data'=> '',
                        'status' => false,
                        'message' => esc_html__('No Data Found', 'kiviCare-clinic-&-patient-management-system-pro')
                    ];
                }
               
            }else{
                return [
                    'data'=> '',
                    'status' => false,
                    'message' => esc_html__('No Data Found', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Failed to print', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function getEncounterPrint($printData){
        try{
            $qualifications = [];
            $university =[];
            if(isset($printData['encounter_id'])){
                $patient_encounter_table = $this->db->prefix . 'kc_' . 'patient_encounters';
                $clinics_table           = $this->db->prefix . 'kc_' . 'clinics';
                $users_table             = $this->db->base_prefix . 'users';
                $medical_history_table   = $this->db->prefix . 'kc_medical_history';
                $custom_field            = $this->db->prefix .'kc_custom_fields ';
                $custom_field_data       = $this->db->prefix .'kc_custom_fields_data ';
                $precriptionResults = $this->db->get_results("SELECT pre.* ,enc.*
                                                 FROM {$this->db->prefix}kc_prescription AS pre 
                                                 JOIN {$patient_encounter_table} AS enc ON enc.id=pre.encounter_id WHERE pre.encounter_id={$printData['encounter_id']}");
                $query = "
                    SELECT {$patient_encounter_table}.*,
                       {$patient_encounter_table}.description,
                       {$patient_encounter_table}.status AS Estatus,
                       doctors.display_name  AS doctor_name,
                       doctors.user_email AS doctor_email,    
                       patients.display_name AS patient_name,
                       patients.user_email AS patient_email,
                       {$clinics_table}.* 
                    FROM  {$patient_encounter_table}
                       LEFT JOIN {$users_table} doctors
                              ON {$patient_encounter_table}.doctor_id = doctors.id
                      LEFT JOIN {$users_table} patients
                              ON {$patient_encounter_table}.patient_id = patients.id
                       LEFT JOIN {$clinics_table}
                              ON {$patient_encounter_table}.clinic_id = {$clinics_table}.id
                    WHERE {$patient_encounter_table}.id = {$printData['encounter_id']} LIMIT 1";

                $encounter = $this->db->get_row( $query);
                $medical_history_data = collect($this->db->get_results( "SELECT * FROM {$medical_history_table} WHERE encounter_id={$printData['encounter_id']}"))->groupBy('type')->map(function ($type) {
                    return $type->pluck('title');
                })->toArray();
                if(!empty($medical_history_data) && is_array($medical_history_data)){
                    $temp = 0;
                    foreach($medical_history_data as $value){
                        $temp = is_array($value) && count($value) > $temp ? count($value) : $temp;
                    }
                    $medical_history_data['count'] = $temp;
                }
                $custom_fields_query = "SELECT * FROM {$custom_field} WHERE module_type = 'patient_encounter_module'";
                $custom_fields = $this->db->get_results($custom_fields_query);
    
                foreach ($custom_fields as $field) {
                    // Process and format the custom fields as needed
                    $main_id = $field->id;
                    $field_details = json_decode($field->fields);
                    $encounter->custom_fields = $custom_fields;
                    $field->cus_id = $field_details->id;
                    $field->label = $field_details->label;
                    $field->name = $field_details->name;
                    $field->placeholder = $field_details->placeholder;
                    $field->type = $field_details->type;
                    if (!empty($field_details->options)) {
                        $field->options = $field_details->options;
                    } else {
                        $field->options = [];
                    }
                }
                $custom_fields_data_query = "SELECT * FROM {$custom_field_data} WHERE module_id = {$printData['encounter_id']}";
                $custom_fields_data = $this->db->get_results($custom_fields_data_query);
                $encounter->custom_fields_data = $custom_fields_data;
               
                if ( !empty( $encounter )) {
                   
                    $encounter->medical_history = $medical_history_data;
                    $encounter->prescription = $precriptionResults;
                    $encounter->include_encounter_custom_field = get_option( KIVI_CARE_PRO_PREFIX . 'include_encounter_custom_field_in_print' , false);
                    $basic_data  = get_user_meta( (int)$encounter->doctor_id, 'basic_data', true );
                    $basic_data = json_decode($basic_data);
                    if(!empty($basic_data->qualifications)){
                        foreach ($basic_data->qualifications as $q) {
                            $qualifications[] =  $q->degree;
                            $qualifications[] =  $q->university;
                        }
                    }
                    $patient_basic_data = json_decode(get_user_meta( (int)$encounter->patient_id, 'basic_data', true ));
                    $encounter->patient_gender = !empty($patient_basic_data->gender)
                        ? ($patient_basic_data->gender === 'female'
                            ? 'F' : 'M') : '';
                    $encounter->patient_address = (!empty($patient_basic_data->address) ? $patient_basic_data->address : '');
                    $encounter->patient_city =  (!empty($patient_basic_data->city) ?  $patient_basic_data->city : '');
                    $encounter->patient_state =  (!empty($patient_basic_data->state) ? $patient_basic_data->state : '');
                    $encounter->patient_country =  (!empty($patient_basic_data->country) ?   $patient_basic_data->country : '');
                    $encounter->patient_postal_code =  (!empty($patient_basic_data->postal_code) ? $patient_basic_data->postal_code : '');
                    $encounter->contact_no = (!empty($patient_basic_data->mobile_number) ? $patient_basic_data->mobile_number : '');
                    $encounter->patient_add = $encounter->patient_address.','.$encounter->patient_city
                                              .','.$encounter->patient_state.','.$encounter->patient_country.','.$encounter->patient_postal_code;
                    $years = $months=  $days= 0;
                    $encounter->date = current_time('Y-m-d');
                    if(!empty($patient_basic_data->dob)){
                        $diff = abs(strtotime(current_time('Y-m-d')) - strtotime($patient_basic_data->dob));
                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)).esc_html__('Days','kiviCare-clinic-&-patient-management-system-pro');
                        $years = $years.esc_html__(' Years','kiviCare-clinic-&-patient-management-system-pro');
                        $months = $months.esc_html__('Days','kiviCare-clinic-&-patient-management-system-pro');
                    }
                    $encounter->patient_age =  $years === '0 Years' ? ($months === '0 Months' ? $days : $months ) : $years;
                    $encounter->qualifications = !empty($qualifications) ? '('.implode (", ", $qualifications).')' :'';
                    $encounter->clinic_address ="#{$encounter->clinic_id } ,{$encounter->address } ,{$encounter->city}" ;
                    $default_clinic_log = !empty($printData['clinic_default_logo']) ? $printData['clinic_default_logo'] : '';
                    $encounter->clinic_logo = !empty($encounter->profile_image) ? wp_get_attachment_url($encounter->profile_image) : $default_clinic_log;
                    return [
                        'data'=> kcEncounterHtml($encounter,$printData['encounter_id'], !empty($printData['print_type']) ? $printData['print_type'] : 'encounter'),
                        'status' => true,
                        'message' => esc_html__('Successfully print Encounter ', 'kiviCare-clinic-&-patient-management-system-pro')
                    ];
                } else {
                    return [
                        'data'=> '',
                        'status' => false,
                        'message' => esc_html__('No Data Found', 'kiviCare-clinic-&-patient-management-system-pro')
                    ];
                }
               
            }else{
                return [
                    'data'=> '',
                    'status' => false,
                    'message' => esc_html__('No Data Found', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Failed to print', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function updateThemeColor($color){
        try{
            if(isset($color['color'])){
                update_option( KIVI_CARE_PRO_PREFIX . 'theme_color',$color['color'] );
                $data = get_option(KIVI_CARE_PRO_PREFIX . 'theme_color');
                return [
                    'data'=> $data,
                    'status' => true,
                    'message' => esc_html__('Theme Color updated', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Theme Color not updated', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }
    public function uploadLogo($requestData){
        try{
            if(isset($requestData['site_logo'])){
                update_option( KIVI_CARE_PRO_PREFIX . 'site_logo',$requestData['site_logo'] );
                $url = wp_get_attachment_url($requestData['site_logo']);
                return [
                    'data'=> $url,
                    'status' => true,
                    'message' => esc_html__('Theme logo updated', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Failed to update theme logo', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function uploadLoader($requestData){
        try{
            if(isset($requestData['site_loader'])){
                update_option( KIVI_CARE_PRO_PREFIX . 'site_loader',$requestData['site_loader'] );
                $url = wp_get_attachment_url($requestData['site_loader']);
                return [
                    'data'=> $url,
                    'status' => true,
                    'message' => esc_html__('Theme loader updated', 'kiviCare-clinic-&-patient-management-system-pro')
                ];
            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Failed to update theme loader', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function updateThemeMode($mode){
                
        if(in_array($mode['mode'],['1','true'])){
            update_option( KIVI_CARE_PRO_PREFIX . 'theme_mode','true' );
        }else{
            update_option( KIVI_CARE_PRO_PREFIX . 'theme_mode','false' );
        }
	    $data = get_option( KIVI_CARE_PRO_PREFIX . 'theme_mode');

	    return [
	        'data'=> $data,
	        'status' => true,
	        'message' => esc_html__('Theme mode updated', 'kiviCare-clinic-&-patient-management-system-pro')
	    ];
    }
    public function getSmsConfig( $data ) {
		$user_meta = get_option('sms_config_data', true );
        if ( !empty($user_meta) && gettype($user_meta) !== 'boolean'  ) {
            $user_meta = json_decode( $user_meta );
            return [
                'data'=> $user_meta,
                'status' => true,
            ];
		} else {
            return [
                'data'=> [],
                'status' => false,
            ];
		}
	}
    public function getWhatsAppConfig( $data ) {
		$user_meta = get_option('whatsapp_config_data', true );
		if ( !empty($user_meta) && gettype($user_meta) !== 'boolean' ) {
            $user_meta = json_decode( $user_meta );
            return [
                'data'=> $user_meta,
                'status' => true,
            ];
		} else {
            return [
                'data'=> [],
                'status' => false,
            ];
		}
	}
    public function saveSmsConfig($data){
        if($data){
            unset($data['config_data']['route_name']);
            unset($data['config_data']['_ajax_nonce']);
            update_option('sms_config_data', json_encode($data['config_data']));
            return [
                'status' => true,
                'message' => esc_html__('Configuration saved', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }else{
            return [
                'status' => false,
                'message' => esc_html__('Configuration not saved', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
	
    }
    public function saveWhatsAppConfig($data){
        if($data){
            unset($data['config_data']['route_name']);
            unset($data['config_data']['_ajax_nonce']);
            update_option('whatsapp_config_data', json_encode($data['config_data']));
            return [
                'status' => true,
                'message' => esc_html__('Configuration saved', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }else{
            return [
                'status' => false,
                'message' => esc_html__('Configuration not saved', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
	
    }
    public function sendSMS($data){      
        global $wpdb;
        $data['type'] = trim($data['type']);
        $args['post_name'] = strtolower(KIVI_CARE_PRO_PREFIX.$data['type']);
        $args['post_type'] = strtolower(KIVI_CARE_PRO_PREFIX.'sms_tmp') ;

        $templateData = $zoom_data = [];
        $message = $what_message = new \stdClass();
        $message->status = $what_message->status = 'unsend';
        $check_exist_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish' ",$args['post_name'],$args['post_type']), ARRAY_A);
        if (!empty($check_exist_post)) {
            $body = $check_exist_post['post_content'];
            $content_sid = get_post_meta($check_exist_post['ID'], 'content_sid', true);
            switch ($data['type']){
                case 'encounter_close':
                    // $receiver_number = kcGetUserValueByKey('patient',(int)$data['patient_id'],'mobile_number');
                    $receiver_number = kcGetContactWithCountryCode('patient',(int)$data['patient_id'],'mobile_number');
                    if(!empty($receiver_number)){
                        $data['encounter_id'] = (int)$data['encounter_id'];
                        $bill_amount =$wpdb->get_var($wpdb->prepare("SELECT total_amount FROM {$wpdb->prefix}kc_bills WHERE encounter_id=%d",$data['encounter_id']));
                        $templateData['total_amount'] = !empty($bill_amount) ? $bill_amount : 0 ;
                        if($content_sid !== null && $content_sid !== ''){
                            $body = kcEmailContentKeyReplace($body,  $templateData,true);
                        }else{
                            $body = kcEmailContentKeyReplace($body,  $templateData);
                        }
                        if(kcCustomNotificationEnable('sms')){
                            $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                        }else{
                            $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                        }

                        if(kcCustomNotificationEnable('whatsapp')){
                            $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                        }else{
                            $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                        }
                    }
                    break;
                case 'add_appointment':
                case 'clinic_book_appointment':
                case 'doctor_book_appointment':
                case 'cancel_appointment':
                    $data['appointment_id'] = (int)$data['appointment_id'];
                    $appointments = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}kc_appointments WHERE id=%d",$data['appointment_id']));
                    if($data['type'] === 'clinic_book_appointment'){
                        $receiver_number = $wpdb->get_var($wpdb->prepare("SELECT telephone_no FROM {$wpdb->prefix}kc_clinics WHERE id=%d",$appointments->clinic_id));
                    }elseif($data['type'] === 'doctor_book_appointment'){
                        // $receiver_number = kcGetUserValueByKey('doctor',(int)$appointments->doctor_id,'mobile_number');
                        $receiver_number = kcGetContactWithCountryCode('doctor',(int)$appointments->doctor_id,'mobile_number');
                    }else{
                        // $receiver_number = kcGetUserValueByKey('patient',(int)$appointments->patient_id,'mobile_number');
                        $receiver_number = kcGetContactWithCountryCode('patient',(int)$appointments->patient_id,'mobile_number');
                    }

                    if(!empty($receiver_number)){
                        $templateData = kcCommonNotificationData($appointments,$zoom_data,!empty($data['service']) ? $data['service'] : '','sms');
                        if($content_sid !== null && $content_sid !== ''){
                            $body = kcEmailContentKeyReplace($body,  $templateData,true);
                        }else{
                            $body = kcEmailContentKeyReplace($body,  $templateData);
                        }
                        if(kcCustomNotificationEnable('sms')){
                            $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                        }else{
                            $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                        }
                        
                        if(kcCustomNotificationEnable('whatsapp')){
                            $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                        }else{
                            $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                        }

                    }
                    break;
                case 'add_doctor_meet_link':
                case 'meet_link':
                case 'zoom_link':
                case 'add_doctor_zoom_link':
                    if (isKiviCareTelemedActive() || isKiviCareGoogleMeetActive()) {
                        $data['appointment_id'] = (int)$data['appointment_id'];
                        $appointments = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}kc_appointments WHERE id=%d",$data['appointment_id']));
                        if( in_array($data['type'],['add_doctor_zoom_link','add_doctor_meet_link'])){
                            // $receiver_number = kcGetUserValueByKey('doctor',(int)$appointments->doctor_id,'mobile_number');
                            $receiver_number = kcGetContactWithCountryCode('doctor',(int)$appointments->doctor_id,'mobile_number');
                        }else{
                            // $receiver_number = kcGetUserValueByKey('patient',(int)$appointments->patient_id,'mobile_number');
                            $receiver_number = kcGetContactWithCountryCode('patient',(int)$appointments->patient_id,'mobile_number');
                        }
                        if(!empty($receiver_number)){
                            if(isKiviCareTelemedActive() && in_array($data['type'],['add_doctor_zoom_link','zoom_link'] )){
                                $zoom_table = $wpdb->prefix . "kc_appointment_zoom_mappings";
                                $zoom_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$zoom_table} WHERE appointment_id = %d",$data['appointment_id']), OBJECT);
                            }else if(isKiviCareGoogleMeetActive()){
                                $googlemeet_table = $wpdb->prefix . "kc_appointment_google_meet_mappings";
                                $zoom_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$googlemeet_table} WHERE appointment_id = %d",$data['appointment_id']), OBJECT);
                            }
                            if(!empty($zoom_data)){
                                $templateData = kcCommonNotificationData($appointments,$zoom_data,'','sms');
                                if($content_sid !== null && $content_sid !== ''){
                                    $body = kcEmailContentKeyReplace($body,  $templateData,true);
                                }else{
                                    $body = kcEmailContentKeyReplace($body,  $templateData);
                                }
                                if(kcCustomNotificationEnable('sms')){
                                    $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                                }else{
                                    $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                                }

                                if(kcCustomNotificationEnable('whatsapp')){
                                    $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                                }else{
                                    $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                                }
                            }
                        }
                    }
                    break;
                case 'patient_register':
                case 'resend_user_credential':
                case 'doctor_registration':
                case 'receptionist_register':
                case 'clinic_admin_registration':
                case 'book_appointment_reminder':
                    // $receiver_number = kcGetUserValueByKey('patient',(int)$data['user_data']['id'],'mobile_number');
                    $receiver_number = kcGetContactWithCountryCode('patient',(int)$data['user_data']['id'],'mobile_number');
                    if($content_sid !== null && $content_sid !== ''){
                        $body = kcEmailContentKeyReplace($body,  $data['user_data'],true);
                    }else{
                        $body = kcEmailContentKeyReplace($body,  $data['user_data']);
                    }
                    if($data['type'] == 'book_appointment_reminder'){
                        if(isset($data['send_type']) && !empty($receiver_number)){
                            if($data['send_type'] =='sms'){
                                if(kcCustomNotificationEnable('sms')){
                                    $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                                }else{
                                    $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                                }
                            }else{
                                if(kcCustomNotificationEnable('whatsapp')){
                                    $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                                }else{
                                    $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                                }
                            }
                        }
                    }else if(!empty($receiver_number)){
                        if(kcCustomNotificationEnable('sms')){
                            $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                        }else{
                            $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                        }

                        if(kcCustomNotificationEnable('whatsapp')){
                            $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                        }else{
                            $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                        }
                    }
                    break;
                case 'book_appointment_reminder_for_doctor':
                    $receiver_number = kcGetContactWithCountryCode('doctor',(int)$data['user_data']['id'],'mobile_number');
                    if($content_sid !== null && $content_sid !== ''){
                        $body = kcEmailContentKeyReplace($body,  $data['user_data'],true);
                    }else{
                        $body = kcEmailContentKeyReplace($body,  $data['user_data']);
                    }
                    if($data['type'] == 'book_appointment_reminder'){
                        if(isset($data['send_type']) && !empty($receiver_number)){
                            if($data['send_type'] =='sms'){
                                if(kcCustomNotificationEnable('sms')){
                                    $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                                }else{
                                    $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                                }
                            }else{
                                if(kcCustomNotificationEnable('whatsapp')){
                                    $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                                }else{
                                    $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                                }
                            }
                        }
                    }else if(!empty($receiver_number)){
                        if(kcCustomNotificationEnable('sms')){
                            $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                        }else{
                            $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                        }

                        if(kcCustomNotificationEnable('whatsapp')){
                            $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                        }else{
                            $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                        }
                    }
                    break;
                case 'user_verified':
                case 'admin_new_user_register':
                case 'patient_clinic_check_in_check_out':
                    $receiver_number = $data['type'] === 'patient_clinic_check_in_check_out' ? $data['user_data']['clinic_number'] : $data['user_data']['user_contact'];
                    if(!empty($receiver_number)){
                        if($content_sid !== null && $content_sid !== ''){
                            $body = kcEmailContentKeyReplace($body,  $data['user_data'],true);
                        }else{
                            $body = kcEmailContentKeyReplace($body,  $data['user_data']);
                        }
                        if(kcCustomNotificationEnable('sms')){
                            $message = $this->sendCustomNotification('sms',$receiver_number,$body,$data);
                        }else{
                            $message = $this->commonSendSms($receiver_number,$body,$content_sid);
                        }

                        if(kcCustomNotificationEnable('whatsapp')){
                            $what_message = $this->sendCustomNotification('whatsapp',$receiver_number, $body,$data);
                        }else{
                            $what_message = $this->commonWhatsAppMessageSend($receiver_number,$body,$content_sid);
                        }
                    }
                    break;
            }
        }
        return [
            'status' => [
                'sms' => $message,
                'whatsapp' => $what_message
            ]
        ];
    }

    public function getDoctorWiseClinic($data){
        $table = $this->db->prefix . 'kc_' . 'doctor_clinic_mappings';
        $table_clinic = $this->db->prefix . 'kc_' . 'clinics';
        if($this->getLoginUserRole() === 'kiviCare_doctor'){
            $user_id = get_current_user_id();
            $docId = $user_id ;
        }else{
            $docId = (int)$data['requestData']['doctor_id'];
        }
        $clinic = "SELECT clinic_id,(SELECT name FROM {$table_clinic} WHERE id= doctor.clinic_id ) as label FROM {$table} as `doctor` 
        WHERE doctor_id =". (int)$docId;
        $clinics = $this->db->get_results( $clinic);
   
        return [
            'status' => true,
            'data'=> $clinics,
        ];
    }
    public function saveSMSTemplate($data){
        foreach ($data['data'] as $key => $value) {
			wp_update_post($value);
            update_post_meta($value['ID'], 'content_sid', $value['content_sid']);
		}

		return[
			'status' => true,
			'message' => esc_html__('SMS template  saved successfully.', 'kiviCare-clinic-&-patient-management-system-pro')
		];
    }
    public function getJosnData($file){
        //english
        $upload_dir = wp_upload_dir(); 
        $dir_name = KIVI_CARE_PRO_PREFIX.'lang';
		$user_dirname = $upload_dir['basedir'] . '/' . $dir_name;
        $current_file = $user_dirname.'/en.json';

        if(!file_exists($current_file)) {
	        $current_file = $user_dirname.'/temp.json';
        }

        $str = file_get_contents($current_file);
        $json = json_decode($str, true);

        $json = collect($json);
        $data = $json->map( function ( $d ) {
            if(gettype($d) === 'object'){
                $d = json_decode($d,true);
            }
          return $d;
        });

        // other language
        $current_file_1 = $user_dirname.'/'.$file['currentFile'].'.json';
        $str1 = file_get_contents($current_file_1);
        $json1 = json_decode($str1, true);

        $json1 = collect($json1);
        $data1 = $json1->map( function ( $d ) {
            if(gettype($d) === 'object'){
                $d = json_decode($d,true);
            }
          return $d;
        });
        $newlang = $file['currentFile'];
        return [
            'status' => true,
            'data'=> [
                'en' => $data->toArray(),
                $newlang=> !empty($data1->toArray()) ? $data1->toArray() :$data->toArray()
            ],
        ];
    }
    public function saveJosnData($requestData){
       
       $prefix = KIVI_CARE_PRO_PREFIX;

       $upload_dir = wp_upload_dir(); 
       $dir_name = $prefix .'lang';
       $user_dirname = $upload_dir['basedir'] . '/' . $dir_name;

       $data = $requestData['jsonData'];
       $file_name =$user_dirname.'/'.$requestData['filename'].'.json';
       $data = json_encode($data);
       $save_lang = [
           'label'=> $requestData['langName'],
           'id'=>$requestData['filename']
       ];   
       $get_lang_option = get_option($prefix.'lang_option');
       $get_lang_option = json_decode($get_lang_option,true);
       $collection = collect($get_lang_option['lang_option'] );
        $result = $collection->where('id', $requestData['filename']);
        if(count($result) == 0){
            array_push($get_lang_option['lang_option'],$save_lang);
            update_option( $prefix.'lang_option',json_encode($get_lang_option));
        
        }
       if(file_put_contents($file_name,$data)){
        chmod($file_name, 0777); 

        $get_admin_lang = get_option(KIVI_CARE_PRO_PREFIX . 'admin_lang');
        if($get_admin_lang['id'] == $requestData['filename']){
            $temp_file_name = $user_dirname.'/temp.json';
            file_put_contents($temp_file_name,$data);
        }
        return [
            'status' => true,
            'message' => esc_html__('Language File Updated successfully.', 'kiviCare-clinic-&-patient-management-system-pro')
        ];
       }else{
        return [
            'status' => false,
            'message' => esc_html__('Failed to update file', 'kiviCare-clinic-&-patient-management-system-pro')
        ];
       }

       
    }
    public function getAllLang(){
        $prefix = KIVI_CARE_PRO_PREFIX;
        $lang_option = get_option($prefix . 'lang_option');
		if($lang_option !== '') {
            $data = json_decode($lang_option);
			$status = true ;
		} else {
			$data = [] ;
			$status = false ;
        }
        return [
            'status' => $status,
            'data'    => $data
        ];
    }

    public function commonSendSms($receiverNo,$body,$content_sid=''){

        $options = array(
            'ignore_errors' => true,
            // other options go here
        );

        if(!kcCheckSmsOptionEnable()){
            $data = new \stdClass();
            $data->status = 'unsend';
            $data->error = __('Sms Option Not Enable','kiviCare-clinic-&-patient-management-system-pro');
            return $data;
        }
        
        $status = '';
        $get_sms_config  = get_option('sms_config_data', true );
        $get_sms_config = json_decode($get_sms_config);
        $sid     = $get_sms_config->account_id;
        $token   = $get_sms_config->auth_token;

        if (!empty($sid) && !empty($token) && !empty($receiverNo) && !empty($get_sms_config->to_number)) {
            try {  
                $twilio = new Client($sid, $token);
                if( !empty($content_sid) && $content_sid !== null && $content_sid !== ''){
                    $status = $twilio->messages->create(
                        $receiverNo, // to 
                        [
                            "ContentSid" => $content_sid,
                            "from" => $get_sms_config->to_number,
                            "contentVariables" => json_encode($body),
                        ]
                );
                }else{
                    $status = $twilio->messages->create(
                        $receiverNo, // to
                        ["body" => wp_strip_all_tags($body), "from" => $get_sms_config->to_number]
                    );
                }
            } catch (\Exception $e) {
                $data = new \stdClass();
                $data->status = 'unsend';
                $data->error =$e->getMessage();
                // will return user to previous screen with twilio error
                return $data;
            }
        }

        return $status;
    }

    public function commonWhatsAppMessageSend($receiverNo, $body,$content_sid = '') {
        if(!kcCheckWhatsappOptionEnable()) {
            $data = new \stdClass();
            $data->status = 'unsend';
            $data->error = __('Whatsapp Option Not Enable','kiviCare-clinic-&-patient-management-system-pro');
           
            return $data;
        }
        $status = '';
        $get_whatsapp_config = get_option('whatsapp_config_data', true);
        $get_whatsapp_config = json_decode($get_whatsapp_config);
        $sid = $get_whatsapp_config->wa_account_id;
        $token = $get_whatsapp_config->wa_auth_token;
        if (!empty($sid) && !empty($token) && !empty($receiverNo) && !empty($get_whatsapp_config->wa_to_number)) {
            try {
                $twilio = new Client($sid, $token);
                if( $content_sid !== null && $content_sid !== ''){
                    $status = $twilio->messages->create( 
                        "whatsapp:" . str_replace(' ', '', $receiverNo), // To
                        [
                            "ContentSid" => $content_sid,
                            "from" => "whatsapp:" . str_replace(' ', '', $get_whatsapp_config->wa_to_number),
                            "contentVariables" => json_encode($body),
                        ]
                    );
                    $status = $status->body;
                }else{
                    $status = $twilio->messages->create(
                        "whatsapp:" . str_replace(' ', '', $receiverNo), // to
                        array(
                            "from" => "whatsapp:" . str_replace(' ', '', $get_whatsapp_config->wa_to_number),
                            "body" => wp_strip_all_tags($body)
                        )
                    );
                }
            } catch (\Twilio\Exceptions\RestException $e) {
                $data = new \stdClass();
                $data->status = 'unsend';
                $data->error = 'Error Code: ' . $e->getCode() . ' - ' . $e->getMessage();
                return $data;
            } catch (\Exception $e) {
                $data = new \stdClass();
                $data->status = 'unsend';
                $data->error = $e->getMessage();
                return $data;
            }
        }
        return $status;
    }

    public function getEncounterPrescriptionClinicalInclude(){

        return [
            'status' => true,
            'data' => get_option( KIVI_CARE_PRO_PREFIX . 'include_clinical_detail_in_print' , false),
            'hideInPatient'  => get_option( KIVI_CARE_PRO_PREFIX . 'hide_clinical_detail_in_patient' , false),
            'custom_field'  => get_option( KIVI_CARE_PRO_PREFIX . 'include_encounter_custom_field_in_print' , false),

        ];

    }

    public function editEncounterPrescriptionClinicalInclude($data){
        $status = false;
        $message = esc_html__('Failed to save','kiviCare-clinic-&-patient-management-system-pro');
        if(isset($data)){
            update_option( KIVI_CARE_PRO_PREFIX . 'include_clinical_detail_in_print',$data['status'] );
            $status = true;
            $message = esc_html__('Setting Saved','kiviCare-clinic-&-patient-management-system-pro');
        }

        return [
            'status' => $status,
            'message' => $message
        ];
    }

    public function editEncounterCustomFieldInclude($data){
        $status = false;
        $message = esc_html__('Failed to save','kiviCare-clinic-&-patient-management-system-pro');
        if(isset($data['status'])){
            update_option( KIVI_CARE_PRO_PREFIX . 'include_encounter_custom_field_in_print',$data['status'] );
            $status = true;
            $message = esc_html__('Setting Saved','kiviCare-clinic-&-patient-management-system-pro');
        }

        return [
            'status' => $status,
            'message' => $message
        ];
    }

    public function saveWidgetOrderList($data){
        $status = false;
        $message = esc_html__('Failed to save','kiviCare-clinic-&-patient-management-system-pro');
        if(isset($data) && !empty($data['list'])){
            update_option(KIVI_CARE_PRO_PREFIX.'widget_order_list',$data['list']);
            $status = true;
            $message = esc_html__('Setting Saved','kiviCare-clinic-&-patient-management-system-pro');
        }

        return [
            'status' => $status,
            'message' => $message
        ];
    }

    public function getWidgetOrderList(){

        return [
            'status' => true,
            'data' => get_option( KIVI_CARE_PRO_PREFIX . 'widget_order_list' , false)
        ];

    }

    public function customNotificationDynamicKeysSave($response,$data){
        update_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_dynamic_keys_update',$data['data']);
        $response['status'] = true;
        $response['message'] = esc_html__("Custom notification dynamic keys saved successfully","kiviCare-clinic-&-patient-management-system-pro");
        return $response;
    }

    public function customNotificationDynamicKeysList($response,$data){
        $list = get_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_dynamic_keys_update');
        $response['status'] = true;
        $response['data'] = !empty($list) && is_array($list) ? $list : [];
        $response['message'] = esc_html__("Custom notification dynamic keys list","kiviCare-clinic-&-patient-management-system-pro");
        return $response;
    }

    public function customNotificationApiConfigurationSave($response,$data){
        update_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_api_configuration_list',$data['data']);
        $response['status'] = true;
        $response['message'] = esc_html__("Custom notification dynamic keys saved successfully","kiviCare-clinic-&-patient-management-system-pro");
        return $response;
    }

    public function customNotificationApiConfigurationList($response,$data){
        $list = get_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_api_configuration_list');
        $response['status'] = true;
        $response['data'] = !empty($list) && is_array($list) ? $list : [];
        $response['message'] = esc_html__("Custom notification dynamic keys list","kiviCare-clinic-&-patient-management-system-pro");
        return $response;
    }

    public function customNotificationSettingSave($response,$data){
        if(!empty($data['type']) && in_array($data['type'],['sms','whatsapp'])){
            $type = $data['type'];
            $status = !empty($data['status']) && in_array($data['status'],['yes']) ? 'yes' : 'no';
            update_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_'.$type.'_setting',$status);
            $response['status'] = true;
            $response['message'] = __('Custom notification setting updated successfully', 'kiviCare-clinic-&-patient-management-system-pro');
        }else{
            $response['message'] = __('Invalid custom notification type', 'kiviCare-clinic-&-patient-management-system-pro');
        }
        return $response;
    }

    public function customNotificationSettingGet($response){
        $sms = get_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_sms_setting');
        $whatsapp = get_option( KIVI_CARE_PRO_PREFIX . 'custom_notification_whatsapp_setting');
        return [
            'enableSMS' => !empty($sms) && $sms === 'yes' ? 'yes' : 'no',
            'enableWhatsapp' => !empty($whatsapp) && $whatsapp === 'yes' ? 'yes' : 'no',
        ];
    }

    public function sendCustomNotificationRequest($request_data){
 
         $args = [];
 
         // Set headers if available in the configuration.
         if (!empty($request_data['headers'])) {
            foreach ($request_data['headers'] as $key => $value) {
                // $header = stripslashes($value);
                // $header = json_decode($value, true);
                $request_data['headers'][$key] = $value;
            }
            $header = collect($request_data['headers']);
            $args['headers'] = $header->pluck('value', 'key')->all();
        }
 
         // Perform the HTTP request based on the method (GET or POST).
         if ($request_data['method'] === 'GET') {
             $args = apply_filters('kcpro_custom_notification_api_args',$args);
             $response = wp_remote_get($request_data['url'], $args);
         } else {
             
             if (!empty($request_data['body'])) {
                //  $request_data['body'] = stripslashes($request_data['body']);
                 $args['body'] = json_decode($request_data['body'],true)??$request_data['body'];
             }
             $args = apply_filters('kcpro_custom_notification_api_args',$args);
             $response = wp_remote_post($request_data['url'], $args);
         }
 
         // Check for errors in the HTTP response.
         if (is_wp_error($response)) {
             $errorResponse = new \stdClass();
             $errorResponse->status = 'unsend';
             $errorResponse->error = __('HTTP Request Error: ', 'kiviCare-clinic-&-patient-management-system-pro').$response->get_error_message();
             return  $errorResponse;
         }
 
         // On success, return the success status and response body.
         $successResponse = new \stdClass();
         $successResponse->status = 'success';
         $successResponse->body = wp_remote_retrieve_body($response);

         // Apply a filter to allow modification of the success response.
         return (array)$successResponse;

    }

    /**
     * Send a custom notification.
     *
     * @param string $type Notification type.
     * @param string $receiverNo Receiver's phone number.
     * @param string $body Notification body.
     * @param mixed $data Additional data.
     *
     * @return \stdClass Success status and response body or error response.
     */
    public function sendCustomNotification($type, $receiverNo, $body, $data)
    {
        // Get the list of custom notification API configurations.
        $apiConfigurations = $this->customNotificationApiConfigurationList([], []);

        if (!is_string($body)) {
            $body = json_encode($body, JSON_UNESCAPED_UNICODE); // Convert arrays/objects to JSON string
        }
    
        // Clean up the string
        $body = html_entity_decode(strip_tags(str_replace("&nbsp;", '', $body)), ENT_NOQUOTES);
    
        // Validate if $body is a valid JSON string
        $is_body_json_format = is_string($body) && json_decode($body) !== null;

        // Check if the API list is empty or if the specified type is not found.
        if (empty($apiConfigurations['data']) ||
            !in_array($type, collect($apiConfigurations['data'])->pluck('type')->toArray())) {
            $errorResponse = new \stdClass();
            $errorResponse->status = 'unsend';
            $errorResponse->error = __('Configuration not found for ', 'kiviCare-clinic-&-patient-management-system-pro').$type;
            return apply_filters('kcpro_custom_notification_failed_response', $errorResponse,$type, $receiverNo, $body, $data);
        }

        // Prepare dynamic keys data.
        $dynamicKeysData = get_option(KIVI_CARE_PRO_PREFIX . 'custom_notification_dynamic_keys_update');
        $dynamicKeysData = !empty($dynamicKeysData) && is_array($dynamicKeysData) ? $dynamicKeysData : [];
        $dynamicKeysData = json_encode($dynamicKeysData);
        $dynamicKeysData = $is_body_json_format ? str_replace('[dynamic_receiver_number]', $receiverNo, $dynamicKeysData) :str_replace(['[dynamic_sms_body]', '[dynamic_receiver_number]'], [$body, $receiverNo], $dynamicKeysData);
        $dynamicKeysData = json_decode($dynamicKeysData, true);

        // Extract dynamic keys and values.
        $dynamicKeys = collect($dynamicKeysData)->pluck('key')->toArray();
        $dynamicValues = collect($dynamicKeysData)->pluck('value')->toArray();

        // Find the custom notification configuration for the specified type.
        $customNotificationConfig = collect($apiConfigurations['data'])->first(function ($config) use ($type) {
            return $config['type'] === $type;
        });

        // Replace dynamic keys with values in the configuration.
        $customNotificationConfig = json_encode($customNotificationConfig);
        $customNotificationConfig = json_decode(str_replace($dynamicKeys, $dynamicValues, $customNotificationConfig), true);

        $args = [];

        // Set headers if available in the configuration.
        if (!empty($customNotificationConfig['headers'])) {
            $header = collect($customNotificationConfig['headers']);
            $args['headers'] = $header->pluck('value', 'key')->all();
        }

        // Perform the HTTP request based on the method (GET or POST).
        if ($customNotificationConfig['method'] === 'GET') {
            $args = apply_filters('kcpro_custom_notification_api_args',$args);
            $response = wp_remote_get($customNotificationConfig['url'], $args);
        } else {
            if (!empty($customNotificationConfig['body'])) {
                $args['body'] = $body ;
            }
            $args = apply_filters('kcpro_custom_notification_api_args',$args);
            $response = wp_remote_post($customNotificationConfig['url'], $args);
        }

        // Check for errors in the HTTP response.
        if (is_wp_error($response)) {
            $errorResponse = new \stdClass();
            $errorResponse->status = 'unsend';
            $errorResponse->error = __('HTTP Request Error: ', 'kiviCare-clinic-&-patient-management-system-pro').$response->get_error_message();
            return apply_filters('kcpro_custom_notification_failed_response', $errorResponse,$type, $receiverNo, $body, $data);
        }

        // On success, return the success status and response body.
        $successResponse = new \stdClass();
        $successResponse->status = 'success';
        $successResponse->body = wp_remote_retrieve_body($response);
        // Apply a filter to allow modification of the success response.
        return apply_filters('kcpro_custom_notification_success_response', $successResponse,$type, $receiverNo, $body, $data);
    }
    public function refresh_dashboard_locale() {
        wp_send_json_success(kcAppendLanguageInHead(true));
    }

}