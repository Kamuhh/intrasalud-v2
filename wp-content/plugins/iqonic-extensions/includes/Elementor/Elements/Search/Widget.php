<?php

namespace Iqonic\Elementor\Elements\Search;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_search';
    }

    public function get_title()
    {
        return __('Layouts: Search', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-layouts-extension'];
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
                'label' => __('Layouts: Search', 'iqonic'),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'      => __('Layout', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default'   => __('Default', 'iqonic'),
                    'modern'    => __('Modern', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'use_search_Text',
            [
                'label'      => __('Use Search Text', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'yes',
                'options'    => [
                    'yes'   => __('Yes', 'iqonic'),
                    'no'    => __('No', 'iqonic'),
                ],
                'condition' => ['layout' => 'modern']
            ]
        );

        $this->add_control(
            'use_search_position',
            [
                'label'      => __('Text Position', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'after',
                'options'    => [
                    'before'   => __('Before Icon', 'iqonic'),
                    'after'    => __('After Icon', 'iqonic'),
                ],
                'condition' => [
                    'layout' => 'modern',
                    'use_search_Text' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'search_text',
            [
                'label' => __('Search Text', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => __('Search', 'iqonic'),
                'condition' => [
                    'layout' => 'modern',
                    'use_search_Text' => 'yes' 
                ],
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label' => __('Placeholder', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => __('Search Website', 'iqonic'),
                'condition' => [
                    'use_search_Text' => 'yes'
                ],
            ]
        );

        $this->add_control(
			'show_search_icon',
			[
				'label' => __( 'Show Search Icon', 'iqonic' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'iqonic' ),
				'label_off' => __( 'Hide', 'iqonic' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'search_icon',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-search',
					'library' => 'solid',
				],
                'condition' => [
                    'show_search_icon' => 'yes'
                ],
			]
		);

        $this->add_control(
            'post_types',
            [
                'label' => __('Search in post types', 'iqonic'),
                'label_block' => false,
                'type' => Controls_Manager::SELECT2,
                'options' => iqonic_addons_get_list_posts_types(),
                'multiple' => true,
                'default' => ''
            ]
        );

       
        

        $this->add_control(
            'style',
            [
                'label'      => __('Search Color scheme', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default'   => __('Default', 'iqonic'),
                    'light'    => __('Light', 'iqonic'),
                    'dark'    => __('Dark', 'iqonic'),
                ],
                'condition' => ['layout' => 'modern'],
            ]
        );

        $this->end_controls_section();
        // search Style Section End

        //Icon
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'modern'],
            ]
        );


        $this->start_controls_tabs('icon_tabs');
        $this->start_controls_tab(
            'tabs_jeBef122kCfHObvih40638',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );


        $this->add_control(
            'icon_color',
            [
                'label' => __('Choose color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search_count .btn-search i ,{{WRAPPER}} .search_count .btn-search svg , {{WRAPPER}} .search_count .btn-search svg path' => 'fill: {{VALUE}}; color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_aJ0C3kdUtggtL5G4tW12awyR',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => __('Choose color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search_count .btn-search:hover svg , {{WRAPPER}} .search_count .btn-search:hover i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search_count .btn-search svg , {{WRAPPER}} .search_count .btn-search i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'icon_width',
            [
                'label' => __('Width', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search_count .btn-search svg , {{WRAPPER}} .search_count .btn-search i' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_height',
            [
                'label' => __('Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search_count .btn-search svg , {{WRAPPER}} .search_count .btn-search i' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();

        // // Modern Style Title Section
        $this->start_controls_section(
            'section_0Of5eNP8jbc',
            [
                'label' => __('Title', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'modern', 'use_search_Text' => 'yes'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'search_typography',
                'label' => __('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .search-text',
            ]
        );

        $this->start_controls_tabs('title_tabs');

        $this->start_controls_tab(
            'title_color_tab_normal',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'title_normal_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_color_tab_hover',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search:hover .search-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        // Modern Style

        $this->start_controls_section(
            'section_0s6Y4c68qoBcctzHf68f',
            [
                'label' => __('Modern', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'modern'],
            ]
        );

        $this->add_control(
            'modern_icon_color',
            [
                'label' => __('Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-form .search-submit svg,
                    {{WRAPPER}} .search-form .search-submit i,
                    {{WRAPPER}} button.btn-search-close svg,
                     {{WRAPPER}} button.btn-search-close i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .search__form::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'modern_text_color',
            [
                'label' => __('Text Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'modern_placeholder_color',
            [
                'label' => __('Placeholder Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search_wrap .search-form input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Default Style
        $this->start_controls_section(
            'section_default0s6Y4c68qoBcctzHf68f',
            [
                'label' => __('Search Box', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'default'],
            ]
        );

        $this->add_control(
            'default_icon_color',
            [
                'label' => __('Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['
                    {{WRAPPER}} .search_wrap.search-form-default .search-form .search-submit svg,
                    {{WRAPPER}} .search_wrap.search-form-default .search-form .search-submit svg path,
                    {{WRAPPER}} .search_wrap.search-form-default .search-form .search-submit i' => 'color: {{VALUE}};fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'search_text_typography',
                'label' => __('Search text typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .search_wrap .form-search input',
            ]
        );

        $this->add_control(
            'default_text_color',
            [
                'label' => __('Text Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search_wrap .form-search input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'default_placeholder_color',
            [
                'label' => __('Placeholder Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search_wrap .search-form input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'default_data_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .search_wrap.search-form-default .search-form input',
            ]
        );

        $this->add_control(
            'searchbox_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px','em', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .search_wrap.search-form-default .search_form_wrap .form-search input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'searchbox_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid'  => __('Solid', 'iqonic'),
                    'dashed' => __('Dashed', 'iqonic'),
                    'dotted' => __('Dotted', 'iqonic'),
                    'double' => __('Double', 'iqonic'),
                    'outset' => __('outset', 'iqonic'),
                    'groove' => __('groove', 'iqonic'),
                    'ridge' => __('ridge', 'iqonic'),
                    'inset' => __('inset', 'iqonic'),
                    'hidden' => __('hidden', 'iqonic'),
                    'none' => __('none', 'iqonic'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .search_wrap.search-form-default .search_form_wrap .form-search input' => 'border-style: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'searchbox_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'condition' => [
                    'searchbox_border_style!' => 'none',
                ],
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search_wrap.search-form-default .search_form_wrap .form-search input' => 'border-color: {{VALUE}} !important;',
                ],

            ]
        );

        $this->add_control(
            'searchbox_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'condition' => [
                    'searchbox_border_style!' => 'none',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px','em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .search_wrap.search-form-default .search_form_wrap .form-search input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],

            ]
        );

        $this->add_control(
            'searchbox_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px','em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .search_wrap.search-form-default .search_form_wrap .form-search input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings();
        require 'render.php';
    }
}
