<?php
/**
 * Kivicare\Utility\Editor\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style;

use Kivicare\Utility\Component_Interface;
use Kivicare\Utility\Dynamic_Style\Styles;

/**
 * Class for integrating with the block editor.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'dynamic_style';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_dynamic_styles' ) );
	}

	public function action_add_dynamic_styles( ) {

		new Styles\Header();
		new Styles\HeaderSticky();
		new Styles\BodyContainer();
		new Styles\Footer();
		new Styles\Banner();
		new Styles\Color();
		new Styles\General();
		new Styles\Loader();
		new Styles\Typography();
		new Styles\Maintenance();
		new Styles\Logo();
		new Styles\AdditionalCode();

	}

}
