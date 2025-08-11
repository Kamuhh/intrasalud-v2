<?php

/**
 * Kivicare\Utility\Redux_Framework\Options class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class UserOptions extends Component
{
	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('User Account Settings', 'kivicare'),
			'id'    => 'user-register-options',
			'fields' => array(
				array(
					'id'    => 'info_custom_headers_options',
					'type'  => 'info',
					'required' 	=> array('header_layout', '=', 'custom'),
					'title' => esc_html__('Note:', 'kivicare'),
					'style' => 'warning',
					'desc'  => esc_html__('This options only works with Default Header Layout', 'kivicare')
				),
				array(
					'id' => 'kivicare_signup_section',
					'type' => 'section',
					'title' =>  esc_html__('Sign Up', 'kivicare'),
					'indent' => true,
					'required' 	=> array('header_layout', '=', 'default'),
				),

				array(
					'id'        => 'kivicare_signup_title',
					'type'      => 'text',
					'title'     => esc_html__('SignUp button title', 'kivicare'),
					'default'     => esc_html__('Sign Up', 'kivicare'),
				),

				array(
					'id'        => 'kivicare_signup_link',
					'type'     => 'select',
					'multi'    => false,
					'data'     => 'pages',
					'title'     => esc_html__('Select Page For SignUp', 'kivicare'),
				),

				array(
					'id' => 'kivicare_signin_section',
					'type' => 'section',
					'title' => esc_html__('Sign In', 'kivicare'),
					'indent' => true,
					'required' 	=> array('header_layout', '=', 'default'),

				),
				array(
					'id'        => 'kivicare_signin_title',
					'type'      => 'text',
					'title'     => esc_html__('SignIn button title', 'kivicare'),
					'default'     => esc_html__('Sign In', 'kivicare'),
				),

				array(
					'id'        => 'kivicare_signin_link',
					'type'     => 'select',
					'multi'    => false,
					'data'     => 'pages',
					'title'     => esc_html__('Select Page For SignIn', 'kivicare'),
				),

				array(
					'id' => 'kivicare_logout_section',
					'type' => 'section',
					'title' => esc_html__('Logout', 'kivicare'),
					'indent' => true,
					'required' 	=> array('header_layout', '=', 'default'),

				),

				array(
					'id'        => 'kivicare_logout_title',
					'type'      => 'text',
					'title'     => esc_html__('Logout Button title', 'kivicare'),
					'default'   =>  esc_html__('Logout', 'kivicare')
				),

				array(
					'id' => 'kivicare_profile_section',
					'type' => 'section',
					'title' => esc_html__('Profile', 'kivicare'),
					'indent' => true,
					'required' 	=> array('header_layout', '=', 'default'),
				),
				array(
					'id'        => 'kivicare_profile_title',
					'type'      => 'text',
					'title'     => esc_html__('Profile button title', 'kivicare'),
					'default'     => esc_html__('Profile', 'kivicare'),
				),

				array(
					'id'        => 'kivicare_profile_link',
					'type'     => 'select',
					'multi'    => false,
					'data'     => 'pages',
					'title'     => esc_html__('Select Page For Profile', 'kivicare'),
				),
			)
		));
	}
}
