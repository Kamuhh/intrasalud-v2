<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


global $wpdb;
$charset_collate = $wpdb->get_charset_collate();


$table_name = $wpdb->prefix . 'kc_appointment_zoom_mappings'; // do not forget about tables prefix

$sql = "CREATE TABLE `{$table_name}` (
    id bigint(20) NOT NULL AUTO_INCREMENT,    
    appointment_id bigint(20) UNSIGNED NOT NULL,
    zoom_id varchar (191) NOT NULL,
    zoom_uuid varchar (191) NOT NULL,
    start_url longtext  NULL,
    join_url longtext  NULL,
    password varchar (191) NOT NULL,   
    created_at datetime NOT NULL,    
    PRIMARY KEY  (id)
  ) $charset_collate;";

maybe_create_table($table_name,$sql);
