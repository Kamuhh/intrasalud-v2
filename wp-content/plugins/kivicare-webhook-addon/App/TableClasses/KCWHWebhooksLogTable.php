<?php
/**
 * Custom table file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 */

namespace KCWebhookAddons\TableClasses;

use KCWebhookAddons\ModelClasses\KCWHWebhooksLogModel;

defined( 'ABSPATH' ) || die( 'Something went wrong' );

/**
 * Class KCWHWebhooksLogTable
 *
 * Table for webhook logs data.
 */
class KCWHWebhooksLogTable extends KCWHWebhooksLogModel {
	/**
	 * KCWHWebhooksLogTable constructor.
	 */
	public function __construct() {

		parent::__construct();

		global $wpdb;

		$kc_charset_collate = $wpdb->get_charset_collate();

		$table_name = $this->get_table_name();

		$sql = "CREATE TABLE `{$table_name}` (
            id bigint(20) NOT NULL AUTO_INCREMENT,    
            module_id bigint(20)  UNSIGNED NOT NULL,
            webhook_id bigint(20)  UNSIGNED NOT NULL,
            log_data longtext,
            created_at datetime NOT NULL,    
            PRIMARY KEY  (id)
          ) $kc_charset_collate;";

		maybe_create_table( $table_name, $sql );
	}
}
