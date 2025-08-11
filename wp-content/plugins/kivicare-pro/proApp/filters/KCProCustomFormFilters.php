<?php

namespace ProApp\filters;

use App\baseClasses\KCBase;
use App\baseClasses\KCRequest;
use App\models\KCClinic;
use App\models\KCCustomForm;
use App\models\KCCustomFormData;

class KCProCustomFormFilters  extends KCBase
{
    public  $db;
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        add_action('kcpro_get_customform_list', [$this, 'getCustomFormList']);
        add_action('kcpro_custom_form_add', [$this, 'addCustomForm']);
        add_action('kcpro_custom_form_edit', [$this, 'editCustomForm']);
        add_action('kcpro_custom_form_delete', [$this, 'deleteCustomForm']);
        add_action('kcpro_get_custom_form_data', [$this, 'formDataGet']);
        add_action('kcpro_custom_form_data_save', [$this, 'formDataSave']);
    }
    public function formDataSave($request_data)
    {


        // Check if the user has permission for the specified custom form and module.
        if (!(new KCCustomFormData())->customFormUserWisePermission($request_data['form_id'], $request_data['module_id'])) {
            // If the user doesn't have permission, send a JSON response with a 403 status code.
            wp_send_json(kcUnauthorizeAccessResponse(403));
        }

        $temp = [
            'form_id' => $request_data['form_id'],
            'module_id' => $request_data['module_id'],
            'form_data' => json_encode($request_data['form_data']),
        ];
        $id = (new KCCustomFormData())->get_var(['form_id' => $temp['form_id'], 'module_id' => $temp['module_id']], 'id');
        // Check if an 'id' is provided in the request data
        if (!empty($id)) {
            // Update existing custom form
            (new KCCustomFormData())->update($temp, ['id' => (int)$id]);
            (new KCCustomFormData())->fireHooks($id,$request_data['module_id']);
            $message = esc_html__('Custom form updated successfully', 'kc-lang');
        } else {
            // Insert a new custom form
            $id = (new KCCustomFormData())->insert($temp);
            (new KCCustomFormData())->fireHooks($id,$request_data['module_id']);
            $message = esc_html__('Custom form saved successfully', 'kc-lang');
        }

        // Send a success response
        wp_send_json([
            'status' => true,
            'data' => [],
            'message' => $message
        ]);
    }

    public function deleteCustomForm($request_data)
    {

        // Check if 'id' is missing in the request data
        if (empty($request_data['id'])) {
            // Send a response indicating that the custom form ID is not found
            wp_send_json([
                'status' => false,
                'data' => [],
                'message' => esc_html__('Custom form ID not found', 'kc-lang')
            ]);
        }

        // Convert 'id' to an integer
        $id = (int)$request_data['id'];

        // Check if the user has permission for the specified custom form.
        if (!(new KCCustomForm())->customFormPermissionUserWise($id)) {
            // If the user doesn't have permission, send a JSON response with a 403 status code.
            wp_send_json(kcUnauthorizeAccessResponse(403));
        }

        // Delete the custom form using the KCCustomForm class
        (new KCCustomForm())->delete(['id' => $id]);

        // Delete associated custom form data using the KCCustomFormData class
        (new KCCustomFormData())->delete(['form_id' => $id]);

        // Send a success response after deletion
        wp_send_json([
            'status' => true,
            'data' => [],
            'message' => esc_html__('Custom form deleted successfully', 'kc-lang')
        ]);
    }


    public function formDataGet($request_data)
    {
        // Check if 'id' is missing in the request data
        if (empty($request_data['form_id']) || empty($request_data['module_id'])) {
            // Send a response indicating that the custom form ID is not found
            wp_send_json([
                'status' => false,
                'data' => [],
                'message' => esc_html__('Custom form ID or module ID not found', 'kc-lang')
            ]);
        }

        // Convert 'form_id' to an integer
        $form_id = (int)$request_data['form_id'];
        // Convert 'module_id' to an integer
        $module_id = (int)$request_data['module_id'];

        // Check if the user has permission for the specified custom form and module.
        if (!(new KCCustomFormData())->customFormUserWisePermission($form_id, $module_id)) {
            // If the user doesn't have permission, send a JSON response with a 403 status code.
            wp_send_json(kcUnauthorizeAccessResponse(403));
        }

        // Get custom form data by 'id'
        $data = (new KCCustomFormData())->get_var(['form_id' => $form_id, 'module_id' => $module_id], 'form_data');

        // Check if custom form data is empty
        if (empty($data)) {
            // Send a response indicating that custom form data is not found
            wp_send_json([
                'status' => false,
                'data' => [],
                'message' => esc_html__('Custom form data not found', 'kc-lang')
            ]);
        }
        // Decode JSON properties
        $data = json_decode($data);
        // Send a success response with the formatted custom form data
        wp_send_json([
            'status' => true,
            'data' => $data,
            'message' => esc_html__('Custom form data', 'kc-lang')
        ]);
    }

    public  function editCustomForm($request_data)
    {

        // Check if 'id' is missing in the request data
        if (empty($request_data['id'])) {
            // Send a response indicating that the custom form ID is not found
            wp_send_json([
                'status' => false,
                'data' => [],
                'message' => esc_html__('Custom form ID not found', 'kc-lang')
            ]);
        }

        // Convert 'id' to an integer
        $id = (int)$request_data['id'];

        // Get custom form data by 'id'
        $data = (new KCCustomForm())->get_by(['id' => $id], '=', true);

        // Check if custom form data is empty
        if (empty($data)) {
            // Send a response indicating that custom form data is not found
            wp_send_json([
                'status' => false,
                'data' => [],
                'message' => esc_html__('Custom form data not found', 'kc-lang')
            ]);
        }

        // Check if the user has permission for the specified custom form.
        if (!(new KCCustomForm())->customFormPermissionUserWise($id)) {
            // If the user doesn't have permission, send a JSON response with a 403 status code.
            wp_send_json(kcUnauthorizeAccessResponse(403));
        }

        // Decode JSON properties
        $data->name = json_decode($data->name);
        $data->module_type = [
            'id' => $data->module_type,
            'label' => str_replace("_", " ", ucfirst($data->module_type))
        ];
        $data->form_data = json_decode($data->fields);
        $data->conditions = json_decode($data->conditions);
        $data->status = [
            'id' => $data->status,
            'label' => (int)$data->status === 1 ? 'Active' : 'Inactive'
        ];

        // Remove 'fields' property
        unset($data->fields);

        // Send a success response with the formatted custom form data
        wp_send_json([
            'status' => true,
            'data' => $data,
            'message' => esc_html__('Custom form data', 'kc-lang')
        ]);
    }
    public function addCustomForm($request_data)
    {
        // Define validation rules for request data
        $rules = [
            'name' => 'required',
            'module_type' => 'required',
            'form_data' => 'required',
            'status' => 'required',
            'conditions' => 'required',
        ];

        // Validate the request data
        $errors = kcValidateRequest($rules, $request_data);

        // Check for validation errors
        if (!empty($errors)) {
            wp_send_json([
                'status' => false,
                'message' => $errors[0] // Assuming you want to send the first error message
            ]);
        }

        // Prepare data to be inserted or updated

        $temp = [
            'name' => json_encode($request_data['name']),
            'module_type' => !empty($request_data['module_type']['id']) ? $request_data['module_type']['id'] : 'appointment_module',
            'fields' => json_encode($request_data['form_data']),
            'status' => isset($request_data['status']['id']) ? (int)$request_data['status']['id'] : 1,
        ];

        // Check if an 'id' is provided in the request data
        if (!empty($request_data['id'])) {

            // Check if the user has permission for the specified custom form.
            if (!(new KCCustomForm())->customFormPermissionUserWise((int)$request_data['id'])) {
                // If the user doesn't have permission, send a JSON response with a 403 status code.
                wp_send_json(kcUnauthorizeAccessResponse(403));
            }

            // Update existing custom form
            $temp['conditions'] = json_encode($request_data['conditions']);
            (new KCCustomForm())->update($temp, ['id' => (int)$request_data['id']]);
            $message = esc_html__('Custom form updated successfully', 'kc-lang');
        } else {
            if (!empty($request_data['module_type']['id']) && $request_data['module_type']['id'] === 'appointment_module') {
                if (isKiviCareProActive()) {
                    if ($this->getLoginUserRole() === $this->getClinicAdminRole()) {
                        $clinic_id = kcGetClinicIdOfClinicAdmin();
                        $clinic_name = (new KCClinic())->get_var(['id' => $clinic_id], 'name');
                        $request_data['conditions']['clinic_ids'] = [['id' => $clinic_id, 'label' => $clinic_name]];
                    }
                }
            }
            // Insert a new custom form
            $temp['conditions'] = json_encode($request_data['conditions']);
            $temp['added_by'] = get_current_user_id();
            $temp['created_at'] = current_time('mysql');
            (new KCCustomForm())->insert($temp);
            $message = esc_html__('Custom form saved successfully', 'kc-lang');
        }

        // Send a success response
        wp_send_json([
            'status' => true,
            'data' => [],
            'message' => $message
        ]);
    }

    public function getCustomFormList($request_data)
    {
        // Define the custom form table name
        $custom_form_table = $this->db->prefix . 'kc_custom_forms';

        // Initialize conditions, pagination, and orderByCondition
        $conditions = 'WHERE 0=0';
        $pagination = '';
        $orderByCondition = 'ORDER BY id DESC';

        // Check and set pagination parameters
        if ((int)$request_data['perPage'] > 0) {
            $perPage = (int)$request_data['perPage'];
            $offset = ((int)$request_data['page'] - 1) * $perPage;
            $pagination = "LIMIT {$perPage} OFFSET {$offset}";
        }

        // Check and set sorting parameters
        if (!empty($request_data['sort'])) {
            $sort = json_decode(stripslashes($request_data['sort'][0]), true);
            if (!empty($sort['field']) && !empty($sort['type']) && $sort['type'] !== 'none') {
                $orderByCondition = "ORDER BY " . sanitize_sql_orderby($sort['field']) . " " . sanitize_sql_orderby(strtoupper($sort['type']));
            }
        }

        // Build search conditions
        if (isset($request_data['searchTerm']) && trim($request_data['searchTerm']) !== '') {
            $searchTerm = esc_sql(strtolower(trim($request_data['searchTerm'])));
            $status=null;
            // Extract status using regex
            if (preg_match('/:(active|inactive)/i', $searchTerm, $matches)) {
                $status = $matches[1]=='active'?'1':'0';
                // Remove the matched status from the search term and trim
                $searchTerm = trim( preg_replace('/:(active|inactive)/i', '', $searchTerm));
            }

            $conditions .= " AND (id LIKE '%$searchTerm%' 
            OR module_type LIKE '%$searchTerm%' 
            OR JSON_UNQUOTE(JSON_EXTRACT(`name`, '$.text')) LIKE '%$searchTerm%' ) ";
            if(!is_null($status)){
                $conditions.= " AND status LIKE '{$status}'  ";
            }

        } else {
            if (!empty($request_data['columnFilters'])) {
                $columnFilters = json_decode(stripslashes($request_data['columnFilters']), true);
                foreach ($columnFilters as $column => $searchValue) {
                    if($column !== 'status'){
                        $searchValue = !empty($searchValue) ? $searchValue : '';
                    }
                    $searchValue = esc_sql(strtolower(trim($searchValue)));
                    $column = esc_sql($column);
                    if ($searchValue === '') {
                        continue;
                    }
                    if ($column === 'name') {
                        $column = "JSON_UNQUOTE(JSON_EXTRACT(`name`, '$.text'))";
                    }
                    $conditions .= " AND $column LIKE '%$searchValue%' ";
                }
            }
        }

        if (isKiviCareProActive()) {
            if ($this->getLoginUserRole() === $this->getClinicAdminRole()) {
                $user_id = get_current_user_id();
                $conditions .= " AND added_by = {$user_id} ";
            }
        }

        // Get the total count of custom form data
        $total_custom_form_data = $this->db->get_var("SELECT COUNT(*) AS count FROM $custom_form_table $conditions");

        // Retrieve custom form data with JSON_UNQUOTE for 'name'
        // $custom_form = $this->db->get_results("SELECT id, JSON_UNQUOTE(JSON_EXTRACT(`name`, '$.text')) AS name, module_type, status FROM $custom_form_table $conditions $orderByCondition $pagination");

        $result = $this->db->get_results("SELECT id, name, module_type, status FROM $custom_form_table $conditions $orderByCondition $pagination");

        $custom_form = array_map(function($row) {
            $nameData = json_decode($row->name, true);
            $row->name = $nameData['text'] ?? '';
            return $row;
        }, $result);

        // Check if custom form data is empty
        if (empty($custom_form)) {
            wp_send_json([
                'status' => false,
                'message' => esc_html__('No custom forms found', 'kc-lang'),
                'data' => []
            ]);
        }

        // Send a success response with custom form data and total count
        wp_send_json([
            'status' => true,
            'message' => esc_html__('Custom forms records', 'kc-lang'),
            'data' => $custom_form,
            'total' => $total_custom_form_data
        ]);
    }
}
