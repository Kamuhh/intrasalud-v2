<?php
/**
 * Custom table file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 */

namespace KCWebhookAddons\TableClasses;

use KCWebhookAddons\ModelClasses\KCWHWebhooksModel;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHWebhooksTable
 *
 * Table for webhook log data.
 */
class KCWHWebhooksTable extends KCWHWebhooksModel {
	/**
	 * KCWHWebhooksTable constructor.
	 */
	public function __construct() {

		parent::__construct();

		global $wpdb;

		$kc_charset_collate = $wpdb->get_charset_collate();

		$table_name = $this->get_table_name();

		$sql = "CREATE TABLE `{$table_name}` (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(192) NOT NULL,    
            module_name varchar(192) NOT NULL,
            event_name varchar(192) NOT NULL,
            methods varchar(192) NOT NULL,
            webhook_data longtext,
            user_id bigint(20)  UNSIGNED NOT NULL,
            status bigint(1) NOT NULL,
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,    
            PRIMARY KEY  (id)
          ) $kc_charset_collate;";

		maybe_create_table( $table_name, $sql );
	}
}
