<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\BodyContainer class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class BodyContainer extends Component
{

	public function __construct()
	{
		if (class_exists('ReduxFramework')) {
			add_action('wp_enqueue_scripts', array($this, 'kivicare_container_width'), 21);
		}
	}

	public function kivicare_container_width()
	{
		global $kivicare_options;

		$box_container_width = '';

		if (isset($kivicare_options['opt-slider-label']) && !empty($kivicare_options['opt-slider-label'])) {
			$container_width = $kivicare_options['opt-slider-label']['width'];
			$box_container_width = "body.iq-container-width .container,
        							body .elementor-section.elementor-section-boxed>
        							.elementor-container { max-width: " . $container_width . "; } ";
			wp_add_inline_style('kivicare-style', $box_container_width);
		}
	}
}
