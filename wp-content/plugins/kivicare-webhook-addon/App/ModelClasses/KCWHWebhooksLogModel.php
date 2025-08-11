<?php
/**
 * Modal class file
 *
 * PHP version 8.0
 *
 * @package KiviCare_Webhooks_Addon
 **/

namespace KCWebhookAddons\ModelClasses;

use App\baseClasses\KCModel;

/**
 * Class KCWHWebhooksLogModel
 *
 * Model for encounter body chart data.
 */
class KCWHWebhooksLogModel extends KCModel {
	/**
	 * KCWHWebhooksLogModel constructor.
	 */
	public function __construct() {
		parent::__construct( 'webhooks_logs' );
	}
}
