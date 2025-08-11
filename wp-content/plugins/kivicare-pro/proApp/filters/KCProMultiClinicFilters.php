<?php 
namespace ProApp\filters ;
use App\baseClasses\KCBase; 
use App\models\KCClinic;
use App\models\KCDoctorClinicMapping;
use App\models\KCReceptionistClinicMapping;
use App\models\KCClinicSession;
use WP_User;

class KCProMultiClinicFilters extends KCBase {
    public $db;
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        add_filter('kcpro_save_clinic', [$this, 'saveClinicData']);
        add_filter('kcpro_edit_clinic', [$this, 'editClinicData']);
        add_filter('kcpro_get_all_clinic', [$this, 'getClinicList']);
        add_filter('kcpro_get_clinic_data', [$this, 'getClinicData']);
        add_filter('kcpro_clinic_session_list', [$this, 'getClinicSessionList']);
        parent::__construct();
    }
    public function saveClinicData($data) {

        $clinic = new KCClinic;

        if (empty($data['id'])) {

            $data['clinicData']['created_at'] = current_time('Y-m-d H:i:s');
            $clinic_id = $clinic->insert($data['clinicData']);
            $data['clinicAdminData']['username'] = kcGenerateUsername( $data['clinicAdminData']['first_name']) ;
            $data['clinicAdminData']['user_pass'] = !empty($data["password"]) ? $data["password"] : kcGenerateString(12);
            $user = wp_create_user( $data['clinicAdminData']['username'],  $data['clinicAdminData']['user_pass'],  $data['clinicAdminData']['user_email']);
            $u    = new WP_User( $user );
            $u->display_name =  $data['clinicAdminData']['first_name'] . ' ' .   $data['clinicAdminData']['last_name'];
            $u->set_role($this->getClinicAdminRole());
            wp_insert_user($u);
            if(!empty($user)) {
                $new_temp = [
                    'clinic_admin_id' => $user,
                    'created_at'=> current_time('Y-m-d H:i:s')
                ];
                $clinic->update($new_temp,array( 'id' => (int)$clinic_id ));
                $user_email_param =  kcCommonNotificationUserData($u->ID,$data['clinicAdminData']['user_pass']);
                kcSendEmail($user_email_param);
                $receiver_number = '+' . $data['clinicAdminData']['country_calling_code_admin'] . $data['clinicAdminData']['mobile_number'];
                if(kcCheckSmsOptionEnable() || kcCheckWhatsappOptionEnable()){
                    apply_filters('kcpro_send_sms', [
                        'type' => 'clinic_admin_registration',
                        'user_data' => $user_email_param,
                        'receiver_number' => $receiver_number
                    ]);
                }
            }
            update_user_meta( $user, 'first_name', $data['clinicAdminData']['first_name'] );
            update_user_meta( $user, 'last_name', $data['clinicAdminData']['last_name'] );
            update_user_meta( $user, 'basic_data', json_encode( $data['clinicAdminData'] ) );
            update_user_meta($user, 'country_calling_code', $data['clinicAdminData']['country_calling_code_admin']);
            update_user_meta($user, 'country_code', $data['clinicAdminData']['country_code_admin']);

            if(isset($data['clinicAdminData']['profile_image']) && !empty((int)$data['clinicAdminData']['profile_image'])) {
                update_user_meta( $user, 'clinic_admin_profile_image', $data['clinicAdminData']['profile_image'] );
            }
            do_action( 'kcpro_clinic_save', $clinic_id );
            return [
                'status' => true,
                'message' => esc_html__('Clinic has been saved successfully', 'kiviCare-clinic-&-patient-management-system-pro')
            ];

        }else{

            if(isset($data['clinicData']['profile_image']) && empty((int)$data['clinicData']['profile_image'])) {
                unset($data['clinicData']['profile_image']);
            }
            $clinic->update($data['clinicData'], array( 'id' => (int)$data['id'] ));
            $data['clinicAdminData']['ID'] = (int)$data['clinicAdminData']['ID'];

            wp_update_user(
                array(
                    'ID'         => $data['clinicAdminData']['ID'],
                    'user_email' => $data['clinicAdminData']['user_email'],
                    'display_name' =>  $data['clinicAdminData']['first_name'] . ' ' . $data['clinicAdminData']['last_name']
                )
            );

            update_user_meta( $data['clinicAdminData']['ID'], 'first_name', $data['clinicAdminData']['first_name'] );
            update_user_meta( $data['clinicAdminData']['ID'], 'last_name', $data['clinicAdminData']['last_name'] );
            update_user_meta( $data['clinicAdminData']['ID'], 'basic_data', json_encode( $data['clinicAdminData'] ) );
            update_user_meta($data['clinicAdminData']['ID'], 'country_calling_code', $data['clinicAdminData']['country_calling_code_admin']);
            update_user_meta($data['clinicAdminData']['ID'], 'country_code', $data['clinicAdminData']['country_code_admin']);
            
            if(isset($data['clinicAdminData']['profile_image']) && !empty((int)$data['clinicAdminData']['profile_image'])) {
                update_user_meta( $data['clinicAdminData']['ID'], 'clinic_admin_profile_image', $data['clinicAdminData']['profile_image'] );
            }

            $choose_language_updated = false;
         
            if($data['clinicAdminData']['choose_language']  !== get_user_locale() ||  $data['clinicAdminData']['choose_language']  !== get_locale()){
                $choose_language_updated= update_user_meta(get_current_user_id(), 'locale',$data['clinicAdminData']['choose_language'] );
            }
           
            do_action( 'kcpro_clinic_update', $data['id'] );

            return [
                'status' => true,
                'message' => esc_html__('Clinic has been updated successfully', 'kiviCare-clinic-&-patient-management-system-pro'),
                'choose_language_updated' => $choose_language_updated!=false
            ];
        }

    }
    public function editClinicData($data) {

        $id = (int)$data['clinic_id'];
        $clinic = new KCClinic;
        $results = $clinic->get_by(['id' => (int)$id], '=',true);

        if( !empty($results->clinic_admin_id) ){
            $clinicAdmin = WP_User::get_data_by('ID', (int)$results->clinic_admin_id);
            $fname = get_user_meta( (int)$clinicAdmin->ID, 'first_name',true );
            $lname=get_user_meta( (int)$clinicAdmin->ID, 'last_name',true);
            $basic_data = get_user_meta( (int)$clinicAdmin->ID, 'basic_data',true );
            $basic_data = json_decode($basic_data);
            $country_code = get_user_meta((int)$clinicAdmin->ID, 'country_code', true);
            $country_calling_code = get_user_meta((int)$clinicAdmin->ID, 'country_calling_code', true);
            $results->country_code = !empty($results->country_code) ? $results->country_code : '';
            $results->country_calling_code = !empty($results->country_calling_code) ? $results->country_calling_code : '';
            $results->specialties = !empty($results->specialties) ?  json_decode($results->specialties) : [];
            if(!empty($results->extra)) {
                $extra = json_decode($results->extra);
                $results->currency_prefix = !empty($extra->currency_prefix) && $extra->currency_prefix !== 'null' ? $extra->currency_prefix : '';
                $results->currency_postfix = !empty($extra->currency_postfix) && $extra->currency_postfix !== 'null' ? $extra->currency_postfix : '';
            }
            $results->first_name = !empty($fname) ? $fname : '';
            $results->last_name = !empty($lname) ? $lname : '';
            $results->user_email = $basic_data->user_email;
            $results->mobile_number = $basic_data->mobile_number;
            $results->dob =$basic_data->dob;
            $results->gender =$basic_data->gender;
            $results->clinic_profile = !empty($results->profile_image) ? wp_get_attachment_url($results->profile_image) : '';
            $results->profile_image = wp_get_attachment_url(get_user_meta((int)$results->clinic_admin_id, 'clinic_admin_profile_image', true));
            $results->country_calling_code_admin = !empty($country_calling_code) ? $country_calling_code : '';
            $results->country_code_admin = !empty($country_code) ? $country_code : '';

            $results->choose_language= get_user_locale();
       
            return [
                'status' => true,
                'message' => esc_html__('Clinic data', 'kiviCare-clinic-&-patient-management-system-pro'),
                'data' => $results
            ];
        }

        return [
            'status' => false,
            'message' => esc_html__('No data found', 'kiviCare-clinic-&-patient-management-system-pro'),
            'data' => []
        ];

    }
    public function getClinicList($clinic){
        $data = [];
        $clinics_table           = $this->db->prefix . 'kc_' . 'clinics';
        $table = $this->db->prefix . 'kc_' . 'doctor_clinic_mappings';
        if($this->getLoginUserRole() === 'kiviCare_doctor'){
            $user_id = get_current_user_id();
            $query = "SELECT clinic_id AS id,(SELECT name FROM {$clinics_table} WHERE id= doctor.clinic_id ) as name FROM {$table} as `doctor` 
            WHERE doctor_id =". (int)$user_id;

        }else if($this->getLoginUserRole() === 'kiviCare_patient'){
            $patienttable =  $this->db->prefix . 'kc_' . 'patient_clinic_mappings';
            $user_id = get_current_user_id();
            $clinicCount = $this->db->get_row('select clinic_id from '.$patienttable.' where patient_id='.$user_id);
            if($clinicCount != null){
                $query = "SELECT clinic_id AS id,(SELECT name FROM {$clinics_table} WHERE id= patient.clinic_id ) as name FROM {$patienttable} as patient 
                WHERE patient_id =". (int)$user_id;
            }else{
                $query = "SELECT * FROM {$clinics_table} WHERE status='1'";
            }
        }else{
            $query = "SELECT * FROM {$clinics_table} WHERE status='1'";
        }
        $clinicList = collect( $this->db->get_results( $query, OBJECT ) )->toArray();
        foreach ($clinicList as $clinic) {
            $data[] = [
                'id'    => $clinic->id,
                'label' => decodeSpecificSymbols($clinic->name)
            ];
        }
        return [
            'data'=> $data,
            'status' =>true,
        ];
        
    }
    public function getClinicData($data){
        $clinic_condition = ' ';
        if(!empty($data['data']['props_clinic_id']) && !in_array($data['data']['props_clinic_id'],['0',0]) ){
            $clinic_condition = " AND id={$data['data']['props_clinic_id']} ";
        }
        $clinics_table           = $this->db->prefix . 'kc_' . 'clinics';
        $query = "SELECT * FROM {$clinics_table} WHERE status='1' {$clinic_condition}";
        $clinicList = collect( $this->db->get_results( $query, OBJECT ) );
        $results = [];
        foreach($clinicList as $key=> $clinic){
            $results[$key]['id'] = $clinic->id;
            $results[$key]['name'] = decodeSpecificSymbols($clinic->name);
            $results[$key]['telephone_no'] = $clinic->telephone_no;
            $results[$key]['specialties'] = !empty($clinic->specialties) ? json_decode($clinic->specialties) : [] ;
            $results[$key]['address'] = $clinic->address;
            $results[$key]['city'] = $clinic->city;
            $results[$key]['postal_code'] = $clinic->postal_code;
            $results[$key]['country'] = $clinic->country;
            $results[$key]['profile_image'] = wp_get_attachment_url($clinic->profile_image);
        }
        return [
            'data'=> $results,
            'status' =>true,
        ];
    }

    public function getClinicSessionList($data){
        $clinic_sessios_table = $this->db->prefix.'kc_clinic_sessions';
        $user_table = $this->db->base_prefix .'users';
        $clinic_table = $this->db->prefix.'kc_clinics';
        $query = "SELECT {$clinic_sessios_table}.*,{$user_table}.display_name AS doctor_name,{$clinic_table}.name AS clinic_name FROM {$clinic_sessios_table} 
                  LEFT JOIN {$user_table} ON {$user_table}.ID = {$clinic_sessios_table}.doctor_id 
                  LEFT JOIN {$clinic_table} ON {$clinic_table}.id = {$clinic_sessios_table}.clinic_id ";
        switch ($this->getLoginUserRole()) {
            case $this->getDoctorRole():
                $where_condition = " AND {$clinic_sessios_table}.doctor_id=".get_current_user_id();
                break;
            case $this->getClinicAdminRole():
                $where_condition = " AND {$clinic_sessios_table}.clinic_id=".kcGetClinicIdOfClinicAdmin();
                break;
            case 'administrator':
                $where_condition = ' ';
                break;
            case $this->getReceptionistRole():
                $where_condition = " AND {$clinic_sessios_table}.clinic_id=".kcGetClinicIdOfReceptionist();
                break;
            default:
                $where_condition = " AND {$clinic_sessios_table}.clinic_id=".kcGetDefaultClinicId();
                break;
        }

        $clinic_sessions = $this->db->get_results("{$query} WHERE 0=0 AND {$user_table}.user_status=0 {$where_condition}");

        if (empty($clinic_sessions)) {
            return [
                'status' => false,
                'message' => esc_html__('No clinic session list found', 'kiviCare-clinic-&-patient-management-system-pro'),
                'data' => []
            ];
        }


        $clinic_sessions = kcClinicSession($clinic_sessions);

        return [
            'status' => true,
            'message' => esc_html__('Clinic session list', 'kiviCare-clinic-&-patient-management-system-pro'),
            'data' => $clinic_sessions
        ];
    }
}
