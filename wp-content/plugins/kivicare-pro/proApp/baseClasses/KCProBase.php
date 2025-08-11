<?php

namespace ProApp\baseClasses;

class KCProBase {

    public $plugin_path;

    public $nameSpace;

    public $plugin_url;

    public $plugin;

    public $dbConfig;

    private $pluginPrefix;

    /**
     * class contructor defined variables
     */
    public function __construct() {

        //plugin base path
        $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
        //plugin base url
        $this->plugin_url  = plugin_dir_url( dirname( __FILE__, 2 ) );

        //plugin namespace defined
        if  (defined( 'KIVI_CARE_PRO_NAMESPACE' )) {
            $this->nameSpace    = KIVI_CARE_PRO_NAMESPACE;
        }

        //plugin prefix defined
        if  (defined( 'KIVI_CARE_PRO_PREFIX' )) {
            $this->pluginPrefix    = KIVI_CARE_PRO_PREFIX;
        }

        $this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/kivicare-clinic-management-system-pro.php';

        $this->dbConfig = [
            'user' => DB_USER,
            'pass' => DB_PASSWORD,
            'db'   => DB_NAME,
            'host' => DB_HOST
        ];

    }

    /**
     * function to get plugin namespace
     * @return string
     */
    public function get_namespace() {
        return $this->nameSpace;
    }

    /**
     * function to get plugin prefix
     * @return string
     */
    protected function getPrefix() {
        return KIVI_CARE_PRO_PREFIX;
    }

    /**
     * function to get plugin clinic admin role
     * @return string
     */
    protected function getClinicAdminRole() {
        return KIVI_CARE_PRO_PREFIX . "clinic_admin";
    }

    /**
     *  function to get plugin doctor role
     * @return string
     */
    protected function getDoctorRole() {
        return KIVI_CARE_PRO_PREFIX . "doctor";
    }

    /**
     *  function to get plugin patient role
     * @return string
     */
    protected function getPatientRole() {
        return KIVI_CARE_PRO_PREFIX . "patient";
    }

    /**
     *  function to get plugin receptionist role
     * @return string
     */
    protected function getReceptionistRole() {
        return KIVI_CARE_PRO_PREFIX . "receptionist";
    }

    /**
     * function to get plugin prefix
     * @return string
     */
    protected function getPluginPrefix() {
        return $this->pluginPrefix;
    }
	
}

