<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\Styles class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;
use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Typography extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Typography', 'kivicare'),
			'id' => 'default_style',
			'icon' => 'el el-text-width',
			'desc' => esc_html__('This section contains typography related options.', 'kivicare'),
			'fields' => array(

				array(
					'id' => 'change_font',
					'type' => 'switch',
					'title' => esc_html__('Do you want to change fonts?', 'kivicare'),
					'default' => esc_html__('0', 'kivicare'),
					'0' => esc_html__('Yes', 'kivicare'),
					'1' => esc_html__('No', 'kivicare')
				),

				array(
					'id'        => 'body_font',
					'type'      => 'typography',
					'title'     => esc_html__( 'Body Font','kivicare' ),
					'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
					'required'  => array( 'change_font', '=', '1' ),
					'google'    => true,
					'font-style'    => true,
					'font-backup'   => true,
					'font-weight'   => true,
					'font-size'     => true,
					'line-height'   => false,
					'color'         => false,
					'text-align'    => false,
					'default'       => array(
						'font-family' => esc_html__( 'Poppins','kivicare' ),
						'google'      => true
					)
			),
	
			array(
				'id'        => 'h1_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H1 Font','kivicare' ),
				'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'PT+Sans','kivicare' ),
					'google'      => true
				)
			),
	
			array(
				'id'        => 'h2_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H2 Font','kivicare' ),
				'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'PT+Sans','kivicare' ),
					'google'      => true
				)
			),
	
			array(
				'id'        => 'h3_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H3 Font','kivicare' ),
				'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'PT+Sans','kivicare' ),
					'google'      => true
				)
			),
			array(
				'id'        => 'h4_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H4 Font','kivicare' ),
				'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'PT+Sans','kivicare' ),
					'google'      => true
				)
			),
			array(
				'id'        => 'h5_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H5 Font','kivicare' ),
				'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'PT+Sans','kivicare' ),
					'google'      => true
				)
			),
			array(
				'id'        => 'h6_font',
				'type'      => 'typography',
				'title'     => esc_html__( 'H6 Font','kivicare' ),
				'subtitle'  => esc_html__( 'Select the font.','kivicare' ),
				'required'  => array( 'change_font', '=', '1' ),
				'google'    => true,
				'font-style'    => true,
				'font-weight'   => true,
				'font-size'     => true,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'default'       => array(
					'font-family' => esc_html__( 'PT+Sans','kivicare' ),
					'google'      => true
				)
			),
			)
		));
	}
}
