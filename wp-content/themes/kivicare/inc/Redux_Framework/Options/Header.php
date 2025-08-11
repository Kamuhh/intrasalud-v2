<?php

/**
 * Kivicare\Utility\Redux_Framework\Options\General class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Header extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__( 'Header', 'kivicare' ),
			'id'    => 'header-editor',
			'icon'  => 'el el-arrow-up',
			'customizer_width' => '500px',
		) );
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Menu Layout','kivicare'),
			'id'    => 'header-variation',
			'subsection' => true,
			'desc'  => esc_html__('This section contains options for Menu .','kivicare'),
			'fields'=> array(

				array(
					'id' => 'header_layout',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout', 'kivicare'),
					'options' => array(
						'default' => esc_html__('Default', 'kivicare'),
						'custom' => esc_html__('Custom', 'kivicare'),
					),
					'default' => 'default'
				),

				array(
					'id'        	=> 'menu_style',
					'type'      	=> 'select',
					'title' 		=> esc_html__('Header Layout', 'kivicare'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'kivicare'),
					'options'		=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'header') : '',
					'desc'			=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'kivicare') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'kivicare') . "</a>" : "",
					'required' 		=> array('header_layout', '=', 'custom'),
				),

				array(
					'id' => 'header_postion',
					'type' => 'button_set',
					'title' => esc_html__('Header Position', 'kivicare'),
					'options' => array(
						'default' => esc_html__('Default', 'kivicare'),
						'over' => esc_html__('Over', 'kivicare'),
					),
					'default' => 'default',
				),
		
				array(
					'id'        => 'header_menu_container',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Header container','kivicare'),
					'options'   => array(
									'container-fluid' => esc_html__('full width','kivicare'),
									'container' => esc_html__('Container','kivicare'),
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('container-fluid','kivicare')
				),
		
				//-------- main header background options start ----------//

				array(
					'id'        => 'kivi_header_background_type',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Background','kivicare'),
					'subtitle'  => esc_html__( 'Select the variation for header background','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'color' => esc_html__('Color','kivicare'),
									'image' => esc_html__('Image','kivicare'),
									'transparent' => esc_html__('Transparent','kivicare')
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'kivi_header_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set Background Color', 'kivicare' ),
					'required'  => array( 'kivi_header_background_type', '=', 'color' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'       => 'kivi_header_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__( 'Upload Image', 'kivicare' ),
					'required'  => array( 'kivi_header_background_type', '=', 'image' ),
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload background image for header.','kivicare'),
				),
		
				// --------main header Background options end----------//
		
				// --------main header Menu options start----------//
				array(
					'id'        => 'header_menu_color_type',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Menu Color Options','kivicare'),
					'subtitle' => esc_html__( 'Select Menu color .','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare'),
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('default','kivicare')
				),
				array(
					'id'            => 'kivi_header_menu_color',
					'type'          => 'color',
					'required'  => array( 'header_menu_color_type', '=', 'custom' ),
					'desc'     => esc_html__( 'Menu Color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_header_menu_active_color',
					'type'          => 'color',
					'required'  => array( 'header_menu_color_type', '=', 'custom' ),
					'desc'     => esc_html__( 'Active Menu Color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_header_menu_hover_color',
					'type'          => 'color',
					'required'  => array( 'header_menu_color_type', '=', 'custom' ),
					'desc'     => esc_html__( 'Menu Hover Color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
			
				//----sub menu options start---//
				array(
					'id'        => 'header_submenu_color_type',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Submenu Color Options','kivicare'),
					'subtitle' => esc_html__( 'Select submenu color.','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare'),
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'kivi_header_submenu_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Color', 'kivicare' ),
					'required'  => array( 'header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_header_submenu_active_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Active Submenu Color', 'kivicare' ),
					'required'  => array( 'header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_header_submenu_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Hover Color', 'kivicare' ),
					'required'  => array( 'header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_header_submenu_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Background Color', 'kivicare' ),
					'required'  =>  array( 'header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_submenu_background_active_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Background Active Color', 'kivicare' ),
					'required'  => array( 'header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_submenu_background_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Background Hover Color', 'kivicare' ),
					'required'  =>  array( 'header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				//----sub menu options end----//
		
			   
		
				// --------main header Menu options end----------//
		
				// --------main header responsive Menu Button Options start----------//
				array(
					'id'        => 'responsive_menu_button_type',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Responsive Menu Color','kivicare'),
					'subtitle' => esc_html__( 'Select menu color for responsive mode.','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare')
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'responsive_menu_button_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Toggle button color', 'kivicare' ),
					'required'  => array( 'responsive_menu_button_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'responsive_menu_button_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Toggle button background color', 'kivicare' ),
					'required'  => array( 'responsive_menu_button_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'responsive_menu_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Responsive menu color', 'kivicare' ),
					'required'  => array( 'responsive_menu_button_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'responsive_menu_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Responsive menu hover color', 'kivicare' ),
					'required'  => array( 'responsive_menu_button_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'responsive_menu_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Responsive menu background color', 'kivicare' ),
					'required'  => array( 'responsive_menu_button_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'responsive_menu_active_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Responsive menu active background color', 'kivicare' ),
					'required'  => array( 'responsive_menu_button_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				// --------main header responsive Menu Button Options end----------//
		
				// --------main header Button 1 Options start----------//
				array(
					'id'        => 'header_display_button',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Button 1','kivicare'),
					'subtitle' => esc_html__( 'Turn on to display the Login and CTA button in header.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('On','kivicare'),
									'no' => esc_html__('Off','kivicare')
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('yes','kivicare')
				),
		
				array(
					'id'        => 'kivi_download_title',
					'type'      => 'text',
					'required'  => array( 'header_display_button', '=', 'yes' ),
					'default'   => 'Get Started',
					'desc'   => esc_html__('Change Title (e.g.Download).','kivicare'),
				),
				array(
					'id'        => 'kivi_download_link',
					'type'      => 'text',
					'required'  => array( 'header_display_button', '=', 'yes' ),
					'desc'   => esc_html__('Add download link.','kivicare'),
				),
		
				array(
					'id'        => 'header_button_color_type',
					'type'      => 'button_set',
					'required'  => array( 'header_display_button', '=', 'yes' ),
					'desc' => esc_html__( 'Select for button color options.','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare')
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'kivi_download_btn_background',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button background color', 'kivicare' ),
					'required'  => array( 'header_button_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_download_btn_background_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button background hover color', 'kivicare' ),
					'required'  => array( 'header_button_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_download_btn_text',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button text color', 'kivicare' ),
					'required'  => array( 'header_button_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_download_btn_text_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button text hover Color', 'kivicare' ),
					'required'  => array( 'header_button_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				// --------main header Button 1 Options end----------//
		
		
				// --------main header Button 2 Options start----------//
				array(
					'id'        => 'header_display_btn2',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Button 2','kivicare'),
					'subtitle' => esc_html__( 'Turn on to display the button 2 in header.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('On','kivicare'),
									'no' => esc_html__('Off','kivicare')
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('yes','kivicare')
				),
		
				array(
					'id'        => 'kivi_btn2_title',
					'type'      => 'text',
					'required'  => array( 'header_display_btn2', '=', 'yes' ),
					'default'   => 'Get Started',
					'desc'   => esc_html__('Change Title (e.g.Download).','kivicare'),
				),
				array(
					'id'        => 'kivi_btn2_link',
					'type'      => 'text',
					'required'  => array( 'header_display_btn2', '=', 'yes' ),
					'desc'   => esc_html__('Add Button 2 link.','kivicare'),
				),
		
				array(
					'id'        => 'header_btn2_color_type',
					'type'      => 'button_set',
					'required'  => array( 'header_display_btn2', '=', 'yes' ),
					'desc' => esc_html__( 'Select for button 2 color options.','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare')
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'kivi_btn2_background',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button 2 background color', 'kivicare' ),
					'required'  => array( 'header_btn2_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_btn2_background_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button 2 background hover color', 'kivicare' ),
					'required'  => array( 'header_btn2_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_btn2_text',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button 2 text color', 'kivicare' ),
					'required'  => array( 'header_button2_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'kivi_btn2_text_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Button 2 text hover Color', 'kivicare' ),
					'required'  => array( 'header_button2_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				// --------main header Button2 Options end----------//
				// ----------search and shop page start ----//
				array(
					'id'        => 'header_display_shop',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Shop & Wishlist Button','kivicare'),
					'subtitle' => esc_html__( 'Turn on to display Shop & Wishlist Button in header.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('Yes','kivicare'),
									'no' => esc_html__('No','kivicare')
								),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('no','kivicare')
				),
		
				array(
				'id'       => 'shop_link',
				'type'     => 'select',
				'multi'    => false,
				'data'     => 'pages',
				'required'  => array( 'header_display_shop', '=', 'yes' ),
				'title'    => __( 'Choose Shop Page' , 'kivicare'),
				'subtitle' => __( 'Select Page that you want to display shop items' , 'kivicare'),
				),
		
				array(
				'id'       => 'wishlist_link',
				'type'     => 'select',
				'multi'    => false,
				'data'     => 'pages',
				'required'  => array( 'header_display_shop', '=', 'yes' ),
				'title'    => __( 'Choose Wishlist Page' , 'kivicare'),
				'subtitle' => __( 'Select Page that you want to display wishlist items' , 'kivicare'),
				),
				// ----------search and shop page end ----//
			)
		));
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__( 'Header Top', 'kivicare' ),
			'id'    => 'Header_Contact',
			'subsection' => true,
			'desc' => esc_html__('The header Layout should be default, to visible the options', 'kivicare'),
			'fields'  => array(
		
				array(
					'id'        => 'email_and_button',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Display Top Header','kivicare'),
					'subtitle' => esc_html__( 'Turn on to display top header Email, Phone, Social Media.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('On','kivicare'),
									'no' => esc_html__('Off','kivicare')
								),
					'default'   => esc_html__('yes','kivicare'),
					'required'  => array( 'header_layout', '=', 'default' ),
				),
				// --------header top background options start----------//
				array(
					'id'        => 'header_top_background_type',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Background','kivicare'),
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'color' => esc_html__('Color','kivicare'),
									'image' => esc_html__('Image','kivicare'),
									'transparent' => esc_html__('Transparent','kivicare')
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'header_top_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set Background Color', 'kivicare' ),
					'required'  => array( 'header_top_background_type', '=', 'color' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'       => 'header_top_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__( 'Upload Image', 'kivicare' ),
					'required'  => array( 'header_top_background_type', '=', 'image' ),
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload background image for top header.','kivicare'),
				),
		
				// --------header top background options end----------//
				// --------header top Text color options start----------//
				array(
					'id'        => 'header_top_text_color_type',
					'type'      => 'button_set',
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'title'     => esc_html__( 'Text / Icon color options','kivicare'),
					'subtitle' => esc_html__( 'Select text / icon color for normal and hover .','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare'),
								),
					'default'   => esc_html__('custom','kivicare')
				),
				array(
					'id'            => 'header_top_text_color',
					'type'          => 'color',
					'desc'      => esc_html__( 'Choose text color for top header.', 'kivicare' ),
					'required'  => array( 'header_top_text_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_top_text_hover_color',
					'type'          => 'color',
					'desc'      => esc_html__( 'Choose text hover color for top header.', 'kivicare' ),
					'required'  => array( 'header_top_text_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'default'   => '#40d1af',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_top_icon_color',
					'type'          => 'color',
					'desc'      => esc_html__( 'Choose Icon color for top header.', 'kivicare' ),
					'required'  => array( 'header_top_text_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_top_icon_hover_color',
					'type'          => 'color',
					'desc'      => esc_html__( 'Choose Icon hover color for top header.', 'kivicare' ),
					'required'  => array( 'header_top_text_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				// --------header top Text color options end----------//
				array(
					'id'       => 'header_phone',
					'type'     => 'text',
					'title'    => esc_html__( 'Phone', 'kivicare' ),
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'preg' => array(
						'pattern' => '/[^0-9_ -+()]/s',
						'replacement' => ''
					),
					'default'  => esc_html__('+0123456789','kivicare'),
				),
		
				array(
					'id'       => 'header_email',
					'type'     => 'text',
					'title'    => esc_html__( 'Email', 'kivicare' ),
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'validate' => 'email',
					'msg'      => esc_html__('custom error message','kivicare'),
					'default'  => esc_html__('support@example.com','kivicare'),
				),
		
				array(
					'id'       => 'header_address',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Address', 'kivicare' ),
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'default'  => esc_html__('1234 North Avenue Luke Lane, South Bend, IN 360001','kivicare' ),
				),
		
				array(
					'id'        => 'header_display_contact',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Email/Phone on Header','kivicare'),
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'subtitle' => esc_html__( 'Turn on to display the Email and Phone number in top header menu.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('On','kivicare'),
									'no' => esc_html__('Off','kivicare')
								),
					'default'   => esc_html__('yes','kivicare')
				),
		
				array(
					'id'        => 'kivi_header_social_media',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Social Media','kivicare'),
					'subtitle' => esc_html__( 'Turn on to display Social Media in top header.','kivicare'),
					'required'  => array( 'email_and_button', '=', 'yes' ),
					'options'   => array(
									'yes' => esc_html__('Yes','kivicare'),
									'no' => esc_html__('No','kivicare')
								),
					'default'   => esc_html__('yes','kivicare')
				),
			)
		) );
		//-----Sticky Header Options Start---//
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Sticky Header', 'kivicare') ,
			'id' => 'sticky-header-variation',
			'subsection' => true,
			// 'desc' => esc_html__('This section contains options for sticky header menu and background color.', 'kivicare') ,
			'desc' => esc_html__('The header Layout should be default, to visible the options', 'kivicare'),
			'fields' => array(
		
				array(
					'id'        => 'sticky_header_display',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Sticky Header','kivicare'),
					'subtitle' => esc_html__( 'Turn on to display sticky header.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('On','kivicare'),
									'no' => esc_html__('Off','kivicare')
								),
					'default'   => esc_html__('yes','kivicare'),
					'required'  => array( 'header_layout', '=', 'default' ),
				),
				 // --------sticky header background options start----------//
				array(
					'id'        => 'sticky_header_background_type',
					'type'      => 'button_set',
					'required'  => array( 'sticky_header_display', '=', 'yes' ),
					'title'     => esc_html__( 'Background','kivicare'),
					'subtitle'  => esc_html__( 'Select the variation for sticky header background','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'color' => esc_html__('Color','kivicare'),
									'image' => esc_html__('Image','kivicare'),
									'transparent' => esc_html__('Transparent','kivicare')
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'sticky_header_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set Background Color', 'kivicare' ),
					'required'  => array( 'sticky_header_background_type', '=', 'color' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'       => 'sticky_header_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__( 'Upload Image', 'kivicare' ),
					'required'  => array( 'sticky_header_background_type', '=', 'image' ),
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload background image for sticky header.','kivicare'),
				),
				// --------sticky header Background options end----------//
		
				// --------sticky header Menu options start----------//
		
				array(
					'id'        => 'sticky_menu_color_type',
					'type'      => 'button_set',
					'required'  => array( 'sticky_header_display', '=', 'yes' ),
					'title'     => esc_html__( 'Menu Color Options','kivicare'),
					'subtitle' => esc_html__( 'Select Menu color for sticky.','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare'),
								),
					'default'   => esc_html__('default','kivicare')
				),
				array(
					'id'            => 'sticky_menu_color',
					'type'          => 'color',
					'required'  => array( 'sticky_menu_color_type', '=', 'custom' ),
					'desc'     => esc_html__( 'Sticky header menu color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sticky_menu_active_color',
					'type'          => 'color',
					'required'  => array( 'sticky_menu_color_type', '=', 'custom' ),
					'desc'     => esc_html__( 'Sticky header active menu color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sticky_menu_hover_color',
					'type'          => 'color',
					'required'  => array( 'sticky_menu_color_type', '=', 'custom' ),
					'desc'     => esc_html__( 'Sticky header menu hover color', 'kivicare' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				//----sticky sub menu options start---//
				array(
					'id'        => 'sticky_header_submenu_color_type',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Submenu Color Options','kivicare'),
					'subtitle' => esc_html__( 'Select submenu color.','kivicare'),
					'required'  => array( 'sticky_header_display', '=', 'yes' ),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare'),
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'sticky_kivi_header_submenu_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Color', 'kivicare' ),
					'required'  => array( 'sticky_header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sticky_kivi_header_submenu_active_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Active Submenu Color', 'kivicare' ),
					'required'  => array( 'sticky_header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sticky_kivi_header_submenu_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Hover Color', 'kivicare' ),
					'required'  => array( 'sticky_header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sticky_kivi_header_submenu_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Background Color', 'kivicare' ),
					'required'  => array( 'sticky_header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sticky_header_submenu_background_active_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Background Active Color', 'kivicare' ),
					'required'  => array( 'sticky_header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sticky_header_submenu_background_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Submenu Background Hover Color', 'kivicare' ),
					'required'  => array( 'sticky_header_submenu_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				// --------sticky header Menu options start----------//
			)
		));
		//-----Sticky Header Options Options End---//
		
		//-----Side Area Options Start---//
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Side Area', 'kivicare') ,
			'id' => 'header-side-area-variation',
		
			'subsection' => true,
			'desc' => esc_html__('This section contains options for side area button in header.', 'kivicare') ,
			'fields' => array(
		
			  array(
					'id'        => 'header_display_side_area',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Side Area (Sliding Panel)','kivicare'),
					'subtitle' => esc_html__( 'Set option for Sliding right side panel.','kivicare'),
					'options'   => array(
									'yes' => esc_html__('On','kivicare'),
									'no' => esc_html__('Off','kivicare')
								),
					'default'   => esc_html__('yes','kivicare')
				),
		
				// --------side area background options start----------//
				array(
					'id'        => 'sidearea_background_type',
					'type'      => 'button_set',
					'required'  => array( 'header_display_side_area', '=', 'yes' ),
					'title'     => esc_html__( 'Background','kivicare'),
					'subtitle'  => esc_html__( 'Select the variation for Sidearea background','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'color' => esc_html__('Color','kivicare'),
									'image' => esc_html__('Image','kivicare'),
									'transparent' => esc_html__('Transparent','kivicare')
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'sidearea_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set Background Color', 'kivicare' ),
					'required'  => array( 'sidearea_background_type', '=', 'color' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'       => 'sidearea_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__( 'Upload Image', 'kivicare' ),
					'required'  => array( 'sidearea_background_type', '=', 'image' ),
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload background image for sidearea.','kivicare'),
				),
				// --------side area Background options end----------//
				array(
					'id' => 'sidearea_width',
					'type' => 'dimensions',
					'height' => false,
					'units'    => array('em','px','%'),
					'title' => esc_html__('Adjust sidearea width', 'kivicare') ,
					'subtitle' => esc_html__('Choose Width, and/or unit.', 'kivicare') ,
					'desc' => esc_html__('Sidearea Width.', 'kivicare') ,
					'required'  => array( 'header_display_side_area', '=', 'yes' ),
				),
		
				// --------side area button color options ----------//
				array(
					'id'        => 'sidearea_btn_color_type',
					'type'      => 'button_set',
					'required'  => array( 'header_display_side_area', '=', 'yes' ),
					'title'     => esc_html__( 'Button color options','kivicare'),
					'subtitle' => esc_html__( 'Select text normal / hover color .','kivicare'),
					'options'   => array(
									'default' => esc_html__('Default','kivicare'),
									'custom' => esc_html__('Custom','kivicare'),
								),
					'default'   => esc_html__('default','kivicare')
				),
		
				array(
					'id'            => 'sidearea_btn_open_color',
					'type'          => 'color',
					'title' => esc_html__('Open button color', 'kivicare') ,
					'subtitle' => esc_html__('Select color for normal / hover.', 'kivicare') ,
					'desc'     => esc_html__( 'Set open button color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_open_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set open button hover color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sidearea_btn_line_color',
					'type'          => 'color',
					'title' => esc_html__('Open button line color', 'kivicare') ,
					'subtitle' => esc_html__('Select normal / hover color of open button lines.', 'kivicare') ,
					'desc'     => esc_html__( 'Set open button line color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_line_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set open button line hover color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sidearea_btn_close_color',
					'type'          => 'color',
					'title' => esc_html__('Close button color', 'kivicare') ,
					'subtitle' => esc_html__('Select normal / hover color of close button inside sidearea.', 'kivicare') ,
					'desc'     => esc_html__( 'Set close button color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_close_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set close button hover color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sidearea_btn_close_line_color',
					'type'          => 'color',
					'title' => esc_html__('Close button line color', 'kivicare') ,
					'subtitle' => esc_html__('Select normal / hover color of close button lines.', 'kivicare') ,
					'desc'     => esc_html__( 'Set open button line color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_close_line_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set close button line hover color', 'kivicare' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
			)
		));

		
	}
}
