<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\Color class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Color extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {

		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__( 'Color Attribute','kivicare' ),
			'id'    => 'color-section',
			'icon'  => 'el el-brush',
			'desc'  => esc_html__('Change the default colors of your site.','kivicare'),
			'fields'=> array(
				array(
					'id'       => 'custom_color_switch',
					'type'     => 'button_set',
					'title'    => esc_html__('Set Custom Color', 'kivicare'),
					'options' => array(
						'yes' => 'Yes', 
						'no' => 'No',
					),
					'default' => 'no'
					),
		
				 array(
					'id'            => 'primary_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Set Primary Color', 'kivicare' ),
					'subtitle'      => esc_html__( 'Select primary accent color.', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array('custom_color_switch' ,'=' , 'yes')
				),
		
				array(
					'id'            => 'secondary_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Set Secondary Color', 'kivicare' ),
					'subtitle'      => esc_html__( 'Select secondary complementing color.', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array('custom_color_switch' ,'=' , 'yes')
				),
		
				 array(
					'id'            => 'title_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Title Color', 'kivicare' ),
					'subtitle'      => esc_html__( 'Select default Title(Headings) color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array('custom_color_switch' ,'=' , 'yes')
				),
		
				array(
					'id'            => 'sub_title_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Sub Title Color', 'kivicare' ),
					'subtitle'      => esc_html__( 'Select default Sub Title color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array('custom_color_switch' ,'=' , 'yes')
				),
		
				array(
					'id'            => 'text_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Body Text Color', 'kivicare' ),
					'subtitle'      => esc_html__( 'Select default body text color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array('custom_color_switch' ,'=' , 'yes')
				),
		
				array(
					'id'            => 'white_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Replace White Color', 'kivicare' ),
					'subtitle'      => esc_html__( 'Select default body text color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false,
					'required'      => array('custom_color_switch' ,'=' , 'yes')
				),
		
			)
		));


	}
}
