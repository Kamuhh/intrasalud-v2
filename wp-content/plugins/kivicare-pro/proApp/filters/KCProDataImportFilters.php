<?php

namespace ProApp\filters;

use App\baseClasses\KCBase;
use App\models\KCClinic;
use App\models\KCAppointment;
use App\models\KCAppointmentServiceMapping;
use App\models\KCPatientEncounter;
use mysql_xdevapi\Exception;
use App\models\KCStaticData;
use App\models\KCPatientClinicMapping;
use App\models\KCDoctorClinicMapping;
use App\models\KCReceptionistClinicMapping;
use App\models\KCService;
use App\models\KCServiceDoctorMapping;
use App\models\KCCustomField;
use App\models\KCPrescription;
use WP_User;

use \PhpOffice\PhpSpreadsheet\IOFactory;

class KCProDataImportFilters extends KCBase{

    public  $date_time ;
    public  $telemed_plugin_active;
    public  $default_clinic_id;
    public  $googlemeet_plugin_active;
    public  $db;
    public  $sms_notification_setting_enable;
    public  $current_user_id;
    public  $total_data_insert;
    public  $patient_unique_id_enable;
    public  $clinic_currency_detail;
    public  $already_exits_response;
    public $current_user_role;
    public $condition_wise_default_clinic;
    public  $total_processed_row;
    public function __construct() {
        add_filter('kcpro_import_module_wise_data', [$this, 'importModuleWiseData']);
        add_filter('kcpro_import_demo_files', [$this, 'importDemoFiles']);
    }

    public function importModuleWiseData($data)
    {

        switch ($data['data']['type']){
            case 'csv':
            case 'xls':
                $response = $this->excelData($data['data']);
                break;
            default:
                $response = [
                    'status' => false,
                    'message' => esc_html__('Import Type not supported', 'kiviCare-clinic-&-patient-management-system-pro'),
                    'data' => $data
                ];
                break;
        }

        return $response;
    }

    public function excelData($data)
    {


        try {
            $return_response = ['status' => false, 'message' => ""];
            if(empty($data["id"])){
                $return_response['message'] = esc_html__("Data Import Failed",'kiviCare-clinic-&-patient-management-system-pro');
                return $return_response;
            }

            
            $inputFileName = get_attached_file($data["id"]);

            $inputFileType = IOFactory::identify($inputFileName);

            $reader = IOFactory::createReader($inputFileType);

            $reader->setReadDataOnly(true);

            $reader->setReadEmptyCells(false);

            $spreadsheet = $reader->load($inputFileName);

            $file_data = $spreadsheet->getActiveSheet()->toArray();

            //check if file is not empty
            if(empty($file_data)){
                $return_response['message'] = esc_html__( "File is empty",'kiviCare-clinic-&-patient-management-system-pro');
                return $return_response;
            }

            //check if file have minimun two row
            if(count($file_data) < 2){
                $return_response['message'] = esc_html__("Only column  data in file",'kiviCare-clinic-&-patient-management-system-pro');
                return $return_response;
            }

            $keys = array_values($file_data[0]);
            // check if first row have all required field
            $required_field = true;
            if(in_array($data['module_type'],['clinic','receptionist','doctor','patient'])){
                if(empty($data['e_mail']) || (string)$data['e_mail'] == 'true'){
                    remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
                }
            }
	        $keys = array_map(function ($v){
				return strip_tags(trim($v));
	        },$keys);
            foreach ($data['required_field'] as  $value){
	            $value = trim(strtolower($value));
	            if(!in_array($value,$keys)){
	                $value_txt = str_replace('_', ' ', $value);
                    $return_response['message'] = esc_html__('Required ','kiviCare-clinic-&-patient-management-system-pro').$value_txt.esc_html__(' column not available in file','kiviCare-clinic-&-patient-management-system-pro');
                    $required_field = false;
                    break;
                }
            }
            if(!$required_field){
                return $return_response;
            }



            $header_columns_count = count($keys);
            unset($file_data[0]);

            //initialize class variables
            $this->date_time = current_time('Y-m-d H:i:s');
            $this->telemed_plugin_active = isKiviCareTelemedActive();
            $this->default_clinic_id = kcGetDefaultClinicId();
            $this->googlemeet_plugin_active = isKiviCareGoogleMeetActive();
            $this->sms_notification_setting_enable = kcCheckSmsOptionEnable();
            global $wpdb;
            $this->db = $wpdb;
            $this->current_user_id = get_current_user_id();
            $this->total_data_insert = 0;
            $this->patient_unique_id_enable = kcPatientUniqueIdEnable('status');
            $this->clinic_currency_detail = kcGetClinicCurrenyPrefixAndPostfix();

            $this->condition_wise_default_clinic = $this->default_clinic_id;
            if($this->current_user_role === $this->getReceptionistRole()){
                $this->condition_wise_default_clinic = kcGetClinicIdOfReceptionist();
            }elseif ($this->current_user_role === $this->getClinicAdminRole()){
                $this->condition_wise_default_clinic = kcGetClinicIdOfClinicAdmin();
            }elseif ($this->current_user_role === $this->getDoctorRole()){
                $this->condition_wise_default_clinic = (new KCDoctorClinicMapping())->get_var(['doctor_id' => $this->current_user_id],'clinic_id');
            }

            if(empty($this->condition_wise_default_clinic)){
                $this->condition_wise_default_clinic = $this->default_clinic_id;
            }

            $this->already_exits_response = [
                'static_data' => [
                    'already_same_data_exists' => [
                        'label' => esc_html__('Same data already exists Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                ],
                'service' =>[
                    'doctor_id_not_exists' => [
                        'label' => esc_html__('doctor id not valid Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'already_same_service_exists' => [
                        'label' => esc_html__('Same service already exists to doctor Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ]
                ],
                'customField' => [
                    'invalid_module_type' => [
                        'label' => esc_html__('Module type is not valid Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'invalid_input_type' => [
                        'label' => esc_html__('Input type is not valid Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'select_type_option_invalid' => [
                        'label' => esc_html__('Select/choice type input field options not available Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ]
                ],
                'clinic' => [
                    'clinic_admin_email_user_by_other_user' => [
                        'label' => esc_html__('Clinic admin email is already used by other users Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'clinic_email_user_by_other_user' => [
                        'label' => esc_html__('Clinic  email is already used by other users Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'clinic_admin_email_user_by_other_clinic' => [
                        'label' => esc_html__('Clinic admin email is already used by other clinic Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'clinic_email_user_by_other_clinic' => [
                        'label' => esc_html__('Clinic  email is already used by other clinic Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                ],
                'receptionist' => [
                    'email_user_by_other_user' =>[
                        'label' => esc_html__('Email is already used by other users Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'failed_to_save_user' => [
                        'label' => esc_html__('Failed to saved user data Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ]
                ],
                'doctor' => [
                    'email_user_by_other_user' => [
                        'label' => esc_html__('Email is already used by other users Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'failed_to_save_user' => [
                        'label' => esc_html__('Failed to saved user data Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ]
                ],
                'patient' => [
                    'email_user_by_other_user' => [
                        'label' => esc_html__('Email is already used by other users Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'failed_to_save_user' =>[
                        'label' => esc_html__('Failed to saved user data Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ]
                ],
                'prescription' => [
                    'already_same_medicine_exists' => [
                        'label' => esc_html__('Same medicine already exists Rows','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ]
                ],
                'appointment' => [
                    'clinic_not_exists' => [
                        'label' => esc_html__('Clinic not found','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'doctor_not_exists' => [
                        'label' => esc_html__('Doctor not found','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'patient_not_exists' => [
                        'label' => esc_html__('Patient not found','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'invalid_details' => [
                        'label' => esc_html__('Invalid appointment details','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
                    'failed_to_save' => [
                        'label' => esc_html__('Failed to import data','kiviCare-clinic-&-patient-management-system-pro'),
                        'value' => 0
                    ],
	                'already_exists' => [
		                'label' => esc_html__('Already exists same appointment data','kiviCare-clinic-&-patient-management-system-pro'),
		                'value' => 0
	                ]
                ]
    
            ];
            $this->current_user_role = $data['current_user_role'];
            $start_from     =  $data['start_from'];
            foreach ($file_data as $i => $a) {
                if (!empty($a)) {
                    //match first row column with all other row data
                    $a = array_slice($a, 0, $header_columns_count);
                    $rows = array_combine($keys, $a);
                    $this->insertListing($rows,$data,$i,$start_from);
                }  
            }   
            switch ($data['module_type']) {
                case 'patient':
                    $this->already_exits_response[$data['module_type']]['email_user_by_other_user']['value'] += intval($data['same_e_mail_used']);
                    $this->already_exits_response[$data['module_type']]['failed_to_save_user']['value'] += intval($data['failed_to_save_user']);
                    break;
            
                case 'appointment':
                    $this->already_exits_response[$data['module_type']]['invalid_details']['value'] += intval($data['invalid_details']);
                    $this->already_exits_response[$data['module_type']]['patient_not_exists']['value'] += intval($data['patient_not_exists']);
                    $this->already_exits_response[$data['module_type']]['clinic_not_exists']['value'] += intval($data['clinic_not_exists']);
                    $this->already_exits_response[$data['module_type']]['doctor_not_exists']['value'] += intval($data['doctor_not_exists']);
                    $this->already_exits_response[$data['module_type']]['already_exists']['value'] += intval($data['already_exists']);
                    $this->already_exits_response[$data['module_type']]['failed_to_save']['value'] += intval($data['failed_to_save']);
                    break;
            
                case 'static_data':
                    $this->already_exits_response[$data['module_type']]['already_same_data_exists']['value'] += intval($data['already_same_data_exists']);
                    break;
            
                case 'service':
                    $this->already_exits_response[$data['module_type']]['doctor_id_not_exists']['value'] += intval($data['doctor_id_not_exists']);
                    $this->already_exits_response[$data['module_type']]['already_same_service_exists']['value'] += intval($data['already_same_service_exists']);
                    break;
            
                case 'customField':
                    $this->already_exits_response[$data['module_type']]['invalid_module_type']['value'] += intval($data['invalid_module_type']);
                    $this->already_exits_response[$data['module_type']]['invalid_input_type']['value'] += intval($data['invalid_input_type']);
                    $this->already_exits_response[$data['module_type']]['select_type_option_invalid']['value'] += intval($data['select_type_option_invalid']);
                    break;
            
                case 'clinic':
                    $this->already_exits_response[$data['module_type']]['clinic_email_user_by_other_user']['value'] += intval($data['clinic_email_user_by_other_user']);
                    $this->already_exits_response[$data['module_type']]['clinic_admin_email_user_by_other_user']['value'] += intval($data['clinic_admin_email_user_by_other_user']);
                    $this->already_exits_response[$data['module_type']]['clinic_email_user_by_other_clinic']['value'] += intval($data['clinic_email_user_by_other_clinic']);
                    $this->already_exits_response[$data['module_type']]['clinic_admin_email_user_by_other_clinic']['value'] += intval($data['clinic_admin_email_user_by_other_clinic']);
                    break;
            
                case 'receptionist':
                    $this->already_exits_response[$data['module_type']]['email_user_by_other_user']['value'] += intval($data['email_user_by_other_user']);
                    break;
            
                case 'doctor':
                    $this->already_exits_response[$data['module_type']]['email_user_by_other_user']['value'] += intval($data['email_user_by_other_user']);
                    $this->already_exits_response[$data['module_type']]['failed_to_save_user']['value'] += intval($data['failed_to_save_user']);
                    break;
            
                default:
                    // Handle cases where module_type doesn't match predefined cases
                    break;
            }
            $total = count($file_data);
            $return_response['status'] = true;
            $return_response['message'] =  $this->total_data_insert ==0 ? esc_html__('No Data Imported', 'kiviCare-clinic-&-patient-management-system-pro') :  esc_html__(' Data Import Successfully', 'kiviCare-clinic-&-patient-management-system-pro');
            $return_response['total_data_insert'] = $this->total_data_insert;
            $return_response['remaining_row'] =  $total- $this->total_processed_row;
            $return_response['detail_report'] = $this->already_exits_response[$data['module_type']];
            $return_response['total_row'] = $total;

            return $return_response;

        }catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e){
            return  ['status' => false,'message' => $e->getMessage()];
        }
    }

    public function importDemoFiles($data)
    {

        $module_type = $data['data']['module_type'];
        $base_url = KIVI_CARE_PRO_DIR_URI.'assets/demo_import_files/';
        return [
            'status' => true,
            'message' => esc_html__('Demo import files', 'kiviCare-clinic-&-patient-management-system-pro'),
            'data' => [
                'csv' => $this->getDemoFileUrl($base_url,$module_type,'csv'),
                'xls' => $this->getDemoFileUrl($base_url,$module_type,'xlsx'),
            ]
        ];
    }

    public function insertListing($import_data,$data,$index,$starting_from){

        //check if row data have all required field data
        // $required_field = true;
        // foreach ($data['required_field'] as $key => $value){
        //     if(empty($import_data[$value])){
        //         $required_field = false;
        //         break;
        //     }
        // }

        // if(!$required_field){
        //     return ;
        // }    
        switch ($data['module_type']){
            case 'appointment':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    $appointment_date = esc_sql(date( 'Y-m-d',strtotime($import_data['date'])));
                    $current_date = current_time('Y-m-d');
                    if($current_date < $appointment_date){
                        $this->already_exits_response['appointment']['invalid_details']['value']++;
                        return;
                    }

                    $appointment_start_time = esc_sql(date( 'H:i:s', strtotime( $import_data['start_time'])));
                    $appointment_end_time = esc_sql(date( 'H:i:s', strtotime( $import_data['end_time'])));
                    if(empty($appointment_start_time) || empty($appointment_end_time)){
                        $this->already_exits_response['appointment']['invalid_details']['value']++;
                        return;
                    }

                    $clinic_name = esc_sql(trim($import_data['clinic_name']));
                    $clinic_id = $this->db->get_var("SELECT id FROM {$this->db->prefix}kc_clinics WHERE name ='{$clinic_name}'");
                    if(empty($clinic_id)){
                        $this->already_exits_response['appointment']['clinic_not_exists']['value']++;
                        return;
                    }

                    $patient_name = esc_sql(trim($import_data['patient_name']));
                    $patient_id = $this->db->get_var("SELECT ID FROM {$this->db->base_prefix}users WHERE display_name ='{$patient_name}'");
                    if(empty($patient_id)){
                        $this->already_exits_response['appointment']['patient_not_exists']['value']++;
                        return;
                    }

                    $doctor_name = esc_sql(trim($import_data['doctor_name']));
                    
                    $doctor_id = $this->db->get_var("
                        SELECT u.ID 
                        FROM {$this->db->base_prefix}users u
                        INNER JOIN {$this->db->base_prefix}usermeta um 
                            ON u.ID = um.user_id
                        WHERE u.display_name = '{$doctor_name}' 
                        AND um.meta_key = '{$this->db->prefix}capabilities' 
                        AND um.meta_value LIKE '%{$this->getDoctorRole()}%'
                    ");

                    if(empty($doctor_id)){
                        $this->already_exits_response['appointment']['doctor_not_exists']['value']++;
                        return;
                    }

                    $import_data['service'] = explode(',',$import_data['service']);
                    $service = new KCService();
                    $service_mapping = new KCServiceDoctorMapping();
                    $service_id = [];
                    foreach ($import_data['service'] as $ser){
                        $ser = esc_sql(trim($ser));
                        $ser_id = $service->get_var(['name' => $ser],'id');
                        if(empty($ser_id)){
                            $ser_id = $service->insert([
                                'type' => 'family_medicine',
                                'name' => $ser,
                                'price' => 0,
                                'status' => 1,
                                'created_at' => $this->date_time
                            ]);
                        }

                        $service_mapping_id = $service_mapping->get_var([
                            'service_id' => $ser_id ,
                            'doctor_id' => $doctor_id
                        ],'id');

                        if(empty($service_mapping_id)){
                            $service_mapping->insert([
                                'service_id' => $ser_id ,
                                'doctor_id' => $doctor_id,
                                'clinic_id' => $clinic_id,
                                'charges' => 0,
                                'status' => 1,
                                'created_at' => $this->date_time,
                                'telemed_service' => 'no'
                            ]);
                        }

                        $service_id[] = $ser_id;
                    }

                    $appointment_data = [
                        'appointment_start_date' => $appointment_date,
                        'appointment_start_time' => $appointment_start_time,
                        'appointment_end_date'   => $appointment_date,
                        'appointment_end_time'   => $appointment_end_time,
                        'clinic_id'              => $clinic_id,
                        'doctor_id'              => $doctor_id,
                        'patient_id'             => $patient_id,
                        'description'            => '',
                        'status'                 => $import_data['status'],
                    ];
                    if(!empty((new KCAppointment())->get_var($appointment_data,'id'))){
                        if(empty($appointment_id)){
                            $this->already_exits_response['appointment']['already_exists']['value']++;
                            return;
                        }
                    }
                    $appointment_data['created_at'] = $this->date_time;
                    $appointment_id = (int)(new KCAppointment())->insert($appointment_data);
                    if(empty($appointment_id)){
                        $this->already_exits_response['appointment']['failed_to_save']['value']++;
                        return;
                    }
                    foreach($service_id as $ser_id){
                        (new KCAppointmentServiceMapping())->insert([
                            'appointment_id' => $appointment_id,
                            'service_id' => $ser_id,
                            'created_at' => $this->date_time,
                            'status'=> 1
                        ]);
                    }
                    $this->total_data_insert++;
                    do_action('kc_appointment_book', $appointment_id);
                }
                break;
            case 'static_data':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    $static_data = new KCStaticData;
                    $import_data['type'] = str_replace(' ', '_', strtolower($import_data['type']));
                    //check if same already exists , if exists don't save
                    if(!empty($static_data->get_var(['label' => trim($import_data['name']),'type' => trim($import_data['type'])],'id'))){
                        $this->already_exits_response['static_data']['already_same_data_exists']['value']++;
                        return;
                    }
                    $value = str_replace(' ', '_', strtolower($import_data['name']));
                    $temp = [
                        'label' => $import_data['name'],
                        'type' => $import_data['type'],
                        'value' => $value,
                        'status' => isset($import_data['status']) ? (in_array((string)$import_data['status'],['1','0']) ? $import_data['status'] : 1 ) : 1,
                        'created_at' => $this->date_time
                    ];
                    $static_data->insert($temp);
                    $this->total_data_insert++;
                }
                break;
            case 'service':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    $import_data['doctor_id'] =explode(',',$import_data['doctor_id']);
                    foreach ($import_data['doctor_id'] as $doctor){
                        if(!in_array($doctor,$data['valid_doctor_id'])){
                            $this->already_exits_response['service']['doctor_id_not_exists']['value']++;
                            return;
                        }
                        $temp = [
                            'type' => str_replace(" ","_",$import_data['category']),
                            'name'   => trim($import_data['name']),
                            'price'  => (float)$import_data['charges'],
                            'created_at' => $this->date_time,
                            'status' => isset($import_data['status']) && in_array((string)$import_data['status'],['0','1']) ? $import_data['status'] : 1
                        ];
                        if(!empty($this->db->get_var("SELECT map.id FROM {$this->db->prefix}kc_service_doctor_mapping AS map LEFT JOIN {$this->db->prefix}kc_services AS ser ON ser.id=map.service_id WHERE 0=0 AND map.doctor_id = {$doctor} AND map.clinic_id = {$import_data['clinic_id']} AND ser.type ='{$temp['type']}' AND ser.name='{$temp['name']}'"))){
                            $this->already_exits_response['service']['already_same_service_exists']['value']++;
                            return;
                        }
                        $service = new KCService();
                        $service_id = $service->get_var(['type' => $temp['type'] ,'name' => $temp['name']],'id');;
                        if(empty($service_id)){
                            $service_id = $service->insert( $temp );
                        }
                        if (!empty($service_id)) {
                            $service_mapping_data = [
                                'service_id' => (int)$service_id,
                                'doctor_id'  => $doctor,
                                'clinic_id'  => !empty($import_data['clinic_id']) ? $import_data['clinic_id'] :  $this->default_clinic_id,
                                'charges'    => (float)$import_data['charges'],
                                'status'  =>  isset($import_data['status']) && in_array((string)$import_data['status'],['0','1']) ? $import_data['status'] : 1,
                                'created_at'  => $this->date_time,
                                'service_name_alias'  => '',
                                'multiple'  =>  !empty($import_data['multi_selection']) && in_array($import_data['multi_selection'],['no','yes']) ? $import_data['multi_selection'] : 'yes',
                                'telemed_service' => ($this->telemed_plugin_active || $this->googlemeet_plugin_active) && !empty($import_data['telemed_service']) &&  in_array($import_data['telemed_service'],['no','yes']) ? $import_data['telemed_service'] : 'no',
                            ];
                            if(isset($import_data['duration']) && !empty((int)$import_data['duration'])){
                                $service_mapping_data['duration'] = (int)$import_data['duration'];
                            }
                            if(!empty($import_data['service_image'])){
                                $image = $this->uploadImage($import_data['service_image']);
                                $service_mapping_data['image'] = !empty($image) ? $image  : '';
                            }

                            (new KCServiceDoctorMapping())->insert($service_mapping_data);
                            $this->total_data_insert++;
                        }
                        // hook for service add.
                        do_action( 'kc_service_add', $service_mapping_data );
                    }
                }
                break;
            case 'customField':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    $accepted_module_type = ['doctor_module','patient_module','patient_encounter_module','appointment_module'];
                    $accepted_input_type = ['select','radio','checkbox','text','number','textarea','calendar'];            
                    if(!in_array($import_data['module'],$accepted_module_type)){
                        $this->already_exits_response['customField']['invalid_module_type']['value']++;
                        return;
                    }
                    if(!in_array($import_data['input_type'],$accepted_input_type)){
                        $this->already_exits_response['customField']['invalid_input_type']['value']++;
                        return;
                    }
                    $selected_type_input_field = ['select','radio','checkbox'];
                    if(in_array($import_data['input_type'],$selected_type_input_field) && empty($import_data['options'])){
                        $this->already_exits_response['customField']['select_type_option_invalid']['value']++;
                        return;
                    }
                    $option = !empty($import_data['options']) ? explode(",",$import_data['options']) : [];
                    $option = array_unique($option);
                    $options = collect($option)->map(function ($option) {
                        return [
                            'id'=>$option,
                            'text'=>$option
                        ];
                    })->toArray();
                    $temp = [
                        'module_type' => $import_data['module'],
                        'fields'      => json_encode([
                            'isRequired' => isset($import_data['required']) ? (string)$import_data['required'] : '' ,
                            'label'      => $import_data['label'] ,
                            'placeholder'=> !empty($import_data['placeholder']) ? $import_data['placeholder'] : '' ,
                            'options'    => !empty($options) ? $options : "",
                            'type'       => $import_data['input_type'] ,
                            'status'     => isset($import_data['status']) && in_array((string)$import_data['status'],['0','1']) ? $import_data['status'] : 1 ,
                        ]),
                        'module_id' => (!empty($import_data['doctor_id']) && $import_data['module'] === "appointment_module") ? $import_data['doctor_id'] : 0,
                        'status'      => isset($import_data['status']) && in_array((string)$import_data['status'],['0','1']) ? $import_data['status'] : 1 ,
                        'created_at'  => $this->date_time,
                    ];

                    ( new KCCustomField())->insert( $temp );

                    $this->total_data_insert++;
                }
                break;
            case 'clinic':

                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    //check email with existing WordPress user
                    $clinic_email_condition = kcCheckUserEmailAlreadyUsed(['user_email' => $import_data['email'],'ID' => ''],true);
                    if(empty($clinic_email_condition['status'])){
                        $this->already_exits_response['clinic']['clinic_email_user_by_other_user']['value']++;
                        return;
                    }
                    $clinic_admin_email_condition = kcCheckUserEmailAlreadyUsed(['user_email' => $import_data['clinic_admin_email'],'ID' => '']);
                    if(empty($clinic_admin_email_condition['status'])){
                        $this->already_exits_response['clinic']['clinic_admin_email_user_by_other_user']['value']++;
                        return;
                    }
                    $clinic = new KCClinic;

                    $clinic_email_exists = $clinic->get_var(['email' => $import_data['email']],'id');

                    if(!empty($clinic_email_exists)){
                        $this->already_exits_response['clinic']['clinic_email_user_by_other_clinic']['value']++;
                        return;
                    }

                    $clinic_admin_email_exists = $clinic->get_var(['email' => $import_data['clinic_admin_email']],'id');
                    if(!empty($clinic_admin_email_exists)){
                        $this->already_exits_response['clinic']['clinic_admin_email_user_by_other_clinic']['value']++;
                        return;
                    }

                    $password = !empty($import_data["password"]) ? $import_data["password"] : kcGenerateString( 12 );

                    $clinicAdminData = array(
                        'first_name'=> !empty($import_data['clinic_admin_first_name']) ? $import_data['clinic_admin_first_name'] : "",
                        'last_name'=> !empty($import_data['clinic_admin_last_name']) ? $import_data['clinic_admin_last_name'] : "",
                        'user_email'=> !empty($import_data['clinic_admin_email']) ? $import_data['clinic_admin_email'] : "",
                        'mobile_number'=> !empty($import_data['clinic_admin_contact']) ? $import_data['clinic_admin_contact'] : "",
                        'gender'=> !empty($import_data['clinic_admin_gender']) ? $import_data['clinic_admin_gender'] : "",
                        'dob'=> !empty($import_data['clinic_admin_dob']) ? date("Y-m-d", strtotime($import_data['clinic_admin_dob'])) : "",
                        'country_calling_code_admin'=> !empty($import_data['clinic_admin_country_calling_code']) ? $import_data['clinic_admin_country_calling_code'] : "",
                        'country_code_admin'=> !empty($import_data['clinic_admin_country_code']) ? $import_data['clinic_admin_country_code'] : "",
                    );

                    $clinicData = array(
                        'name'=> $import_data['clinic_name'],
                        'email'=> !empty($import_data['email']) ? $import_data['email'] : "",
                        'specialties'=> json_encode(!empty($specialization = $this->getSpecialization($import_data)) ? $specialization : []),
                        'status'=> !empty($import_data['status']) ? $import_data['status'] : 1,
                        'telephone_no'=> !empty($import_data['contact']) ? $import_data['contact'] : "",
                        'address'=> !empty($import_data['address']) ? $import_data['address'] : "",
                        'city'=> !empty($import_data['city']) ? $import_data['city'] : "",
                        'country'=> !empty($import_data['country']) ? $import_data['country'] : "",
                        'postal_code'=> !empty($import_data['postal_code']) ? $import_data['postal_code'] : "",
                        'extra' => json_encode([
                            'currency_prefix' =>   $this->clinic_currency_detail['prefix'],
                            'currency_postfix' => $this->clinic_currency_detail['postfix'],
                        ]),
                        'country_calling_code'=> !empty($import_data['country_calling_code']) ? $import_data['country_calling_code'] : "",
                        'country_code'=> !empty($import_data['country_code']) ? $import_data['country_code'] : "",
                    );


                    if(!empty($import_data['clinic_admin_profile_image'])){
                        $image = $this->uploadImage($import_data['clinic_admin_profile_image']);
                        $clinicAdminData['profile_image'] = !empty($image) ? $image  : '';
                    }

                    if(!empty($import_data['clinic_profile_image'])){
                        $image = $this->uploadImage($import_data['clinic_profile_image']);
                        $clinicData['profile_image'] = !empty($image) ? $image  : '';
                    }
                    apply_filters('kcpro_save_clinic', [
                        'clinicData' =>  $clinicData,
                        'clinicAdminData'=>$clinicAdminData,
                        'id'=> '',
                        'password' => $password
                    ]);

                    $this->total_data_insert++;
                }
                break;
            case 'receptionist':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    if(email_exists($import_data['email'])){
                        $this->already_exits_response['receptionist']['email_user_by_other_user']['value']++;
                        return;
                    }
                    $import_data['password'] = !empty($import_data["password"]) ? $import_data["password"] : kcGenerateString( 12 );
                    $import_data['user_role'] = $this->getReceptionistRole();
                    $import_data['status'] = isset($import_data['status']) && in_array($import_data['status'],['0',0,'1',1])  ? $import_data['status'] : 0 ;
                    $user_id = $this->insertUser($import_data);

                    if(empty($user_id)){
                        $this->already_exits_response['receptionist']['failed_to_save_user']['value']++;
                        return;
                    }

                    $import_data['user_id'] = $user_id;
                    update_user_meta($user_id, 'first_name', $import_data['first_name'] );
                    update_user_meta($user_id, 'last_name', $import_data['last_name'] );
                    if(!empty($import_data['profile_image']) ){
                        $image = $this->uploadImage($import_data['profile_image']);
                        if (!empty($image)) {
                            update_user_meta($user_id, 'receptionist_profile_image',$image);
                        }
                    }

                    $temp = [
                        'mobile_number' => !empty($import_data['contact']) ? $import_data['contact'] : "",
                        'gender'        => !empty($import_data['gender']) ? $import_data['gender'] : "",
                        'dob'           => !empty($import_data['dob']) ?  date("Y-m-d", strtotime($import_data['dob'])) : '',
                        'address'       => !empty($import_data['address']) ? $import_data['address'] : "",
                        'city'          => !empty($import_data['city']) ? $import_data['city'] : "",
                        'state'         => '',
                        'country'       => !empty($import_data['country']) ? $import_data['country'] : "",
                        'postal_code'   => !empty($import_data['postal_code']) ? $import_data['postal_code'] : "",
                    ];

                    update_user_meta( $user_id, 'basic_data', json_encode( $temp, JSON_UNESCAPED_UNICODE ) );

                    //update user country calling code
                    update_user_meta($user_id, 'country_calling_code', $import_data['country_calling_code']);

                    //update user country code
                    update_user_meta($user_id, 'country_code', $import_data['country_code']);

                    // Insert receptionist Clinic mapping...
                    $clinic_id = !empty($import_data["clinic_id"]) && in_array($import_data["clinic_id"],$data['valid_clinic_id']) ?
                        $import_data["clinic_id"] : $this->condition_wise_default_clinic;

                    (new KCReceptionistClinicMapping())->insert( [
                        'receptionist_id' => $user_id,
                        'clinic_id'       => $clinic_id,
                        'created_at'      => $this->date_time
                    ] );

                    $this->total_data_insert++;
                    //send notification to import user
                    $import_data['template'] = 'receptionist_register';
                    $this->sendUserNotification($import_data,$data);
                    do_action( 'kc_receptionist_save', $user_id );
                }
                break;
            case 'doctor':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    if(email_exists($import_data['email'])){
                        $this->already_exits_response['doctor']['email_user_by_other_user']['value']++;
                        return;
                    }
                    $import_data['password'] = !empty($import_data["password"]) ? $import_data["password"] : kcGenerateString( 12 );
                    $import_data['user_role'] = $this->getDoctorRole();
                    $import_data['status'] = isset($import_data['status']) && in_array($import_data['status'],['0',0,'1',1])  ? $import_data['status'] : 0 ;
                    $user_id = $this->insertUser($import_data);
                    if(empty($user_id)){
                        $this->already_exits_response['doctor']['failed_to_save_user']['value']++;
                        return;
                    }
                    $import_data['user_id'] = $user_id;

                    //update user firstname
                    update_user_meta($user_id, 'first_name', $import_data['first_name']);
                    //update/save user lastname
                    update_user_meta($user_id, 'last_name', $import_data['last_name']);

                    //doctor qualification
                    $qualification = [];
                    if(!empty($import_data['degree_name']) && $import_data['degree_university'] && $import_data['degree_year']){
                        $degree = explode(",",$import_data['degree_name']);
                        $university = explode(",",$import_data['degree_university']);
                        $year = explode(",",$import_data['degree_year']);
                        $count_qualification = [count($degree),count($university),count($year)];
                        $min_value = min($count_qualification);
                        for ($i = 0; $i < $min_value; $i++) {
                            $qualification[] = ["degree" => $degree[$i], "university" => $university[$i], "year" => $year[$i]];
                        }

                    }

                    $temp = [
                        'mobile_number' => !empty($import_data['contact']) ? $import_data['contact'] : "",
                        'gender' => !empty($import_data['gender']) ? $import_data['gender'] : "",
                        'dob' => !empty($import_data['dob']) ? date("Y-m-d", strtotime($import_data['dob'])) : "",
                        'address' => !empty($import_data['address']) ? $import_data['address'] : "",
                        'city' => !empty($import_data['city']) ? $import_data['city'] : "",
                        'state' => !empty($import_data['state']) ? $import_data['state'] : '',
                        'country' => !empty($import_data['country']) ? $import_data['country'] : "",
                        'postal_code' => !empty($import_data['postal_code']) ? $import_data['postal_code'] : "",
                        'qualifications' => !empty($qualification) ? $qualification : [] ,
                        'price_type' => !empty($import_data['price_type']) ? $import_data['price_type'] : "",
                        'price' => !empty($import_data['price']) ? $import_data['price'] : "",
                        'no_of_experience' => !empty($import_data['experience']) ? $import_data['experience'] : "",
                        'video_price' => 0,
                        'specialties' => !empty($specialization = $this->getSpecialization($import_data)) ? $specialization : [],
                        'time_slot' => !empty($import_data['time_slot']) ? $import_data['time_slot'] : "",
                    ];
                    //update/save user other details
                    update_user_meta($user_id, 'basic_data', json_encode($temp, JSON_UNESCAPED_UNICODE));

                    //update user country calling code
                    update_user_meta($user_id, 'country_calling_code', $import_data['country_calling_code']);

                    //update user country code
                    update_user_meta($user_id, 'country_code', $import_data['country_code']);

                    //update/save user description
                    if( !empty($import_data['description'])){
                        update_user_meta($user_id, 'doctor_description',$import_data['description'] );
                    }

                    //update/save doctor profile image
                    if(!empty($import_data['profile_image']) ) {
                        $image = $this->uploadImage($import_data['profile_image']);
                        if (!empty($image)) {
                            update_user_meta($user_id, 'doctor_profile_image',$image);
                        }
                    }

                    //doctor clinic
                    if(!empty($import_data['clinic_id'])){
                        $clinics = explode(",",$import_data['clinic_id']);
                        $clinics = array_filter($clinics,function($v)use ($data){
                            return in_array($v,$data['valid_clinic_id']);
                        });
                    }
                    $clinics = !empty($clinics) ? $clinics : array($this->condition_wise_default_clinic);
                    $doctor_mapping = new KCDoctorClinicMapping;
                    foreach($clinics as $clinic){
                        $new_temp = [
                            'doctor_id' => $user_id,
                            'clinic_id' => $clinic,
                            'owner' => 0,
                            'created_at' => $this->date_time
                        ];
                        $doctor_mapping->insert($new_temp);
                    }


                    $this->total_data_insert++;

                    //send notification to import user
                    $import_data['template'] = 'doctor_registration';
                    $this->sendUserNotification($import_data,$data);
                    do_action( 'kc_doctor_save', $user_id );
                }
                break;
            case 'patient':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;
                    if(email_exists($import_data['email'])){
                        $this->already_exits_response['patient']['email_user_by_other_user']['value']++;
                        return;
                    }
                    $import_data['password'] = !empty($import_data["password"]) ? $import_data["password"] : kcGenerateString( 12 );
                    $import_data['user_role'] = $this->getPatientRole();
                    $import_data['status'] = isset($import_data['status']) && in_array($import_data['status'],['0',0,'1',1])  ? $import_data['status'] : 0 ;
                    $user_id = $this->insertUser($import_data);
                    if(empty($user_id)){
                        $this->already_exits_response['patient']['failed_to_save_user']['value']++;
                        return;
                    }
                    $import_data['user_id'] = $user_id;

                    foreach ($import_data as $key => $value) {
                        if (strpos($key, 'customfield') !== false || strpos($key, 'Customfield') !== false) {
                            $new_key = substr($key, strpos($key, '-') + 1);
                            $custom_fields_values[$new_key] = $value;
                        }
                    }

                    $kc_custom_fields_table = $this->db->prefix.'kc_custom_fields';
                    $kc_custom_fields_data_table = $this->db->prefix.'kc_custom_fields_data';

                    // loop through the custom fields values array
                    foreach ($custom_fields_values as $key => $value) {
                        // get the field name from the key
                        // $field_name = str_replace('customfield-', '', $key);
                    
                        // query the wp_kc_custom_fields table to get the field id
                        $field = $this->db->get_row("SELECT * FROM {$kc_custom_fields_table} WHERE module_type = 'patient_module' AND JSON_EXTRACT(fields, '$.name') = '$key'");
                    
                        // insert data into wp_kc_custom_fields_data table
                        if ($field) {
                        $custom_field_data = array(
                            'module_type' => 'patient_module',
                            'module_id' => $user_id,
                            'fields_data' => $value,
                            'field_id' => $field->id,
                            'created_at' => current_time('mysql')
                        );
                        $this->db->insert($kc_custom_fields_data_table, $custom_field_data);
                        }
                    }
                    
                    //patient added  by
                    update_user_meta( $user_id, 'patient_added_by', $this->current_user_id );
                    update_user_meta($user_id, 'first_name',$import_data['first_name'] );
                    update_user_meta($user_id, 'last_name', $import_data['last_name'] );
                    if($this->patient_unique_id_enable){
                        update_user_meta( $user_id, 'patient_unique_id',generatePatientUniqueIdRegister()) ;
                    }
                    //save patient profile image
                    if( !empty($import_data['profile_image'])  ){
                        $image = $this->uploadImage($import_data['profile_image']);
                        if (!empty($image)) {
                            update_user_meta($user_id, 'patient_profile_image',$image);
                        };
                    }

                    $temp = [
                        'mobile_number' => !empty($import_data['contact']) ? $import_data['contact'] : '',
                        'gender'        => !empty($import_data['gender']) ? $import_data['gender'] : '',
                        'dob'           => !empty($import_data['dob']) ? $import_data['dob'] : '',
                        'address'       => !empty($import_data['address']) ? $import_data['address'] : '',
                        'city'          => !empty($import_data['city']) ? $import_data['city'] : '',
                        'state'         => '',
                        'country'       => !empty($import_data['country']) ? $import_data['country'] : '',
                        'postal_code'   => !empty($import_data['postal_code']) ? $import_data['postal_code'] : '',
                        'blood_group'   => !empty($import_data['blood_group']) && $import_data['blood_group'] !== 'default' ? $import_data['blood_group'] : '',
                    ];
                    update_user_meta( $user_id, 'basic_data', json_encode( $temp, JSON_UNESCAPED_UNICODE ));

                    //update user country calling code
                    update_user_meta($user_id, 'country_calling_code', $import_data['country_calling_code']);

                    //update user country code
                    update_user_meta($user_id, 'country_code', $import_data['country_code']);

                    // Insert Patient Clinic mapping...
                    $clinic_id =  !empty($import_data["clinic_id"]) && in_array($import_data["clinic_id"],$data['valid_clinic_id']) ?
                        $import_data["clinic_id"] : $this->condition_wise_default_clinic;

                    ( new KCPatientClinicMapping())->insert([
                        'patient_id' => $user_id,
                        'clinic_id' => $clinic_id,
                        'created_at' => $this->date_time
                    ]);

                    $this->total_data_insert++;

                    //send notification to import user
                    $import_data['template'] = 'patient_register';
                    $this->sendUserNotification($import_data,$data);
                    do_action( 'kc_patient_save', $user_id );
                }
                break;
            case 'prescription':
                if($index>$starting_from && $index-$starting_from <= 5){
                    $this->total_processed_row = $index;

                    $value = str_replace(' ','_',$import_data['name']);
                    if (empty((new KCStaticData())->get_var(['type' => 'prescription_medicine', 'value' => $value], 'id'))) {
                        (new KCStaticData())->insert([
                            'label' => $import_data['name'],
                            'type' => 'prescription_medicine',
                            'value' => $value,
                            'status' => 1,
                            'created_at' => $this->date_time
                        ]);
                    }
                    $temp = [
                        'encounter_id' => (int)$data['encounter_id'],
                        'name' => $import_data['name'],
                        'frequency' => $import_data['frequency'],
                        'duration' => (int)$import_data['duration'],
                        'instruction' => !empty($import_data['instruction']) ? $import_data['instruction'] : '',
                    ];
                    $prescription = new KCPrescription();
                    if (!empty($prescription->get_var($temp, 'id'))) {
                        $this->already_exits_response['prescription']['already_same_medicine_exists']['value']++;
                        return;
                    }
                    $temp['created_at'] = $this->date_time;
                    $temp['added_by'] = $this->current_user_id;
                    $prescription->insert($temp);
                    $this->total_data_insert++;
                }
                break;
        }
        return;
    }

    public function getDemoFileUrl($base_url,$module_type,$file_type)
    {
        $base_url .= $file_type.'/'.$module_type.'.'.$file_type;
        return $base_url;
    }

    public function insertUser($import_data)
    {
        $name = $import_data['first_name'] . " " . $import_data['last_name'];
        $user = wp_create_user( kcGenerateUsername( $name ), $import_data["password"], sanitize_email( $import_data['email'] ) );
        if(!is_wp_error($user)){
            $u               = new WP_User( $user );
            $u->display_name = $name;
            wp_insert_user( $u );
            // add  role to create user
            $u->set_role( $import_data['user_role']);
            $this->db->update($this->db->base_prefix . 'users', ['user_status' => $import_data['status']], ['ID' => $user]);
            return (int)$user;
        }

        return false;
    }

    public function sendUserNotification($import_data,$data){
        $email = !empty($data['e_mail']) && (string)$data['e_mail'] == 'true';
        $sms = !empty($data['sms']) && (string)$data['sms'] == 'true';
        if($email || $sms){
            //get email/sms/whatsapp template dynamic key array
            $user_email_param =  kcCommonNotificationUserData($import_data['user_id'],$import_data['password']);
            //send email after patient save
            if($email){
                kcSendEmail($user_email_param);
            }
            //send sms/whatsapp after patient save
            if($this->sms_notification_setting_enable && $sms
                && !empty($import_data['contact'])){
                apply_filters('kcpro_send_sms', [
                    'type' => $import_data['template'],
                    'user_data' => $user_email_param,
                ]);
            }
        }
    }

    public function getSpecialization($import_data){
        $specialization = [];
        if(!empty($import_data['specialization'])){
            $temp = explode(",",$import_data['specialization']);
            $static_data = new KCStaticData();
            foreach ($temp as $spec){
                $format_specialization = strtolower($spec);
                $format_specialization = str_replace(" ","_",$format_specialization);
                $static_data_id = $static_data->get_var(['type' => 'specialization' ,'value' => $format_specialization],'id');
                if(empty($static_data_id)){
                    $static_data_id = $static_data->insert([
                        'type' => 'specialization',
                        'label' => $spec ,
                        'value' => $format_specialization ,
                        'status' => 1 ,
                        'created_at' => $this->date_time
                    ]);
                }
                $specialization[] = ['id' => $static_data_id,'label' => $spec ];
            }
        }

        return $specialization;
    }

    public function uploadImage($url)
    {
        try{
            require_once( ABSPATH . "/wp-load.php");
            require_once( ABSPATH . "/wp-admin/includes/image.php");
            require_once( ABSPATH . "/wp-admin/includes/file.php");
            require_once( ABSPATH . "/wp-admin/includes/media.php");

            // Download url to a temp file
            $tmp = download_url( $url );
            if ( is_wp_error( $tmp ) ) return false;

            // Get the filename and extension ("photo.png" => "photo", "png")
            $filename = pathinfo($url, PATHINFO_FILENAME);
            $extension = pathinfo($url, PATHINFO_EXTENSION);


            // An extension is required or else WordPress will reject the upload
            if ( ! $extension ) {
                // Look up mime type, example: "/photo.png" -> "image/png"
                $mime = mime_content_type( $tmp );
                $mime = is_string($mime) ? sanitize_mime_type( $mime ) : false;

                // Only allow certain mime types because mime types do not always end in a valid extension (see the .doc example below)
                $mime_extensions = array(
                    // mime_type         => extension (no period)
                    'image/jpg'          => 'jpg',
                    'image/jpeg'         => 'jpeg',
                    'image/gif'          => 'gif',
                    'image/png'          => 'png',
                );

                if ( isset( $mime_extensions[$mime] ) ) {
                    // Use the mapped extension
                    $extension = $mime_extensions[$mime];
                }else{
                    // Could not identify extension
                    @unlink($tmp);
                    return false;
                }
            }


            // Upload by "sideloading": "the same way as an uploaded file is handled by media_handle_upload"
            $args = array(
                'name' => "$filename.$extension",
                'tmp_name' => $tmp,
            );

            // Do the upload
            $attachment_id = media_handle_sideload( $args, 0, '');
            // Cleanup temp file
            @unlink($tmp);

            // Error uploading
            if ( is_wp_error($attachment_id) ) return false;

            // Success, return attachment ID (int)
            return (int) $attachment_id;

        }catch(Exception $e){
            return false;
        }

    }

}