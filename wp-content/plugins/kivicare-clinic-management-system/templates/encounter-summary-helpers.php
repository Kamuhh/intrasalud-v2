<?php
if (!function_exists('kc_render_encounter_summary_html')) {
    function kc_render_encounter_summary_html($encounter_id) {
        if (!function_exists('kc_get_encounter_by_id')) {
            require_once KIVI_CARE_DIR . 'app/helpers/encounter-summary-helpers.php';
        }

        $encounter     = kc_get_encounter_by_id($encounter_id);
        $patient       = kc_get_patient_by_id($encounter['patient_id'] ?? 0);
        $doctor        = kc_get_doctor_by_id($encounter['doctor_id'] ?? 0);
        $clinic        = kc_get_clinic_by_id($encounter['clinic_id'] ?? 0);
        $diagnoses     = kc_get_encounter_problems($encounter_id);
        $indications   = kc_get_encounter_indications($encounter_id);
        $orders        = kc_get_encounter_orders($encounter_id);
        $prescriptions = kc_get_encounter_prescriptions($encounter_id);

        ob_start();
        include __DIR__ . '/encounter-summary-print.php';
        return ob_get_clean();
    }
}

if (!function_exists('kc_render_encounter_letter')) {
    function kc_render_encounter_letter($encounter_id){
        // Cargar funciones base si no están
        if (!function_exists('kc_get_encounter_by_id')) {
            $base = defined('KIVI_CARE_DIR') ? KIVI_CARE_DIR : plugin_dir_path(__FILE__) . '../';
            $maybe = trailingslashit($base) . 'app/helpers/encounter-summary-helpers.php';
            if (file_exists($maybe)) { require_once $maybe; }
        }

        $encounter     = kc_get_encounter_by_id($encounter_id);
        $patient       = kc_get_patient_by_id($encounter['patient_id'] ?? 0);
        $doctor        = kc_get_doctor_by_id($encounter['doctor_id'] ?? 0);
        $clinic        = kc_get_clinic_by_id($encounter['clinic_id'] ?? 0);
        $diagnoses     = kc_get_encounter_problems($encounter_id);
        $indications   = kc_get_encounter_indications($encounter_id);
        $orders        = kc_get_encounter_orders($encounter_id);
        $prescriptions = kc_get_encounter_prescriptions($encounter_id);

        // Datos de pie/membretado
        $clinic_logo   = !empty($clinic['profile_image']) ? wp_get_attachment_url($clinic['profile_image']) : '';
        $clinic_name   = $clinic['name'] ?? 'Intrasalud';
        $clinic_addr   = trim(($clinic['state'] ?? '').', '.($clinic['city'] ?? '').', '.($clinic['country'] ?? ''));
        $today         = !empty($encounter['encounter_date']) ? $encounter['encounter_date'] : date('Y-m-d');

        // Firma del doctor
        $doctor_signature_id = get_user_meta((int)($encounter['doctor_id'] ?? 0), 'doctor_signature', true);
        $doctor_signature    = $doctor_signature_id ? wp_get_attachment_url($doctor_signature_id) : '';
        $doc_basic           = json_decode(get_user_meta((int)($encounter['doctor_id'] ?? 0), 'basic_data', true), true) ?: [];
        $doc_spec            = $doc_basic['specialization'] ?? ($doc_basic['departments'] ?? '');
        $doc_mpps            = $doc_basic['mpps'] ?? '';
        $doc_cm              = $doc_basic['cm'] ?? '';
        $doc_ci              = $doc_basic['dni'] ?? '';

        // Render del template carta
        ob_start();
        $file = defined('KIVI_CARE_DIR')
            ? KIVI_CARE_DIR.'templates/encounter-summary-print.php'
            : plugin_dir_path(__FILE__).'encounter-summary-print.php';

        // Variables disponibles en el template:
        // $encounter, $patient, $doctor, $clinic, $diagnoses, $indications, $orders, $prescriptions,
        // $clinic_logo, $clinic_name, $clinic_addr, $today, $doctor_signature, $doc_spec, $doc_mpps, $doc_cm, $doc_ci
        include $file;

        return ob_get_clean();
    }
}
