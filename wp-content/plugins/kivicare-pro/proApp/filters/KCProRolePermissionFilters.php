<?php

namespace ProApp\filters;

use function Clue\StreamFilter\fun;

class KCProRolePermissionFilters extends \App\baseClasses\KCBase{
    public $db;
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        add_filter('kcpro_get_all_permission', [$this, 'getAllPermission']);
        add_filter('kcpro_save_permission_list', [$this, 'savePermissionList']);

    }

    public function getAllPermission($data){

        $modules = json_decode(get_option(KIVI_CARE_PREFIX . 'modules'));

        if (!empty($modules->module_config)) {
            foreach ($modules->module_config as $module) {
                switch ($module->name) {
                    case 'receptionist':
                        $isEnableReceptionistModule = $module->status == 1;
                        break;
                    case 'billing':
                        $isEnableBillingModule = $module->status == 1;
                        break;
                    case 'custom_fields':
                        $isEnableCustomFieldsModule = $module->status == 1;
                        break;
                }
            }
        }

        $allRole = ['administrator',$this->getPatientRole(),
            $this->getDoctorRole(),
            $this->getReceptionistRole(),
            $this->getClinicAdminRole()];

        $data = collect(get_editable_roles())->filter(function ($v,$key)use($allRole){
            return in_array($key,$allRole);
        });
        $temp = [];
        foreach ($data as $role => $cap){         
           $capability = [];
           foreach ($cap['capabilities'] as $capKey => $capVal){              
               if(strpos(strtolower($capKey), 'kivicare') !== false){
                   if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'appointment_add',
                       KIVI_CARE_PRO_PREFIX.'appointment_delete',
                       KIVI_CARE_PRO_PREFIX.'appointment_edit',
                       KIVI_CARE_PRO_PREFIX.'appointment_view',
                       KIVI_CARE_PRO_PREFIX.'appointment_list',
                       KIVI_CARE_PRO_PREFIX.'appointment_export',
                       KIVI_CARE_PRO_PREFIX.'patient_appointment_status_change',
                       KIVI_CARE_PRO_PREFIX.'appointment_cancel'
                   ])){
                       $capability['appointment_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'patient_encounter_add',
                       KIVI_CARE_PRO_PREFIX.'patient_encounter_delete',
                       KIVI_CARE_PRO_PREFIX.'patient_encounter_edit',
                       KIVI_CARE_PRO_PREFIX.'patient_encounter_list',
                       KIVI_CARE_PRO_PREFIX.'patient_encounter_view',
                       KIVI_CARE_PRO_PREFIX.'patient_encounter_export',
                       KIVI_CARE_PRO_PREFIX.'patient_encounters']
                   )){
                       $capability['encounter_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'encounters_template_add',
                       KIVI_CARE_PRO_PREFIX.'encounters_template_delete',
                       KIVI_CARE_PRO_PREFIX.'encounters_template_edit',
                       KIVI_CARE_PRO_PREFIX.'encounters_template_list',
                       KIVI_CARE_PRO_PREFIX.'encounters_template_view',
                       KIVI_CARE_PRO_PREFIX.'patient_encounters_templates']
                   )){
                       $capability['encounters_template_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[KIVI_CARE_PRO_PREFIX.'medical_records_add',
                       KIVI_CARE_PRO_PREFIX.'medical_records_delete',
                       KIVI_CARE_PRO_PREFIX.'medical_records_edit',
                       KIVI_CARE_PRO_PREFIX.'medical_records_list'
                   ])){
                       $capability['clinical_detail_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'prescription_add',
                       KIVI_CARE_PRO_PREFIX.'prescription_delete',
                       KIVI_CARE_PRO_PREFIX.'prescription_edit',
                       KIVI_CARE_PRO_PREFIX.'prescription_view',
                       KIVI_CARE_PRO_PREFIX.'prescription_list',
                       KIVI_CARE_PRO_PREFIX.'prescription_export',
                   ])){
                       $capability['prescription_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'patient_report',
                       KIVI_CARE_PRO_PREFIX.'patient_report_add',
                       KIVI_CARE_PRO_PREFIX.'patient_report_edit',
                       KIVI_CARE_PRO_PREFIX.'patient_report_view',
                       KIVI_CARE_PRO_PREFIX.'patient_report_delete'
                   ])){
                       $capability['patient_report_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'clinic_add',
                       KIVI_CARE_PRO_PREFIX.'clinic_delete',
                       KIVI_CARE_PRO_PREFIX.'clinic_edit',
                       KIVI_CARE_PRO_PREFIX.'clinic_view',
                       KIVI_CARE_PRO_PREFIX.'clinic_list',
                       KIVI_CARE_PRO_PREFIX.'clinic_profile',
                       KIVI_CARE_PRO_PREFIX.'clinic_export',
                       KIVI_CARE_PRO_PREFIX.'clinic_resend_credential',
                   ])){
                       $capability['clinic_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'patient_add',
                       KIVI_CARE_PRO_PREFIX.'patient_delete',
                       KIVI_CARE_PRO_PREFIX.'patient_clinic',
                       KIVI_CARE_PRO_PREFIX.'patient_edit',
                       KIVI_CARE_PRO_PREFIX.'patient_view',
                       KIVI_CARE_PRO_PREFIX.'patient_list',
                       KIVI_CARE_PRO_PREFIX.'patient_profile',
                       KIVI_CARE_PRO_PREFIX.'patient_export',
                       KIVI_CARE_PRO_PREFIX.'patient_resend_credential',
                   ])){
                       $capability['patient_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if($role !== $this->getPatientRole() && in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'doctor_add',
                       KIVI_CARE_PRO_PREFIX.'doctor_delete',
                       KIVI_CARE_PRO_PREFIX.'doctor_dashboard',
                       KIVI_CARE_PRO_PREFIX.'doctor_edit',
                       KIVI_CARE_PRO_PREFIX.'doctor_view',
                       KIVI_CARE_PRO_PREFIX.'doctor_list',
                       KIVI_CARE_PRO_PREFIX.'doctor_profile',
                       KIVI_CARE_PRO_PREFIX.'doctor_export',
                    //    KIVI_CARE_PRO_PREFIX.'patient_review_add',
                    //    KIVI_CARE_PRO_PREFIX.'patient_review_edit',
                    //    KIVI_CARE_PRO_PREFIX.'patient_review_delete',
                       KIVI_CARE_PRO_PREFIX.'patient_review_get',
                       KIVI_CARE_PRO_PREFIX.'doctor_resend_credential',
                   ])){
                       $capability['doctor_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if($isEnableReceptionistModule && in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'receptionist_add',
                       KIVI_CARE_PRO_PREFIX.'receptionist_delete',
                       KIVI_CARE_PRO_PREFIX.'receptionist_edit',
                       KIVI_CARE_PRO_PREFIX.'receptionist_view',
                       KIVI_CARE_PRO_PREFIX.'receptionist_list',
                       KIVI_CARE_PRO_PREFIX.'receptionist_profile',
                       KIVI_CARE_PRO_PREFIX.'receptionist_export',
                       KIVI_CARE_PRO_PREFIX.'receptionist_resend_credential',
                   ])){
                       $capability['receptionist_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'service_add',
                       KIVI_CARE_PRO_PREFIX.'service_delete',
                       KIVI_CARE_PRO_PREFIX.'service_edit',
                       KIVI_CARE_PRO_PREFIX.'service_view',
                       KIVI_CARE_PRO_PREFIX.'service_list',
                       KIVI_CARE_PRO_PREFIX.'service_export'
                   ])){
                       $capability['service_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'doctor_session_add',
                       KIVI_CARE_PRO_PREFIX.'doctor_session_delete',
                       KIVI_CARE_PRO_PREFIX.'doctor_session_edit',
                       KIVI_CARE_PRO_PREFIX.'doctor_session_list',
                       KIVI_CARE_PRO_PREFIX.'doctor_session_export'
                   ])){
                       $capability['session_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if($isEnableBillingModule && in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'patient_bill_add',
                    //    KIVI_CARE_PRO_PREFIX.'patient_bill_delete',
                       KIVI_CARE_PRO_PREFIX.'patient_bill_edit',
                       KIVI_CARE_PRO_PREFIX.'patient_bill_list',
                       KIVI_CARE_PRO_PREFIX.'patient_bill_export',
                       KIVI_CARE_PRO_PREFIX.'patient_bill_view'
                   ])){
                       $capability['billing_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if($isEnableCustomFieldsModule && in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'custom_field_add',
                       KIVI_CARE_PRO_PREFIX.'custom_field_delete',
                       KIVI_CARE_PRO_PREFIX.'custom_field_edit',
                       KIVI_CARE_PRO_PREFIX.'custom_field_list',
                       KIVI_CARE_PRO_PREFIX.'custom_field_export',
                       KIVI_CARE_PRO_PREFIX.'custom_field_view'
                   ])){
                       $capability['custom_field_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'static_data_add',
                       KIVI_CARE_PRO_PREFIX.'static_data_delete',
                       KIVI_CARE_PRO_PREFIX.'static_data_edit',
                       KIVI_CARE_PRO_PREFIX.'static_data_list',
                       KIVI_CARE_PRO_PREFIX.'static_data_export',
                       KIVI_CARE_PRO_PREFIX.'static_data_view'
                   ])){
                       $capability['static_data_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'clinic_schedule',
                       KIVI_CARE_PRO_PREFIX.'clinic_schedule_add',
                       KIVI_CARE_PRO_PREFIX.'clinic_schedule_edit',
                       KIVI_CARE_PRO_PREFIX.'clinic_schedule_delete',
                       KIVI_CARE_PRO_PREFIX.'clinic_schedule_export',
                   ])){
                       $capability['holiday_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if(in_array($capKey,[
                       KIVI_CARE_PRO_PREFIX.'dashboard_total_patient',
                       KIVI_CARE_PRO_PREFIX.'dashboard_total_appointment',
                       KIVI_CARE_PRO_PREFIX.'dashboard_total_today_appointment',
                       KIVI_CARE_PRO_PREFIX.'dashboard_total_doctor',
                       KIVI_CARE_PRO_PREFIX.'dashboard_total_service',
                       KIVI_CARE_PRO_PREFIX.'dashboard_total_revenue',
                   ])){
                       $capability['dashboard_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }else if($role === $this->getPatientRole() && in_array($capKey,[
                        KIVI_CARE_PRO_PREFIX.'patient_review_add',
                        KIVI_CARE_PRO_PREFIX.'patient_review_edit',
                        // KIVI_CARE_PRO_PREFIX.'patient_review_delete',
                        KIVI_CARE_PRO_PREFIX.'patient_review_get',
                   ])){
                        $capability['patient_review_module'][$capKey] = in_array($capVal, ['1', 1, 'true', true]);
                   }else{
                        $capability['other_module'][$capKey] = in_array($capVal,['1',1,'true',true]);
                   }
               }
           }
            $capability = apply_filters( 'kcpro_module_permission_filter', $capability, $role );
            $temp[$role] = [
              'name' =>  $cap['name'],
              'capabilities' => collect($capability)->sortKeys()
            ];

        }
        $data = $temp;
        return [
            'data' => $data,
            'status' => true
        ];
    }

    public function savePermissionList($data){

        if(!empty($data['data']) && is_array($data['data']) && !empty($data['type']) && !empty(!empty($data['data'][$data['type']]['capabilities']))){
            $capabilities = $data['data'][$data['type']]['capabilities'];
            $cap1 = [];
            foreach ($capabilities as $cap2){
                $cap1 = array_merge($cap1,$cap2);
            }
            $capabilities = $cap1;
            if(!empty($capabilities)){
                $subscriber = get_role($data['type']);
                if(!empty($subscriber)){
                    foreach($capabilities as $key => $cap){
                        if(!empty($key)){
                            // $subscriber->remove_cap($key);
                            $subscriber->add_cap($key,in_array($cap,['1',1,true,'true']));
                        }
                    }
                    return [
                        'status' => true,
                        'message' => __('Permission updated successfully','kiviCare-clinic-&-patient-management-system-pro')
                    ];
                }

            }
        }
        return [
            'status' => false,
            'message' => __('Data not found','kiviCare-clinic-&-patient-management-system-pro')
        ];
    }
}