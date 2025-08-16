<?php
function kc_get_encounter_by_id($id){
    static $cache = [];
    if(isset($cache[$id])){
        return $cache[$id];
    }
    if(!class_exists('App\\Controllers\\KCPatientEncounterController')){
        require_once KC_PLUGIN_DIR . 'app/controllers/KCPatientEncounterController.php';
    }
    $controller = new \App\Controllers\KCPatientEncounterController();
    $data = $controller->getEncounterData((int)$id);
    $cache[$id] = $data ? (array)$data : [];
    return $cache[$id];
}

function kc_get_patient_by_id($id){
    $user = get_userdata($id);
    if(!$user){ return []; }
    $basic = json_decode(get_user_meta($id, 'basic_data', true), true);
    $cedula   = $basic['dni'] ?? '';
    $username = $user->user_login;
    $ci = !empty($cedula) ? $cedula : $username;

    $genderKey = strtolower($basic['gender'] ?? '');
    $genderMap = [
        'male'   => 'masculino',
        'female' => 'femenino'
    ];
    $gender = $genderMap[$genderKey] ?? 'no especificado';

    $dob = $basic['dob'] ?? '';
    if(!empty($dob)){
        try{
            $birth = new DateTime($dob);
            $today = new DateTime('today');
            $years = $today->diff($birth)->y;
            $dob = sprintf('%s (%d años)', $dob, $years);
        }catch(Exception $e){
            // keep original format
        }
    } else {
        $dob = '-';
    }
    
    return [
        'id'    => $id,
        'name'  => $user->display_name,
        'email' => $user->user_email,
        'ci'    => $ci,
        'gender'=> $gender,
        'dob'   => $dob,
    ];
}

function kc_get_doctor_by_id($id){
    $user = get_userdata($id);
    if(!$user){ return []; }
    return [
        'id'   => $id,
        'name' => $user->display_name,
        'email'=> $user->user_email,
    ];
}

function kc_get_clinic_by_id($id){
    global $wpdb;
    $table = $wpdb->prefix . 'kc_clinics';
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", (int)$id), ARRAY_A);
    return $row ? $row : [];
}

function kc_get_encounter_diagnoses($encounter_id){
    $enc = kc_get_encounter_by_id($encounter_id);
    $out = [];
    if (!empty($enc['diagnosis'])) {
        $decoded = json_decode($enc['diagnosis'], true);
        if (is_array($decoded)) {
            foreach ($decoded as $d) {
                if (is_array($d)) {
                    $out[] = [
                        'code' => $d['code'] ?? '',
                        'name' => $d['name'] ?? '',
                    ];
                } else {
                    $out[] = ['code' => '', 'name' => $d];
                }
            }
        } else {
            $out[] = ['code' => '', 'name' => $enc['diagnosis']];
        }
    }
    return $out;
}

function kc_get_encounter_orders($encounter_id){
    $enc = kc_get_encounter_by_id($encounter_id);
    $out = [];
    if (!empty($enc['observations'])) {
        $decoded = json_decode($enc['observations'], true);
        if (is_array($decoded)) {
            foreach ($decoded as $o) {
                if (is_array($o)) {
                    $out[] = $o;
                } else {
                    $out[] = ['name' => $o];
                }
            }
        } else {
            $out[] = ['name' => $enc['observations']];
        }
    }
    return $out;
}

function kc_get_encounter_indications($encounter_id){
    $enc = kc_get_encounter_by_id($encounter_id);
    $out = [];
    if (!empty($enc['notes'])) {
        $decoded = json_decode($enc['notes'], true);
        if (is_array($decoded)) {
            foreach ($decoded as $i) {
                if (is_array($i)) {
                    $out[] = $i;
                } else {
                    $out[] = ['text' => $i];
                }
            }
        } else {
            $out[] = ['text' => $enc['notes']];
        }
    }
    return $out;
}

function kc_get_encounter_prescriptions($encounter_id){
    $enc = kc_get_encounter_by_id($encounter_id);
    $out = [];
    if (!empty($enc['prescription'])) {
        $decoded = json_decode($enc['prescription'], true);
        if (is_array($decoded)) {
            foreach ($decoded as $p) {
                if (is_array($p)) {
                    $out[] = $p;
                }
            }
        }
    }
    return $out;
}

function kc_build_encounter_summary_text($encounter_id){
    $e = kc_get_encounter_by_id($encounter_id);
    $p = kc_get_patient_by_id($e['patient_id'] ?? 0);
    $lines = [];
    $lines[] = 'Resumen de atención';
    $lines[] = 'Paciente: '.($p['name'] ?? '');
    $lines[] = 'Fecha: '.($e['encounter_date'] ?? $e['date'] ?? '');
    $diagnoses = kc_get_encounter_diagnoses($encounter_id);
    if ($diagnoses) {
        $lines[] = 'Diagnósticos:';
        foreach ($diagnoses as $d) {
            $lines[] = '- '.trim(($d['code'] ?? '').' '.($d['name'] ?? ''));
        }
    }
    $orders = kc_get_encounter_orders($encounter_id);
    if ($orders) {
        $lines[] = 'Órdenes:';
        foreach ($orders as $o) {
            $lines[] = '- '.($o['name'] ?? '');
        }
    }
    $indications = kc_get_encounter_indications($encounter_id);
    if ($indications) {
        $lines[] = 'Indicaciones:';
        foreach ($indications as $i) {
            $lines[] = '- '.($i['text'] ?? '');
        }
    }
    $prescriptions = kc_get_encounter_prescriptions($encounter_id);
    if ($prescriptions) {
        $lines[] = 'Receta:';
        foreach ($prescriptions as $pr) {
            $lines[] = '- '.trim(($pr['name'] ?? '').' '.($pr['frequency'] ?? '').' '.($pr['duration'] ?? ''));
        }
    }
    return implode("\n", $lines);
}

function kc_render_encounter_summary_html($encounter_id){
    $encounter     = kc_get_encounter_by_id($encounter_id);
    $patient       = kc_get_patient_by_id($encounter['patient_id'] ?? 0);
    $doctor        = ['name' => $encounter['doctor_name'] ?? ''];
    $clinic        = ['name' => $encounter['clinic_name'] ?? ''];
    $diagnoses     = kc_get_encounter_diagnoses($encounter_id);
    $orders        = kc_get_encounter_orders($encounter_id);
    $indications   = kc_get_encounter_indications($encounter_id);
    $prescriptions = kc_get_encounter_prescriptions($encounter_id);

    ob_start();
    include KC_PLUGIN_DIR . 'templates/encounter-summary-modal.php';
    return ob_get_clean();
}
