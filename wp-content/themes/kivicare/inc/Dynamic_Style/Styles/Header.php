<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Header class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;


class Header extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'kivicare_header_dynamic_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'kivicare_top_header_background_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'kivicare_header_side_area_bg_styles'), 20);
	}

	public function kivicare_header_dynamic_style()
	{
		$page_id = get_queried_object_id();
		if (function_exists('get_field') && get_field('key_header', $page_id)['display_header'] != 'default') {
			if (get_field('key_header', $page_id)['display_header'] == 'no') {
				$header_css = 'header, header#default-header { 
					display : none !important;
				}';
				wp_add_inline_style('kivicare-global', $header_css);
			}
		}
	}

	function kivicare_top_header_background_style() {

        global $kivicare_options;

		if(isset($kivicare_options['email_and_button']) && $kivicare_options['email_and_button'] == "yes") {
			if(!empty($kivicare_options['header_top_background_type'])) {
				$options = $kivicare_options['header_top_background_type'];

				$top_header_css = '';

				if($options == 'image') {
					$top_header_css .= '.sub-header {
						background : ' . $kivicare_options['header_top_background_image'] . ' !important;
					}';
				}

				if($options == 'color') {
					$top_header_css .= '.sub-header {
						background : ' . $kivicare_options['header_top_background_color'] . ' !important;
					}';
				}

				if($options == 'transparent') {
					$top_header_css .= '.sub-header{
						background : transparent !important;
					}';
				}

				if (!empty($top_header_css)) {
					wp_add_inline_style('kivicare-global', $top_header_css);
				}
				
			}

			if(isset($kivicare_options['header_top_text_color']) && !empty($kivicare_options['header_top_text_color'])) {
				$top_header_css .= '.sub-header a{
					color : ' . $kivicare_options['header_top_text_color'] . ' !important;
				}';
			}
			
			if(isset($kivicare_options['header_top_text_hover_color']) && !empty($kivicare_options['header_top_text_hover_color'])) {
				$top_header_css .= '.sub-header a:hover{
					color : ' . $kivicare_options['header_top_text_hover_color'] . ' !important;
				}';
			}

            if(isset($kivicare_options['header_top_icon_color']) && !empty($kivicare_options['header_top_icon_color'])) {
				$top_header_css .= '.sub-header a i{
					color : ' . $kivicare_options['header_top_icon_color'] . ' !important;
				}';
			}

            if(isset($kivicare_options['header_top_icon_hover_color']) && !empty($kivicare_options['header_top_icon_hover_color'])) {
				$top_header_css .= '.sub-header a i:hover{
					color : ' . $kivicare_options['header_top_icon_hover_color'] . ' !important;
				}';
			}

			if (!empty($top_header_css)) {
				wp_add_inline_style('kivicare-global', $top_header_css);
			}
		}
	}

	public function kivicare_header_side_area_bg_styles() {

		global $kivicare_options;

        $dynamic_css = '';

        if(isset($kivicare_options['header_display_side_area']) && $kivicare_options['header_display_side_area'] == 'yes') {
            if(isset($kivicare_options['sidearea_background_type'])) {
                $type = $kivicare_options['sidearea_background_type'];
                if($type == 'color') {
                    $dynamic_css .= '.iq-menu-side-bar{
                        background: '. $kivicare_options['sidearea_background_color'] .' !important;
                    }';
                }

                if($type == 'image') {
                    if(!empty($kivicare_options['sidearea_background_image']['url'])) {
                        $dynamic_css .= '.iq-menu-side-bar{
                            background: url('. $kivicare_options['sidearea_background_image']['url'] .') !important;
                        }';
                    }
                }

                if($type == 'transparent') {
                    $dynamic_css .= '.iq-menu-side-bar{
                        background: transparent !important;
                    }';
                }
            }
        }

        //open button color
        if(isset($kivicare_options['sidearea_btn_color_type']) && $kivicare_options['sidearea_btn_color_type'] == 'custom') {
            if(isset($kivicare_options['sidearea_btn_open_color']) && !empty($kivicare_options['sidearea_btn_open_color'])) {
                $dynamic_css .= '.iq-sidearea-btn-container {
                    background: '. $kivicare_options['sidearea_btn_open_color'].' !important;
                }';
            }

            if(isset($kivicare_options['sidearea_btn_open_hover']) && !empty($kivicare_options['sidearea_btn_open_hover'])) {
                $dynamic_css .= '.iq-sidearea-btn-container:hover {
                    background: '. $kivicare_options['sidearea_btn_open_hover'].' !important;
                }';
            }
        }

        //open button line color
        if(isset($kivicare_options['sidearea_btn_color_type']) && $kivicare_options['sidearea_btn_color_type'] == 'custom') {
            if(isset($kivicare_options['sidearea_btn_line_color']) && !empty($kivicare_options['sidearea_btn_line_color'])) {
                $dynamic_css .= '.menu-btn .line {
                    background: '. $kivicare_options['sidearea_btn_line_color'].' !important;
                }';
            }

            if(isset($kivicare_options['sidearea_btn_line_hover_color']) && !empty($kivicare_options['sidearea_btn_line_hover_color'])) {
                $dynamic_css .= '.iq-sidearea-btn-container:hover .menu-btn .line {
                    background: '. $kivicare_options['sidearea_btn_line_hover_color'].' !important;
                }';
            }
        }

        //close button color
        if(isset($kivicare_options['sidearea_btn_color_type']) && $kivicare_options['sidearea_btn_color_type'] == 'custom') {
            if(isset($kivicare_options['sidearea_btn_close_color']) && !empty($kivicare_options['sidearea_btn_close_color'])) {
                $dynamic_css .= '#menu-btn-side-close {
                    background: '. $kivicare_options['sidearea_btn_close_color'].' !important;
                }';
            }

            if(isset($kivicare_options['sidearea_btn_close_hover']) && !empty($kivicare_options['sidearea_btn_close_hover'])) {
                $dynamic_css .= '#menu-btn-side-close:hover {
                    background: '. $kivicare_options['sidearea_btn_close_hover'].' !important;
                }';
            }
        }

        //close button line color
        if(isset($kivicare_options['sidearea_btn_color_type']) && $kivicare_options['sidearea_btn_color_type'] == 'custom') {
            if(isset($kivicare_options['sidearea_btn_close_line_color']) && !empty($kivicare_options['sidearea_btn_close_line_color'])) {
                $dynamic_css .= '#menu-btn-side-close .menu-btn .line {
                    background: '. $kivicare_options['sidearea_btn_close_line_color'].' !important;
                }';
            }

            if(isset($kivicare_options['sidearea_btn_close_line_hover_color']) && !empty($kivicare_options['sidearea_btn_close_line_hover_color'])) {
                $dynamic_css .= '#menu-btn-side-close:hover .menu-btn .line {
                    background: '. $kivicare_options['sidearea_btn_close_line_hover_color'].' !important;
                }';
            }
        }

        if(!empty($dynamic_css)) {
            wp_add_inline_style('kivicare-global', $dynamic_css);
        }
    }

}
