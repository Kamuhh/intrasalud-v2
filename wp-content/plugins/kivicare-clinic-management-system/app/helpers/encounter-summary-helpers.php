<?php
/**
 * Encounter Summary Helpers
 * -----------------------------------------
 * Funciones utilitarias para armar el resumen:
 * - Diagnósticos  (problem)
 * - Órdenes       (observation / clinical_observations)
 * - Indicaciones  (note / notes)
 * - Recetas       (JSON en la tabla de encuentros)
 *
 * Robusto a instalaciones con tablas legacy y sin columna `status`.
 */

if (!function_exists('kc__db_table_exists')) {
    function kc__db_table_exists($table) {
        global $wpdb;
        $like = $wpdb->esc_like($table);
        return (bool) $wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE %s", $like) );
    }
}

if (!function_exists('kc__db_columns')) {
    function kc__db_columns($table) {
        global $wpdb;
        $cols = $wpdb->get_col("SHOW COLUMNS FROM {$table}", 0);
        return is_array($cols) ? $cols : [];
    }
}

/* =========================
 * Entidades base por ID
 * ========================= */
if (!function_exists('kc_get_encounter_by_id')) {
    function kc_get_encounter_by_id($id){
        global $wpdb;
        $table = $wpdb->prefix . 'kc_patient_encounters';
        $row = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", (int)$id),
            ARRAY_A
        );
        return $row ?: [];
    }
}

if (!function_exists('kc_get_patient_by_id')) {
    function kc_get_patient_by_id($id){
        $user = get_userdata((int)$id);
        if(!$user){ return []; }
        $basic = json_decode(get_user_meta((int)$id, 'basic_data', true), true) ?: [];
        return [
            'id'     => (int)$id,
            'name'   => $user->display_name,
            'email'  => $user->user_email,
            'gender' => $basic['gender'] ?? '',
            'dob'    => $basic['dob'] ?? '',
            'dni'    => $basic['dni'] ?? '',
        ];
    }
}

if (!function_exists('kc_get_doctor_by_id')) {
    function kc_get_doctor_by_id($id){
        // Para nuestro caso, estructura igual que paciente (display_name, email, basic_data)
        return kc_get_patient_by_id($id);
    }
}

if (!function_exists('kc_get_clinic_by_id')) {
    function kc_get_clinic_by_id($id){
        global $wpdb;
        $table = $wpdb->prefix . 'kc_clinics';
        $row = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", (int)$id),
            ARRAY_A
        );
        return $row ?: [];
    }
}

/* ============================================
 * Lector genérico de medical history / problems
 * ============================================ */
if (!function_exists('kc__get_encounter_items')) {
    /**
     * Devuelve filas normalizadas ['title'=>..., 'note'=>...]
     * Buscando en kc_medical_history (si existe) y, si no, en kc_medical_problems (legacy).
     * @param int   $encounter_id
     * @param array $types lista de tipos a incluir (e.g. ['observation','clinical_observations'])
     * @return array
     */
    function kc__get_encounter_items($encounter_id, array $types){
        global $wpdb;

        $tbl_history  = $wpdb->prefix . 'kc_medical_history';
        $tbl_problems = $wpdb->prefix . 'kc_medical_problems';

        $table = kc__db_table_exists($tbl_history) ? $tbl_history : $tbl_problems;

        $cols      = kc__db_columns($table);
        $hasStatus = in_array('status', $cols, true);
        $hasNote   = in_array('note',   $cols, true);

        if (empty($types)) { $types = ['observation', 'clinical_observations']; }

        // SELECT dinámico
        $select = 'title';
        if ($hasNote) { $select .= ', note'; }

        // placeholders para el IN(...)
        $ph = implode(',', array_fill(0, count($types), '%s'));

        $where = "encounter_id = %d AND type IN ($ph)";
        if ($hasStatus) {
            $where .= " AND (status = 1 OR status = '1' OR status = 'Active' OR status IS NULL)";
        }

        $sql     = "SELECT {$select} FROM {$table} WHERE {$where} ORDER BY id ASC";
        $params  = array_merge([(int)$encounter_id], $types);
        $prepared = call_user_func_array([$wpdb,'prepare'], array_merge([$sql], $params));

        $rows = $wpdb->get_results($prepared, ARRAY_A) ?: [];

        // Normalizar
        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'title' => (string)($r['title'] ?? ''),
                'note'  => $hasNote ? (string)($r['note'] ?? '') : '',
            ];
        }
        return $out;
    }
}

/* =========================
 * Wrappers semánticos
 * ========================= */
if (!function_exists('kc_get_encounter_problems')) {
    // Diagnósticos (en tu BD están como type='problem')
    function kc_get_encounter_problems($encounter_id){
        return kc__get_encounter_items((int)$encounter_id, ['problem','clinical_problems']);
    }
}

if (!function_exists('kc_get_encounter_orders')) {
    // ÓRDENES CLÍNICAS = Observations
    function kc_get_encounter_orders($encounter_id){
        $list = kc__get_encounter_items((int)$encounter_id, ['observation','clinical_observations']);

        // Fallback a la columna antigua del encuentro si no hay filas
        if (empty($list)) {
            $enc = kc_get_encounter_by_id($encounter_id);
            $legacy = $enc['observations'] ?? $enc['observation'] ?? ($enc['clinical_observations'] ?? '');
            if (!empty($legacy)) {
                $list = [[ 'title' => (string)$legacy, 'note' => '' ]];
            }
        }
        return $list;
    }
}

if (!function_exists('kc_get_encounter_indications')) {
    // INDICACIONES = Notes
    function kc_get_encounter_indications($encounter_id){
        $list = kc__get_encounter_items((int)$encounter_id, ['note','notes']);

        // Fallback a la columna antigua del encuentro si no hay filas
        if (empty($list)) {
            $enc = kc_get_encounter_by_id($encounter_id);
            $legacy = $enc['notes'] ?? $enc['note'] ?? '';
            if (!empty($legacy)) {
                $list = [[ 'title' => (string)$legacy, 'note' => '' ]];
            }
        }
        return $list;
    }
}

/* =============
 * Prescripciones
 * ============= */
if (!function_exists('kc_get_encounter_prescriptions')) {
    function kc_get_encounter_prescriptions($encounter_id){
        $enc = kc_get_encounter_by_id($encounter_id);
        $out = [];
        if (!empty($enc['prescription'])) {
            $decoded = json_decode($enc['prescription'], true);
            if (is_array($decoded)) {
                foreach ($decoded as $p) {
                    if (is_array($p)) { $out[] = $p; }
                }
            }
        }
        return $out;
    }
}

/* =================================
 * Texto plano para enviar por email
 * ================================= */
if (!function_exists('kc_build_encounter_summary_text')) {
    function kc_build_encounter_summary_text($encounter_id){
        $e = kc_get_encounter_by_id($encounter_id);
        $p = kc_get_patient_by_id($e['patient_id'] ?? 0);
        $lines = [];
        $lines[] = 'Resumen de atención';
        $lines[] = 'Paciente: ' . ($p['name'] ?? '');
        $lines[] = 'Fecha: ' . ($e['encounter_date'] ?? $e['date'] ?? '');

        $diagnoses = kc_get_encounter_problems($encounter_id);
        if ($diagnoses) {
            $lines[] = 'Diagnósticos:';
            foreach ($diagnoses as $d) { $lines[] = '- ' . ($d['title'] ?? ''); }
        }

        $indications = kc_get_encounter_indications($encounter_id);
        if ($indications) {
            $lines[] = 'Indicaciones:';
            foreach ($indications as $i) { $lines[] = '- ' . ($i['title'] ?? ''); }
        }

        $orders = kc_get_encounter_orders($encounter_id);
        if ($orders) {
            $lines[] = 'Órdenes clínicas:';
            foreach ($orders as $o) {
                $line = '- ' . ($o['title'] ?? '');
                if (!empty($o['note'])) { $line .= ' — ' . $o['note']; }
                $lines[] = $line;
            }
        }

        $prescriptions = kc_get_encounter_prescriptions($encounter_id);
        if ($prescriptions) {
            $lines[] = 'Receta:';
            foreach ($prescriptions as $pr) {
                $lines[] = '- ' . trim(($pr['name'] ?? '') . ' ' . ($pr['frequency'] ?? '') . ' ' . ($pr['duration'] ?? ''));
            }
        }
        return implode("\n", $lines);
    }
}

/* ==========================
 * HTML del modal (si lo usas)
 * ========================== */
if (!function_exists('kc_render_encounter_summary_html')) {
    function kc_render_encounter_summary_html($encounter_id){
        $encounter     = kc_get_encounter_by_id($encounter_id);
        $patient       = kc_get_patient_by_id($encounter['patient_id'] ?? 0);
        $doctor        = kc_get_doctor_by_id($encounter['doctor_id'] ?? 0);
        $clinic        = kc_get_clinic_by_id($encounter['clinic_id'] ?? 0);
        $diagnoses     = kc_get_encounter_problems($encounter_id);
        $orders        = kc_get_encounter_orders($encounter_id);       // ÓRDENES CLÍNICAS
        $indications   = kc_get_encounter_indications($encounter_id);  // INDICACIONES
        $prescriptions = kc_get_encounter_prescriptions($encounter_id);

        ob_start();
        $base = defined('KIVI_CARE_DIR') ? KIVI_CARE_DIR : plugin_dir_path(__FILE__);
        include trailingslashit($base) . 'templates/encounter-summary-modal.php';
        return ob_get_clean();
    }
}
