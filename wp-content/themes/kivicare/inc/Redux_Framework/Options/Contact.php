<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\Contact class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Contact extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__( 'Contact', 'kivicare' ),
			'id'    => 'Contact',
			'icon'  => 'el el-map-marker',
			'fields'           => array(
	
				array(
					'id'       => 'address',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Address', 'kivicare' ),
					'default'  => esc_html__('1234 North Avenue Luke Lane, South Bend, IN 360001','kivicare' ),
				),
	
				array(
					'id'       => 'phone',
					'type'     => 'text',
					'title'    => esc_html__( 'Phone', 'kivicare' ),
					'preg' => array(
						'pattern' => '/[^0-9_ -+()]/s',
						'replacement' => ''
					),
					'default'  => esc_html__('+0123456789','kivicare' ),
				),

				array(
					'id'       => 'phone1',
					'type'     => 'text',
					'title'    => esc_html__( 'Phone1', 'kivicare' ),
					'preg' => array(
						'pattern' => '/[^0-9_ -+()]/s',
						'replacement' => ''
					),
					'default'  => esc_html__('+234567890','kivicare' ),
				),
	
				array(
					'id'       => 'email',
					'type'     => 'text',
					'title'    => esc_html__( 'Email', 'kivicare' ),
					'validate' => 'email',
					'msg'      => esc_html__('custom error message','kivicare' ),
					'default'  => esc_html__('support@example.com','kivicare' ),
				),
			   
			)
		) );

		
	}
}
