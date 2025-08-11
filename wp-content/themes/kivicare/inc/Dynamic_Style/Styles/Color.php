<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class Color extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'kivicare_color_options'), 20);
	}

	public function kivicare_color_options()
	{
		global $kivicare_options;
		$color_var = "";
		if (function_exists('get_field') || class_exists('ReduxFramework')) {
			
			if (function_exists('get_field') && isset(get_field('key_color_pallete')['primary_color']) && !empty(get_field('key_color_pallete')['primary_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['primary_color'];
				$color_var .= '--primary-color: ' . $color . ' !important;';
			} else {
				if ( isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['custom_color_switch'] == 'yes' && isset($kivicare_options['primary_color']) && !empty($kivicare_options['primary_color'])) {
					$color = $kivicare_options['primary_color'];
					$color_var .= '--primary-color: ' . $color . ' !important;';
				}
			}

			if ( function_exists('get_field') && isset(get_field('key_color_pallete')['secondary_color']) && !empty(get_field('key_color_pallete')['secondary_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['secondary_color'];
				$color_var .= '--secondary-color: ' . $color . ' !important;';
			} else {
				if (isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['custom_color_switch'] == 'yes' && isset($kivicare_options['secondary_color']) && !empty($kivicare_options['secondary_color'])) {
					$color = $kivicare_options['secondary_color'];
					$color_var .= '--secondary-color: ' . $color . ' !important;';
				}
			}

			if (function_exists('get_field') && isset(get_field('key_color_pallete')['text_color']) && !empty(get_field('key_color_pallete')['text_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['text_color'];
				$color_var .= '--body-text: ' . $color . ' !important;';
			} else {
				if ( isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['custom_color_switch'] == 'yes' && isset($kivicare_options['text_color']) && !empty($kivicare_options['text_color'])) {
					$color = $kivicare_options['text_color'];
					$color_var .= '--body-text: ' . $color . ' !important;';
				}
			}

			if (function_exists('get_field') && isset(get_field('key_color_pallete')['title_color']) && !empty(get_field('key_color_pallete')['title_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['title_color'];
				$color_var .= ' --global-font-title: ' . $color . ' !important;';
			} else {
				if ( isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['custom_color_switch'] == 'yes' && isset($kivicare_options['title_color']) && !empty($kivicare_options['title_color'])) {
					$color = $kivicare_options['title_color'];
					$color_var .= ' --global-font-title: ' . $color . ' !important;';
				}
			}
			
			if (function_exists('get_field') && isset(get_field('key_color_pallete')['white_light_color']) && !empty(get_field('key_color_pallete')['white_light_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['white_light_color'];
				$color_var .= '--white-light-color: ' . $color . ' !important;';
			} 

			$kivi_color = '';
			if (function_exists('get_field') && get_field('key_color_switch') != 'default' && isset($kivi_color['sub_title_color']) && !empty($kivi_color['sub_title_color'])) {
				$color = $kivi_color['sub_title_color'];
				$color_var .= ' --global-font-color: ' . $color . ' !important;';
			} elseif (isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['custom_color_switch'] == 'yes' && isset($kivicare_options['sub_title_color']) && !empty($kivicare_options['sub_title_color'])) {
				$color = $kivicare_options['sub_title_color'];
				$color_var .= ' --global-font-color: ' . $color . ' !important;';
			}

			if (function_exists('get_field') && get_field('key_color_switch') != 'default' && isset($kivi_color['white_color']) && !empty($kivi_color['white_color'])) {
				$color = $kivi_color['white_color'];
				$color_var .= '  --white-color: ' . $color . ' !important;';
			} elseif (isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['custom_color_switch'] == 'yes' && isset($kivicare_options['white_color']) && !empty($kivicare_options['white_color'])) {
				$color = $kivicare_options['white_color'];
				$color_var .= '  --white-color: ' . $color . ' !important;';
			}
			
			if (!empty($color_var)) {
				$color_attrs = ':root { ' . $color_var . '}';
				wp_add_inline_style('kivicare-global', $color_attrs);
			}
		}
	}
}
