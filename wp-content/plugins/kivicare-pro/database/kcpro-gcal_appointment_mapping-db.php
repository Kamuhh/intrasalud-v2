<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


global $wpdb;
$charset_collate = $wpdb->get_charset_collate();


$table_name = $wpdb->prefix . 'kc_gcal_appointment_mapping'; // do not forget about tables prefix

$sql = "CREATE TABLE `{$table_name}` (
    id bigint(20) NOT NULL AUTO_INCREMENT,    
    appointment_id bigint(20) NULL,   
    event_key varchar(255) NULL,     
    event_value varchar(255) NULL,   
    doctor_id bigint(20) NULL,    
    PRIMARY KEY  (id)
  ) $charset_collate;";

maybe_create_table($table_name,$sql);
