<?php

namespace ProApp\baseClasses;

use ProApp\filters\KCProPaymentFilter;

class KCProActivate  extends KCProBase
{

    /**
     * @var string
     */
    public $warningMessage = '';

    /**
     * function called when plugin activated
     * @return void
     */
    public static function activate()
    {
        global $wpdb;
        (new KCProGetDependency('kivicare-clinic-management-system', 'kc-lang'))->getPlugin();
        //add pro plugin tables
        
        (new self())->migratePermissions();


        //add default option
        (new self())->addModuleConfig();
        add_option(KIVI_CARE_PRO_PREFIX . 'theme_color', '#4874dc');
        add_option(KIVI_CARE_PRO_PREFIX . 'theme_mode', 'false');
        add_option(KIVI_CARE_PRO_PREFIX . 'admin_lang', 'en');

        //update woocommerce off is option not save previously
        if (!(new KCProHelper)->getOption('woocommerce_payment')) {
            (new KCProHelper)->updateOption('woocommerce_payment', 'off');
        }

        if ( ! get_option( KIVI_CARE_PRO_PREFIX . 'prescription_enconter_template_table_column_alter' ) ) {
            $table_prescription_enconter_template = $wpdb->prefix . 'kc_prescription_enconter_template';

            $new_fields_prescription_enconter_template = [
                'name' => 'text',
                'frequency' => 'varchar(50)',
                'duration' => 'varchar(50)',
                'instruction' => 'text',
            ];
            
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_prescription_enconter_template'") == $table_prescription_enconter_template) {
                kcUpdateFieldsDataType($table_prescription_enconter_template, $new_fields_prescription_enconter_template);
            }
            update_option( KIVI_CARE_PRO_PREFIX . 'prescription_enconter_template_table_column_alter', 'yes' );
           
        }       
    }

    /**
     * call all required hook and function
     * @return void
     */
    public function init()
    {
        //translate plugin text
        add_action('init', function () {
            load_plugin_textdomain('kiviCare-clinic-&-patient-management-system-pro', false, dirname(KIVI_CARE_PRO_BASE_PATH) . '/languages');
        });

        //add google calendar appointment mapping table add
        (new self())->migrateTable();
        (new self())->migrateDatabase();


        // (new self())->migratePermissions();

        //check if lite plugin install and admin notice
        // $this->migratePermissions();

        add_action('init', function () {
            // if (!get_option(KIVI_CARE_PRO_PREFIX . 'check_new_user_activated')) {
            //     kcProNewUserActivate();
            // }

            if (!function_exists('get_plugins')) {
                include_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            $kivicare_plugin = 'kivicare-clinic-management-system/kivicare-clinic-management-system.php';
            //check if lite plugin active and load require class file
            if (is_plugin_active($kivicare_plugin)) {
                $plugins = get_plugins();
                if ( !empty($plugins[ $kivicare_plugin ]) ) {
                    if (version_compare($plugins[ $kivicare_plugin ]['Version'], KIVI_CARE_PRO_REQUIRED_PLUGIN_VERSION, '>=')) {
                        (new KCProFilterHandler())->init();
                        return;
                    }
                }
            }
            //deactivate plugin if lite plugin not active
            deactivate_plugins(KIVI_CARE_PRO_BASE_PATH);
        });

        //check lite plugin active in rest api
        // add_action('rest_api_init', [$this, 'checkPluginActive']);
        add_action('admin_init', [$this, 'checkPluginActive']);

        //old code
        if (!get_option('sms_config_data')) {
            add_action('admin_init', [$this, 'backupConfig']);
        }

        //allow json file upload in dashboard
        add_filter('upload_mimes', function ($mimes) {
            $mimes['json'] = 'application/json';
            return $mimes;
        });
    }

    /**
     * old code
     * @return void
     */
    public function backupConfig()
    {
        $user = wp_get_current_user();
        $roles = (array) $user->roles;
        if (in_array('administrator', $roles)) {
            $current_user_id = get_current_user_id();
            $get_sms_config  = get_user_meta($current_user_id, 'sms_config_data', true);
            update_option('sms_config_data', $get_sms_config);
        }
    }

    /**
     * check require plugin activated
     * @return void
     */
    public function checkPluginActive()
    {
        $kivicare_plugin = 'kivicare-clinic-management-system/kivicare-clinic-management-system.php';
        //check lite plugin active
        if (is_plugin_active($kivicare_plugin)) {
            $plugins = get_plugins();
            //check lite plugin version
            if (!empty($plugins[$kivicare_plugin])) {
                //compare current lite plugin version with required version
                if (!(version_compare($plugins[$kivicare_plugin]['Version'], KIVI_CARE_PRO_REQUIRED_PLUGIN_VERSION, '>='))) {
                    $p_version = $plugins[$kivicare_plugin]['Version'];
                    $this->warningMessage = esc_html__('Warning:', 'kiviCare-clinic-&-patient-management-system-pro') . '<b><i>' . esc_html__('KiviCare - Clinic & Patient Management System Pro', 'kiviCare-clinic-&-patient-management-system-pro') . '</i>  </b>' . esc_html__(' Requires Plugin Version :  ', 'kiviCare-clinic-&-patient-management-system-pro') . '<b> <i>' . esc_html__('KiviCare - Clinic & Patient Management System (EHR) V', 'kiviCare-clinic-&-patient-management-system-pro') . KIVI_CARE_PRO_REQUIRED_PLUGIN_VERSION . ' </i></b>' . esc_html__('your current plugin version is', 'kiviCare-clinic-&-patient-management-system-pro') . '<b> ' . $p_version . ' </b>';
                    //send admin notice of error
                    add_action('admin_notices', [$this, 'pluginWarning']);
                    //remove plugin activate message
                    if (isset($_GET['activate'])) unset($_GET['activate']);
                    //deactivate plugin
                    deactivate_plugins(KIVI_CARE_PRO_BASE_PATH);
                }
            } else {
                $this->warningMessage = esc_html__('Warning:', 'kiviCare-clinic-&-patient-management-system-pro') . '<b><i>' . esc_html__('KiviCare - Clinic & Patient Management System Pro', 'kiviCare-clinic-&-patient-management-system-pro') . '</i>  </b>' . esc_html__('Requires', 'kiviCare-clinic-&-patient-management-system-pro') . ' <b> <i>' . esc_html__('KiviCare - Clinic & Patient Management System (EHR)', 'kiviCare-clinic-&-patient-management-system-pro') . '</i></b>';
                //send admin notice of error
                add_action('admin_notices', [$this, 'pluginWarning']);
                //remove plugin activate message
                if (isset($_GET['activate'])) unset($_GET['activate']);
                //deactivate plugin
                deactivate_plugins(KIVI_CARE_PRO_BASE_PATH);
            }
        } else {
            $this->warningMessage = esc_html__('Warning: kiviCare-clinic-&-patient-management-system-pro', 'kiviCare-clinic-&-patient-management-system-pro') . '<b><b>' . esc_html__(' is deactivate Because kivicare-clinic-management-system is not active', 'kiviCare-clinic-&-patient-management-system-pro') . '</b><br> <strong>' . esc_html__('Note:kivicare-clinic-management-system plugin is active still receiving this message then Make sure that kivicare-clinic-management-system plugin folder is same as " kivicare-clinic-management-system" in wp-content/plugins.', 'kiviCare-clinic-&-patient-management-system-pro') . '</strong>';
            //send admin notice of error
            add_action('admin_notices', [$this, 'pluginWarning']);
            //remove plugin activate message
            if (isset($_GET['activate'])) unset($_GET['activate']);
            //deactivate plugin
            deactivate_plugins(KIVI_CARE_PRO_BASE_PATH);
        }
    }

    /**
     * print admin error message
     * @return void
     */
    public function pluginWarning()
    {
        $class = 'notice notice-error';
        $message = $this->warningMessage;
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    }

    /**
     * add table to database
     * @return void
     */
    public function migrateDatabase()
    {
        require KIVI_CARE_PRO_DIR . 'database/kc-patient-report-db.php';
        if (!get_option(KIVI_CARE_PRO_PREFIX . 'migrate-encounter-template-1')) {
            require KIVI_CARE_PRO_DIR . 'database/kc-patient-encounter-template-db.php';
            update_option(KIVI_CARE_PRO_PREFIX . 'permissions-migrate-1', '1');
        }
    }

    /**
     * add default configuration value
     * @return void
     */
    public function addModuleConfig()
    {
        $prefix = KIVI_CARE_PRO_PREFIX;
        $prescription_module = [
            'prescription_module_config' => [
                [
                    'name' => 'prescription',
                    'label' => 'Prescription',
                    'status' => '1'
                ]
            ],
        ];
        delete_option($prefix . 'prescription_module');
        add_option($prefix . 'prescription_module', json_encode($prescription_module));

        $encounter_modules = [
            'encounter_module_config' => [
                [
                    'name' => 'problem',
                    'label' => 'Problem',
                    'status' => '1'
                ],
                [
                    'name' => 'observation',
                    'label' => 'Observations',
                    'status' => '1'
                ],
                [
                    'name' => 'note',
                    'label' => 'Note',
                    'status' => '1'
                ]
            ],
        ];
        delete_option($prefix . 'enocunter_modules');
        add_option($prefix . 'enocunter_modules', json_encode($encounter_modules));

        $lang_option = [
            'lang_option' => [
                [
                    'label' => 'English',
                    'id' => 'en'
                ],
                [
                    'label' => 'Arabic',
                    'id' => 'ar'
                ],
                [
                    'label' => 'Greek',
                    'id' => 'gr'
                ],
                [
                    'label' => 'Franch',
                    'id' => 'fr'
                ]
            ],
        ];
        delete_option($prefix . 'lang_option');
        add_option($prefix . 'lang_option', json_encode($lang_option));
    }

    /**
     * add table to database
     * @return void
     */
    public function migrateTable()
    {
        require KIVI_CARE_PRO_DIR . 'database/kcpro-gcal_appointment_mapping-db.php';
    }
    /**
     * It adds a new role to the WordPress database For patient_report_edit
     */
    public function migratePermissions()
    {
        if (!get_option(KIVI_CARE_PRO_PREFIX . 'permissions-migrate-2')) {
            $migrate_role_cap = array(
                array(
                    "role" =>  "administrator",
                    "cap" => array(
                        KIVI_CARE_PRO_PREFIX . 'patient_report_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_delete' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_get' => true,

                        KIVI_CARE_PRO_PREFIX . 'encounters_template_list' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_view' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_delete' => true,
                    )
                ),
                array(
                    "role" =>  $this->getClinicAdminRole(),
                    "cap" => array(
                        KIVI_CARE_PRO_PREFIX . 'patient_report_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_delete' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_get' => true,

                        KIVI_CARE_PRO_PREFIX . 'encounters_template_list' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_view' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_delete' => true,
                    )
                ),
                array(
                    "role" =>  $this->getDoctorRole(),
                    "cap" => array(
                        KIVI_CARE_PRO_PREFIX . 'patient_report_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_add' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_edit' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_delete' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_get' => true,

                        KIVI_CARE_PRO_PREFIX . 'encounters_template_list' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_view' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_delete' => true,
                    )
                ),
                array(
                    "role" =>  $this->getPatientRole(),
                    "cap" => array(
                        KIVI_CARE_PRO_PREFIX . 'patient_report_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_delete' => true,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_get' => true,
                    )
                ),
                array(
                    "role" =>  $this->getReceptionistRole(),
                    "cap" => array(
                        KIVI_CARE_PRO_PREFIX . 'patient_report_edit' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_add' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_edit' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_delete' => false,
                        KIVI_CARE_PRO_PREFIX . 'patient_review_get' => true,

                        KIVI_CARE_PRO_PREFIX . 'encounters_template_list' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_add' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_edit' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_view' => true,
                        KIVI_CARE_PRO_PREFIX . 'encounters_template_delete' => true,
                    )
                )
            );
            foreach ($migrate_role_cap as $userRoleCap) {
                $role = get_role($userRoleCap['role']);
                foreach ($userRoleCap['cap'] as $cap => $grant) {
                    $role->add_cap($cap, $grant);
                }
            }
            update_option(KIVI_CARE_PRO_PREFIX . 'permissions-migrate-2', 'yes');
        }
    }
}
