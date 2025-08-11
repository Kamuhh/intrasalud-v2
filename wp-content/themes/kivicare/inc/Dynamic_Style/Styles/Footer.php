<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Footer class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class Footer extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'kivicare_footer_dynamic_style'), 20);
	}

	public function is_kivicare_footer()
	{
		$is_footer = true;
		$page_id = get_queried_object_id();
		$footer_page_option = get_post_meta($page_id, "display_footer", true);
		$footer_page_option = !empty($footer_page_option) ? $footer_page_option : "default";
		global $kivicare_options ;

		if ($footer_page_option != 'default') {
			$is_footer = ($footer_page_option == 'no') ? false : true;
		}
		if (is_404() && !$kivicare_options['footer_on_404']) {
			$is_footer = false;
		}
		
		return $is_footer;
	}

	public function kivicare_footer_dynamic_style()
	{
		if (!$this->is_kivicare_footer()) {
			return;
		}
		
		$page_id = get_queried_object_id();
		global $kivicare_options;
		$footer_css = '';

		if (function_exists('get_field') && get_field('acf_key_footer_switch', $page_id) != 'default') {
			if (get_field('acf_key_footer_switch') == 'no') {
				$footer_css = 'footer { 
					display : none !important;
				}';
			}
		} else if (isset($kivicare_options['kivi_footer_top'])) {
			if ($kivicare_options['kivi_footer_top'] == 'no') {
				$footer_css = '.footer-top { 
					display : none !important;
				}';
			}
		}

		if (function_exists('get_field') && get_field('field_footer_bg_color') && !empty(get_field('field_footer_bg_color'))) {
			$footer_bg_color = get_field('field_footer_bg_color');
			$footer_css .= ".footer {
						background-color: $footer_bg_color !important;
					}";
		} else if (class_exists('ReduxFramework') && isset($kivicare_options['change_footer_color'])) {
			if ($kivicare_options['change_footer_color'] == "0") {
			    $f_color = $kivicare_options['footer_color'];
				$footer_css .= "
					footer.default {
						background-color : $f_color !important;
					}";
			}
		}

		if (!empty($footer_css)) {
			wp_add_inline_style('kivicare-global', $footer_css);
		}
	}
}
