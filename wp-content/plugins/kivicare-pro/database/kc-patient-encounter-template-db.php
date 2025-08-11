<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

global $wpdb;

$kc_charset_collate = $wpdb->get_charset_collate();

// do not forget about tables prefix
$template_table_name = $wpdb->prefix . 'kc_patient_encounters_template';
$template_mapping_table_name = $wpdb->prefix . 'kc_patient_encounters_template_mapping';
$prescription_enconter_template_table_name = $wpdb->prefix . 'kc_prescription_enconter_template';
$medical_history_table_name = $wpdb->prefix . 'kc_medical_history';
$prescription_table_name = $wpdb->prefix . 'kc_prescription';
$patient_encounters_table_name = $wpdb->prefix . 'kc_patient_encounters';


$template_sql = "CREATE TABLE `{$template_table_name}` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `encounters_template_id` BIGINT(255) NOT NULL, 
    `clinical_detail_type` varchar(128) NOT NULL,
    `clinical_detail_val` varchar(255) NOT NULL,
    `added_by` int NOT NULL,
    `created_at` datetime DEFAULT NULL,
    PRIMARY KEY  (id)
  ) $kc_charset_collate;";

$template_mapping_sql = "CREATE TABLE `{$template_mapping_table_name}`
    ( `id` BIGINT(255) NOT NULL AUTO_INCREMENT , 
      `encounters_template_name` VARCHAR(255) NOT NULL, 
      `status`  BOOLEAN NOT NULL DEFAULT 1, 
      `created_at` datetime DEFAULT NULL,
      `added_by` int NOT NULL,
      PRIMARY KEY  (`id`)
    )
    $kc_charset_collate;";

$prescription_enconter_template_sql = "CREATE TABLE `{$prescription_enconter_template_table_name}`
    ( `id` BIGINT(255) NOT NULL AUTO_INCREMENT , 
      `encounters_template_id` BIGINT(255) NOT NULL, 
      `name` text, 
      `frequency`  BOOLEAN NOT NULL DEFAULT 1, 
      `duration`  BOOLEAN NOT NULL DEFAULT 1, 
      `instruction`  BOOLEAN NULL DEFAULT 1, 
      `added_by` int NOT NULL,
      `created_at` datetime DEFAULT NULL,    
      `updated_at` datetime DEFAULT NULL,
      PRIMARY KEY  (`id`)
    )
    $kc_charset_collate;";

maybe_create_table($template_table_name, $template_sql);
maybe_create_table($template_mapping_table_name, $template_mapping_sql);
maybe_create_table($prescription_enconter_template_table_name, $prescription_enconter_template_sql);

$medical_history_table_sql = "ALTER TABLE `{$medical_history_table_name}` ADD `is_from_template` tinyint DEFAULT 0";
maybe_add_column($medical_history_table_name,'is_from_template',$medical_history_table_sql);

$prescription_table_sql = "ALTER TABLE `{$prescription_table_name}` ADD `is_from_template` tinyint DEFAULT 0";
maybe_add_column($prescription_table_name,'is_from_template',$prescription_table_sql);

$patient_encounters_sql = "ALTER TABLE `{$patient_encounters_table_name}` ADD `template_id` BIGINT(255)";
maybe_add_column($patient_encounters_table_name,'template_id',$patient_encounters_sql);