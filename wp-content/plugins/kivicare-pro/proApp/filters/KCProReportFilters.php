<?php

namespace ProApp\filters;
use App\baseClasses\KCBase;
use App\models\KCClinic;
use DateTime;
use function Clue\StreamFilter\fun;

class KCProReportFilters extends KCBase
{
    public $db;
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        add_filter('kcpro_doctor_revenue', [$this, 'doctorRevenue']);
        add_filter('kcpro_get_clinic_revenue', [$this, 'getClinicRevenue']);
        add_filter('kcpro_get_clinic_bar_chart', [$this, 'getClinicBarChart']);
        add_filter('kcpro_appointment_count', [$this, 'getAppointmentCount']);
        add_filter('kcpro_clinic_appointment_count', [$this, 'getClinicAppointmentCount']);

    }

    public function  getClinicRevenue($request_data){
        global $wpdb;
        $data   = array();

        $getallClinic = collect((new KCClinic())->get_all());
        $bill_table = $wpdb->prefix . 'kc_' . 'bills';
        $encounter_table = $wpdb->prefix .'kc_patient_encounters';
        $clinic_table = $wpdb->prefix .'kc_clinics';

        if($this->getLoginUserRole() === $this->getClinicAdminRole()){
            $getallClinic = $getallClinic->where('clinic_admin_id',get_current_user_id());
        }
        if(!empty($request_data['clinic_id'])){
            $request_data['clinic_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['clinic_id']),true));
        }
        if(!empty($request_data['filter_id'])){
            $request_data['filter_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['filter_id']),true));
        }
        if(isset($request_data['clinic_id']['id']) && $request_data['clinic_id']['id'] != 'all'){
            $request_data['clinic_id']['id'] = (int)$request_data['clinic_id']['id'];
            $getallClinic = $getallClinic->where('id',$request_data['clinic_id']['id']);
        }

        $doctor_where_condition = ' ';
        if(isset($request_data['doctor_id']) ){
            $request_data['doctor_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['doctor_id']),true));
            if($request_data['doctor_id']['id'] != 'all'){
                $select_doctor_id = (int)$request_data['doctor_id']['id'];
                if(!empty($select_doctor_id)){
                    $doctor_where_condition = " AND p_encounter.doctor_id = {$select_doctor_id} ";
                }
            }
        }

        $patient_condition = !empty($request_data['patient_id']) ? " AND p_encounter.patient_id=".(int)$request_data['patient_id']." " : " ";


        $all_clinic_id = collect($getallClinic)->pluck('id')->implode(',');
        $common_query = "SELECT SUM(bill.actual_amount) AS total_revenue ,clinic.name FROM {$bill_table} AS bill
                        LEFT JOIN {$encounter_table} AS p_encounter ON p_encounter.id = bill.encounter_id
                        INNER JOIN {$clinic_table} AS clinic ON clinic.id = p_encounter.clinic_id
                        WHERE bill.payment_status = 'paid' {$patient_condition} AND   p_encounter.clinic_id IN ({$all_clinic_id}) {$doctor_where_condition} ";

        if(!empty(get_option(KIVI_CARE_PREFIX.'reset_revenue'))){
            $reset_revenue_date = get_option(KIVI_CARE_PREFIX.'reset_revenue');
            $common_query .= "AND bill.created_at > '{$reset_revenue_date}'";
        }
        $group_by = " GROUP BY p_encounter.clinic_id";
        $date = [] ;
        $revenue = [] ;
        $labels = [];
        switch ($request_data['filter_id']['id']) {
            case 'weekly':

                $all_weeks = kcGetAllWeeks(date('Y'));

                if($request_data['sub_type'] == ''){
                    $request_data['sub_type'] = date('W');
                }

                $month_id = (new DateTime())->setISODate(date('y'), $request_data['sub_type'])->format('m');

                if(!empty($all_weeks[$month_id][$request_data['sub_type']])) {
                    $get_dates  = $all_weeks[$month_id][$request_data['sub_type']];
                    $week_start = $get_dates['week_start'];
                    $week_end   = $get_dates['week_end'];
                    $bill = $common_query."  AND (bill.created_at BETWEEN '{$week_start}' AND '{$week_end}' OR bill.created_at LIKE '%{$week_start}%' OR bill.created_at LIKE '%{$week_end}%') ".$group_by ;
                    $results = $wpdb->get_results($bill);
                    $data   = collect($results)->pluck('total_revenue')->map(function($v){return (float)$v;})->toArray();
                    $labels = collect($results)->pluck('name')->toArray();

                }

                break;
            case 'monthly':

                $month = ($request_data['sub_type'] == '') ? date('m') : $request_data['sub_type'];
                $year  = date('Y');
                $bill     = $common_query."  AND MONTH(bill.created_at) = {$month} AND YEAR(bill.created_at) = {$year} ".$group_by ;
                $results  = $wpdb->get_results($bill);
                $data   = collect($results)->pluck('total_revenue')->map(function($v){return (float)$v;})->toArray();
                $labels = collect($results)->pluck('name')->toArray();

                break;
            case 'yearly':

                $year = ($request_data['sub_type'] == '') ? date('Y') : $request_data['sub_type'];
                $bill     = $common_query."  AND YEAR(bill.created_at) = {$year} " .$group_by;
                $results  = $wpdb->get_results($bill);
                $data   = collect($results)->pluck('total_revenue')->map(function($v){return (float)$v;})->toArray();
                $labels = collect($results)->pluck('name')->toArray();
                break;

            default:
                # code...
                break;
        }

        return [
            'status'  => true,
            'data' => $data,
            'labels' => $labels,
            'message' => esc_html__('Clinic Revenue', 'kiviCare-clinic-&-patient-management-system-pro'),
        ];
    }
    public function getClinicBarChart($request_data){
        global $wpdb;
        $bill_table = $wpdb->prefix . 'kc_' . 'bills';
        $getallClinic = collect((new KCClinic())->get_all());

        if($this->getLoginUserRole() === $this->getClinicAdminRole()){
            $getallClinic = $getallClinic->where('clinic_admin_id',get_current_user_id());
        }
        if(!empty($request_data['clinic_id'])){
            $request_data['clinic_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['clinic_id']),true));
        }
        if(!empty($request_data['filter_id'])){
            $request_data['filter_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['filter_id']),true));
        }
        if(isset($request_data['clinic_id']['id']) && $request_data['clinic_id']['id'] != 'all'){
            $request_data['clinic_id']['id'] = (int)$request_data['clinic_id']['id'];
            $getallClinic = $getallClinic->where('id',$request_data['clinic_id']['id']);
        }

        $doctor_where_condition = ' ';
        if(isset($request_data['doctor_id']) ){
            $request_data['doctor_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['doctor_id']),true));
            if($request_data['doctor_id']['id'] != 'all'){
                $select_doctor_id = (int)$request_data['doctor_id']['id'];
                if(!empty($select_doctor_id)){
                    $doctor_where_condition = " AND p_encounter.doctor_id = {$select_doctor_id} ";
                }
            }
        }
        $patient_condition = !empty($request_data['patient_id']) ? " AND p_encounter.patient_id=".(int)$request_data['patient_id']." " : " ";

        $getallClinic = $getallClinic->toArray();
        $getallClinic = array_values($getallClinic);
        $encounter_table = $wpdb->prefix .'kc_patient_encounters';
        $clinic_table = $wpdb->prefix .'kc_clinics';
        $common_query = "SELECT SUM(bill.actual_amount) AS total_revenue  FROM {$bill_table} AS bill
                        LEFT JOIN {$encounter_table} AS p_encounter ON p_encounter.id = bill.encounter_id
                        INNER JOIN {$clinic_table} AS clinic ON clinic.id = p_encounter.clinic_id
                        WHERE bill.payment_status = 'paid' {$doctor_where_condition} {$patient_condition}";

        if(!empty(get_option(KIVI_CARE_PREFIX.'reset_revenue'))){
            $reset_revenue_date = get_option(KIVI_CARE_PREFIX.'reset_revenue');
            $common_query .= "AND bill.created_at > '{$reset_revenue_date}'";
        }

        $date = [] ;
        $revenue = [] ;

        switch ( $request_data['filter_id']['id']) {
            case 'weekly':
                $all_weeks = kcGetAllWeeks(date('Y'));

                if($request_data['sub_type'] == ''){
                    $request_data['sub_type'] = date('W');
                }

                $month_id = (new DateTime())->setISODate(date('Y'), $request_data['sub_type'])->format('m');

                if(!empty($all_weeks[$month_id][$request_data['sub_type']])) {
                    $get_dates = $all_weeks[$month_id][$request_data['sub_type']];
                    $week_start = new DateTime($get_dates['week_start']);
                    $week_end = new DateTime($get_dates['week_end']);
            
                    foreach ($getallClinic as $key => $clinic) {
                        $data = [];
                        $current_date = clone $week_start; // Clone the start date to prevent modification of the original object

                        while ($current_date <= $week_end) {
                            if ($key == 0) {
                                $date[] = $current_date->format(get_option('date_format'));
                            }
                            $results = $wpdb->get_var($common_query . " AND p_encounter.clinic_id = {$clinic->id} AND bill.created_at LIKE '%" . $current_date->format('Y-m-d') . "%'");
                            $data[] = !empty($results) ? (float) $results : 0;
                            $current_date->modify('+1 day'); // Increment the current date by 1 day
                        }
                        $revenue[] = [
                            "name" => $clinic->name,
                            "data" => $data
                        ];
                    }

                } else {
                    $revenue[] = [
                        "name" => '',
                        "data" => 0
                    ];
                }

                break;
            case 'monthly':
                $month = ($request_data['sub_type'] == '') ? date('m') : $request_data['sub_type'] ;
                $weeks =kcMonthsWeeksArray($month);
                foreach($getallClinic as $key => $clinic) {
                    $data = [];
                    if(!empty($weeks) && count($weeks) > 0){
                        foreach ($weeks as $wKeys => $wValue){
                            $weekFirstDay = current($wValue);
                            $weekLastDay = end($wValue);
                            if($key == 0){
                                $date[]= [date(get_option('date_format'),strtotime($weekFirstDay)), ' to ', date(get_option('date_format'),strtotime($weekLastDay))];
                            }

                            $bill = $common_query." AND p_encounter.clinic_id ={$clinic->id}  AND (bill.created_at BETWEEN '{$weekFirstDay}' AND '{$weekLastDay}' OR bill.created_at LIKE '%{$weekFirstDay}%' OR bill.created_at LIKE '%{$weekLastDay}%')";
                            $results = $wpdb->get_var($bill);
                            $data[] = !empty($results) ?  (float)$results : 0;
                        }
                    }
                    $revenue[] = [
                        "name" => $clinic->name,
                        "data" => $data
                    ];
                }

                break;
            case 'yearly':

                $year = ($request_data['sub_type'] == '') ? date('Y') : $request_data['sub_type'];
                $get_all_month = kcGetAllMonth($year);

                foreach($getallClinic as $key => $clinic) {
                    $data = [];
                    foreach ($get_all_month as $m_key => $m)
                    {
                        if($key == 0){
                            $date[]= $m;
                        }

                        $bill = $common_query. " AND p_encounter.clinic_id ={$clinic->id} AND YEAR(bill.created_at) = {$year} AND MONTH(bill.created_at) = {$m_key}";
                        $results = $wpdb->get_var($bill);
                        $data[] = !empty($results) ?  (float)$results : 0;
                    }
                    $revenue[] = [
                        "name" => $clinic->name,
                        "data" => $data
                    ];
                }
                break;

            default:
                $date = [] ;
                $revenue = [] ;
                break;
        }

        $revenue = array_map(function ($v){
            if(isset($v['data']) && is_array($v['data'])){
                if($this->arrayContainsOnlyEmptyNullValue($v['data'])){
                    $v['data'] = [];
                }
            }
            return $v;
        },$revenue);

        return [
            'status'  => true,
            'date'=> $date,
            'data'=> !empty($revenue[0]['name']) ? $revenue : [],
            'message' => esc_html__('Clinic Revenue', 'kiviCare-clinic-&-patient-management-system-pro'),
        ];
    }

    public function doctorRevenue($request_data){
        global $wpdb;
        $doctor_clinic_mappings = $wpdb->prefix . 'kc_' . 'doctor_clinic_mappings';
        $bill_table = $wpdb->prefix . 'kc_' . 'bills';
        $revenue_data   = array();
        $date           = array();


        $current_user_role = $this->getLoginUserRole();
        $clinic_condition = ' ';
        if(!empty($request_data['clinic_id'])){
            $request_data['clinic_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['clinic_id']),true));
        }
        if(!empty($request_data['filter_id'])){
            $request_data['filter_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['filter_id']),true));
        }

        $select_doctor_id = '';
        if(isset($request_data['doctor_id']) ){
            $request_data['doctor_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['doctor_id']),true));
            if($request_data['doctor_id']['id'] != 'all'){
                $select_doctor_id = (int)$request_data['doctor_id']['id'];
            }
        }

        if(isset($request_data['clinic_id']['id']) && $request_data['clinic_id']['id'] != 'all'){
            $request_data['clinic_id']['id'] = (int)$request_data['clinic_id']['id'];
            $get_clnic_doctor = "SELECT doctor_id FROM {$doctor_clinic_mappings} WHERE clinic_id=".$request_data['clinic_id']['id'];
            $results          = collect($wpdb->get_results($get_clnic_doctor))->pluck('doctor_id')->toArray();
            $doctors      = collect(get_users(['role' => $this->getDoctorRole(),'user_status' => '0','fields' => ['display_name','ID'],'include' => !empty($results) ? $results : [-1]]))->toArray();
        }else{
            if($current_user_role === $this->getClinicAdminRole()){
                $clinic_admin_clinic_id = kcGetClinicIdOfClinicAdmin();
                $get_clnic_doctor = "SELECT doctor_id FROM {$doctor_clinic_mappings} WHERE clinic_id={$clinic_admin_clinic_id}";
                $results          = collect($wpdb->get_results($get_clnic_doctor))->pluck('doctor_id')->toArray();
                $doctors      = collect(get_users(['role' => $this->getDoctorRole(),'user_status' => '0','include' => !empty($results) ? $results : [-1]]))->toArray();
                $clinic_condition = " petab.clinic_id={$clinic_admin_clinic_id} AND " ;
            }else{
                $doctors    = collect(get_users([
                    'role' => $this->getDoctorRole(),
                    'user_status' => '0',
                    'fields' => ['display_name','ID']
                ]))->toArray();
            }
        }

        $patient_condition = !empty($request_data['patient_id']) ? " AND petab.patient_id=".(int)$request_data['patient_id']." " : " ";

        if(!empty($select_doctor_id)){
            $doctors = [];
            $doctors[] = (object)[
                'display_name' => $request_data['doctor_id']['label'],
                'ID' => $select_doctor_id
            ];
        }
        switch ( $request_data['filter_id']['id']) {
            case 'weekly':
                $all_weeks = kcGetAllWeeks(date('Y'));

                if($request_data['sub_type'] == ''){
                    $request_data['sub_type'] = date('W');
                }

                $month_id = (new DateTime())->setISODate(date('Y'), $request_data['sub_type'])->format('m');

                if(!empty($all_weeks[$month_id][$request_data['sub_type']])) {
                    $get_dates = $all_weeks[$month_id][$request_data['sub_type']];
                    $week_start = new DateTime($get_dates['week_start']);
                    $week_end = new DateTime($get_dates['week_end']);

                    foreach ($doctors as $key => $value) {
                        $doctor_revenue = [];

                        $current_date = clone $week_start; // Clone the start date to prevent modification of the original object

                        while ($current_date <= $week_end) {
                            if ($key == 0) {
                                $date[] = $current_date->format(get_option('date_format'));
                            }
            
                            $items = "SELECT SUM(btab.actual_amount) AS total_revenue FROM {$bill_table} AS btab JOIN {$this->db->prefix}kc_patient_encounters AS petab ON petab.id = btab.encounter_id
                                 WHERE payment_status = 'paid' {$patient_condition} AND petab.doctor_id = {$value->ID} AND {$clinic_condition} btab.created_at LIKE '%" . $current_date->format('Y-m-d') . "%'";
            
                            $data = $wpdb->get_var($items);
                            $doctor_revenue[] = !empty($data) ? (float)$data : 0;

                            $current_date->modify('+1 day'); // Increment the current date by 1 day
                        }

                        $revenue_data[] = [
                            "name" => $value->display_name,
                            "data" => $doctor_revenue,
                        ];
                    }
                } else {
                    $revenue_data[] = [
                        "name" => '',
                        "data" => 0,
                    ];
                }
                break;
            case 'monthly':

                $month = ($request_data['sub_type'] == '') ? date('m') : $request_data['sub_type'] ;
                $weeks =kcMonthsWeeksArray($month);
                foreach($doctors as $key =>  $value){
                    $doctor_revenue = [];
                    if(!empty($weeks) && count($weeks) > 0){
                        foreach ($weeks as $wKeys => $wValue)
                        {
                            $weekFirstDay = current($wValue);
                            $weekLastDay = end($wValue);
                            if($key == 0){
                                $date[]= [date(get_option('date_format'),strtotime($weekFirstDay)), ' to ', date(get_option('date_format'),strtotime($weekLastDay))];
                            }
                            if(!empty(get_option(KIVI_CARE_PREFIX.'reset_revenue'))){
                                $reset_revenue_date = get_option(KIVI_CARE_PREFIX.'reset_revenue');
                                $items ="SELECT SUM(btab.actual_amount) AS total_revenue FROM {$bill_table} AS btab JOIN {$this->db->prefix}kc_patient_encounters AS petab ON petab.id = btab.encounter_id
                                     WHERE payment_status = 'paid' {$patient_condition} AND petab.doctor_id = {$value->ID} AND {$clinic_condition} (btab.created_at BETWEEN '{$weekFirstDay}' AND '{$weekLastDay}' 
                                     OR btab.created_at LIKE '%{$weekFirstDay}%' OR btab.created_at  LIKE  '%{$weekLastDay}%') AND btab.created_at > '{$reset_revenue_date}'";
                            }else{
                                $items ="SELECT SUM(btab.actual_amount) AS total_revenue FROM {$bill_table} AS btab JOIN {$this->db->prefix}kc_patient_encounters AS petab ON petab.id = btab.encounter_id
                                     WHERE payment_status = 'paid' {$patient_condition} AND petab.doctor_id = {$value->ID} AND {$clinic_condition} (btab.created_at BETWEEN '{$weekFirstDay}' AND '{$weekLastDay}' 
                                     OR btab.created_at LIKE '%{$weekFirstDay}%' OR btab.created_at  LIKE  '%{$weekLastDay}%')";
                            }
                            $data = $wpdb->get_var($items);
                            $doctor_revenue[] = !empty($data) ? (float)$data : 0;
                        }
                    }

                    $revenue_data[] = [
                        "name" =>  $value->display_name,
                        "data" => $doctor_revenue,
                    ];
                }

                break;

            case 'yearly':

                $year = ($request_data['sub_type'] == '') ? date('Y') : $request_data['sub_type'];
                $get_all_month = kcGetAllMonth($year);

                foreach($doctors as $key =>  $value){
                    $doctor_revenue = [];
                    foreach ($get_all_month as $m_key => $m)
                    {
                        if($key == 0){
                            $date[]= $m;
                        }
                        if(!empty(get_option(KIVI_CARE_PREFIX.'reset_revenue'))){
                            $reset_revenue_date = get_option(KIVI_CARE_PREFIX.'reset_revenue');
                            $items = "SELECT SUM(btab.actual_amount) AS total_revenue FROM {$bill_table} AS btab JOIN {$this->db->prefix}kc_patient_encounters AS petab ON petab.id = btab.encounter_id
                                     WHERE payment_status = 'paid' {$patient_condition} AND petab.doctor_id = {$value->ID} AND {$clinic_condition} YEAR(btab.created_at) = {$year} AND MONTH(btab.created_at) = {$m_key} AND btab.created_at > '{$reset_revenue_date}'";
                        }else{
                            $items = "SELECT SUM(btab.actual_amount) AS total_revenue FROM {$bill_table} AS btab JOIN {$this->db->prefix}kc_patient_encounters AS petab ON petab.id = btab.encounter_id
                                     WHERE payment_status = 'paid' {$patient_condition} AND petab.doctor_id = {$value->ID} AND {$clinic_condition} YEAR(btab.created_at) = {$year} AND MONTH(btab.created_at) = {$m_key}";
                        }
                        $data = $wpdb->get_var($items);
                        $doctor_revenue[] = !empty($data) ? (float)$data : 0;
                    }

                    $revenue_data[] = [
                        "name" =>  $value->display_name,
                        "data" => $doctor_revenue,
                    ];
                }

                break;

            default:
                # code...
                break;
        }

        $revenue_data = array_map(function ($v){
            if(isset($v['data']) && is_array($v['data'])){
                if($this->arrayContainsOnlyEmptyNullValue($v['data'])){
                    $v['data'] = [];
                }
            }
            return $v;
        },$revenue_data);


        return [
            'status'  => true,
            'data'    => !empty($revenue_data[0]['name']) ? $revenue_data : [],
            'date'    => $date,
            'message' => esc_html__('Clinic Revenue', 'kiviCare-clinic-&-patient-management-system-pro'),
        ];
    }

    public function getAppointmentCount($request_data){
        global $wpdb;
        $revenue_data   = array();
        $date           = array();

        $current_user_role = $this->getLoginUserRole();
        $clinic_condition = $appointment_status_condition =  ' ';
        if(!empty($request_data['clinic_id'])){
            $request_data['clinic_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['clinic_id']),true));
        }
        if(!empty($request_data['filter_id'])){
            $request_data['filter_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['filter_id']),true));
        }

        if(!empty($request_data['appointment_status_doctor']) && $request_data['appointment_status_doctor'] !== 'all'){
            $request_data['appointment_status_doctor'] = $request_data['appointment_status_doctor'] === 'cancel' ? '0' : $request_data['appointment_status_doctor'];
            $appointment_status_condition = " AND status={$request_data['appointment_status_doctor']} ";
        }

        if(isset($request_data['clinic_id']['id']) && $request_data['clinic_id']['id'] != 'all'){
            $request_data['clinic_id']['id'] = (int)$request_data['clinic_id']['id'];
            $clinic_condition = " AND clinic_id={$request_data['clinic_id']['id']}" ;
        }else if($current_user_role === $this->getClinicAdminRole()){
            $clinic_admin_clinic_id = kcGetClinicIdOfClinicAdmin();
            $clinic_condition = " AND clinic_id={$clinic_admin_clinic_id}  " ;
        }

        $arr = [
            'role' => $this->getDoctorRole(),
            'user_status' => '0',
            'fields' => ['display_name','ID']
        ];

        if(isset($request_data['doctor_id']) ){
            $request_data['doctor_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['doctor_id']),true));
            if($request_data['doctor_id']['id'] != 'all'){
                $arr['include'] = [(int)$request_data['doctor_id']['id']];
            }
        }

        $patient_condition = !empty($request_data['patient_id']) ? " AND patient_id=".(int)$request_data['patient_id']." " : " ";

        $doctors    = collect(get_users($arr))->toArray();

        switch ( $request_data['filter_id']['id']) {
            case 'weekly':
                $all_weeks = kcGetAllWeeks(date('Y'));

                if($request_data['sub_type'] == ''){
                    $request_data['sub_type'] = date('W');
                }

                $month_id = (new DateTime())->setISODate(date('Y'), $request_data['sub_type'])->format('m');

                if(!empty($all_weeks[$month_id][$request_data['sub_type']])) {
                    $get_dates = $all_weeks[$month_id][$request_data['sub_type']];
                    $week_start = new DateTime($get_dates['week_start']);
                    $week_end = new DateTime($get_dates['week_end']);

                    foreach ($doctors as $key => $value) {
                        $doctor_revenue = [];
                        $doctorId = !empty($select_doctor_id) && $select_doctor_id != 0 ? $select_doctor_id : $value->id;
                        $current_date = clone $week_start; // Clone the start date to prevent modification of the original object

                        while ($current_date <= $week_end) {
                            if ($key == 0) {
                                $date[] = $current_date->format(get_option('date_format'));
                            }
                            $items = $wpdb->prepare(
                                "SELECT COUNT(*) AS appointmentCount FROM {$wpdb->prefix}kc_appointments
                                WHERE (appointment_start_date LIKE %s) {$clinic_condition} {$patient_condition} {$appointment_status_condition} AND doctor_id = %d
                                GROUP BY doctor_id",
                                '%' . $current_date->format('Y-m-d') . '%',
                                $doctorId
                            );
                            $data = $wpdb->get_var($items);
                            $doctor_revenue[] = !empty($data) ? $data : 0;
                            $current_date->modify('+1 day'); // Increment the current date by 1 day
                        }

                        $revenue_data[] = [
                            "name" => $value->display_name,
                            "data" => $doctor_revenue,
                        ];
                    }
                } else {
                    $revenue_data[] = [
                        "name" => '',
                        "data" => 0,
                    ];
                }
                break;
            case 'monthly':
                $month = ($request_data['sub_type'] == '') ? date('m') : $request_data['sub_type'] ;
                $weeks =kcMonthsWeeksArray($month);
                foreach($doctors as $key =>  $value){
                    $doctorId = !empty($select_doctor_id) && $select_doctor_id != 0 ? $select_doctor_id : $value->id;
                    $doctor_revenue = [];

                    if(!empty($weeks) && count($weeks) > 0){
                        foreach ($weeks as $wKeys => $wValue)
                        {
                            $weekFirstDay = current($wValue);
                            $weekLastDay = end($wValue);

                            if($key == 0){
                                $date[]= [date(get_option('date_format'),strtotime($weekFirstDay)), ' to ', date(get_option('date_format'),strtotime($weekLastDay))];
                            }
                            $items ="SELECT COUNT(*) AS appointmentCount FROM {$wpdb->prefix}kc_appointments
                                    WHERE (appointment_start_date BETWEEN '{$weekFirstDay}' AND '{$weekLastDay}') {$patient_condition} {$clinic_condition} {$appointment_status_condition} AND doctor_id = {$doctorId} GROUP BY doctor_id";
                            $data = $wpdb->get_var($items);
                            $doctor_revenue[] = !empty($data)  ? $data : 0;
                        }
                        $revenue_data[] = [
                            "name" =>  $value->display_name,
                            "data" => $doctor_revenue,
                        ];
                    }

                }
                break;
            case 'yearly':

                $year = ($request_data['sub_type'] == '') ? date('Y') : $request_data['sub_type'];
                $get_all_month = kcGetAllMonth($year);

                foreach($doctors as $key =>  $value){
                    $doctorId = !empty($select_doctor_id) && $select_doctor_id != 0 ? $select_doctor_id : $value->id;
                    $doctor_revenue = [];
                    foreach ($get_all_month as $m_key => $m)
                    {
                        if($key == 0){
                            $date[]= $m;
                        }
                        $items ="SELECT COUNT(*) AS appointmentCount FROM {$wpdb->prefix}kc_appointments
                                    WHERE YEAR(appointment_start_date) = {$year} AND MONTH(appointment_start_date) = {$m_key} {$patient_condition} {$clinic_condition} {$appointment_status_condition} AND doctor_id={$doctorId}";
                        $data = $wpdb->get_var($items);
                        $doctor_revenue[] = !empty($data) ? $data : 0;
                    }

                    $revenue_data[] = [
                        "name" =>  $value->display_name,
                        "data" => $doctor_revenue,
                    ];
                }

                break;
        }

        $revenue_data = array_map(function ($v){
            if(isset($v['data']) && is_array($v['data'])){
                if($this->arrayContainsOnlyEmptyNullValue($v['data'])){
                    $v['data'] = [];
                }
            }
            return $v;
        },$revenue_data);

        return [
            'status'  => true,
            'data'    => !empty($revenue_data[0]['name']) ? $revenue_data : [],
            'date'    => $date,
            'message' => esc_html__('appointment Count', 'kiviCare-clinic-&-patient-management-system-pro'),
        ];
    }

    public function getClinicAppointmentCount($request_data){
        global $wpdb;
        $revenue_data   = array();
        $date           = array();

        $current_user_role = $this->getLoginUserRole();
        $clinic_condition = $appointment_status_condition = $doctor_condition = ' ';
        if(!empty($request_data['clinic_id'])){
            $request_data['clinic_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['clinic_id']),true));
        }
        if(!empty($request_data['filter_id'])){
            $request_data['filter_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['filter_id']),true));
        }

        if(!empty($request_data['appointment_status_clinic']) && $request_data['appointment_status_clinic'] !== 'all'){
            $request_data['appointment_status_clinic'] = $request_data['appointment_status_clinic'] === 'cancel' ? '0' : $request_data['appointment_status_clinic'];
            $appointment_status_condition = " AND status={$request_data['appointment_status_clinic']} ";
        }

        if(isset($request_data['clinic_id']['id']) && $request_data['clinic_id']['id'] != 'all'){
            $request_data['clinic_id']['id'] = (int)$request_data['clinic_id']['id'];
            $clinic_condition = " AND clinic_id={$request_data['clinic_id']['id']} " ;
        }else if($current_user_role === $this->getClinicAdminRole()){
            $clinic_admin_clinic_id = kcGetClinicIdOfClinicAdmin();
            $clinic_condition = " AND clinic_id={$clinic_admin_clinic_id}  " ;
        }

        if(isset($request_data['doctor_id']) ){
            $request_data['doctor_id'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['doctor_id']),true));
            if($request_data['doctor_id']['id'] != 'all'){
                $doctor_condition = " AND doctor_id={$request_data['doctor_id']['id']}  ";
            }
        }

        $patient_condition = !empty($request_data['patient_id']) ? " AND patient_id=".(int)$request_data['patient_id']." " : " ";
        $report_conditions = '';
        if ($current_user_role === $this->getClinicAdminRole()) {  
            $report_conditions = "AND id = {$clinic_admin_clinic_id}";
        } 
        $query = "SELECT name as clinic_name, id as clinic_id FROM {$wpdb->prefix}kc_clinics WHERE status = 1 {$report_conditions}";
        $clinicList = $this->db->get_results($query, ARRAY_A);
        switch ( $request_data['filter_id']['id']) {
            case 'weekly':
                $all_weeks = kcGetAllWeeks(date('Y'));

                if($request_data['sub_type'] == ''){
                    $request_data['sub_type'] = date('W');
                }

                $month_id = (new DateTime())->setISODate(date('Y'), $request_data['sub_type'])->format('m');
            
                if (!empty($all_weeks[$month_id][$request_data['sub_type']])) {
                    $get_dates = $all_weeks[$month_id][$request_data['sub_type']];
                    $week_start = new DateTime($get_dates['week_start']);
                    $week_end = new DateTime($get_dates['week_end']);
            
                    foreach ($clinicList as $key => $value) {
                        $clinic_revenue = [];
                        $clinicId = $value['clinic_id'];
                        $current_date = clone $week_start; // Clone the start date to prevent modification of the original object

                        while ($current_date <= $week_end) {
                            if($key == 0){
                                $date[] = $current_date->format(get_option('date_format'));
                            }
                            $items = $wpdb->prepare(
                                "SELECT COUNT(*) AS appointmentCount FROM {$wpdb->prefix}kc_appointments
                                WHERE (appointment_start_date LIKE %s) {$clinic_condition} {$patient_condition} {$doctor_condition} {$appointment_status_condition} AND clinic_id = %d
                                GROUP BY clinic_id",
                                '%' . $current_date->format('Y-m-d') . '%',
                                $clinicId
                            );
                            $data = $wpdb->get_var($items);
                            $clinic_revenue[] = !empty($data) ? $data : 0;
                            $current_date->modify('+1 day'); // Increment the current date by 1 day
                        }

                        $revenue_data[] = [
                            "name" => !empty($value['clinic_name']) ? $value['clinic_name'] : '',
                            "data" => $clinic_revenue,
                        ];
                    }
                } else {
                    $revenue_data[] = [
                        "name" => '',
                        "data" => 0,
                    ];
                }
                break;
            case 'monthly':
                $month = ($request_data['sub_type'] == '') ? date('m') : $request_data['sub_type'] ;
                $weeks =kcMonthsWeeksArray($month);
                foreach($clinicList as $key =>  $value){
                    $clinicId = $value['clinic_id'];
                    $clinic_revenue = [];

                    if(!empty($weeks) && count($weeks) > 0){
                        foreach ($weeks as $wKeys => $wValue)
                        {
                            $weekFirstDay = current($wValue);
                            $weekLastDay = end($wValue);

                            if($key == 0){
                                $date[]= [date(get_option('date_format'),strtotime($weekFirstDay)), ' to ', date(get_option('date_format'),strtotime($weekLastDay))];
                            }
                            $items ="SELECT COUNT(*) AS appointmentCount FROM {$wpdb->prefix}kc_appointments
                                    WHERE (appointment_start_date BETWEEN '{$weekFirstDay}' AND '{$weekLastDay}')  {$clinic_condition} {$patient_condition} {$doctor_condition} {$appointment_status_condition} AND clinic_id = {$clinicId} GROUP BY clinic_id";
                            $data = $wpdb->get_var($items);
                            $clinic_revenue[] = !empty($data) ? $data : 0;
                        }
                        $revenue_data[] = [
                            "name" =>  !empty($value['clinic_name']) ? $value['clinic_name'] : '',
                            "data" => $clinic_revenue,
                        ];
                    }

                }
                break;
            case 'yearly':

                $year = ($request_data['sub_type'] == '') ? date('Y') : $request_data['sub_type'];
                $get_all_month = kcGetAllMonth($year);

                foreach($clinicList as $key =>  $value){
                    $clinicId = $value['clinic_id'];
                    $clinic_revenue = [];
                    foreach ($get_all_month as $m_key => $m)
                    {
                        if($key == 0){
                            $date[]= $m;
                        }
                        $items ="SELECT COUNT(*) AS appointmentCount FROM {$wpdb->prefix}kc_appointments
                                    WHERE YEAR(appointment_start_date) = {$year} AND MONTH(appointment_start_date) = {$m_key}  {$clinic_condition} {$patient_condition} {$doctor_condition} {$appointment_status_condition} AND clinic_id={$clinicId}";
                        $data = $wpdb->get_var($items);
                        $clinic_revenue[] = !empty($data) ? $data : 0;
                    }

                    $revenue_data[] = [
                        "name" =>  !empty($value['clinic_name']) ? $value['clinic_name'] : '',
                        "data" => $clinic_revenue,
                    ];
                }

                break;
        }

        $revenue_data = array_map(function ($v){
            if(isset($v['data']) && is_array($v['data'])){
                if($this->arrayContainsOnlyEmptyNullValue($v['data'])){
                    $v['data'] = [];
                }
            }
            return $v;
        },$revenue_data);

        return [
            'status'  => true,
            'data'    => !empty($revenue_data[0]['name']) ? $revenue_data : [],
            'date'    => $date,
            'message' => esc_html__('clinic appointment Count', 'kiviCare-clinic-&-patient-management-system-pro'),
        ];
    }

    public function arrayContainsOnlyEmptyNullValue($array)
    {
        foreach ($array as $value) {
            if (!empty($value)) {
                return false;
            }
        }
        return true;
    }


}