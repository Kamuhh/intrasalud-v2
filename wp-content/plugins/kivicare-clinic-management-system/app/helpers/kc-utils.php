<?php
// === Helpers para edad y traducciones ===
if (!function_exists('kc_age_from_dob')) {
    function kc_age_from_dob($dob) {
        if (empty($dob)) { return ''; }
        try {
            $birth = new DateTime($dob);
            $today = new DateTime('today');
            return (string)$birth->diff($today)->y;
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('kc_gender_es')) {
    function kc_gender_es($gender) {
        $g = strtolower(trim((string)$gender));
        $map = [
            'male'   => 'Masculino',
            'female' => 'Femenino',
            'other'  => 'Otro',
            'masculino' => 'Masculino',
            'femenino'  => 'Femenino',
        ];
        return $map[$g] ?? ucfirst($g);
    }
}
