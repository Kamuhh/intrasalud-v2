<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\Page class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;
use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Page extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__('Page Settings','kivicare'),
			'id'    => 'page',
			'icon'  => 'el el-file-edit',
			'fields'=> array(

				array(
					'id'        => 'search_page',
					'type'      => 'image_select',
					'title'     => esc_html__( 'Search page Setting','kivicare' ),
					'subtitle'  => wp_kses( __( '<br />Choose among these structures (Right Sidebar, Left Sidebar and 1column) for your Search page.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.','kivicare' ), array( 'br' => array() ) ),
					'options'   => array(
						'1' => array( 'title' => esc_html__( 'Full Width','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/single-column.jpg' ),
						'4' => array( 'title' => esc_html__( 'Right Sidebar','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/right-side.jpg' ),
						'5' => array( 'title' => esc_html__( 'Left Sidebar','kivicare' ), 'img' => get_template_directory_uri() . '/assets/images/redux/left-side.jpg' ),
					),
					'default'   => '1',
				),
			)
		));
	}
}
