<?php

/**
 * Kivicare\Utility\Redux_Framework\Options\General class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class General extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('General', 'kivicare'),
			'id'    => 'editer-general',
			'icon'  => 'el el-dashboard',
			'customizer_width' => '500px',
		));
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Body Layout', 'kivicare'),
			'id'    => 'layout-section',
			'icon'  => 'el el-website',
			'subsection' => true,
			'fields' => array(
		
				array(
					'id'       => 'opt-slider-label',
					'type'     => 'dimensions',
					'height'   => false,
					'units'    => array('em', 'px', '%'),
					'title'    => esc_html__('Grid Container Width', 'kivicare'),
					'desc'     => esc_html__('Adjust Your Site Container Width Wtih Help Of Above Opiton.', 'kivicare'),
					'default'  => array(
						'width'   => '1400px',
					),
				),
		
				array(
					'id'       => 'layout_set',
					'type'     => 'button_set',
					'title'    => esc_html__('Set Body Options', 'kivicare'),
					'subtitle' => esc_html__('Select this option for body color or image of the theme.', 'kivicare'),
					'options'  => array(
						'1' => 'Color',
						'2' => 'Default',
						'3' => 'Image'
					),
					'default'  => '2'
				),
		
				array(
					'id'       => 'kivi_layout_image',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__('Set Body Image', 'kivicare'),
					'read-only' => false,
					'required'  => array('layout_set', '=', '3'),
					'subtitle' => esc_html__('Upload Image for your body.', 'kivicare'),
				),
		
				array(
					'id'            => 'kivi_layout_color',
					'type'          => 'color',
					'title'         => esc_html__('Set Body Color', 'kivicare'),
					'subtitle'      => esc_html__('Choose Body Color', 'kivicare'),
					'required'  => array('layout_set', '=', '1'),
					'default'       => '#ffffff',
					'mode'          => 'background',
					'transparent'   => false
				),
		
			)
		));
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Back to Top', 'kivicare'),
			'id'    => 'header-general',
			'icon'  => 'el el-circle-arrow-up',
			'subsection' => true,
			'fields' => array(
		
				array(
					'id'        => 'kivi_back_to_top',
					'type'      => 'button_set',
					'title'     => esc_html__('"Back to top" Button', 'kivicare'),
					'subtitle' => esc_html__('Turn on to show "Back to top" button.', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => esc_html__('yes', 'kivicare')
				),
		
			)
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Enable RTL?', 'kivicare'),
			'id'    => 'is_rtl',
			'icon'  => 'el el-chevron-right',
			'subsection' => true,
			'fields' => array(
				array(
					'id'        => 'kivicare_direction_options',
					'type'     => 'button_set',
					'title' => esc_html__('RTL','kivicare'),
					'subtitle'      => esc_html__('Select Yes To convert site to rtl.', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),					
					'default'   => 'no'
				),

				array(
					'id'        => 'kivicare_enable_switcher',
					'type'      => 'switch',
					'title'     => __('Show Style Switcher', 'kivicare'),
					'subtitle'     => __('The style switcher is only for preview on front-end', 'kivicare'),
					'default'   => false,
				),
			)
		));
	}
}
