<?php

namespace Iqonic\Elementor\Elements\PricingPlan;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic-pricing-plan';
    }

    public function get_title()
    {
        return __('Iqonic Price', 'iqonic');
    }

    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-price-table';
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section',
            [
                'label' => __('Pricing Plan', 'iqonic'),
            ]
        );

        $this->add_control(
            'pricing_style',
            [
                'label' => __('Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => __('Style 1', 'iqonic'),
                    '2' => __('Style 2', 'iqonic'),
                ],
                'default'    => '1',
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => __('Price', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10', 'iqonic'),
            ]
        );

        $this->add_control(
            'price_title',
            [
                'label' => __('Price Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Title', 'iqonic'),
            ]
        );

        $this->add_control(
            'services_title',
            [
                'label' => __('Services Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Services', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_period',
            [
                'label' => __('Time Period', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('/month', 'iqonic'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'iqonic'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter Description', 'iqonic'),
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label' => __('Currency Symbol', 'iqonic'),
                'type' => Controls_Manager::SELECT2,
                'options' => iqonic_currency(),
            ]
        );

        $this->add_control(
            'active',
            [
                'label' => __('Is Active?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'label_off',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'has_price_shadow',
            [
                'label' => __('Use Box Shadow', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'label_off',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
			'image',
			[
				'label' => __('Choose Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $repeater = new Repeater();
        $repeater->add_control(
            'tab_title',
            [
                'label' => __('Plan info List', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Service Item', 'iqonic'),
                'placeholder' => __('Service Item', 'iqonic'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'has_service_active',
            [
                'label' => __('Active?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'label_off',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );
        $repeater->add_control(
            'has_service_icon',
            [
                'label' => __('Use Icon?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'label_off',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $repeater->add_control(
            'service_icon',
            [
                'label' => __('Service Icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star'

                ],
                'condition' => [
                    'has_service_icon' => 'yes',
                ],
                'label_block' => false,
                'skin' => 'inline',


            ]
        );


        $this->add_control(
            'tabs',
            [
                'label' => __('List Items', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __('Service Item', 'iqonic'),


                    ]

                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );
        $this->add_control(
            'title_tag',
            [
                'label'      => __('Title Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h4',
                'options'    => [

                    'h1'          => __('h1', 'iqonic'),
                    'h2'          => __('h2', 'iqonic'),
                    'h3'          => __('h3', 'iqonic'),
                    'h4'          => __('h4', 'iqonic'),
                    'h5'          => __('h5', 'iqonic'),
                    'h6'          => __('h6', 'iqonic'),


                ],
            ]
        );
        $this->add_control(
            'price_tag',
            [
                'label'      => __('Price Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h4',
                'options'    => [

                    'h1'          => __('h1', 'iqonic'),
                    'h2'          => __('h2', 'iqonic'),
                    'h3'          => __('h3', 'iqonic'),
                    'h4'          => __('h4', 'iqonic'),
                    'h5'          => __('h5', 'iqonic'),
                    'h6'          => __('h6', 'iqonic'),


                ],
            ]
        );
        $this->add_control(
            'services_title_tag',
            [
                'label'      => __('Services Title Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h4',
                'options'    => [

                    'h1'          => __('h1', 'iqonic'),
                    'h2'          => __('h2', 'iqonic'),
                    'h3'          => __('h3', 'iqonic'),
                    'h4'          => __('h4', 'iqonic'),
                    'h5'          => __('h5', 'iqonic'),
                    'h6'          => __('h6', 'iqonic'),


                ],
            ]
        );

        $this->add_control(
            'iqonic_has_box_shadow',
            [
                'label' => __('Box Shadow?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'text-left' => [
                        'title' => __('Left', 'iqonic'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'text-center' => [
                        'title' => __('Center', 'iqonic'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'text-right' => [
                        'title' => __('Right', 'iqonic'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ]
            ]
        );


        $this->end_controls_section();

        /*Button Start*/
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
        /*Button End*/

        /* Price Table Start*/

        $this->start_controls_section(
            'section_fyWdp0abeSvr3Mi44LVm',
            [
                'label' => __('Price Table', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('price_table_tabs');
        $this->start_controls_tab(
            'tabs_yL0o668ZXM4g9zsUSjCi',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'section_vl8vK4162c',
            [
                'label' => __('Outer Background ', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_table_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-inner-box',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_f1pW85xe0693t0fKBV1Y',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'section_COl862c',
            [
                'label' => __('Outer Hover Background ', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_table_hover_background',
                'label' => __('Hover Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-inner-box:hover',
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'price_table_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-inner-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_table_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-inner-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();

        /* Price table End*/



        /* Price Header Start*/

        $this->start_controls_section(
            'section_K570f6fbXo53dcT4m2eN',
            [
                'label' => __('Price Header', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        /*currency Start*/
        $this->add_control(
            'section_mX28erE332RbyLve03nU',
            [
                'label' => __('Currency', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_currency_text_typography',
                'label' => __('Currency Typography', 'iqonic'),
                'selector' => '{{WRAPPER}}  .kivicare-price-header .kivicare-price small:first-child	',
            ]
        );

        $this->start_controls_tabs('price_currency_tabs');
        $this->start_controls_tab(
            'tabs_Lfkb48DXYs0eBP93241E',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_currency_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-header .kivicare-price small:first-child' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_fmjB3Off9KF4v53WZ8Xh',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_currency_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-header .kivicare-price small:first-child,
					 {{WRAPPER}} .kivicare-price-container.active .kivicare-price-header .kivicare-price small:first-child' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'price_currency_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price small:first-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_currency_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price small:first-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        /*Currency End*/

        /*Price Start*/

        $this->add_control(
            'section_YxSwfrRT69442fI6mbCp',
            [
                'label' => __('Price', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_text_typography',
                'label' => __('Price Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-inner-box .kivicare-price .price',
            ]
        );

        $this->start_controls_tabs('price_text_tabs');
        $this->start_controls_tab(
            'tabs_FqDe9pYKt6UXJnGh82d2',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_text_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-inner-box .kivicare-price .price' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_B2b426p9P3hRJ8sxrUTO',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_text_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-inner-box:hover .kivicare-price .price,
                     {{WRAPPER}} .kivicare-inner-box:active .kivicare-price .price' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'price_text_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_text_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        /*Price End*/

        /*Duration Start*/

        $this->add_control(
            'section_60rHB44IC3AdVSnFPgj7',
            [
                'label' => __('Duration', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_duration_text_typography',
                'label' => __('Duration Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-price-header .kivicare-price-desc,{{WRAPPER}}  .kivicare-price-header .kivicare-price small ',
            ]
        );

        $this->start_controls_tabs('price_duration_tabs');
        $this->start_controls_tab(
            'tabs_c5Qbq8WLv6d5307l0Uu3',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_duration_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-header .kivicare-price-desc,{{WRAPPER}}  .kivicare-price-header .kivicare-price small ' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_3A639G6mPd309Rl889Yy',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_duration_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-header .kivicare-price-desc,
					 {{WRAPPER}} .kivicare-price-container:hover  .kivicare-price-header .kivicare-price small,
					 {{WRAPPER}} .kivicare-price-container.active .kivicare-price-header .kivicare-price-desc,
					 {{WRAPPER}} .kivicare-price-container.active  .kivicare-price-header .kivicare-price small ' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'price_duration_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price-desc,{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price small' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_duration_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price-desc,{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price small' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        /*Duration End*/

        /*Title Start*/

        $this->add_control(
            'section_TnSdjH5Zb7wEm8sxQVuG',
            [
                'label' => __('Title', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_title_text_typography',
                'label' => __('Title Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-price-header .kivicare-price-title',
            ]
        );



        $this->start_controls_tabs('price_title_tabs');
        $this->start_controls_tab(
            'tabs_09OPJST046UeIAYb1Kba',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_title_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-header .kivicare-price-title' => 'color: {{VALUE}};',
                ],

            ]

        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_cT0eg16qd070xv7muc2b',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_title_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container:hover .kivicare-price-header .kivicare-price-title,
					 {{WRAPPER}}  .kivicare-price-container.active .kivicare-price-header .kivicare-price-title' => 'color: {{VALUE}};',
                ],

            ]

        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'price_title_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_title_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        /*Title End*/


        /*Sub Title Start*/


        $this->add_control(
            'section_cxKaO95c5CZW4Nz3w36M',
            [
                'label' => __('Subtitle', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_subtitle_text_typography',
                'label' => __('Subtitle Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-price-header .kivicare-price-description ',
            ]
        );

        $this->start_controls_tabs('price_subtitle_tabs');
        $this->start_controls_tab(
            'tabs_Fu3Wm8nztYqbbkbpSc6J',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_subtitle_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-header .kivicare-price-description ' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_rXQ60813pl6Rn3B1Sx9d',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_subtitle_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-header .kivicare-price-description ,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-header .kivicare-price-description ' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'price_subtitle_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_subtitle_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header .kivicare-price-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        /*Sub Title End*/

        /*Header Backgrund Start*/

        $this->add_control(
            'section_O75inm3q9CVk7962gh96',
            [
                'label' => __('Pricing Header Background', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('price_header_tabs');
        $this->start_controls_tab(
            'tabs_5D6V6NS96w3QI6bdMU23',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_header_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-price-container .kivicare-price-header',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_rH655IP80scfKQz9Wnq6',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_header_hover_background',
                'label' => __('Hover Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-header,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-header',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'price_header_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_header_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_section();

        /* Price Header End*/

        /* Price Body Start*/

        $this->start_controls_section(
            'section_Odd5qY6t9Lnb095371uS',
            [
                'label' => __('Price Body', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        /*Body End*/

        /*Pricing List Start*/

        $this->add_control(
            'section_95xiZHF76mKJ1bE9dS6u',
            [
                'label' => __('Pricing list', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'priceing_list_text_typography',
                'label' => __('Pricing List Content Typography', 'iqonic'),
                'selector' => '
                    {{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li, 
                    {{WRAPPER}} .kivicare-price-container .kivicare-price-body ul > li > span, 
                    {{WRAPPER}} .kivicare-price-container .kivicare-price-body ul > li > svg ',
            ]
        );

        $this->start_controls_tabs('priceing_list_tabs');
        $this->start_controls_tab(
            'tabs_jwryR96oG27O78J6HT8b',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );
        $this->add_control(
            'priceing_list_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li' => 'color: {{VALUE}};',
                ],

            ]

        );

        $this->add_control(
            'priceing_active_list_color',
            [
                'label' => __('Active Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-body ul li.active i' => 'color: {{VALUE}};',
                ],

            ]

        );

        $this->add_control(
            'priceing_inactive_list_color',
            [
                'label' => __('Inactive Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li.inactive i' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'priceing_list_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li',
            ]
        );

        $this->add_control(
            'priceing_list_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'priceing_list_border_style',
            [
                'label' => __('Pricing List Border Style', 'iqonic'),
                'condition' => [
                    'priceing_list_has_border' => 'yes',
                ],
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

                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'priceing_list_border_color',
            [
                'label' => __('Pricing List Border Color', 'iqonic'),
                'condition' => [
                    'priceing_list_has_border' => 'yes',
                ],
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'priceing_list_border_width',
            [
                'label' => __('Pricing List Border Width', 'iqonic'),
                'condition' => [
                    'priceing_list_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'priceing_list_border_radius',
            [
                'label' => __('Pricing List Border Radius', 'iqonic'),
                'condition' => [
                    'priceing_list_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-body ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_85j6g91EM579Gcdx6T6b',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'priceing_list_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    ' 
                    {{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li' => 'color: {{VALUE}};',
                ],

            ]

        );

        $this->add_control(
            'priceing_active_list_hover_color',
            [
                'label' => __('Active Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '
                    {{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li.active i' => 'color: {{VALUE}};',
                ],

            ]

        );

        $this->add_control(
            'priceing_inactive_list_hover_color',
            [
                'label' => __('Inactive Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '
                    {{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li.inactive i' => 'color: {{VALUE}};',
                ],

            ]

        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'priceing_list_hover_background',
                'label' => __('Hover Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-body ul li',
            ]
        );
        $this->add_control(
            'priceing_list_hover_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );
        $this->add_control(
            'priceing_list_hover_border_style',
            [
                'label' => __('Pricing List Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'priceing_list_hover_has_border' => 'yes',
                ],
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
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-body ul li' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'priceing_list_hover_border_color',
            [
                'label' => __('Pricing List Border Color', 'iqonic'),
                'condition' => [
                    'priceing_list_hover_has_border' => 'yes',
                ],
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-body ul li' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'priceing_list_hover_border_width',
            [
                'label' => __('Pricing List Border Width', 'iqonic'),
                'condition' => [
                    'priceing_list_hover_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-body ul li' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'priceing_list_hover_border_radius',
            [
                'label' => __('Pricing List Border Radius', 'iqonic'),
                'condition' => [
                    'priceing_list_hover_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-body ul li,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-body ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'priceing_list_padding',
            [
                'label' => __('Pricing List Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-body ul li ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'priceing_list_margin',
            [
                'label' => __('Pricing List Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-body ul li ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );


        $this->end_controls_section();

        /* Price Body End*/

        /* Price footer Start End*/

        $this->start_controls_section(
            'section_fx9Nm3Z6LD6P50r9TFY8',
            [
                'label' => __('Price Footer', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('price_footer_tabs');
        $this->start_controls_tab(
            'tabs_7SsC2Xby38hDba3850rm',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_footer_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-price-container .kivicare-price-footer',
            ]
        );

        $this->add_control(
            'price_footer_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'price_footer_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'price_footer_has_border' => 'yes',
                ],
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
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-footer' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'price_footer_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'price_footer_has_border' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-footer' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'price_footer_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'price_footer_has_border' => 'yes',
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-footer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'price_footer_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'price_footer_has_border' => 'yes',
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container .kivicare-price-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_z67bhXB90O5P0cibF3U1',
            [
                'label' => __('Active', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_footer_hover_background',
                'label' => __('Hover Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-footer,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-footer',
            ]
        );
        $this->add_control(
            'price_footer_hover_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );
        $this->add_control(
            'price_footer_hover_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'condition' => [
                    'price_footer_hover_has_border' => 'yes',
                ],
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

                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-footer,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-footer' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'price_footer_hover_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'price_footer_hover_has_border' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-footer,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-footer' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'price_footer_hover_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'price_footer_hover_has_border' => 'yes',
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-footer,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-footer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'price_footer_hover_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'price_footer_hover_has_border' => 'yes',
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-price-container:hover .kivicare-price-footer,{{WRAPPER}} .kivicare-price-container.active .kivicare-price-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();



        $this->add_responsive_control(
            'price_footer_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'price_footer_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-price-container .kivicare-price-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );


        $this->end_controls_section();

        /* Price Footer End*/
    }

    protected function render()
    {
        require 'render.php';
    }
}
