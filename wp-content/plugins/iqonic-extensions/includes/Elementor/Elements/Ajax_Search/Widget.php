<?php

namespace Iqonic\Elementor\Elements\Ajax_Search;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_ajaxsearch';
    }

    public function get_title()
    {
        return __('Layouts: Ajax Search', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-search';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_iqonic_layouts_search',
            [
                'label' => __('Layouts: Ajax Search', 'iqonic'),
            ]
        );


        $this->add_control(
			'show_search_icon',
			[
				'label' => __( 'Show Search Icon', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'iqonic' ),
				'label_off' => __( 'Hide', 'iqonic' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'search_icon',
			[
				'label' => __( 'Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-search',
					'library' => 'solid',
				],
                'condition' => [
                    'show_search_icon' => 'yes'
                ],
			]
		);
        
        $this->end_controls_section();
    }

    protected function render()
    {
        require 'render.php';
    }
}
