<?php

namespace Iqonic\Elementor\Elements\Tab;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_tabs';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Tabs', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'section',
            [
                'label' => esc_html__('Tabs', 'iqonic'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Tab Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Tab Title', 'iqonic'),
                'default' => esc_html__('Tab', 'iqonic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_title_desc',
            [
                'label' => esc_html__('Tab Content Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Tab Content Title', 'iqonic'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'contentimage',
            [
                'label' => esc_html__('Tab Content Choose Image', 'iqonic'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__('Content', 'iqonic'),
                'default' => esc_html__('Tab Content', 'iqonic'),
                'placeholder' => esc_html__('Tab Content', 'iqonic'),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__('Read More', 'iqonic'),
            ]
        );

        $repeater->add_control(
            'link_type',
            [
                'label' => esc_html__( 'Link Type', 'iqonic' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [					
                    'dynamic' => esc_html__( 'Dynamic', 'iqonic' ),
                    'custom' => esc_html__( 'Custom', 'iqonic' ),
                ],
            ]
        );
    
        $repeater->add_control(
            'dynamic_link',
            [
                'label' => esc_html__('Page List', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'link_type' => 'dynamic',
                ],
                'options' => iqonic_get_posts("page"),
            ]
        );
    
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'iqonic' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'link_type' => 'custom',
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'iqonic' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs Items', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__('Tab #1', 'iqonic'),
                        'selected_icon' =>  ['value' => 'fas fa-star'],
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'contentimage' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'button_action' => 'none',
                        'tab_title_desc' => esc_html__('Description #1', 'iqonic'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'iqonic'),
                        'button_text'  => esc_html__('Read More', 'iqonic'),
                    ]

                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );


        $this->add_control(
            'has_icon',
            [
                'label' => esc_html__('Use Button Icon?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_NEZmnxQ',
            [
                'label' => esc_html__('Tab Block', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );




        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_tabblock_background',
                'label' => esc_html__('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-tabs ',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_tabblock_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs',
            ]
        );
        
        $this->add_control(
            'kivicare_tabblock_block_has_border',
            [
                'label' => esc_html__('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'kivicare_tabblock_border_style',
            [
                'label' => esc_html__('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['kivicare_tabblock_block_has_border' => ['yes']],
                'default' => 'none',
                'options' => [
                    'solid'  => esc_html__('Solid', 'iqonic'),
                    'dashed' => esc_html__('Dashed', 'iqonic'),
                    'dotted' => esc_html__('Dotted', 'iqonic'),
                    'double' => esc_html__('Double', 'iqonic'),
                    'outset' => esc_html__('outset', 'iqonic'),
                    'groove' => esc_html__('groove', 'iqonic'),
                    'ridge' => esc_html__('ridge', 'iqonic'),
                    'inset' => esc_html__('inset', 'iqonic'),
                    'hidden' => esc_html__('hidden', 'iqonic'),
                    'none' => esc_html__('none', 'iqonic'),

                ],

                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'kivicare_tabblock_border_color',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['kivicare_tabblock_block_has_border' => ['yes']],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'kivicare_tabblock_border_width',
            [
                'label' => esc_html__('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['kivicare_tabblock_block_has_border' => ['yes']],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_tabblock_border_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['kivicare_tabblock_block_has_border' => ['yes']],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_tab();

        $this->add_responsive_control(
            'kivicare_tabblock_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_tabblock_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );


        $this->end_controls_section();

        /* Icon Box  End*/

        /* Tablist content start*/

        $this->start_controls_section(
            'section_e93Koa91f1kFaVN6MABU',
            [
                'label' => esc_html__('Tab list', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_tag',
            [
                'label'      => esc_html__('Title Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h5',
                'options'    => [

                    'h1'          => esc_html__('h1', 'iqonic'),
                    'h2'          => esc_html__('h2', 'iqonic'),
                    'h3'          => esc_html__('h3', 'iqonic'),
                    'h4'          => esc_html__('h4', 'iqonic'),
                    'h5'          => esc_html__('h5', 'iqonic'),
                    'h6'          => esc_html__('h6', 'iqonic'),
                    'p'           => esc_html__('p', 'iqonic'),

                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_text_typography',
                'label' => esc_html__('Title Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link .tab-title',
            ]
        );

        $this->start_controls_tabs('tablist_tabs');

        $this->start_controls_tab(
            'tabs_M7mf29Ec64y0K03BYo9c',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'content_text_color',
            [
                'label' => esc_html__('Title Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link .tab-title' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'quote_back_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link',

            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_tablist_box_shadow',
                'label' => esc_html__('Tablist Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_r0c98aZl9VUB07Jah5Ic',
            [
                'label' => esc_html__('Active', 'iqonic'),
            ]
        );


        $this->add_control(
            'content_active_text_color',
            [
                'label' => esc_html__('Title  Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link.active .tab-title, {{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link:hover .tab-title' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'quote_active_back_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link:hover,{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link.active,{{WRAPPER}} .kivicare-tabs .nav-pills .show > .nav-link',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_tab_active_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link:hover,{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link.active,{{WRAPPER}} .kivicare-tabs .nav-pills .show > .nav-link',
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();



        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .nav-pills .nav-item .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .nav.nav-pills' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );



        $this->end_controls_section();

        /* Tablist content end*/
                /*Icon Icon start*/

                $this->start_controls_section(
                    'section_285gUPrCuoL6e62Mhf7m',
                    [
                        'label' => esc_html__('Icon Box Icon/Image', 'iqonic'),
                        'tab' => Controls_Manager::TAB_STYLE,
                    ]
                );
        
        
                $this->start_controls_tabs('Iconbox_icon_tabs');
                $this->start_controls_tab(
                    'tabs_jeBef2kCfHObvih40638',
                    [
                        'label' => esc_html__('Normal', 'iqonic'),
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_has_border',
                    [
                        'label' => esc_html__('Set Custom Border?', 'iqonic'),
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'no',
                        'yes' => esc_html__('yes', 'iqonic'),
                        'no' => esc_html__('no', 'iqonic'),
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_border_style',
                    [
                        'label' => esc_html__('Border Style', 'iqonic'),
                        'type' => Controls_Manager::SELECT,
                        'condition' => ['kivicare_iconbox_has_border' => ['yes']],
                        'default' => 'none',
                        'options' => [
                            'solid'  => esc_html__('Solid', 'iqonic'),
                            'dashed' => esc_html__('Dashed', 'iqonic'),
                            'dotted' => esc_html__('Dotted', 'iqonic'),
                            'double' => esc_html__('Double', 'iqonic'),
                            'outset' => esc_html__('outset', 'iqonic'),
                            'groove' => esc_html__('groove', 'iqonic'),
                            'ridge' => esc_html__('ridge', 'iqonic'),
                            'inset' => esc_html__('inset', 'iqonic'),
                            'hidden' => esc_html__('hidden', 'iqonic'),
                            'none' => esc_html__('none', 'iqonic'),
        
                        ],
        
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image' => 'border-style:{{VALUE}};',
        
                        ],
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_border_color',
                    [
                        'label' => esc_html__('Border Color', 'iqonic'),
                        'condition' => ['kivicare_iconbox_has_border' => ['yes']],
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image' => 'border-color: {{VALUE}};',
                        ],
        
        
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_border_width',
                    [
                        'label' => esc_html__('Border Width', 'iqonic'),
                        'condition' => ['kivicare_iconbox_has_border' => ['yes']],
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
        
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_border_radius',
                    [
                        'label' => esc_html__('Border Radius', 'iqonic'),
                        'condition' => ['kivicare_iconbox_has_border' => ['yes']],
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
        
                    ]
                );
                $this->end_controls_tab();
        
                $this->start_controls_tab(
                    'tabs_aJ0C3kdUL5G4tW12awyR',
                    [
                        'label' => esc_html__('Hover', 'iqonic'),
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_hover_has_border',
                    [
                        'label' => esc_html__('Set Custom Border?', 'iqonic'),
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'no',
                        'yes' => esc_html__('yes', 'iqonic'),
                        'no' => esc_html__('no', 'iqonic'),
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_hover_border_style',
                    [
                        'label' => esc_html__('Border Style', 'iqonic'),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'none',
                        'options' => [
                            'solid'  => esc_html__('Solid', 'iqonic'),
                            'dashed' => esc_html__('Dashed', 'iqonic'),
                            'dotted' => esc_html__('Dotted', 'iqonic'),
                            'double' => esc_html__('Double', 'iqonic'),
                            'outset' => esc_html__('outset', 'iqonic'),
                            'groove' => esc_html__('groove', 'iqonic'),
                            'ridge' => esc_html__('ridge', 'iqonic'),
                            'inset' => esc_html__('inset', 'iqonic'),
                            'hidden' => esc_html__('hidden', 'iqonic'),
                            'none' => esc_html__('none', 'iqonic'),
        
                        ],
                        'condition' => ['kivicare_iconbox_hover_has_border' => ['yes']],
        
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image:hover' => 'border-style:{{VALUE}};',
                        ],
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_hover_border_color',
                    [
                        'label' => esc_html__('Border Color', 'iqonic'),
                        'type' => Controls_Manager::COLOR,
                        'condition' => ['kivicare_iconbox_hover_has_border' => ['yes']],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image:hover' => 'border-color: {{VALUE}};',
                        ],
        
                    ]
                );
        
        
                $this->add_control(
                    'kivicare_iconbox_icon_hover_border_width',
                    [
                        'label' => esc_html__('Border Width', 'iqonic'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'condition' => ['kivicare_iconbox_hover_has_border' => ['yes']],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
        
                    ]
                );
        
                $this->add_control(
                    'kivicare_iconbox_icon_hover_border_radius',
                    [
                        'label' => esc_html__('Border Radius', 'iqonic'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'condition' => ['kivicare_iconbox_hover_has_border' => ['yes']],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
        
                    ]
                );
        
                $this->end_controls_tab();
                $this->end_controls_tabs();
        
        
                $this->add_responsive_control(
                    'icon_width',
                    [
                        'label' => esc_html__('Width', 'iqonic'),
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
                            '{{WRAPPER}} .kivicare-tabs .tab-image img' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );
        
                $this->add_responsive_control(
                    'icon_height',
                    [
                        'label' => esc_html__('Height', 'iqonic'),
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
                            '{{WRAPPER}} {{WRAPPER}} .kivicare-tabs .tab-image img' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );
        
        
                $this->add_responsive_control(
                    'kivicare_iconbox_icon_padding',
                    [
                        'label' => esc_html__('Padding', 'iqonic'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
        
                    ]
                );
        
                $this->add_responsive_control(
                    'kivicare_iconbox_icon_margin',
                    [
                        'label' => esc_html__('Margin', 'iqonic'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .kivicare-tabs .tab-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
        
                    ]
                );
        
        
                $this->end_controls_section();
        
                /* Icon Box  icon*/
        /*Icon Box start*/

        $this->start_controls_section(
            'section_NELc08X86U438J8ZmnxQ',
            [
                'label' => esc_html__('Tab Content', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('Iconbox_tabs');
        $this->start_controls_tab(
            'tabs_jefOdwB60gC8bAl3exvb',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_iconbox_background',
                'label' => esc_html__('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-tabs .tab-details',
            ]
        );

        $this->add_control(
            'kivicare_iconbox_block_has_border',
            [
                'label' => esc_html__('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'kivicare_iconbox_border_style',
            [
                'label' => esc_html__('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['kivicare_iconbox_block_has_border' => ['yes']],
                'default' => 'none',
                'options' => [
                    'solid'  => esc_html__('Solid', 'iqonic'),
                    'dashed' => esc_html__('Dashed', 'iqonic'),
                    'dotted' => esc_html__('Dotted', 'iqonic'),
                    'double' => esc_html__('Double', 'iqonic'),
                    'outset' => esc_html__('outset', 'iqonic'),
                    'groove' => esc_html__('groove', 'iqonic'),
                    'ridge' => esc_html__('ridge', 'iqonic'),
                    'inset' => esc_html__('inset', 'iqonic'),
                    'hidden' => esc_html__('hidden', 'iqonic'),
                    'none' => esc_html__('none', 'iqonic'),

                ],

                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'kivicare_iconbox_border_color',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['kivicare_iconbox_block_has_border' => ['yes']],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details' => 'border-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_iconbox_border_width',
            [
                'label' => esc_html__('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['kivicare_iconbox_block_has_border' => ['yes']],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_iconbox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['kivicare_iconbox_block_has_border' => ['yes']],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_iconbox_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .tab-details',
            ]
        );

        $this->add_responsive_control(
            'kivicare_iconbox_outer_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_iconbox_outer_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_YKc3bWU0OyR6287gk966',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'section_COl8v62c',
            [
                'label' => esc_html__('Outer Hover Background ', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_iconbox_hover_background',
                'label' => esc_html__('Hover Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-tabs .tab-details:hover',
            ]
        );

        $this->add_control(
            'kivicare_iconbox_outer_block_has_border',
            [
                'label' => esc_html__('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'kivicare_outer_iconbox_border_style',
            [
                'label' => esc_html__('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['kivicare_iconbox_outer_block_has_border' => ['yes']],
                'default' => 'none',
                'options' => [
                    'solid'  => esc_html__('Solid', 'iqonic'),
                    'dashed' => esc_html__('Dashed', 'iqonic'),
                    'dotted' => esc_html__('Dotted', 'iqonic'),
                    'double' => esc_html__('Double', 'iqonic'),
                    'outset' => esc_html__('outset', 'iqonic'),
                    'groove' => esc_html__('groove', 'iqonic'),
                    'ridge' => esc_html__('ridge', 'iqonic'),
                    'inset' => esc_html__('inset', 'iqonic'),
                    'hidden' => esc_html__('hidden', 'iqonic'),
                    'none' => esc_html__('none', 'iqonic'),

                ],

                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details:hover' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'kivicare_outer_iconbox_border_color',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['kivicare_iconbox_outer_block_has_border' => ['yes']],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details:hover' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'kivicare_outer_iconbox_border_width',
            [
                'label' => esc_html__('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['kivicare_iconbox_outer_block_has_border' => ['yes']],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_outer_iconbox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['kivicare_iconbox_outer_block_has_border' => ['yes']],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_iconbox_hover_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .tab-details:hover',
            ]
        );


        $this->add_responsive_control(
            'kivicare_iconbox_outer_hover_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_iconbox_outer_hover_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-tabs .tab-details:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_content_title_typography',
                'label' => esc_html__('Title Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .tab-details .tab-title-desc',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_content_desc_typography',
                'label' => esc_html__('Content Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-tabs .tab-details .tab-detail-desc',
            ]
        );
        

        $this->end_controls_section();

        /* Icon Box  End*/

        // Button Text Style
        $this->start_controls_section(
            'section_d1da6dnvYM43C71weL29',
            [
                'label' => esc_html__('Button Text Color', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );

        $this->start_controls_tabs('contact_tabs');
        $this->start_controls_tab(
            'tabs_o8I22AKRc2bJa7BgdwHW',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Choose Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-button,{{WRAPPER}} .kivicare-button span.text-btn ' => 'color: {{VALUE}};',
                ],


            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_1322c8M564ER8L6I65U0',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'data_hover_text',
            [
                'label' => esc_html__('Choose Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .kivicare-button:hover , {{WRAPPER}} .kivicare-button:hover span.text-btn' => 'color: {{VALUE}};',
                ],

            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_text_typography',
                'label' => esc_html__('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-button , {{WRAPPER}} .kivicare-button span.text-btn',
            ]
        );

        $this->end_controls_section();
        // Button Text Style

        // Background Style Start

        $this->start_controls_section(
            'section_0s6Y4c68qoBcctzHf68f',
            [
                'label' => esc_html__('Button Background', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );
        $this->start_controls_tabs('_dr6Yu5af63L5yHm3cGc1');
        $this->start_controls_tab(
            'tabs_z5VRHMPjDcr6wJb0a4vF',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'data_background',
                'label' => esc_html__('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-button ',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_Xa27O3BGf5k23KqHfeNM',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'data_hover',
                'label' => esc_html__('Background', 'iqonic'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .kivicare-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        // Box shadow Style Start

        $this->start_controls_section(
            'section_0s6Y4cctzHf68f',
            [
                'label' => esc_html__('Button Box Shadow', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['has_box_shadow' => 'block']

            ]
        );
        $this->start_controls_tabs('_dr6Yu5a5yHm3cGc1');
        $this->start_controls_tab(
            'tabs_z5VRHjDcr6w4vF',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_icon_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-button,{{WRAPPER}} a.kivicare-button',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_Xa27O3BG23KqHfeNM',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_iconhoverbox_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-button:hover,{{WRAPPER}} a.kivicare-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // Border Style Start
        $this->start_controls_section(
            'section_iD8bVLQc8q83f4j5cnJk',
            [
                'label' => esc_html__('Button Border', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );
        $this->add_control(
            'has_custom_border',
            [
                'label' => esc_html__('Use Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );
        $this->add_control(
            'data_border',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-button' => 'border-color: {{VALUE}};',
                ],
                'condition' => ['has_custom_border' => 'yes'],

            ]
        );
        $this->add_control(
            'data_hover_border_outline',
            [
                'label' => esc_html__('Hover Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .kivicare-button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => ['has_custom_border' => 'yes'],

            ]
        );


        $this->add_control(
            'border_style',
            [
                'label' => esc_html__('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'solid' => esc_html__('Solid', 'iqonic'),
                    'dashed' => esc_html__('Dashed', 'iqonic'),
                    'dotted' => esc_html__('Dotted', 'iqonic'),
                    'double' => esc_html__('Double', 'iqonic'),
                    'outset' => esc_html__('outset', 'iqonic'),
                    'groove' => esc_html__('groove', 'iqonic'),
                    'ridge' => esc_html__('ridge', 'iqonic'),
                    'inset' => esc_html__('inset', 'iqonic'),
                    'hidden' => esc_html__('hidden', 'iqonic'),
                    'none' => esc_html__('none', 'iqonic'),

                ],
                'condition' => ['has_custom_border' => 'yes'],

                'selectors' => [
                    '{{WRAPPER}} .kivicare-button' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['has_custom_border' => 'yes'],

            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-button ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['has_custom_border' => 'yes'],

            ]
        );
        $this->end_controls_section();
        // Border Style Start

        // Icon Style Start
        $this->start_controls_section(
            'section_qfCKlSw4To1FsPY6B33a',
            [
                'label' => esc_html__('Icon', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['has_icon' => 'yes']

            ]
        );

        $this->start_controls_tabs('_daer6Yu5a5yHm3cGc1');
        $this->start_controls_tab(
            'tabs_Xa27G2rfKqHfeNM',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'icon_text_color1',
            [
                'label' => esc_html__('Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-button span.main,{{WRAPPER}} .kivicare-button.kivicare-blog-link span.main' => 'background: {{VALUE}};',
                ]
        
            ]
        );
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'tabs_Xa27O323KtfdeNM',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'icon_text_color_hover',
            [
                'label' => esc_html__('Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-button.kivicare-blog-link:hover span.main,{{WRAPPER}} .kivicare-button:hover span.main' => 'background: {{VALUE}};',
                ]
        
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'section_cf6i4c8e7lf4ocrcLUGa',
            [
                'label' => esc_html__('Icon/Image', 'iqonic'),
            ]
        );

        $this->add_control(
            'media_style',
            [
                'label'      => esc_html__('Icon / Image', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'none',
                'options'    => [
                    'icon'          => esc_html__('Icon', 'iqonic'),
                    'image'          => esc_html__('Image', 'iqonic'),
                    'none'          => esc_html__('None', 'iqonic'),
                ],
            ]
        );
        $this->add_control(
            'position',
            [
                'label' => esc_html__('Position', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'iqonic'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'left' => [
                        'title' => esc_html__('Left', 'iqonic'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'condition' => [
                    'media_style!' => 'none',
                ],
                'prefix_class' => 'image-position-'
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'condition' => [
                    'media_style' => 'icon',
                ],
                'default' => [
                    'value' => 'fas fa-star'

                ],
                'skin' => 'inline',
                'label_block' => false,
                'show_label' => true
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'iqonic'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'media_style' => 'image',
                ],
                'default' => [
                    'url' => IQONIC_EXTENSION_PLUGIN_URL . 'includes/Elementor/assets/img/grap.png',
                ],

            ]
        );
        $this->end_controls_section();
        // Container Style Section End
        


    }

    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Tab/render.php';
    }
}
