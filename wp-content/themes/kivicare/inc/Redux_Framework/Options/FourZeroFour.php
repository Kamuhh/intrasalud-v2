<?php

/**
 * Kivicare\Utility\Redux_Framework\Options\FourZeroFour class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class FourZeroFour extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('404','kivicare'),
			'id'    => 'fourzerofour-section',
			'icon'  => 'el-icon-error',
			'desc'  => esc_html__('This section contains options for 404.','kivicare'),
			'fields'=> array(

				array(
					'id' 		=> 'four_zero_four_layout',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Page Layout', 'kivicare'),
					'options' 	=> array(
						'default' 	=> esc_html__('Default', 'kivicare'),
						'custom' 	=> esc_html__('Custom', 'kivicare'),
					),
					'default'	=> 'default'
				),

				array(
					'id'        => '404_layout',
					'type'      => 'select',
					'title' 	=> esc_html__('404 Layout', 'kivicare'),
					'subtitle' 	=> esc_html__('Select the layout variation that you want to use for 404 page.', 'kivicare'),
					'options'	=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'four_zero_four') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'kivicare') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'kivicare') . "</a>" : "",
					'required' 	=> array('four_zero_four_layout', '=', 'custom'),
				),
		
				array(
					'id'       => 'kivi_404_banner_image',         
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__( '404 Page Default Banner Image','kivicare'),
					'read-only'=> false,
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
					'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/404.png' ),
					'subtitle' => esc_html__( 'Upload banner image for your Website. Otherwise blank field will be displayed in place of this section.','kivicare'),
				),
		
				array(
					'id'        => 'kivi_fourzerofour_title',
					'type'      => 'text',
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
					'title'     => esc_html__( '404 Page Title','kivicare'),
					'default'   => esc_html__( 'Oops! This Page is Not Found.','kivicare' )
				),
				array(
					'id'        => 'kivi_four_description',
					'type'      => 'textarea',
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
					'title'     => esc_html__( '404 Page Description','kivicare'),
					'default'   => esc_html__( 'The requested page does not exists.','kivicare' )
				),
				array(
					'id'       	=> 'header_on_404',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Enable', 'kivicare'),
					'off'		=> esc_html__('Disable', 'kivicare'),
					'title'    	=> esc_html__('Header', 'kivicare'),
					'subtitle' 	=> esc_html__('Enable / disable header on 404 page', 'kivicare'),
					'default'  	=> false,
				),

				array(
					'id'       	=> 'footer_on_404',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Enable', 'kivicare'),
					'off'		=> esc_html__('Disable', 'kivicare'),
					'title'    	=> esc_html__('Footer', 'kivicare'),
					'subtitle' 	=> esc_html__('Enable / disable footer on 404 page', 'kivicare'),
					'default'  	=> false,
				)
				
			)) 
		);

	}
}
