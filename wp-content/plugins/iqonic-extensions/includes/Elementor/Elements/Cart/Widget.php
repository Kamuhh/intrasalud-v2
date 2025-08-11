<?php

namespace Iqonic\Elementor\Elements\Cart;

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
        return 'iqonic_cart';
    }

    public function get_title()
    {
        return __('Layouts: Cart', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-layouts-extension'];
    }

    public function get_icon()
    {
        return 'eicon-cart';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_sc_layouts_cart',
            [
                'label' => __('Layouts: Cart', 'iqonic'),
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => __('Icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-shopping-cart',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'use_ajax', [
                'label' => esc_html__('Enable AJAX?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes','iqonic'),
                'label_off' => esc_html__('No','iqonic'),
                'return' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
        // Cart Style Section End

        //Icon
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .mini-cart-count svg,{{WRAPPER}} .mini-cart-count i,{{WRAPPER}} .mini-cart-count svg path, {{WRAPPER}} .kivicare-cart i, {{WRAPPER}} .kivicare-cart svg path' => 'fill: {{VALUE}}; color: {{VALUE}};'
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
                    '{{WRAPPER}} .mini-cart-count:hover svg,{{WRAPPER}} .mini-cart-count:hover svg path,{{WRAPPER}} .mini-cart-count:hover i, {{WRAPPER}} .kivicare-cart:hover i' => 'fill: {{VALUE}}; color: {{VALUE}};',
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
                    '{{WRAPPER}} .mini-cart-count i,{{WRAPPER}} .mini-cart-count svg
                    ,{{WRAPPER}} .kivicare-cart i' => 'font-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .mini-cart-count svg,{{WRAPPER}} .mini-cart-count i, {{WRAPPER}} .kivicare-cart svg ,{{WRAPPER}} .kivicare-cart i' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .mini-cart-count svg,{{WRAPPER}} .mini-cart-count i, {{WRAPPER}} .kivicare-cart svg ,{{WRAPPER}} .kivicare-cart i' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();

        // Count
        $this->start_controls_section(
            'section_count_style',
            [
                'label' => __('Count', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('count_tabs');
        $this->start_controls_tab(
            'tabs_countef122kCfHObvih40638',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'count_color',
            [
                'label' => __('Choose color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count-total, {{WRAPPER}} .kivicare-cart .basket-item-count .cart-items-count.count' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_count_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mini-cart-count-total, {{WRAPPER}} .basket-item-count',
            ]
        );
        $this->add_control(
            'kivicare_icon_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'kivicare_icon_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['kivicare_icon_has_border' => ['yes']],
                'default' => 'none',
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
                    '{{WRAPPER}} .mini-cart-count-total' => 'border-style:{{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'kivicare_icon_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'condition' => ['kivicare_icon_has_border' => ['yes']],
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count-total' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'kivicare_icon_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'condition' => ['kivicare_icon_has_border' => ['yes']],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count-total' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_icon_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'condition' => ['kivicare_icon_has_border' => ['yes']],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count-total' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_countaJ0C3kdUtggtL5G4tW12awyR',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'count_hover_color',
            [
                'label' => __('Choose color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count:hover .mini-cart-count-total' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_count_hover_background',
                'label' => __('Hover Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mini-cart-count:hover .mini-cart-count-total',
            ]
        );

        $this->add_control(
            'kivicare_count_hover_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'kivicare_icon_hover_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
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
                'condition' => ['kivicare_count_hover_has_border' => ['yes']],

                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count:hover .mini-cart-count-total' => 'border-style:{{VALUE}};',


                ],
            ]
        );

        $this->add_control(
            'kivicare_icon_hover_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['kivicare_count_hover_has_border' => ['yes']],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count:hover .mini-cart-count-total' => 'border-color: {{VALUE}};',
                ],


            ]
        );


        $this->add_control(
            'kivicare_icon_hover_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => ['kivicare_count_hover_has_border' => ['yes']],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count:hover .mini-cart-count-total' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_icon_hover_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => ['kivicare_count_hover_has_border' => ['yes']],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-count:hover .mini-cart-count-total' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'count_size',
            [
                'label' => __('Font Size', 'iqonic'),
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
                    '{{WRAPPER}} .mini-cart-count-total' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'count_width',
            [
                'label' => __('Width', 'iqonic'),
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
                    '{{WRAPPER}} .mini-cart-count-total' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'count_height',
            [
                'label' => __('Height', 'iqonic'),
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
                    '{{WRAPPER}} .mini-cart-count-total' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // Title Style Section
        $this->start_controls_section(
            'section_f4aS9uHc50Of5eNP8jbc',
            [
                'label' => __('Title', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_typography',
                'label' => __('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .mini-cart-count-text',
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
                    '{{WRAPPER}} .mini-cart-count-text' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .mini-cart-count-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        if ( class_exists( 'WooCommerce' ) ) {
            require 'render.php';
        }
    }
}
