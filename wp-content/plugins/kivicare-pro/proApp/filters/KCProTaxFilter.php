<?php

namespace proApp\filters;

use App\baseClasses\KCBase;
use App\models\KCServiceDoctorMapping;
use App\models\KCTax;
use App\models\KCTaxData;
use App\models\KCPatientEncounter;

class KCProTaxFilter extends KCBase{

    public $db;
    /**
     * Initialize the Tax class by setting up filters and actions.
     */
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
    
        // Setup filters for various actions
        add_filter('kivicare_tax_list', array($this, 'index'), 10, 2);
        add_filter('kivicare_tax_save', array($this, 'save'), 10, 2);
        add_filter('kivicare_tax_edit', array($this, 'edit'), 10, 2);
        add_filter('kivicare_tax_delete', array($this, 'delete'), 10, 2);
        
        // Delete tax data when related appointments or encounters are deleted
        add_action('kc_appointment_delete', function ($id) {
            $this->delete_data(['id' => $id, 'type' => 'appointment']);
        });
        
        /* // Delete tax data when related appointments or encounters are deleted
        add_action('kc_appointment_delete', function ($id, $encounter_id) {

            $data = [[
                'id' => $id,
                'type' => 'appointment'
            ],[
                'id' => $encounter_id,
                'type' => 'encounter'
            ]];

            $this->delete_data($data);

        }, 10, 2); */

        add_action('kivicare_encounter_delete', function ($id) {
            $this->delete_data([['id' => $id, 'type' => 'encounter']]);
        });
        
        // Setup filter for calculating tax
        add_filter('kivicare_calculate_tax', array($this, 'calculate_tax'), 10, 2);
        
        // Setup filter for saving tax data
        add_filter('kivicare_save_tax_data', array($this, 'save_tax_data'), 10, 1);
    }


    /**
     * Retrieves a list of tax records based on the provided request data.
     *
     * @param array $response The initial response array.
     * @param array $request_data The request data containing filters, search terms, pagination details, etc.
     * @return array The response containing the list of tax records.
     */
    public function index($response,$request_data){

        $tax_table = $this->db->prefix . 'kc_taxes';
        $clinic_table = $this->db->prefix . 'kc_clinics';
        $users_table = $this->db->base_prefix . 'users';
        $service_table = $this->db->base_prefix . 'kc_services';

        $paginationCondition = ' ';
        if((int)$request_data['perPage'] > 0){
            $perPage = (int)$request_data['perPage'];
            $offset = ((int)$request_data['page'] - 1) * $perPage;
            $paginationCondition = " LIMIT {$perPage} OFFSET {$offset} ";
        }

        $orderByCondition = " ORDER BY id DESC ";
        if(!empty($request_data['sort'])){
            $request_data['sort'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['sort'][0]),true));
            if(!empty($request_data['sort']['field']) && !empty($request_data['sort']['type']) && $request_data['sort']['type'] !== 'none'){
                $orderByCondition = " ORDER BY {$tax_table}.".sanitize_sql_orderby($request_data['sort']['field'])." ".sanitize_sql_orderby(strtoupper($request_data['sort']['type']));
            }
        }
        $condition = ' WHERE 0=0 ';
        if(isset($request_data['searchTerm']) && trim($request_data['searchTerm']) !== ''){
            $request_data['searchTerm'] = esc_sql(strtolower(trim($request_data['searchTerm'])));

            $status=null;
            // Extract status using regex
            if (preg_match('/:(active|inactive)/i', $request_data['searchTerm'], $matches)) {
                $status = $matches[1]=='active'?'1':'0';
                // Remove the matched status from the search term and trim
                $request_data['searchTerm'] = trim( preg_replace('/:(active|inactive)/i', '', $request_data['searchTerm']));
            }

            $condition.= " AND ({$tax_table}.name LIKE '%{$request_data['searchTerm']}%' 
                           OR {$clinic_table}.name LIKE '%{$request_data['searchTerm']}%'
                           OR {$users_table}.display_name LIKE '%{$request_data['searchTerm']}%' 
                           OR {$service_table}.name LIKE '%{$request_data['searchTerm']}%' 
                           ) ";
                if(!is_null($status)){
                    $condition.= " AND {$tax_table}.status LIKE '$status' ";
                }
        }else{
            if(!empty($request_data['columnFilters'])){
                $request_data['columnFilters'] = kcRecursiveSanitizeTextField(json_decode(stripslashes($request_data['columnFilters']),true));
                foreach ($request_data['columnFilters'] as $column => $searchValue){
                    $searchValue = esc_sql(strtolower(trim($searchValue)));
                    $column = esc_sql($column);
                    if($searchValue === ''){
                        continue;
                    }
                    switch ($column){
                        case 'id':
                        case 'name':
                        case 'status':
                            $condition.= " AND {$tax_table}.`{$column}` LIKE '%{$searchValue}%' ";
                            break;
                        case 'clinic_name':
                            $condition.= " AND {$clinic_table}.name LIKE '%{$searchValue}%' ";
                            break;
                        case 'doctor_name':
                            $condition.= " AND {$users_table}.display_name LIKE '%{$searchValue}%' ";
                            break;
                        case 'service_name':
                            $condition.= " AND {$service_table}.name LIKE '%{$searchValue}%' ";
                            break;
                    }
                }
            }
        }


        $clinic_postfix = kcGetClinicCurrenyPrefixAndPostfix()['postfix'];

        if($this->getLoginUserRole() === $this->getClinicAdminRole()){
            $user_clinic_id = kcGetClinicIdOfClinicAdmin();
            $condition .= " AND {$tax_table}.clinic_id IN (-1,'-1',{$user_clinic_id}) ";
        }


        $total_tax_data = $this->db->get_var( "SELECT count({$tax_table}.id)  FROM {$tax_table} 
                                LEFT JOIN  {$clinic_table} ON {$clinic_table}.id = {$tax_table}.clinic_id
                                LEFT JOIN  {$service_table} ON {$service_table}.id = {$tax_table}.service_id
                                LEFT JOIN  {$users_table} ON {$users_table}.ID = {$tax_table}.doctor_id {$condition}" );
        
        $result  = $this->db->get_results("SELECT {$tax_table}.id AS id, {$tax_table}.name AS `name`,{$tax_table}.tax_type AS tax_type,
                                {$tax_table}.tax_value AS tax_value, {$tax_table}.added_by AS added_by,{$tax_table}.status  AS `status`,
                                CONCAT(ROUND({$tax_table}.tax_value, 2),CASE WHEN {$tax_table}.tax_type = 'percentage' THEN '%' ELSE '{$clinic_postfix}' END) AS tax_rate,
                                {$tax_table}.created_at AS created_at, COALESCE({$clinic_table}.name,'All clinic') AS clinic_name ,
                                COALESCE({$users_table}.display_name  ,'All doctor') AS doctor_name,
                                COALESCE({$service_table}.name ,'All service') AS service_name FROM {$tax_table} 
                                LEFT JOIN  {$clinic_table} ON {$clinic_table}.id = {$tax_table}.clinic_id
                                LEFT JOIN  {$service_table} ON {$service_table}.id = {$tax_table}.service_id
                                LEFT JOIN  {$users_table} ON {$users_table}.ID = {$tax_table}.doctor_id {$condition} {$orderByCondition} {$paginationCondition}");

        if(empty($result)){
            $response['message'] = esc_html__("No data found", 'kiviCare-clinic-&-patient-management-system-pro');
            return $response;
        }
        array_walk($result, function (&$res) {
			$res->clinic_name = decodeSpecificSymbols($res->clinic_name);
		});
        $response['status'] = true;
        $response['message'] = esc_html__("Tax lists", 'kiviCare-clinic-&-patient-management-system-pro');
        $response['data'] = $result;
        $response['total_rows'] = $total_tax_data;
        return $response;
    }
    /**
     * Saves tax data based on the provided request data.
     *
     * @param array $response The initial response array.
     * @param array $request_data The request data containing tax information to be saved.
     * @return array The response indicating the status of the save operation.
     */
    public function save($response, $request_data) {
        // Prepare data for insertion
        $data = [
            "name" => $request_data['name'],
            "tax_value" => round((float)$request_data['tax_value'], 2),
            "tax_type" => $request_data['tax_type'],
            "status" => $request_data['status']
        ];
        
        // Determine clinic ID
        $data['clinic_id'] = empty($request_data['clinic_id']) || empty($request_data['clinic_id']['id']) ? -1 : $request_data['clinic_id']['id'];
        
        // Update existing tax record
        if (!empty($request_data['id'])) {
            // Prepare doctor and service IDs
            $data['doctor_id'] = empty($request_data['doctor_id']) || empty($request_data['doctor_id']['id']) ? -1 : $request_data['doctor_id']['id'];
            $data['service_id'] = empty($request_data['service_id']) || empty($request_data['service_id']['id']) ? -1 : $request_data['service_id']['id'];
            
            // Check user role permission
            if (!(new KCTax())->checkUserRoleWisePermission($request_data['id'])) {
                wp_send_json(kcUnauthorizeAccessResponse(403));
            }
            
            // Check if the same tax already exists
            $existingTaxId = (int) $this->checkTaxExists($data, $data['doctor_id'], $data['service_id']);
            if ($existingTaxId != $request_data['id'] && $existingTaxId != 0) {
                $response['message'] = esc_html__('Same tax already exists, please add a unique name', 'kiviCare-clinic-&-patient-management-system-pro');
                return $response;
            }
            
            // Update the tax record
            (new KCTax())->update($data, ['id' => $request_data['id']]);
            $response['status'] = true;
            $response['message'] = esc_html__('Tax updated successfully', 'kiviCare-clinic-&-patient-management-system-pro');
        }
        // Save a new tax record
        else {
            // Set added_by and created_at values
            $data['added_by'] = get_current_user_id();
            $data['created_at'] = current_time('mysql');
            
            // Check if multiple doctor IDs or service IDs are provided
            if ((!empty($request_data['doctor_id']) && is_array($request_data['doctor_id'])) || (!empty($request_data['service_id']) && is_array($request_data['service_id']))) {
                if (!empty($request_data['doctor_id'])) {
                    if (!empty($request_data['service_id'])) {
                        foreach ($request_data['service_id'] as $service) {
                            // Check if the same tax already exists
                            if (!empty($this->checkTaxExists($data, $service['doctor_id'], $service['id']))) {
                                $response['message'] = esc_html__('Same tax already exists, please add a unique name', 'kiviCare-clinic-&-patient-management-system-pro');
                                return $response;
                                break;
                            }
                        }
                        // Insert multiple tax records
                        foreach ($request_data['service_id'] as $service) {
                            $data['doctor_id'] = $service['doctor_id'];
                            $data['service_id'] = $service['id'];
                            (new KCTax())->insert($data);
                        }
                    } else {
                        foreach ($request_data['doctor_id'] as $doctor) {
                            // Check if the same tax already exists
                            if (!empty($this->checkTaxExists($data, $doctor['id'], -1))) {
                                $response['message'] = esc_html__('Same tax already exists, please add a unique name', 'kiviCare-clinic-&-patient-management-system-pro');
                                return $response;
                                break;
                            }
                        }
                        // Insert multiple tax records
                        foreach ($request_data['doctor_id'] as $doctor) {
                            $data['doctor_id'] = $doctor['id'];
                            $data['service_id'] = -1;
                            (new KCTax())->insert($data);
                        }
                    }
                } else {
                    foreach ($request_data['service_id'] as $service) {
                        // Check if the same tax already exists
                        if (!empty($this->checkTaxExists($data, -1, $service['service_id']))) {
                            $response['message'] = esc_html__('Same tax already exists, please add a unique name', 'kiviCare-clinic-&-patient-management-system-pro');
                            return $response;
                            break;
                        }
                    }
                    // Insert multiple tax records
                    foreach ($request_data['service_id'] as $service) {
                        $data['doctor_id'] = -1;
                        $data['service_id'] = $service['id'];
                        (new KCTax())->insert($data);
                    }
                }
            } else {
                // Set doctor and service IDs
                $data['doctor_id'] = empty($request_data['doctor_id']) || empty($request_data['doctor_id']['id']) ? -1 : $request_data['doctor_id']['id'];
                $data['service_id'] = empty($request_data['service_id']) || empty($request_data['service_id']['id']) ? -1 : $request_data['service_id']['id'];
                
                // Check if the same tax already exists
                if (!empty($this->checkTaxExists($data, $data['doctor_id'], $data['service_id']))) {
                    $response['message'] = esc_html__('Same tax already exists, please add a unique name', 'kiviCare-clinic-&-patient-management-system-pro');
                    return $response;
                }
                
                // Insert the tax record
                (new KCTax())->insert($data);
            }
            $response['status'] = true;
            $response['message'] = esc_html__('Tax saved successfully', 'kiviCare-clinic-&-patient-management-system-pro');
        }
        return $response;
    }

    /**
     * Checks if a tax record with the specified attributes already exists.
     *
     * @param array $taxData Tax data to check against.
     * @param int   $doctorId Doctor ID for the tax record.
     * @param int   $serviceId Service ID for the tax record.
     * @return int|null The ID of the existing tax record if found, otherwise null.
     */
    public function checkTaxExists($taxData, $doctorId, $serviceId){
        return (new KCTax())->get_var([
            'name' => $taxData['name'],
            'clinic_id' => $taxData['clinic_id'],
            'doctor_id' => $doctorId,
            'service_id' => $serviceId,
        ], 'id');
    }

    /**
     * Retrieves and prepares tax data for editing based on the provided request data.
     *
     * @param array $response The initial response array.
     * @param array $request_data The request data containing the ID of the tax to be edited.
     * @return array The response containing the prepared tax data for editing.
     */
    public function edit($response, $request_data) {

        // Define table names
        $tax_table = $this->db->prefix . 'kc_taxes';
        $clinic_table = $this->db->prefix . 'kc_clinics';
        $users_table = $this->db->base_prefix . 'users';
        $service_table = $this->db->base_prefix . 'kc_services';

        // Retrieve tax data with additional information
        $data = $this->db->get_row("SELECT {$tax_table}.*,{$clinic_table}.name AS clinic_name ,
                                    {$users_table}.display_name AS doctor_name, {$service_table}.name AS service_name FROM {$tax_table} 
                                    LEFT JOIN  {$clinic_table} ON {$clinic_table}.id = {$tax_table}.clinic_id
                                    LEFT JOIN  {$service_table} ON {$service_table}.id = {$tax_table}.service_id
                                    LEFT JOIN  {$users_table} ON {$users_table}.ID = {$tax_table}.doctor_id WHERE {$tax_table}.id = {$request_data['id']}");

        $data->tax_value = round((float)$data->tax_value, 2);
        // Prepare data for response
        if (!empty($data)) {
            $data->clinic_id = !empty($data->clinic_id) && !in_array($data->clinic_id, [-1, '-1']) ? ['id' => $data->clinic_id, 'label' => $data->clinic_name] : null;
            $data->doctor_id = !empty($data->doctor_id) && !in_array($data->doctor_id, [-1, '-1']) ? ['id' => $data->doctor_id, 'label' => $data->doctor_name] : null;
            $data->service_id = !empty($data->service_id) && !in_array($data->service_id, [-1, '-1']) ? ['id' => $data->service_id, 'label' => $data->service_name] : null;
        }

        // Prepare response
        $response['status'] = true;
        $response['message'] = esc_html__("tax data", 'kiviCare-clinic-&-patient-management-system-pro');
        $response['data'] = $data;

        return $response;
    }


    /**
     * Deletes a tax record based on the provided request data.
     *
     * @param array $response The initial response array.
     * @param array $request_data The request data containing the ID of the tax to be deleted.
     * @return array The response indicating the status of the delete operation.
     */
    public function delete($response, $request_data) {
        // Delete the tax record
        (new KCTax())->delete(['id' => $request_data['id']]);

        // Prepare the response
        $response['status'] = true;
        $response['message'] = esc_html__("Tax deleted successfully", 'kiviCare-clinic-&-patient-management-system-pro');

        return $response;
    }

    /**
     * Calculates tax charges based on the provided request data.
     *
     * @param array $response The initial response array.
     * @param array $request_data The request data containing tax calculation parameters.
     * @return array The response containing calculated tax data and total charges.
     */
    public function calculate_tax($response,$request_data){

        if(!empty($request_data['id'])){
           // Retrieve tax data for a specific module
            $response['data'] = (new KCTaxData())->get_tax([
                'module_id' => $request_data['id'],
                'module_type' => $request_data['type']
            ]);
        }else{

            // Prepare service IDs for query
            if (!empty($request_data['service_id'])) {
                $request_data['service_id'][] = -1;
                $request_data['service_id'] = implode(',', $request_data['service_id']);
            } else {
                $request_data['service_id'] = -1;
            }

            // Define table name
            $tax_table = $this->db->prefix . 'kc_taxes';

            // Retrieve tax data based on various criteria
            $clinic_tax = $this->db->get_results("SELECT * FROM {$tax_table} 
                            WHERE clinic_id IN ({$request_data['clinic_id']},-1) AND doctor_id  IN (-1, {$request_data['doctor_id']}) 
                            AND service_id IN ({$request_data['service_id']}) AND status = 1");

            $doctor_tax = $this->db->get_results("SELECT * FROM {$tax_table}
                            WHERE ((clinic_id = -1 AND doctor_id IN (-1, {$request_data['doctor_id']}))
                            OR (clinic_id = 1 AND doctor_id = {$request_data['doctor_id']})) 
                            AND service_id IN ({$request_data['service_id']}) AND status = 1");

            $service_tax = $this->db->get_results("SELECT * FROM {$tax_table}
                        WHERE (( (clinic_id = -1 OR clinic_id = {$request_data['clinic_id']})
                            AND doctor_id = {$request_data['doctor_id']}
                            AND service_id IN ({$request_data['service_id']}))
                        OR 
                            (clinic_id = -1 AND doctor_id = -1
                            AND service_id IN ({$request_data['service_id']}) )) AND status = 1");

            // Combine and process tax data
            $response['data'] = collect(array_merge($clinic_tax,$doctor_tax,$service_tax))->unique('id')->map(function($v)use($request_data){
                $v->tax_value = round((float)$v->tax_value, 2);
                if(!in_array($v->service_id,[-1,'-1'])){
                    if($request_data['type'] === 'encounter'){
                        $v->charges = 0;
                        foreach($request_data['service_count'][$v->service_id] as $count_service){
                            if($v->tax_type === 'percentage' ){
                                $v->charges += ($v->tax_value / 100) * $count_service['price'];
                            }else{
                                $v->charges += $v->tax_value;
                            }
                        }
                        if($v->tax_type === 'percentage' ){
                            $v->name .= "({$v->tax_value}%)"; 
                        }
                    }else{
                        $service_charge = (new KCServiceDoctorMapping())->get_var([
                            "doctor_id" => $request_data['doctor_id'],
                            "service_id" => $v->service_id,
                            "clinic_id" => $request_data['clinic_id']
                        ],'charges');
                        if($v->tax_type === 'percentage' ){
                            $v->name .= "({$v->tax_value}%)"; 
                            $v->charges = ($v->tax_value / 100) * $service_charge;
                        }else{
                            $v->charges = $v->tax_value;
                        }
                    }
                    
                }else{
                    if($v->tax_type === 'percentage' ){
                        $v->name .= "({$v->tax_value}%)"; 
                        $v->charges = ($v->tax_value / 100) * $request_data['total_charge'];
                    }else{
                        $v->charges = $v->tax_value;
                    }
                }
                $v->charges = round($v->charges, 2);
                return $v;
            })->toArray();
        }

        $response['data'] = collect($response['data'])->groupBy('name')->map(function ($taxes) {
            $combined_tax = clone $taxes[0]; // Clone the first tax instance
        
            if (count($taxes) > 1) {
                // If there are multiple taxes with the same name, combine their charges
                $combined_tax->charges = collect($taxes)->sum('charges');
            }
        
            return $combined_tax;
        })->values()->toArray();
        $response['status'] = true;
        $response['message'] = esc_html__("Calculated tax data", 'kiviCare-clinic-&-patient-management-system-pro');
        $response['tax_total'] = round(collect($response['data'])->sum('charges'), 3);
        return $response;
    }

    /**
     * Saves tax data for a module based on the provided request data.
     *
     * @param array $request_data The request data containing tax data and module information.
     * @return void
     */
    public function save_tax_data($request_data) {
        foreach ($request_data['tax_data'] as $tax) {
            // Helper function to safely retrieve the value
            $getValue = function($item, $key) {
                return is_array($item) ? ($item[$key] ?? null) : ($item->$key ?? null);
            };
            
            $temp = [
                'module_type' => $request_data['type'],
                'module_id' => $request_data['id'],
                'name' => $getValue($tax, 'name'),
                'charges' => $getValue($tax, 'charges'),
                'tax_type' => $getValue($tax, 'tax_type'),
                'tax_value' => $getValue($tax, 'tax_value')
            ];
            
            (new KCTaxData())->insert($temp);
        }
    }

    /**
     * Deletes tax data associated with a module based on the provided data.
     *
     * @param array $data The data containing module ID and type for which tax data should be deleted.
     * @return void
     */
    public function delete_data($data) {
        foreach($data as $taxdata){
            if (!empty($taxdata['id']) || !empty($taxdata['type'])) {
                (new KCTaxData())->delete([
                    'module_id' => $taxdata['id'],
                    'module_type' => $taxdata['type']
                ]);
            }
        }
    }

}