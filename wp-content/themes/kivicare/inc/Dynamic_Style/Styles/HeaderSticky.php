<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\HeaderSticky class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class HeaderSticky extends Component
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'kivicare_header_sticky_background_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'kivicare_sticky_sub_menu_color_options'), 20);
		add_action('wp_enqueue_scripts', array($this, 'kivicare_sticky_menu_color_options'), 20);
	}

	public function kivicare_header_sticky_background_style()
	{
		global $kivicare_options;

		$inline_css = '';
		if (isset($kivicare_options['sticky_header_display']) && $kivicare_options['sticky_header_display'] === 'yes') {
			if (isset($kivicare_options['sticky_header_bg']) && $kivicare_options['sticky_header_bg'] != 'default') {
				$type = $kivicare_options['sticky_header_bg'];
				if ($type == 'color') {
					if (!empty($kivicare_options['sticky_header_bg_color'])) {
						$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
							background : ' . $kivicare_options['sticky_header_bg_color'] . '!important;
						}';
					}
				}
				if ($type == 'image') {
					if (!empty($kivicare_options['sticky_header_bg_img']['url'])) {
						$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
							background : url(' . $kivicare_options['sticky_header_bg_img']['url'] . ') !important;
						}';
					}
				}
				if ($type == 'transparent') {
					$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
						background : transparent !important;
					}';
				}
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('kivicare-global', $inline_css);
		}
	}

	public function kivicare_sticky_menu_color_options()
	{
		global $kivicare_options;
		$inline_css = '';
		if (isset($kivicare_options['sticky_menu_color_type']) && $kivicare_options['sticky_menu_color_type'] == 'custom') {
			if (isset($kivicare_options['sticky_menu_color']) && !empty($kivicare_options['sticky_menu_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu > li > a, .has-sticky.header-up .sf-menu > li > a{
						color : ' . $kivicare_options['sticky_menu_color'] . '!important;
					}';
			}

			if (isset($kivicare_options['sticky_menu_hover_color']) && !empty($kivicare_options['sticky_menu_hover_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu li:hover > a,.has-sticky.header-down .sf-menu li.current-menu-ancestor > a,.has-sticky.header-down .sf-menu  li.current-menu-item > a, .has-sticky.header-up .sf-menu li:hover > a,.has-sticky.header-up .sf-menu li.current-menu-ancestor > a,.has-sticky.header-up .sf-menu  li.current-menu-item > a{
						color : ' . $kivicare_options['sticky_menu_hover_color'] . '!important;
					}';
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('kivicare-global', $inline_css);
		}
	}

	public function kivicare_sticky_sub_menu_color_options()
	{
		global $kivicare_options;
		$inline_css = '';

		if (isset($kivicare_options['sticky_header_submenu_color_type']) && $kivicare_options['sticky_header_submenu_color_type'] == 'custom') {
			if (isset($kivicare_options['sticky_kivicare_header_submenu_color']) && !empty($kivicare_options['sticky_kivicare_header_submenu_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu ul.sub-menu a, .has-sticky.header-up .sf-menu ul.sub-menu a{
                color : ' . $kivicare_options['sticky_kivicare_header_submenu_color'] . ' !important;
            }';
			}

			if (isset($kivicare_options['sticky_kivicare_header_submenu_hover_color']) && !empty($kivicare_options['sticky_kivicare_header_submenu_hover_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu li.sfHover>a,.has-sticky.header-down .sf-menu li:hover>a,.has-sticky.header-down .sf-menu li.current-menu-ancestor>a,.has-sticky.header-down .sf-menu li.current-menu-item>a,.has-sticky.header-down .sf-menu ul>li.menu-item.current-menu-parent>a,.has-sticky.header-down .sf-menu ul li.current-menu-parent>a,.has-sticky.header-down .sf-menu ul li .sub-menu li.current-menu-item>a,
				.has-sticky.header-up .sf-menu li.sfHover>a,.has-sticky.header-up .sf-menu li:hover>a,.has-sticky.header-up .sf-menu li.current-menu-ancestor>a,.has-sticky.header-up .sf-menu li.current-menu-item>a,.has-sticky.header-up .sf-menu ul>li.menu-item.current-menu-parent>a,.has-sticky.header-up .sf-menu ul li.current-menu-parent>a,.has-sticky.header-up .sf-menu ul li .sub-menu li.current-menu-item>a{
                color : ' . $kivicare_options['sticky_kivicare_header_submenu_hover_color'] . ' !important;
            }';
			}

			if (isset($kivicare_options['sticky_kivicare_header_submenu_background_color']) && !empty($kivicare_options['sticky_kivicare_header_submenu_background_color'])) {
				$inline_css .= '.has-sticky.header-up .sf-menu ul.sub-menu li, .has-sticky.header-down .sf-menu ul.sub-menu li {
                background : ' . $kivicare_options['sticky_kivicare_header_submenu_background_color'] . ' !important;
            }';
			}

			if (isset($kivicare_options['sticky_header_submenu_background_hover_color']) && !empty($kivicare_options['sticky_header_submenu_background_hover_color'])) {
				$inline_css .= '.has-sticky.header-up .sf-menu ul.sub-menu li:hover,.has-sticky.header-up .sf-menu ul.sub-menu li.current-menu-item ,.has-sticky.header-up .sf-menu ul.sub-menu li:hover,.has-sticky.header-up .sf-menu ul.sub-menu li.current-menu-item,
				.has-sticky.header-down .sf-menu ul.sub-menu li:hover,.has-sticky.header-down .sf-menu ul.sub-menu li.current-menu-item ,.has-sticky.header-down .sf-menu ul.sub-menu li:hover,.has-sticky.header-down .sf-menu ul.sub-menu li.current-menu-item{
                background : ' . $kivicare_options['sticky_header_submenu_background_hover_color'] . ' !important;
            }';
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('kivicare-global', $inline_css);
		}
	}
}
