<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\Maintenance class
 *
 * @package kivicare
 */

 namespace Kivicare\Utility\Redux_Framework\Options;

 use Redux;
 use Kivicare\Utility\Redux_Framework\Component;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
class Maintenance extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Maintenance', 'kivicare'),
			'id'    => 'Maintenance',
			'icon'  => 'el el-cogs',
			'desc'  => esc_html__('This section contains options for maintenance.', 'kivicare'),
			'fields'           => array(

				array(
					'id'        => 'mainte_mode',
					'type'      => 'button_set',
					'title'     => esc_html__('On/Off Maintenance or Coming Soon mode', 'kivicare'),
					'subtitle' => esc_html__('Turn on to active Maintenance or Coming Soon mode.', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('On', 'kivicare'),
						'no' => esc_html__('Off', 'kivicare')
					),
					'default'   => esc_html__('no', 'kivicare')
				),

				array(
					'id'       => 'maintenance_radio',
					'type'     => 'radio',
					'title'    => esc_html__('Maintenance Mode', 'kivicare'),
					'required'  => array('mainte_mode', '=', 'yes'),
					'options'  => array(
						'1' => 'Maintenance',
						'2' => 'Coming Soon',
					),
					'default'  => '1'
				),

				array(
					'id'       => 'maintenance_bg_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Maintenance Default Background Image', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '1'),
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/redux/maintenance.jpg'),
					'read-only' => false,
					'subtitle' => esc_html__('Upload background image for your Website. Otherwise blank field will be displayed in place of this section.', 'kivicare'),
				),

				array(
					'id'       => 'maintenance_title',
					'type'     => 'text',
					'title'    => esc_html__('Maintenance Title', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '1'),
					'default'  => esc_html__('Sorry,we are down for maintenance', 'kivicare'),
				),

				array(
					'id'       => 'mainten_desc',
					'type'     => 'text',
					'title'    => esc_html__('Maintenance Description', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '1'),
					'default'  => esc_html__('We will be back shortly', 'kivicare'),
				),

				array(
					'id'       => 'coming_soon_bg_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Coming Soon Default Background Image', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '2'),
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/redux/maintenance.jpg'),
					'read-only' => false,
					'subtitle' => esc_html__('Upload background image for your Website. Otherwise blank field will be displayed in place of this section.', 'kivicare'),
				),

				array(
					'id'          => 'opt_date',
					'type'        => 'date',
					'title'       => esc_html__('Coming Soon Date', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '2'),
					'desc'        => esc_html__('This is the description field, again good for additional info.', 'kivicare'),
					'placeholder' => 'Click to enter a date'
				),

				array(
					'id'       => 'coming_title',
					'type'     => 'text',
					'title'    => esc_html__('Coming Soon Title', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '2'),
					'default'  => esc_html__('Coming Soon', 'kivicare'),
				),

				array(
					'id'       => 'coming_desc',
					'type'     => 'text',
					'title'    => esc_html__('Coming Soon Description', 'kivicare'),
					'required'  => array('maintenance_radio', '=', '2'),
					'default'  => esc_html__('We will be back with new and professional Ideas', 'kivicare'),
				),
			)
		));
	}
}
