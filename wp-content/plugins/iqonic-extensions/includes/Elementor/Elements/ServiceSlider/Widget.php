<?php

namespace Iqonic\Elementor\Elements\ServiceSlider;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_service_slider';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Service Slider', 'iqonic');
    }
    
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-icon-box';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_NELc08X86U438J8ZmnxQ',
            [
                'label' => esc_html__('Service Box', 'iqonic'),
            ]
        );

        $this->add_control(
			'service_style',
			[
				'label'      => __('Select Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1'          => __('Style 1', 'iqonic'),
					'2'          => __('Style 2', 'iqonic'),
				],
			]
		);

        $this->add_control(
            'iqonic_show_content',
            [
                'label'   => esc_html__('Show Content?', 'iqonic'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'yes'     => esc_html__('yes', 'iqonic'),
                'no'      => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'dis_number',
            [
                'label'         => esc_html__('Posts Per Page', 'iqonic'),
                'type'          => Controls_Manager::TEXT,
                'default'       => '-1',
                'dynamic'       => [
                    'active'    => true,
                ],
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'order',
            [
                'label'    => esc_html__('Order By', 'iqonic'),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'ASC',
                'options'  => [
                    'DESC' => esc_html__('Descending', 'iqonic'),
                    'ASC'  => esc_html__('Ascending', 'iqonic')
                ],
            ]
        );
       
        $this->add_control(
            'title_tag',
            [
                'label'      => esc_html__('Title Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h4',
                'options'    => [
                    'h1'          => esc_html__('h1', 'iqonic'),
                    'h2'          => esc_html__('h2', 'iqonic'),
                    'h3'          => esc_html__('h3', 'iqonic'),
                    'h4'          => esc_html__('h4', 'iqonic'),
                    'h5'          => esc_html__('h5', 'iqonic'),
                    'h6'          => esc_html__('h6', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'iqonic_select_services',
            [
                'label' => esc_html__('Select Services', 'iqonic'),
                'type' => Controls_Manager::SELECT2,
                'return_value' => 'true',
                'multiple' => true,
                'options' => iqonic_get_post('service'),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'service_img_background',
				'label' => esc_html__('Pattern Image', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .swiper-slide.iq-service-slide::before',
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_swiper_control',
            [
                'label' => esc_html__('Slider Control', 'iqonic'),
                'condition' => [ 'service_style' => '1' ],
            ]
        );

        $this->add_control(
            'sw_loop',
            [
                'label' => esc_html__('Loop', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'true',
                'options' => [
                    'true'  => esc_html__('True', 'iqonic'),
                    'false' => esc_html__('False', 'iqonic'),
                ],
            ]
        );
        
        $this->add_control(
            'want_pagination',
            [
                'label' => esc_html__('Show Pagination ?', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true'  => esc_html__('True', 'iqonic'),
                    'false' => esc_html__('False', 'iqonic'),
                ],
            ]
        );
        
        $this->add_control(
            'want_nav',
            [
                'label' => esc_html__('Show Navigation ?', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true'  => esc_html__('True', 'iqonic'),
                    'false' => esc_html__('False', 'iqonic'),
                ],
            ]
        );
        
        $this->add_control(
            'centered_slides',
            [
                'label' => esc_html__('Centered Slides ?', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'true'  => esc_html__('True', 'iqonic'),
                    'false' => esc_html__('False', 'iqonic'),
                ],
                'default' => 'false',
            ]
        );
        
        $this->add_control(
            'sw_enable_autoplay',
            [
                'label' => esc_html__('Enable Auto Play', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'yes' => esc_html__('True','iqonic'),
                    'no' => esc_html__('False','iqonic'),
                ],
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'sw_autoplay',
            [
                'label' => esc_html__('Auto Play Delay', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10000,
                'step' => 1000,
                'default' => 4000,
                'condition' => [
                    'sw_enable_autoplay' => 'yes',
                ]
            ]
        );
        
        $this->add_control(
            'sw_slide',
            [
                'label' => esc_html__('Slide Per Page', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 3,
            ]
        );
        
        $this->add_control(
            'sw_laptop_no',
            [
                'label' => esc_html__('Laptop View', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 2,
            ]
        );
        
        $this->add_control(
            'sw_tab_no',
            [
                'label' => esc_html__('Tablet View', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1,
            ]
        );
        
        $this->add_control(
            'sw_mob_no',
            [
                'label' => esc_html__('Mobile View', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1,
            ]
        );
        
        $this->add_control(
            'sw_speed',
            [
                'label' => esc_html__('Speed', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 1,
                'default' => 1000,
            ]
        );
        
        $this->add_control(
            'sw_space_slide',
            [
                'label' => esc_html__('Space Between Slide', 'iqonic'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 40,
            ]
        );
        
        $this->start_controls_tabs(
            'style_swiper_tabs'
        );
        
        $this->start_controls_tab(
            'style_swiper_normal_tab',
            [
                'label' => esc_html__('Normal', 'iqonic'),
                'condition' => [
                    'want_nav' => 'true',
                ],
            ]
        );
        
        $this->add_control(
            'navigation_normal_color',
            [
                'label' => esc_html__('Navigation Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:after
                    ,{{WRAPPER}} .swiper-button-prev:after' => 'color:{{VALUE}};'
                ],
            ]
        );
        
        
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_swiper_hover_tab',
            [
                'label' => esc_html__('Hover', 'iqonic'),
                'condition' => [
                    'want_nav' => 'true',
                    
                ],
            ]
        );
        
        $this->add_control(
            'navigation_hover_color',
            [
                'label' => esc_html__('Navigation Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev:hover .text-btn, {{WRAPPER}} .swiper-button-next:hover .text-btn,{{WRAPPER}} .swiper-button-next:hover,{{WRAPPER}} .swiper-button-prev:hover' => 'color:{{VALUE}};'
                ],
            ]
        );
        
        
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        

        $this->end_controls_section();




        $this->start_controls_section(
            'section_service_box',
            [
                'label' => esc_html__('Service Box', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('service_tabs');
        $this->start_controls_tab(
            'service_box_bg_normal',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'service_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .iq-service-slide',

            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'service_box_bg_hover',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'service_hover_back_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .iq-service-slide:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'service_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .iq-service-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iq-service-slide' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iq-service-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_service_box_icon',
            [
                'label' => esc_html__('Icon', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('service_icon_tabs');
        $this->start_controls_tab(
            'service_box_icon_normal',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'section_icon_color',
            [
                'label'    => esc_html__('Color','iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors'=> ['{{WRAPPER}} .iq-service-slide svg path'=>'fill : {{VALUE}}' ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'service_box_icon_hover',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'section_icon_color_hover',
            [
                'label'    => esc_html__('Color','iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors'=> ['{{WRAPPER}} .iq-service-slide:hover svg path'=>'fill : {{VALUE}}' ]
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
                        'max' => 500,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .iq-service-slide svg , 
                    {{WRAPPER}} .iq-service-slide img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_icon_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iq-service-slide svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_icon_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iq-service-slide svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'service_title',
            [
                'label'    => esc_html__('Title','iqonic'),
                'tab'      => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .service-content .iq-heading-title',
			]
		);

        $this->start_controls_tabs('service_title_tabs');
        $this->start_controls_tab(
            'service_title_normal',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'section_title_color',
            [
                'label'    => esc_html__('Color','iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors'=> ['{{WRAPPER}} .iq-service-slide .service-content .iq-heading-title'=>'color : {{VALUE}}']
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'service_title_hover',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'section_title_color_hover',
            [
                'label'    => esc_html__('Color','iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors'=> ['{{WRAPPER}} .iq-service-slide:hover .service-content .iq-heading-title'=>'color : {{VALUE}}']
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .service-content .iq-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .service-content .iq-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content',
            [
               'label'    => esc_html__('Content','iqonic'),
               'tab'      => Controls_Manager::TAB_STYLE,
               'condition' => [
                'iqonic_show_content' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
           Group_Control_Typography::get_type(),
           [
               'name' => 'content_typography',
               'label' => esc_html__( 'Typography', 'plugin-domain' ),
               'selector' => '{{WRAPPER}} .service-content .iq-service-desc',
           ]
       );

       $this->start_controls_tabs(
            'tab_content'
        );

    $this->start_controls_tab(
        'section_normal_tab_content',
        [
            'label'    => esc_html__('Normal','iqonic')
        ]
    );

    $this->add_control(
        'content-color',
        [
            'label'    => esc_html__('Color','iqonic'),
            'type'     => Controls_Manager::COLOR,
            'selectors'=> ['{{WRAPPER}} .service-content .iq-service-desc'=>'color:{{VALUE}}']
        ]
    );
    
        $this->end_controls_tab();
        $this->start_controls_tab(
        'section_hover_tab_content',
        [
            'label'    => esc_html__('Hover','iqonic')
        ]
        );

        $this->add_control(
            'content-color-hover',
            [
                'label'    => esc_html__('Color','iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors'=> ['
                {{WRAPPER}} .iq-service-slide:hover .service-content .iq-service-desc'=>'color:{{VALUE}}']
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
                    '{{WRAPPER}} .service-content .iq-service-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .service-content .iq-service-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    
        require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_btn_controls.php';
    }

    protected function render()
    {
         require 'render.php';
        if (Plugin::$instance->editor->is_edit_mode()) {  ?>
            <script>
                (function(jQuery) {
                    callSwiper();
                    Servicesliderslider();
                })(jQuery);
            </script>  <?php
        }
    }
}