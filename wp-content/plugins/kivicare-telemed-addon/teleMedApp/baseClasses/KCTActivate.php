<?php

namespace TeleMedApp\baseClasses;

class KCTActivate extends KCTBaseClass {

	protected $warningMessage;

    public static function activate() {
        (new KCTGetDependency('kivicare-clinic-management-system', 'kiviCare-clinic-&-patient-management-system'))->getPlugin();
        self::migrateDatabase();
    }

    public function init() {

        add_action( 'rest_api_init', [$this, 'checkPluginActive'] );
		add_action( 'admin_init', [$this, 'checkPluginActive'] );

		add_action( 'wp_ajax_check_zoom_code', [ $this, 'checkZoomCode' ] );
		
        if (!function_exists('get_plugins')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        add_action('init',function(){
            if ( is_plugin_active($this->lite_plugin_base_name) ) {
                $plugins = get_plugins();
                if (!empty($plugins[$this->lite_plugin_base_name])) {
                    if (version_compare($plugins[$this->lite_plugin_base_name]['Version'] , KIVI_CARE_TELEMED_REQUIRED_PLUGIN_VERSION,'>=')) {
                        (new KCTFilterHandler())->init();
                        return;
                    }
                }
            }
            deactivate_plugins(  KIVI_CARE_TELEMED_BASE_PATH);
        });
	
	}
	
	public function checkZoomCode() {
		// Get request data
		$code = isset( $_GET['code'] ) ? sanitize_text_field( $_GET['code'] ) : '';
		$request_data = [ 'code' => $code, 'grant_type' => 'authorization_code' ];

		// Check if the required filter is available
		if ( ! has_filter( 'kct_generate_doctor_zoom_oauth_token' ) ) {
			wp_send_json_error( [ 'message' => "KiviCare Telemed Required" ] );
			wp_die();
		}

		// Apply the filter and get the response
		$response 	= apply_filters( 'kct_generate_doctor_zoom_oauth_token', $request_data );
		$message 	= $response['message'];
		$status 	= $response['status'];
		// Send a success response with the redirect URL
		
		$dashboard_redirect=  add_query_arg(array(
			'page'=> 'dashboard',
			'zoom_status' => $status,
			'message1' => $message,
			"#/setting/ZoomOAuth"
		),admin_url("admin.php"));
		wp_redirect( $dashboard_redirect );
		exit;
	}
	
	function checkPluginActive() {

        $deactivate = false;
        $kivicare_plugin = $this->lite_plugin_base_name ;
		if ( is_plugin_active($kivicare_plugin) ) {
			$plugins = get_plugins();
			if(isset($plugins[$kivicare_plugin]) && $plugins[$kivicare_plugin] !== '') {
				if(!(version_compare($plugins[$kivicare_plugin]['Version'] , KIVI_CARE_TELEMED_REQUIRED_PLUGIN_VERSION,'>='))) {
                    $p_version = $plugins[$kivicare_plugin]['Version'];
                    $this->warningMessage = esc_html__('Warning:','kiviCare-telemed-addon').'<b><i>'.esc_html__('The KiviCare - Telemed add-on','kiviCare-telemed-addon').'</i>  </b>'.esc_html__('Requires Plugin Version : ','kiviCare-telemed-addon').'<b> <i>'.esc_html__('KiviCare - Clinic & Patient Management System (EHR) V','kiviCare-telemed-addon').KIVI_CARE_TELEMED_REQUIRED_PLUGIN_VERSION.' </i></b>'.esc_html__('your current plugin version is','kiviCare-telemed-addon').' <b> '. $p_version .' </b> ';
                    $deactivate = true;
				}
			} else {
				$this->warningMessage = esc_html__('Warning:','kiviCare-telemed-addon').'<b><i>'.esc_html__('The KiviCare - Telemed add-on','kiviCare-telemed-addon').'</i>  </b>'.esc_html__('Requires : ','kiviCare-telemed-addon').'<b> <i>'.esc_html__('KiviCare - Clinic & Patient Management System (EHR)','kiviCare-telemed-addon');
                $deactivate = true;
			}
		} else {
            $this->warningMessage = esc_html__( 'Warning: kiviCare-telemed-addon','kiviCare-telemed-addon'). '<b><b>' . esc_html__(' is deactivate Because kivicare-clinic-management-system is not active', 'kiviCare-telemed-addon' ).'</b><br> <strong>'.esc_html__('Note:kivicare-clinic-management-system plugin is active still receiving this message then Make sure that kivicare-clinic-management-system plugin folder is same as " kivicare-clinic-management-system" in wp-content/plugins.' ,'kiviCare-telemed-addon').'</strong>';
            $deactivate = true;
		}

        if($deactivate){
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
            deactivate_plugins(  KIVI_CARE_TELEMED_BASE_PATH);
            add_action( 'admin_notices', [$this, 'pluginWarning'] );
        }
	}

	public function pluginWarning() {
		$class = 'notice notice-warning';
		$message = $this->warningMessage;
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
	}

	public static function migrateDatabase () {
		require KIVI_CARE_TELEMED_DIR . 'teleMedApp/database/kct-appointment-zoom-mappings-db.php';
	}


}