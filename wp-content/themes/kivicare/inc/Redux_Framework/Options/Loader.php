<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\Loader class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;
use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Loader extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Loader','kivicare'),
			'id'    => 'header-loader',
			'icon'  => 'el el-refresh',
			'fields'=> array(
		
				array(
					'id'        => 'kivi_display_loader',
					'type'      => 'button_set',
					'title'     => esc_html__( 'kivicare Loader','kivicare'),
					'subtitle' => wp_kses('Turn on to show the icon/images loading animation while your site loads', 'kivicare'),
					'options'   => array(
									'yes' => esc_html__('Yes','kivicare'),
									'no' => esc_html__('No','kivicare')
								),
					'default'   => esc_html__('yes','kivicare')
				),
		
				array(
					'id'            => 'loader_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Loader Background Color', 'kivicare' ),
					'required'  => array( 'kivi_display_loader', '=', 'yes' ),
					'subtitle'      => esc_html__( 'Choose Loader Background Color', 'kivicare' ),
					'default'       => '#ffffff',
					'transparent'   => false
				),
		
				array(
					'id'       => 'kivi_loader_gif',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__( 'Add GIF image for loader','kivicare'),
					'read-only'=> false,
					'required'  => array( 'kivi_display_loader', '=', 'yes' ),
					'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/loader.gif' ),
					'subtitle' => esc_html__( 'Upload Loader GIF image for your Website.','kivicare'),
				),
		
				array(
					'id'             => 'loader-dimensions',
					'type'           => 'dimensions',
					'units'          => array( 'em', 'px', '%' ),
					'units_extended' => 'true',
					'required'  => array( 'kivi_display_loader', '=', 'yes' ),
					'title'          => esc_html__( 'Loader (Width/Height) Option', 'kivicare' ),
					'subtitle'       => esc_html__( 'Allows you to choose width, height, and/or unit.', 'kivicare' ),
					'desc'           => esc_html__( 'You can enable or disable any piece of this field. Width, Height, or Units.', 'kivicare' ),
				),
		
			)
		));
		
	}
}
