<?php

namespace Iqonic_Layouts\Classes;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://iqonic.design/
 * @since      1.2.0
 *
 * @package    Iqonic_Layouts_Extension
 * @subpackage Iqonic_Layouts_Extension/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.2.0
 * @package    Iqonic_Layouts_Extension
 * @subpackage Iqonic_Layouts_Extension/includes
 * @author     Iqonic_Layouts Design <hello@iqonic.design>
 */
class Iqonic_Layouts_Extension_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.2.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'iqonic-layouts-extension',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
