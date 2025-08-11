<?php

namespace Iqonic\Classes;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://iqonic.design/
 * @since      1.1.0
 *
 * @package    Iqonic_Extension
 * @subpackage Iqonic_Extension/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.0
 * @package    Iqonic_Extension
 * @subpackage Iqonic_Extension/includes
 * @author     Iqonic Design <hello@iqonic.design>
 */
class Iqonic_Extension_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'iqonic',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
