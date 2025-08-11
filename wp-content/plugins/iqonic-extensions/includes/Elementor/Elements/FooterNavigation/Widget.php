<?php

namespace Iqonic\Elementor\Elements\FooterNavigation;

use Kivicare\Utility;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_footer_navigation';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Footer Navigation Menu', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-layouts-extension'];
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_header',
            [
                'label' => esc_html__('Navigation', 'iqonic'),

            ]
        );

        $this->add_control(
			'ft_nav_style',
			[
				'label'      => __('Select Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'ft-nav-style-one',
				'options'    => [
					'ft-nav-style-one'          => __('Style-1', 'iqonic'),
				],
			]
		);

        $this->add_control(
            'direction',
            [
                'label'      => esc_html__('Direction', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'vertical',
                'options'    => [
                    'horizontal'    => esc_html__('Horizontal', 'iqonic'),
                    'vertical'      => esc_html__('Vertical', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label'      => esc_html__('Column Gap', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => '1',
                'options'    => [
                    '1'    => esc_html__('1', 'iqonic'),
                    '2'      => esc_html__('2', 'iqonic'),
                    '3'      => esc_html__('3', 'iqonic'),
                ],
                'condition' => ['direction' => 'vertical'],
                'prefix_class' => 'iqonic-footer-gap-',
            ]
        );


        $this->add_control(
            'menu',
            [
                'label'     => esc_html__('Menu test', 'iqonic'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'select',
                'options'   =>  layout_get_nav_menus(),
            ]
        );

        $this->add_control(
            'has_icon',
            [
                'label' => esc_html__('Use Icon?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
                'prefix_class' => 'iqonic-footer-menu-icon-',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start'    => [
                        'title' => esc_html__('Left', 'iqonic'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'iqonic'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'iqonic'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-nav-menu ul.layout-footer-widget' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /* menu list End*/

        //Menu Color
        $this->start_controls_section(
            'section_footrmenu_style',
            [
                'label' => esc_html__('Menu', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'footer_menu_typography',
                'label' => esc_html__('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .footer-menu  li  a',
            ]
        );

        $this->start_controls_tabs('menu_tabs');
        $this->start_controls_tab(
            'tabs_menujeBef122kCfHOb40638',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-menu  li  a'  => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iqonic-footer-menu-icon .footer-menu > li::before
                    ,{{WRAPPER}} .layout-footer-widget.footer-menu li a:after'  => 'color: {{VALUE}};'
                ],
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_menuaJ0C3kdUtggtL5G4tW12awyR',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-menu  li:hover  a' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Icon color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iqonic-footer-menu-icon .footer-menu > li:hover::before
                    ,{{WRAPPER}} .layout-footer-widget.footer-menu li:hover a:after'  => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'menu_parent_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .footer-menu  li  a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'menu_parent_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .footer-menu  li  a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
