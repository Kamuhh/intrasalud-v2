<?php 

namespace ProApp\filters ;
use App\baseClasses\KCBase;
use Exception;
use Twilio\Rest\Client;

class KCProSettingFilters  extends KCBase {
    public function __construct() {
        add_filter('kcpro_get_encounter_setting', [$this, 'getEncounterModule']);
        add_filter('kcpro_save_prescription_setting', [$this, 'savePrescriptionModule']);
        add_filter('kcpro_get_prescription_list', [$this, 'getPrescriptionModule']);
        add_filter('kcpro_get_list', [$this, 'getList']);
        add_filter('kcpro_save_pro_option_value', [$this, 'saveProOptionValue'], 10, 2);
        add_filter('kcpro_save_wordpress_logo', [$this, 'saveWordpresLogo']);
        add_filter('kcpro_get_wordpress_logo', [$this, 'getWordpresLogo']);
        add_filter('kcpro_get_twilio_template',[$this,'getTwilioTemp'],10,1);
    }
    public function getTwilioTemp($content_sid){
        $get_whatsapp_config = json_decode(get_option('whatsapp_config_data', true));
        $twilio = new Client($get_whatsapp_config->wa_account_id, $get_whatsapp_config->wa_auth_token);
        $content = '';
        try{
            $content = $twilio->content->v1->contents($content_sid)->fetch();
            return $content->types;
        } catch (\Twilio\Exceptions\RestException $e) {
            wp_send_json([$e]);
        } catch (\Exception $e) {
            wp_send_json([$e]);
        }
        return [$content];
    }
    public function getList(){
        $prefix = KIVI_CARE_PRO_PREFIX;
        $encounter_modules = get_option($prefix . 'enocunter_modules');
		if($encounter_modules !== '') {
            $data = json_decode($encounter_modules);
			$status = true ;
		} else {
			$data = [] ;
			$status = false ;
        }
        return [
            'status' => $status,
            'data'    => $data
        ];
    }
    public function getEncounterModule($settings){
        if(!empty($settings)){
            $prefix = KIVI_CARE_PRO_PREFIX;
            update_option( $prefix. 'enocunter_modules', json_encode($settings['encounter_module']));
            return [
                'status' => true,
                'message' => esc_html__('Setting update successfully', 'kcp-lang')

            ];
        }else{
            return [
                'status' => false,
                'message' => esc_html__('Failed to update  setting', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }
    public function savePrescriptionModule($settings){
        if(!empty($settings)){
            $prefix = KIVI_CARE_PRO_PREFIX;
            update_option( $prefix. 'prescription_module', json_encode($settings['prescription_module']));
            return [
                'status' => true,
                'message' => esc_html__('Setting update successfully', 'kiviCare-clinic-&-patient-management-system-pro')

            ];
        }else{
            return [
                'status' => false,
                'message' => esc_html__('Failed to update  setting', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }
    public function getPrescriptionModule($settings){
        $prefix = KIVI_CARE_PRO_PREFIX;
        $prescription_modules = get_option($prefix . 'prescription_module');
		if(!empty($prescription_modules)) {
            $data = json_decode($prescription_modules);
			$status = true ;
		} else {
			$data = [] ;
			$status = false ;
        }
        return [
            'status' => $status,
            'data'    => $data
        ];
    }

    public function saveProOptionValue($request_data,$setting_name){
        if(isset($request_data['text'])){
            update_option(KIVI_CARE_PRO_PREFIX.$setting_name,$request_data['text']);
        }else if(isset($request_data['status'])){
            update_option(KIVI_CARE_PRO_PREFIX.$setting_name,$request_data['status']);
        }
    }

    public function saveWordpresLogo($requestData){

        if(isset($requestData['status'])){
            $requestData['status'] = $requestData['status'] == '1' ? "on"  : "off";
            update_option( KIVI_CARE_PRO_PREFIX . 'wordpress_logo_status',$requestData['status'] );
            return ['status' => true,'data' => $requestData['status'] == 'on'];
        }
        try{
            if(isset($requestData['wordpress_logo'])){
                update_option( KIVI_CARE_PRO_PREFIX . 'wordpress_logo',$requestData['wordpress_logo'] );
                $url = wp_get_attachment_url($requestData['wordpress_logo']);
                return [
                    'data'=> $url,
                    'status' => true,
                    'message' => esc_html__('Wordpress logo updated', 'kiviCare-clinic-&-patient-management-system-pro')
                ];

            }
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' => esc_html__('Failed to update Wordpress logo', 'kiviCare-clinic-&-patient-management-system-pro')
            ];
        }
    }

    public function getWordpresLogo(){

        return [
            'status' => true,
            'data' =>[
                'status' => kcWordpressLogostatusAndImage('status') ? 1 : 0,
                'logo' => kcWordpressLogostatusAndImage('image')
            ]
        ];
    }
}