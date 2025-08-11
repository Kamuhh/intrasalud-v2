<?php

namespace Iqonic_Layouts\Classes;

/**
 * Fired during plugin activation
 *
 * @link       https://iqonic.design/
 * @since      1.2.0
 *
 * @package    Iqonic_Layouts_Extension
 * @subpackage Iqonic_Layouts_Extension/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.2.0
 * @package    Iqonic_Layouts_Extension
 * @subpackage Iqonic_Layouts_Extension/includes
 * @author     Iqonic_Layouts Design <hello@iqonic.design>
 */
class Iqonic_Layouts_Extension_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.2.0
	 */
	public static function activate()
	{
		$elementor_cpt = get_option("elementor_cpt_support");
		if (is_array($elementor_cpt) && count($elementor_cpt) > 0 && !in_array("iqonic_hf_layout", $elementor_cpt)) {
			$elementor_cpt = array_merge(["iqonic_hf_layout"], $elementor_cpt);
		}
		update_option("elementor_cpt_support", $elementor_cpt);
	}
}
