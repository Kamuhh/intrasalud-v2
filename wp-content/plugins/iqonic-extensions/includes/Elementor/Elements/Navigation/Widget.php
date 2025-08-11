<?php

namespace Iqonic\Elementor\Elements\Navigation;

use Elementor\Plugin;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_navigation';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Navigation Menu', 'iqonic');
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
            'layout',
            [
                'label'      => esc_html__('Layout', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default'   => esc_html__('Default', 'iqonic'),
                    'burger'    => esc_html__('Burger', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'      => esc_html__('Direction', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'horizontal',
                'options'    => [
                    'horizontal'    => esc_html__('Horizontal', 'iqonic'),
                    'vertical'      => esc_html__('Vertical', 'iqonic'),
                ],
                'condition' => ['layout' => 'default']
            ]
        );
        $this->add_control(
            'design_style',
            [
                'label'      => esc_html__('Hover Effect', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'style-one',
                'options'    => [
                    'style-one'       => esc_html__('Style 1', 'iqonic'),
                    'style-two'    => esc_html__('Style 2', 'iqonic'),
                ],
                'condition' => ['layout' => 'default', 'direction' => 'vertical']
            ]
        );
        $this->add_control(
            'location',
            [
                'label'         => esc_html__('Location', 'iqonic'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'select',
                'options'       =>   layout_get_nav_menus('location') ,
                'description'   => 'Select None for menu based selection',
            ]
        );

        $this->add_control(
            'menu',
            [
                'label'     => esc_html__('Menu', 'iqonic'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'select',
                'options'   =>  layout_get_nav_menus('location') ,
                'condition' => ['location' => 'select']
            ]
        );

        $this->add_control(
            'hover_effect',
            [
                'label'      => esc_html__('Hover Effect', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default'       => esc_html__('Style 1 (Default)', 'iqonic'),
                    'background'    => esc_html__('Style 2', 'iqonic'),
                    'top-border'    => esc_html__('Style 3', 'iqonic'),
                ],
                'condition' => ['layout' => 'default', 'direction' => 'horizontal']
            ]
        );

        $this->add_control(
            'use_more',
            [
                'label'      => esc_html__('Use More', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'yes',
                'options'    => [
                    'yes'   => esc_html__('Yes', 'iqonic'),
                    'no'    => esc_html__('No', 'iqonic'),
                ],
                'condition' => ['layout' => 'default', 'direction' => 'horizontal']
            ]
        );
        $this->add_control(
            'more_text',
            [
                'label' => esc_html__('More Text', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__('More', 'iqonic'),
                'condition' => ['layout' => 'default', 'direction' => 'horizontal', 'use_more' => 'yes'],
            ]
        );

        $this->add_control(
            'more_item',
            [
                'label' => esc_html__('Items', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'description' => esc_html__('Show Number of Lists use More Text', 'iqonic'),
                'default' => esc_html__('5', 'iqonic'),
                'condition' => ['layout' => 'default', 'direction' => 'horizontal', 'use_more' => 'yes'],
            ]
        );

        $this->add_control(
            'use_custom_icon',
            [
                'label'      => esc_html__('Use Custom Icon', 'iqonic'),
                'type'       => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'iqonic'),
                'label_off' => esc_html__('No', 'iqonic'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => ['layout' => 'burger']
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-line'
                ],
                'condition' => ['layout' => 'burger', 'use_custom_icon' => 'yes'],
            ]
        );

        $this->end_controls_section();

        /* menu list End*/

        //Menu Color
        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => esc_html__('Menu', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'default'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_typography',
                'label' => esc_html__('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .sf-menu > li > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu>li>a ',
            ]
        );
        $this->add_control(
            'kivicare_menu_height',
            [
                'label' => esc_html__('Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => ['direction' => 'vertical'],
                'selectors' => [
                    '{{WRAPPER}} .verticle-mn' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'menu_align',
            [
                'label' => esc_html__('Alignment', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => esc_html__('Left', 'iqonic'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'iqonic'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'iqonic'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .widget-nav-menu .menu-main-menu-container .top-menu,{{WRAPPER}} .kivicare-menu-wrapper.mobile-menu .navbar ,{{WRAPPER}} .kivicare-menu-wrapper.mobile-menu .navbar .verticle-mn' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .widget-nav-menu nav.navbar ,{{WRAPPER}} .kivicare-menu-wrapper.mobile-menu .navbar .verticle-mn ,{{WRAPPER}} .kivicare-menu-wrapper.mobile-menu .navbar' => 'justify-content: {{VALUE}}',

                ],
            ]
        );
        $this->start_controls_tabs('menu_tabs');
        $this->start_controls_tab(
            'tabs_menujeBef122kCfHObvih40638',
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
                    '{{WRAPPER}} .sf-menu > li > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu>li>a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li>.toggledrop i'  => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_menuaJ0C3kdUtggtL5G4tW12awyR',
            [
                'label' => esc_html__('Active/Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sf-menu li:hover > a,{{WRAPPER}} .sf-menu li.current-menu-ancestor > a,{{WRAPPER}} .sf-menu  li.current-menu-item > a ,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li.current-menu-item>.toggledrop i,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li.current-menu-item>a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li .sub-menu li:hover>a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li:hover>.toggledrop i,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li:hover>a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul>li.current-menu-ancestor>.toggledrop i,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul>li.current-menu-ancestor>a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul li .sub-menu li.current-menu-item>a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul li .sub-menu li.menu-item.current-menu-ancestor>a ,
                    {{WRAPPER}} .sf-menu li.sfHover>a' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}}  .sf-menu > li, {{WRAPPER}} .kivicare-full-menu .top-menu > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}}  .sf-menu > li, {{WRAPPER}} .kivicare-full-menu .top-menu > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();


        // Default layout top-border
        $this->start_controls_section(
            'section_border4tW12awyR',
            [
                'label' => esc_html__('Border', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'default',
                    'hover_effect' => 'top-border'
                ]
            ]
        );

        $this->add_control(
            'kivicare_menu_border_color',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-hover-top-border .sf-menu > li > a::before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'kivicare_menu_border_width',
            [
                'label' => esc_html__('Border Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-hover-top-border .sf-menu > li > a::before' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_section();


        // Default layout Background
        $this->start_controls_section(
            'section_background4tW12awyR',
            [
                'label' => esc_html__('Background', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'default',
                    'hover_effect' => 'background'
                ]
            ]
        );

        $this->add_control(
            'kivicare_menu_bg_color',
            [
                'label' => esc_html__('Background Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-hover-background .sf-menu > li:hover > a,{{WRAPPER}} .menu-hover-background .sf-menu li.current-menu-ancestor > a,{{WRAPPER}} .menu-hover-background .sf-menu li.current-menu-item > a' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        //Sub Menu Color
        $this->start_controls_section(
            'section_submenu_style',
            [
                'label' => esc_html__('Sub Menu', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'default',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submenu_bg_background',
                'label' => esc_html__('Submenu Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .sf-menu ul.sub-menu',
            ]
        );

        $this->add_responsive_control(
            'submenu_parent_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .sf-menu ul.sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'section_vl8vK4162c',
            [
                'label' => esc_html__('Inner Menu', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_typography',
                'label' => esc_html__('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .sf-menu ul.sub-menu a ,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li .sub-menu li a',
            ]
        );

        $this->start_controls_tabs('submenu_tabs');
        $this->start_controls_tab(
            'tabs_submenujeBef1kCfHObvih40638',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'submenu_text_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sf-menu ul.sub-menu a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li .sub-menu li a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li li>.toggledrop i'  => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'kivicare_submenu_bg_color',
            [
                'label' => esc_html__('Background Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sf-menu ul.sub-menu li' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_submenuaJ0C3kdUtg5G4tW12awyR',
            [
                'label' => esc_html__('Active/Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'submenu_text_hover_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sf-menu .sub-menu li.sfHover>a, {{WRAPPER}} .sf-menu  .sub-menu li:hover>a, {{WRAPPER}} .sf-menu .sub-menu li.current-menu-ancestor>a,{{WRAPPER}} .sf-menu .sub-menu li.current-menu-item>a,{{WRAPPER}} .sf-menu ul.sub-menu>li.menu-item.current-menu-parent>a,{{WRAPPER}} .sf-menu ul .sub-menu li.current-menu-parent>a,{{WRAPPER}} .sf-menu ul li .sub-menu li.current-menu-item>a ,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu  .sub-menu li.current-menu-item > .toggledrop i,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu  .sub-menu li.current-menu-item > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li .sub-menu li:hover > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li:hover > .toggledrop i,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li:hover > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul > li.current-menu-ancestor > .toggledrop i,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul > li.current-menu-ancestor > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul li .sub-menu li.current-menu-item > a,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout ul li .sub-menu li.menu-item.current-menu-ancestor > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .sf-menu ul>li.menu-item>a:before' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'kivicare_submenu_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sf-menu ul.sub-menu li:hover,{{WRAPPER}} .sf-menu ul.sub-menu li.current-menu-item' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'submenu_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .sf-menu ul.sub-menu li ,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li .sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'submenu_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .sf-menu ul.sub-menu li ,{{WRAPPER}} .kivicare-mobile-menu.vertical-menu-layout .top-menu li .sub-menu li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_section();


        //Burger Menu Icon
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__('Icon', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'burger'],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-btn svg ,{{WRAPPER}} .menu-btn svg path,{{WRAPPER}} .menu-btn i' => 'fill: {{VALUE}}; color: {{VALUE}};'
                ],
                'condition' => ['use_custom_icon' => 'yes'],
            ]
        );

        $this->add_control(
            'default_icon_color',
            [
                'label' => esc_html__('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-btn .line' => 'background-color: {{VALUE}};'
                ],
                'condition' => ['use_custom_icon!' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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
                    '{{WRAPPER}} .menu-btn svg,{{WRAPPER}} .menu-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['use_custom_icon' => 'yes'],
            ]
        );

        $this->end_controls_section();

        //Menu Color
        $this->start_controls_section(
            'section_burger_menu_style',
            [
                'label' => esc_html__('Menu', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['layout' => 'burger'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'burger_mobile_typography',
                'label' => esc_html__('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-mobile-menu .top-menu > li > a',
            ]
        );

        $this->add_control(
            'burger_text_color',
            [
                'label' => esc_html__('Menu color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-mobile-menu .top-menu > li > a,{{WRAPPER}} .kivicare-mobile-menu .top-menu li > .toggledrop i'  => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'burger_text_hover_color',
            [
                'label' => esc_html__('Menu Hover color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-mobile-menu .top-menu li.current-menu-item > .toggledrop i,{{WRAPPER}} .kivicare-mobile-menu .top-menu li.current-menu-item > a,{{WRAPPER}} .kivicare-mobile-menu .top-menu li .sub-menu li:hover > a,{{WRAPPER}} .kivicare-mobile-menu .top-menu li:hover > .toggledrop i,{{WRAPPER}} .kivicare-mobile-menu .top-menu li:hover > a,{{WRAPPER}} .kivicare-mobile-menu ul > li.current-menu-ancestor > .toggledrop i,{{WRAPPER}} .kivicare-mobile-menu ul > li.current-menu-ancestor > a,{{WRAPPER}} .kivicare-mobile-menu ul li .sub-menu li.current-menu-item > a,{{WRAPPER}} .kivicare-mobile-menu ul li .sub-menu li.menu-item.current-menu-ancestor > a' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'section_1vK4162c',
            [
                'label' => esc_html__('Sub Menu', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'burger_submobile_typography',
                'label' => esc_html__('Sub Menu Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-mobile-menu .top-menu li .sub-menu li a',
            ]
        );

        $this->add_control(
            'burger_subenu_text_hover_color',
            [
                'label' => esc_html__('Sub Menu color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-mobile-menu .top-menu li .sub-menu li a ,{{WRAPPER}} .kivicare-mobile-menu .top-menu li .sub-menu li svg' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        require 'render.php';
        if (Plugin::$instance->editor->is_edit_mode()) {
            if ($settings['design_style'] == "style-one") {
?>
                <script>
                    (function($) {
                        if ($('.menu-style-one.kivicare-mobile-menu').length > 0) {
                            getDefaultMenu();
                        }
                    })(jQuery);
                </script>
            <?php
            }
            if ($settings['design_style'] == "style-two") {
            ?>
                <script>
                    (function($) {
                        MoreMenu();
                    })(jQuery);
                </script>
<?php
            }
        }
    }
}
