<?php

namespace ProApp\filters;

use App\baseClasses\KCBase;

class KCProBillingFilters extends KCBase{
    public $db;

    /**
     * add all filters
     */
    public function __construct() {
        global $wpdb;

        $this->db = $wpdb;
        add_filter('kcpro_get_bill_list', [$this, 'billList']);
        add_filter('kcpro_get_without_bill_encounter_list', [$this, 'getWithoutBillEncounterList']);
    }

    /**
     * function to get encounter bill lists
     * @param $request_data
     * @return array
     */
    public function billList($request_data){

        $patient_encounter_table = $this->db->prefix . 'kc_patient_encounters';
        $bills_table = $this->db->prefix . 'kc_bills';
        $clinics_table           = $this->db->prefix . 'kc_clinics';
        $users_table             = $this->db->base_prefix . 'users';
        $bill_ietms_table        = $this->db->prefix . 'kc_bill_items';
        $services_table        = $this->db->prefix . 'kc_services';
        $login_id              = get_current_user_id();
        $current_user_login_role = $this->getLoginUserRole();
        $patient_user_condition = $doctor_user_condition = $clinic_condition = $search_condition = $service_name_condition = '';
        //default descending order by bill id
        $orderByCondition = " ORDER BY {$bills_table}.id DESC ";
        $paginationCondition = ' ';
        //check if perpage value if valid
        if((int)$request_data['perPage'] > 0){
            $perPage = (int)$request_data['perPage'];
            $offset = ((int)$request_data['page'] - 1) * $perPage;
            //limit and offset for pagination
            // $paginationCondition = " LIMIT {$perPage} OFFSET {$offset} ";
        }

        //check if sort by value
        if(!empty($request_data['sort'])){
            //validate data
            $request_data['sort'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['sort'][0]),true));
            //check if sort array have field and type value
            if(!empty($request_data['sort']['field']) && !empty($request_data['sort']['type']) && $request_data['sort']['type'] !== 'none'){
                //sanitize for query
                $sortField = sanitize_sql_orderby($request_data['sort']['field']);
                //sanitize for query
                $sortByValue = sanitize_sql_orderby(strtoupper($request_data['sort']['type']));
                switch($request_data['sort']['field']){
                    case 'status':
                    case 'id':
                        $orderByCondition = " ORDER BY {$patient_encounter_table}.{$sortField} {$sortByValue} ";
                        break;
                    case 'doctor_name':
                        $orderByCondition = " ORDER BY doctors.display_name {$sortByValue} ";
                        break;
                    case 'clinic_name':
                        $orderByCondition = " ORDER BY {$clinics_table}.name {$sortByValue} ";
                        break;
                    case 'patient_name':
                        $orderByCondition = " ORDER BY patients.display_name {$sortByValue} ";
                        break;
                    case 'created_at':
                    case 'bill_id':
                    case 'total_amount':
                    case 'discount':
                    case 'actual_amount':
                        $sortField = $sortField == 'bill_id' ? 'id' : $sortField;
                        $orderByCondition = " ORDER BY {$bills_table}.{$sortField} {$sortByValue}";
                        break;
                }
            }
        }

        //check if global search value is not empty
        if(isset($request_data['searchTerm']) && trim($request_data['searchTerm']) !== ''){
            //sanitize value
            $request_data['searchTerm'] = esc_sql(strtolower(trim($request_data['searchTerm'])));

            $status=null;
            // Extract status using regex
            if (preg_match('/:(paid|unpaid)/i', $request_data['searchTerm'], $matches)) {
                $status = $matches[1];
                // Remove the matched status from the search term and trim
                $request_data['searchTerm'] = trim( preg_replace('/:(paid|unpaid)/i', '', $request_data['searchTerm']));
            }
            //create search where condition query
            $search_condition.= " AND (
                           {$bills_table}.id LIKE '%{$request_data['searchTerm']}%' 
                           OR {$patient_encounter_table}.id LIKE '%{$request_data['searchTerm']}%' 
                           OR {$clinics_table}.name LIKE '%{$request_data['searchTerm']}%' 
                           OR doctors.display_name LIKE '%{$request_data['searchTerm']}%' 
                           OR patients.display_name LIKE '%{$request_data['searchTerm']}%'  
                           ) ";
            if(!is_null($status)){
                $search_condition.= " AND {$bills_table}.payment_status LIKE '{$status}' ";
            }
        }else{
            //check if column wise value is not empty
            if(!empty($request_data['columnFilters'])){
                //validate data
                $request_data['columnFilters'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['columnFilters']),true));
                //loop through all requested column field                
                foreach ($request_data['columnFilters'] as $column => $searchValue){
                    $searchValue = $column !== 'created_at' ?  esc_sql(strtolower(trim($searchValue))) :$searchValue ;
                    $column = esc_sql($column);
                    if($searchValue === ''){
                        continue;
                    }
                    // create search where condition query based on column name
                    switch($column){
                        case 'status':
                        case 'id':
                            $search_condition.= " AND {$patient_encounter_table}.{$column} LIKE '%{$searchValue}%' ";
                            break;
                        case 'doctor_name':
                            $search_condition.= " AND doctors.display_name LIKE '%{$searchValue}%' ";
                            break;
                        case 'clinic_name':
                            $search_condition.= " AND {$clinics_table}.name LIKE '%{$searchValue}%' ";
                            break;
                        case 'patient_name':
                            $search_condition.= " AND patients.display_name LIKE '%{$searchValue}%'";
                            break;
                        case 'bill_id':
                        case 'total_amount':
                        case 'discount':
                        case 'actual_amount':
                            $column = $column == 'bill_id' ? 'id' : $column;
                            $search_condition.= " AND {$bills_table}.{$column} LIKE '%{$searchValue}%'";
                            break;
                        case 'created_at':
                            if(!empty($searchValue['start']) && !empty($searchValue['end'])){
                                $searchValue['start'] = esc_sql(strtolower(trim($searchValue['start'])));
                                $searchValue['end'] = esc_sql(strtolower(trim($searchValue['end'])));
                                $search_condition.= " AND CAST({$bills_table}.{$column} AS DATE )  BETWEEN '{$searchValue['start']}' AND '{$searchValue['end']}' ";
                            }
                            break;
                        case 'service_name':
                            $service_name_condition = $searchValue;
                            // $search_condition.= " AND {$services_table}.name LIKE '%{$searchValue}%'";
                            break;
                    }
                }
            }
        }

        //check if current user role is patient role
        if ($this->getPatientRole() === $current_user_login_role) {
            //add patient condition in query
            $patient_user_condition =  " AND {$patient_encounter_table}.patient_id = {$login_id} " ;
        }

        //check if request data have patient id
        if(!empty($request_data['patient_id']) && $request_data['patient_id'] > 0) {
            $request_data['patient_id'] = (int)$request_data['patient_id'];
            //add patient condition in query
            $patient_user_condition =  " AND {$patient_encounter_table}.patient_id = {$request_data['patient_id']} " ;
        }

        //check if current user role is doctor role
        if ($this->getDoctorRole() === $current_user_login_role) {
            //add doctor condition in query
            $doctor_user_condition =  " AND {$patient_encounter_table}.doctor_id = {$login_id} " ;
        }

        //check if current user role is clinic role
        if( $this->getClinicAdminRole() === $current_user_login_role) {
            //get clinic id of clinic admin and add clinic condition in query
            $clinic_condition = " AND {$patient_encounter_table}.clinic_id=".kcGetClinicIdOfClinicAdmin();
        }

        //check if current user role is receptionist role
        if($this->getReceptionistRole() === $current_user_login_role){
            //get clinic id of clinic receptionist and add clinic condition in query
            $clinic_condition = " AND {$patient_encounter_table}.clinic_id = " .kcGetClinicIdOfReceptionist() ;
        }


        //common query for total count and data

        $common_query = " FROM  {$bills_table}
			   INNER JOIN {$patient_encounter_table}
		              ON {$patient_encounter_table}.id = {$bills_table}.encounter_id
		       LEFT JOIN {$users_table} doctors
		              ON {$patient_encounter_table}.doctor_id = doctors.id
		       LEFT JOIN {$users_table} patients
		              ON {$patient_encounter_table}.patient_id = patients.id
		       LEFT JOIN {$clinics_table}
		              ON {$patient_encounter_table}.clinic_id = {$clinics_table}.id  
                      LEFT JOIN {$bill_ietms_table}
		              ON {$bills_table}.id = {$bill_ietms_table}.bill_id      
                      LEFT JOIN {$services_table}
		              ON {$bill_ietms_table}.item_id = {$services_table}.id          
            WHERE 0 = 0  {$patient_user_condition}  {$doctor_user_condition}  {$clinic_condition} {$search_condition} ";


        // get bill data
        $bills_data = $this->db->get_results( "SELECT {$bills_table}.id as bill_id,
               {$bills_table}.title as bill_title,
               {$bills_table}.total_amount as total_amount,
               {$bills_table}.discount as discount,
               {$bills_table}.actual_amount as actual_amount,
               {$bills_table}.created_at as bill_created_at,
               {$patient_encounter_table}.*,
		       doctors.display_name  AS doctor_name,
		       patients.display_name AS patient_name,
		       {$clinics_table}.name AS clinic_name,
		    --    {$services_table}.name AS service_name
               GROUP_CONCAT({$services_table}.name) AS service_name
			   {$common_query} GROUP BY {$bills_table}.id {$orderByCondition} {$paginationCondition} " );
               
            // $mergedArray = [];
            $n = 0;
            foreach($bills_data as $bill){               
                $bills_data[$n]->created_at = kcGetFormatedDate($bill->bill_created_at);
                $bills_data[$n]->encounter_date = kcGetFormatedDate($bill->encounter_date);

                $bills_data[$n]->clinic_name = decodeSpecificSymbols( $bill->clinic_name);
                $n++;
            }

            if (!empty($service_name_condition)) {
                $filtered_data = [];
                foreach ($bills_data as $bill) {
                    if (stripos($bill->service_name, $service_name_condition) !== false) {
                        $filtered_data[] = $bill;
                    }
                }            
                $bills_data = $filtered_data;               
            }
            
            $paginated_data = array_slice($bills_data, $offset, $perPage);
            $bills_data = $paginated_data;
            
        //check if bill data is empty
        if ( ! count( $bills_data ) ) {
           return [
                'status'  => false,
                'message' => esc_html__('No encounter found', 'kiviCare-clinic-&-patient-management-system-pro'),
                'data'    => []
            ];
        }

        //get total bill count for pagination
        $total = $this->db->get_var( "SELECT count(*) {$common_query} ");

        //get currency details
        $curreny_details = kcGetClinicCurrenyPrefixAndPostfix();

        $total_amount = $discount = $actual_amount = 0;
        //add prefix and postfix in bill amount/discount and actual amount value and get total of for last row in table
        foreach ($bills_data as $value){
            $total_amount += $value->total_amount;
            $value->total_amount = $curreny_details['prefix'] .$value->total_amount.$curreny_details['postfix'];
            $discount += $value->discount;
            $value->discount = $curreny_details['prefix'] .$value->discount.$curreny_details['postfix'];
            $actual_amount += $value->actual_amount;
            $value->actual_amount = $curreny_details['prefix'] .$value->actual_amount.$curreny_details['postfix'];
        }
        $total_amount =  $curreny_details['prefix'] .$total_amount.$curreny_details['postfix'];
        $discount =  $curreny_details['prefix'] .$discount.$curreny_details['postfix'];
        $actual_amount =  $curreny_details['prefix'] .$actual_amount.$curreny_details['postfix'];

        //get last row
        $total_data_row = $bills_data[0];
        //make all data empty
        $total_data_row = (object)array_map(function($item) { return '' ; }, (array)$total_data_row);
        //add data to clone row
        $total_data_row->bill_id = esc_html__('Total Value', 'kiviCare-clinic-&-patient-management-system-pro');
        $total_data_row->total_amount = $total_amount;
        $total_data_row->discount = $discount;
        $total_data_row->actual_amount = $actual_amount;
        $total_data_row->last_row = 'yes';
        //add clone row to bill data as last row
        $bills_data[] =$total_data_row;        
        return [
            'status'     => true,
            'message'    => esc_html__('Encounter list', 'kiviCare-clinic-&-patient-management-system-pro'),
            'data'       => $bills_data,
            'total_rows' => $total,
            "clinic_extra" => $curreny_details,
        ] ;

    }

    /**
     * @param $request_data
     * @return array
     */
    public function getWithoutBillEncounterList($request_data){
        $login_id              = get_current_user_id();
        $current_user_login_role = $this->getLoginUserRole();
        $patient_encounter_table = $this->db->prefix . 'kc_patient_encounters';
        $bills_table = $this->db->prefix . 'kc_bills';
        $clinics_table           = $this->db->prefix . 'kc_clinics';
        $users_table             = $this->db->base_prefix . 'users';

        $patient_user_condition = $doctor_user_condition = $clinic_condition = $encounter_condition = '';
        //get all encounter id
        $all_bill_encounter = collect($this->db->get_results("SELECT encounter_id FROM {$bills_table}"))->pluck('encounter_id')->implode(',');
        //check if all encounter id is not empty
        if(!empty($all_bill_encounter)){
            //exclude all encounter which have bills
            $encounter_condition = " AND {$patient_encounter_table}.id NOT IN ({$all_bill_encounter}) ";
        }


        //check if current user role is patient role
        if ($this->getPatientRole() === $current_user_login_role) {
            //add patient condition in query
            $patient_user_condition =  " AND {$patient_encounter_table}.patient_id = {$login_id} " ;
        }

        //check if current user role is doctor role
        if ($this->getDoctorRole() === $current_user_login_role) {
            //add doctor condition in query
            $doctor_user_condition =  " AND {$patient_encounter_table}.doctor_id = {$login_id} " ;
        }

        //check if current user role is clinic admin role
        if( $this->getClinicAdminRole() === $current_user_login_role) {
            //get clinic id of clinic admin and add clinic condition in query
            $clinic_condition = " AND {$patient_encounter_table}.clinic_id=".kcGetClinicIdOfClinicAdmin();
        }

        //check if current user role is receptionist role
        if($this->getReceptionistRole() === $current_user_login_role){
            //get clinic id of clinic receptionist and add clinic condition in query
            $clinic_condition = " AND {$patient_encounter_table}.clinic_id = " .kcGetClinicIdOfReceptionist() ;
        }

        //check if pro plugin active
        if(!isKiviCareProActive()){
            $clinic_condition = " AND {$patient_encounter_table}.clinic_id = " .kcGetDefaultClinicId() ;
        }


        //get encounter data
        $encounters = collect($this->db->get_results( "SELECT {$patient_encounter_table}.*,
		       doctors.display_name  AS doctor_name,
		       patients.display_name AS patient_name,
		       {$clinics_table}.name AS clinic_name 
			  FROM  {$patient_encounter_table}
		       LEFT JOIN {$users_table} doctors
		              ON {$patient_encounter_table}.doctor_id = doctors.id
		       LEFT JOIN {$users_table} patients
		              ON {$patient_encounter_table}.patient_id = patients.id
		       LEFT JOIN {$clinics_table}
		              ON {$patient_encounter_table}.clinic_id = {$clinics_table}.id
            WHERE 0 = 0 {$encounter_condition} {$patient_user_condition}  {$doctor_user_condition}  {$clinic_condition} " ))->map(function ($v){
                $v -> encounter_date = kcGetFormatedDate($v -> encounter_date);
                return $v;
            })->toArray();

        //check if encounter data is empty
        if(empty($encounters)){
            return [
                'status'  => false,
                'message' => esc_html__('No encounter found', 'kiviCare-clinic-&-patient-management-system-pro'),
                'data'    => []
            ];
        }

        return [
            'status'  => true,
            'message' => esc_html__('Encounter list without bills', 'kiviCare-clinic-&-patient-management-system-pro'),
            'data'    => $encounters
        ] ;
    }
}