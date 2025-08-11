<?php

namespace ProApp\filters;

use App\models\KCAppointment;
use App\models\KCPatientEncounter;
use App\models\KCPatientReport;
use App\baseClasses\KCBase;
use DateTime;
use DateTimeZone;
use WP_User;

class KCProPatientReport extends KCBase
{

    public $db;
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;

        add_filter('kcpro_upload_patient_report', [$this, 'uploadPatientReport']);
        add_filter('kcpro_get_patient_report', [$this, 'getPatientReport']);
        add_filter('kcpro_view_patient_report', [$this, 'viewPatientReport']);
        add_filter('kcpro_delete_patient_report', [$this, 'deletePatientReport']);
        add_action('kcpro_edit_patient_report', [$this, 'editPatientReport']);
    }


    public function uploadPatientReport($formdata)
    { 
        $patient_report_table = new KCPatientReport;
        $formdata['upload_data']['name'] = esc_sql(trim($formdata['upload_data']['name']));
        $same_file_name_exists = $this->db->get_var("SELECT name FROM {$this->db->prefix}kc_patient_medical_report WHERE name='{$formdata['upload_data']['name']}'");
        if (!empty($same_file_name_exists)) {
            return [
                'status' => false,
                'data' => '',
                'message' => esc_html__('Same medical file name already exists,please enter different file name', 'kiviCare-clinic-&-patient-management-system-pro'),
            ];
        }

        $data = array(
            'name' => $formdata['upload_data']['name'],
            'patient_id' => $formdata['upload_data']['patient_id'],
            'date' => $formdata['upload_data']['date'],
            'upload_report' => $formdata['upload_data']['upload_report'],
        );
        $result = $patient_report_table->insert($data);
        if($result){
            return [
                'status' => true,
                'data'=> $formdata['upload_data']['patient_id'],
                'message' => esc_html__('Report Added Successfully', 'kiviCare-clinic-&-patient-management-system-pro'),
            ];
        }else{
            return [
                'status' => false,
                'data'=> $formdata['upload_data']['patient_id'],
                'message' => esc_html__('Report Not Added', 'kiviCare-clinic-&-patient-management-system-pro'),
            ];
        }
    }
    public function getPatientReport($data)
    {   
        if (!empty($data)) {
            $data['pid'] = (int)$data['pid'];
            if (!empty($data['report_id'])) {
                $reports = collect((new KCPatientReport())->get_by(['id' => (int)$data['report_id']]));
                return [
                    'data' => $reports,
                    'status' => true,
                ];
            }
            $reports = collect((new KCPatientReport())->get_by(['patient_id' => (int)$data['pid']]))->map(function ($v) {
                $v->date = !empty($v->date) ? date_format(date_create($v->date), "Y-m-d") :  $v->date;
                $v->medical_date = !empty($v->date) ? kcGetFormatedDate($v->date) :  $v->date;
                // Get the full path of the file
                $file_path = get_attached_file($v->upload_report);

                // Extract the file name from the path
                $file_name = basename($file_path);
                $v->report_file_name = $file_name ;
                $v->author = get_post_field( 'post_author', $v->upload_report );
                return $v;
            });
            return [
                'data' => $reports,
                'status' => true,
            ];
        } else {
            return [
                'data' => [],
                'status' => false,
            ];
        }
    }

    public function viewPatientReport($view) {
	    $upload_report = (new KCPatientReport())->get_var(['patient_id' => (int)$view['pid'], 'id' => (int)$view['docid']],'upload_report');
        
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($upload_report, $cipher, AUTH_KEY, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, AUTH_KEY, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

        $url = admin_url( 'admin-ajax.php' );
        $data = array(
            'action' => "kc_attachment" ,
            'key' => $ciphertext
        );
        $url .= '?' . http_build_query($data);
        return [
            'data' => $url,
            'status' => true,
        ];
    }

    public function deletePatientReport($data)
    {
        $report = new KCPatientReport();

        // Updated permission check block
        $current_user_id = get_current_user_id();
        $report_id = (int)$data['report_id'];
        $report_entry = $report->get_by(['id' => $report_id]);

        if (empty($report_entry)) {
            return [
                'status' => false,
                'message' => esc_html__('Report not found.', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }

        $report_patient_id = (int)$report_entry[0]->patient_id;
        $required_capability = KIVI_CARE_PRO_PREFIX . 'patient_report_delete';

        if ($report_patient_id !== $current_user_id && !current_user_can($required_capability)) {
            return [
                'status' => false,
                'message' => esc_html__('Unauthorized access to delete this report.', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
        // End: Updated permission check block

        if (isset($data['report_id'])) {

            $report->delete(['id' => (int)$data['report_id']]);
            return [
                'status' => true,
                'message' => esc_html__('Report Deleted Successfully', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        } else {
            return [
                'status' => false,
                'message' => esc_html__('Report not Deleted Successfully', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }
    public function editPatientReport($req_data)
    {
        $patient_report_table = new KCPatientReport();
        $req_data['name'] = esc_sql(trim($req_data['name']));
        
        $same_file_name_exists = $this->db->get_var("SELECT name FROM {$this->db->prefix}kc_patient_medical_report WHERE name='{$req_data['name']}' AND id != {$req_data['id']}");
        
        if (!empty($same_file_name_exists)) {
            wp_send_json_error(array(
                'status' => false,
                'message' => esc_html__('Same medical file name already exists,please enter different file name', 'kiviCare-clinic-&-patient-management-system-pro')
            ));
        }
        
        $dateTime = new DateTime($req_data['date']);

        // Format the DateTime object into PHP's default date format (Y-m-d H:i:s)
        $formattedDate = $dateTime->format('Y-m-d H:i:s');

        $result =  $patient_report_table->update(array('name' => sanitize_text_field($req_data['name']),  'date' =>$formattedDate), array('id' => $req_data['id']));

        if ($result !== false)
            wp_send_json_success(array(
                'status' => true,
                'message' => esc_html__('Report Update Successfully', 'kiviCare-clinic-&-patient-management-system-pro')
            ));


        wp_send_json_error([
            'status' => false,
            'message' => esc_html__('SomeThing Wents Wrongs', 'kiviCare-clinic-&-patient-management-system-pro'),
        ]);
    }
}
