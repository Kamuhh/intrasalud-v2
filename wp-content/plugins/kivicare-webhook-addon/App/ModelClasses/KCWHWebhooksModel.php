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
 * Class KCWHWebhooksModel
 *
 * Model for encounter body chart data.
 */
class KCWHWebhooksModel extends KCModel {
	/**
	 * KCWHWebhooksModel constructor.
	 */
	public function __construct() {
		parent::__construct( 'webhooks' );
	}
}
