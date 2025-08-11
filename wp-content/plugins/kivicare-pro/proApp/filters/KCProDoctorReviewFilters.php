<?php

namespace ProApp\filters;

use App\baseClasses\KCBase;
use App\models\KCUser;

class KCProDoctorReviewFilters extends KCBase{
    public $db;
    public function __construct() {
        global $wpdb;

        $this->db = $wpdb;

        add_filter('kcpro_calculate_doctor_review', [$this, 'calculateDoctorReview'],10,2);
        add_filter('kcpro_save_doctor_review', [$this, 'saveReview']);
        add_filter('kcpro_get_doctor_review', [$this, 'getReview']);
        add_filter('kcpro_get_doctor_review_detail', [$this, 'getDoctorReviewDetail']);
    }

    public function calculateDoctorReview($id,$type){
        $id = (int)$id;
        global $wpdb;
        $allReview = $wpdb->get_row($wpdb->prepare("SELECT sum(review) as total_review,count(*) as count FROM {$wpdb->prefix}kc_patient_review WHERE doctor_id=%d",$id));
        $max = 0;
        if(!empty($allReview->count)){
            $max = $allReview->total_review / $allReview->count;
        }
        if($type === 'list'){
            return [
                "star" => $max,
                'total_rating' => !empty($allReview->count) ? $allReview->count : 0
            ];
        }
        if($max > 0){
            ob_start();
            ?>
            <i class="kivi-star" data-star="<?php echo esc_html($max); ?>"></i>
            <?php
            return [ 'star' => ob_get_clean()] ;
        }
        return [
            "star" => '',
            'total_rating' => 0
        ];
    }

    public function getReview($request_data){

        $doctor_id = (int)$request_data["doctor_id"];
        $patient_id = (int)$request_data["patient_id"];

        $allAppointments = $this->db->get_row("SELECT * FROM {$this->db->prefix}kc_patient_review WHERE  patient_id={$patient_id} and doctor_id={$doctor_id}");

        if(!empty($allAppointments)){
           return [
               'data' => $allAppointments,
               'status'  => true,
               'message' => __('Data Founded','kiviCare-clinic-&-patient-management-system-pro')
           ];
        }else{
            return [
                'data' => [],
                'status'  => false,
                'message' => __('Date Not Found','kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function saveReview($request_data){

        $temp = [
            'review' => $request_data['star'],
            'patient_id' => $request_data['patient_id'],
            'doctor_id' => $request_data['doctor_id'],
            'updated_at' => current_time('Y-m-d H:i:s')
        ];
        if(!empty($request_data['description'])){
            $temp['review_description'] = $request_data['description'];
        }
        if(empty($request_data["id"])){
            $this->db->insert($this->db->prefix.'kc_patient_review',$temp);
        }else{
            $id = (int)$request_data["id"];
            $this->db->update($this->db->prefix.'kc_patient_review',$temp, array('id'=>$id));
        }

       return [
           'data' => [],
           'status'  => true,
           'message' => __('Thank you for your review','kiviCare-clinic-&-patient-management-system-pro')
       ];
    }

    public function getDoctorReviewDetail($data){
        $id = (int)$data['doctor_id'];
        if( !(new KCUser())->doctorPermissionUserWise($id)){
            wp_send_json(kcUnauthorizeAccessResponse(403));
        }
        global $wpdb;
        $allReview = collect($wpdb->get_results($wpdb->prepare("SELECT review.* ,us.display_name AS patient_name  FROM {$wpdb->prefix}kc_patient_review as review LEFT JOIN {$wpdb->prefix}users AS us ON us.ID=review.patient_id WHERE doctor_id=%d",$id)))->unique('patient_id');
        $max = 0;
        $totalCount = count($allReview);
        if(!empty($allReview) && $totalCount > 0){
            $totalReview = $allReview->sum('review');
            if(!empty($totalReview)){
                $max = $totalReview / $totalCount;
            }
        }
        foreach ($allReview as $key => $value) {
            $allReview[$key]->updated_at = kcGetFormatedDate($value->updated_at);
            $allReview[$key]->created_at = kcGetFormatedDate($value->created_at);
        }
        
        return [
            'status' => true,
            'data' => [
                "average_rating" => $max,
                'total_rating' => !empty($totalCount) ? $totalCount : 0,
                'detail' => $allReview->toArray()
            ],
            'message' => __('doctor review/rating details','kiviCare-clinic-&-patient-management-system-pro')
        ];
    }
}