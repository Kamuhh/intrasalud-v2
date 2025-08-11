<?php

namespace Iqonic\Elementor\Elements\DoctorInfo;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'Iq_Doc_Info';
    }

    public function get_title()
    {
        return __('Iq Doc Info', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-person';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_711rNK9oIdi6RuT0z72g',
			[
				'label' => __('Doctor Info', 'iqonic'),
			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/DoctorInfo/render.php';
    }
}
