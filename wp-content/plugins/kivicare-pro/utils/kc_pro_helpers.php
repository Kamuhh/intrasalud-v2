<?php
use ProApp\filters\KCProLanaguageFilters;
function kcProSendSms($type,$data){
    (new KCProLanaguageFilters());
    return  apply_filters('kcpro_send_sms', [
        'type' => $type,
        'user_data' => $data,
        'send_type' => 'sms'
    ]);
}

function kcProWhatappSms($type,$data){
    (new KCProLanaguageFilters());
    return apply_filters('kcpro_send_sms', [
        'type' => $type,
        'user_data' => $data,
        'send_type' => 'whatsapp'
    ]);

}

function kcCommonSmsWhatsapp($appointment_id){
    (new KCProLanaguageFilters());
    return  kcSendAppointmentSmsOnPro($appointment_id);
}

function kcProNewUserActivate(){
    $raw_response = wp_remote_post('https://wordpress.iqonic.design/product/main/feedback-api/wp-json/iqonic-product/v1/collect',[
        'timeout' => 30,
        'sslverify' => false,
        'body' => [
            'product_name' => 'kivicare',
            'domain' => get_site_url(),
        ],
    ]);

    // Handle response error.
    if ( !is_wp_error( $raw_response ) && wp_remote_retrieve_response_code( $raw_response ) === 200  ) {
        update_option( KIVI_CARE_PRO_PREFIX.'check_new_user_activated','yes');
    }

}