<?php

/**
 * Kivicare\Utility\Redux_Framework\Options\Footer class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Footer extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__( 'Footer', 'kivicare' ),
			'id'    => 'footer-editor',
			'icon'  => 'el el-arrow-down',
			'customizer_width' => '500px',
		) );

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer Layout', 'kivicare'),
			'id' => 'footer-layout',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for footer.', 'kivicare'),
			'fields' => array(

				array(
					'id' => 'footer_layout',
					'type' => 'button_set',
					'title' => esc_html__('Footer Layout', 'kivicare'),
					'options' => array(
						'default' => esc_html__('Default', 'kivicare'),
						'custom' => esc_html__('Custom', 'kivicare'),
					),
					'default' => 'default'
				),

				array(
					'id'        => 'footer_style',
					'type'      => 'select',
					'title' 	=> esc_html__('Footer Layout', 'kivicare'),
					'subtitle' 	=> esc_html__('Select the layout variation that you want to use for Footer.', 'kivicare'),
					'options'	=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'footer') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'kivicare') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'kivicare') . "</a>" : "",
					'required' 	=> array('footer_layout', '=', 'custom'),
				),

			)
		));
	
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer Image','kivicare'),
			'id'    => 'footer-logo',
			'subsection' => true,
			'desc'  => esc_html__('This section contains options for footer.','kivicare'),
			'fields'=> array(

				array(
					'id'    => 'info_custom_footer_image',
					'type'  => 'info',
					'required' 	=> array('footer_layout', '=', 'custom'),
					'title' => esc_html__('Note:', 'kivicare'),
					'style' => 'warning',
					'desc'  => esc_html__('This options only works with Default Footer Layout', 'kivicare')
				),

		
				array(
					'id'        => 'display_footer',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Display Footer Background Image','kivicare'),
					'subtitle' => esc_html__( 'Display Footer Background Image On All page', 'kivicare' ),
					'required' 	=> array('footer_layout', '=', 'default'),
					'options'   => array(
									'yes' => esc_html__('Yes','kivicare'),
									'no' => esc_html__('No','kivicare')
								),
					'default'   => esc_html__('no','kivicare')
				),

				array(
					'id'       => 'footer_image',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Footer Background Image','kivicare'),
					'required'  => array( 'display_footer', '=', 'yes' ),
					'read-only'=> false,
					'required' 	=> array('footer_layout', '=', 'default'),
					'subtitle' => esc_html__( 'Upload Footer image for your Website.','kivicare'),
				),
		
				array(
					'id'       => 'logo_footer',         
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Footer Logo','kivicare'),            
					'read-only'=> false,
					'required' 	=> array('footer_layout', '=', 'default'),
					'subtitle' => esc_html__( 'Upload Footer Logo for your Website.','kivicare'),
					'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/logo.png' ),
				),
		
				array(
					'id'        => 'change_footer_color',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Change Footer Color','kivicare'),
					'subtitle' => esc_html__( 'Turn on to Change Footer Background Color', 'kivicare' ),
					'required' 	=> array('footer_layout', '=', 'default'),
					'options'   => array(
									'0' => esc_html__('Yes','kivicare'),
									'1' => esc_html__('No','kivicare')
								),
					'default'   => esc_html__('0','kivicare')
				),
		
				array(
					'id'            => 'footer_color',
					'type'          => 'color',
					'subtitle'      => esc_html__( 'Choose Footer Background Color', 'kivicare' ),
					'required'  => array( 'change_footer_color', '=', '0' ),
					'default'       =>'#eff1fe',
					'mode'          => 'background',
					'transparent'   => false
				),		
			)
		));
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer Option','kivicare'),
			'id'    => 'footer-section',
			'subsection' => true,
			'desc'  => esc_html__('This section contains options for footer.','kivicare'),
			'fields'=> array(

				array(
					'id'    => 'info_custom_footer_option',
					'type'  => 'info',
					'required' 	=> array('footer_layout', '=', 'custom'),
					'title' => esc_html__('Note:', 'kivicare'),
					'style' => 'warning',
					'desc'  => esc_html__('This options only works with Default Footer Layout', 'kivicare')
				),
		
				array(
					'id'        => 'kivi_footer_top',
					'type'      => 'button_set',
					'required' 	=> array('footer_layout', '=', 'default'),
					'title'     => esc_html__( 'Display Footer Top','kivicare'),
					'subtitle' => esc_html__( 'Display Footer Top On All page', 'kivicare' ),
					'options'   => array(
									'yes' => esc_html__('Yes','kivicare'),
									'no' => esc_html__('No','kivicare')
								),
					'default'   => esc_html__('yes','kivicare')
				),
		
				array(
					'id'        => 'kivi_footer_width',
					'type'      => 'image_select',
					'title'     => esc_html__( 'Footer Layout Type','kivicare' ),
					'required'  => array( 'kivi_footer_top', '=', 'yes' ),
					'subtitle'  => wp_kses( __( '<br />Choose among these structures (1column, 2column and 3column) for your footer section.<br />To fill these column sections you should go to appearance > widget.<br />And add widgets as per your needs.','kivicare' ), array( 'br' => array() ) ),
					'options'   => array(
										'1' => array( 'title' => esc_html__( 'Footer Layout 1','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_first.png' ),
										'2' => array( 'title' => esc_html__( 'Footer Layout 2','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_second.png' ),
										'3' => array( 'title' => esc_html__( 'Footer Layout 3','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_third.png' ),
										'4' => array( 'title' => esc_html__( 'Footer Layout 4','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_four.png' ),
										'5' => array( 'title' => esc_html__( 'Footer Layout 5','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_five.png' ),
									),
					'default'   => '3',
				),
		
				array(
					'id'       => 'footer_one',
					'type'     => 'select',
					'title'    => esc_html__('Select 1 Footer Alignment', 'kivicare'),
					'required'  => array( 'kivi_footer_top', '=', 'yes' ),
					'options'  => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default'  => '1',
				),
		
				array(
					'id'       => 'footer_two',
					'type'     => 'select',
					'title'    => esc_html__('Select 2 Footer Alignment', 'kivicare'),
					'required'  => array( 'kivi_footer_top', '=', 'yes' ),
					'options'  => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default'  => '1',
				),
		
				array(
					'id'       => 'footer_three',
					'type'     => 'select',
					'title'    => esc_html__('Select 3 Footer Alignment', 'kivicare'),
					'required'  => array( 'kivi_footer_top', '=', 'yes' ),
					'options'  => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default'  => '1',
				),
		
				array(
					'id'       => 'footer_fore',
					'type'     => 'select',
					'title'    => esc_html__('Select 4 Footer Alignment', 'kivicare'),
					'required'  => array( 'kivi_footer_top', '=', 'yes' ),
					'options'  => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default'  => '1',
				),
		
				array(
					'id'       => 'footer_five',
					'type'     => 'select',
					'title'    => esc_html__('Select 5 Footer Alignment', 'kivicare'),
					'required'  => array( 'kivi_footer_top', '=', 'yes' ),
					'options'  => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default'  => '1',
				),
			)
		));
		
		Redux::set_section($this->opt_name, array(
			'title'      => esc_html__( 'Footer Copyright', 'kivicare' ),
			'id'         => 'footer-copyright',
			'subsection' => true,
			'fields'     => array(

				array(
					'id'    => 'info_custom_footer_copyrights',
					'type'  => 'info',
					'required' 	=> array('footer_layout', '=', 'custom'),
					'title' => esc_html__('Note:', 'kivicare'),
					'style' => 'warning',
					'desc'  => esc_html__('This options only works with Default Footer Layout', 'kivicare')
				),
		
				array(
					'id'        => 'display_copyright',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Display Copyrights','kivicare'),
					'options'   => array(
									'yes' => esc_html__('Yes','kivicare'),
									'no' => esc_html__('No','kivicare')
								),
					'default'   => esc_html__('yes','kivicare'),
					'required' 	=> array('footer_layout', '=', 'default'),
				),
				 array(
					'id'       => 'footer_copyright_align',
					'type'     => 'select',
					'title'    => esc_html__('Copyrights Alignment', 'kivicare'),
					'options'  => array(
						'1' => 'Left',
						'2' => 'Right',
						'3' => 'Center',
					),
					'default'  => '3',
					'required' 	=> array('footer_layout', '=', 'default'),
				),
		
		
				array(
					'id'        => 'footer_copyright',
					'type'      => 'editor',
					'required'  => array( 'display_copyright', '=', 'yes' ),
					'title'     => esc_html__( 'Copyrights Text','kivicare'),
					'default'   => esc_html__( 'Copyright {{year}} KiviCare All Rights Reserved.','kivicare'),
				),
			))
		);

	}
}
