<?php

namespace Iqonic\Elementor\Elements\ImageBox;

use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_imageBox';
    }

    public function get_title()
    {
        return __('Iqonic Image Box', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-image-box';
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image Box', 'iqonic'),
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

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => __('Title & Description', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('This is the heading', 'iqonic'),
                'placeholder' => __('Enter your title', 'iqonic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => __('Content', 'iqonic'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'iqonic'),
                'placeholder' => __('Enter your description', 'iqonic'),
                'separator' => 'none',
                'rows' => 10,
                'show_label' => false,
            ]
        );


        $this->add_control(
            'image_has_link',
            [
                'label' => __('Use Link', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );


        $this->add_control(
            'imagebox_link_type',
            [
                'label' => __('Link Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [
                    'dynamic' => __('Dynamic', 'iqonic'),
                    'custom' => __('Custom', 'iqonic'),
                ],
                'condition' => ['image_has_link' => 'yes']
            ]
        );

        $this->add_control(
            'select_post_type',
            [
                'label' => __('Select post type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'page',
                'options' => [
                    'page' => __('page', 'iqonic'),
                    'team' => __('team', 'iqonic'),
                    'post' => __('post', 'iqonic'),
                    'product' => __('product', 'iqonic'),
                ],
                'condition' => [
                    'imagebox_link_type' => 'dynamic',
                    'image_has_link' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'imagebox_dynamic_link',
            [
                'label' => esc_html__('Select Page', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'imagebox_link_type' => 'dynamic',
                    'image_has_link' => 'yes',
                    'select_post_type' => 'page',
                ],
                'options' => iqonic_get_posts("page"),
            ]
        );

        $this->add_control(
            'imagebox_product_link',
            [
                'label' => esc_html__('Select product', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'imagebox_link_type' => 'dynamic',
                    'image_has_link' => 'yes',
                    'select_post_type' => 'product',
                ],
                'options' => iqonic_get_posts("product"),
            ]
        );

        $this->add_control(
            'imagebox_team_link',
            [
                'label' => esc_html__('Select team', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'imagebox_link_type' => 'dynamic',
                    'image_has_link' => 'yes',
                    'select_post_type' => 'team',
                ],
                'options' => iqonic_get_posts("team"),
            ]
        );

        $this->add_control(
            'imagebox_post_link',
            [
                'label' => esc_html__('Select post', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'imagebox_link_type' => 'dynamic',
                    'image_has_link' => 'yes',
                    'select_post_type' => 'post',
                ],
                'options' => iqonic_get_posts("post"),
            ]
        );

        $this->add_control(
            'is_new_tab',
            [
                'label' => __('Open in new tab?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'condition' => [
                    'imagebox_link_type' => 'dynamic',
                    'image_has_link' => 'yes',
                ],
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'image_box_link',
            [
                'label' => __('Link', 'iqonic'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'iqonic'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => ['image_has_link' => 'yes', 'imagebox_link_type' => 'custom']
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => __('Image Position', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'iqonic'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'top' => [
                        'title' => __('Top', 'iqonic'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => __('Right', 'iqonic'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label' => __('Title HTML Tag', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'use_image_scroll',
            [
                'label' => __('Use Image Scroll', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );


        $this->add_control(
            'view',
            [
                'label' => __('View', 'iqonic'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'iqonic'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label' => __('Spacing', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .scroll-img' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .scroll-img' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .scroll-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .scroll-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => __('Width', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box .kivicare-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size_height',
            [
                'label' => __('Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'condition' => ['use_image_scroll' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box.hover-image-scroll .kivicare-image-box-img' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .kivicare-image-box.hover-image-scroll:hover .kivicare-image-box-img img' => 'transform: translateY(calc(-100% + {{SIZE}}{{UNIT}}));',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'imagebox_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-image-box .kivicare-image-box-img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box .kivicare-image-box-img,{{WRAPPER}} .kivicare-image-box .kivicare-image-box-img img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'label' => __('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-image-box .kivicare-image-box-img a img',
            ]
        );
        $this->add_responsive_control(
            'image_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box .kivicare-image-box-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'iqonic'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab(
            'normal',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .scroll-img img',
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => __('Opacity', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .scroll-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => __('Transition Duration', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .scroll-img img, {{WRAPPER}} .kivicare-image-box-img img' => 'transition-duration: {{SIZE}}s',
                    '{{WRAPPER}} .scroll-img img' => 'animation-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover .scroll-img img',
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' => __('Opacity', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .scroll-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'iqonic'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __('Alignment', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'iqonic'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'iqonic'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'iqonic'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'iqonic'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'heading_title',
            [
                'label' => __('Title', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box-title, {{WRAPPER}} .kivicare-image-box-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .kivicare-image-box-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .kivicare-image-box-title',
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label' => __('Description', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .kivicare-image-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .kivicare-image-box-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'description_shadow',
                'selector' => '{{WRAPPER}} .kivicare-image-box-description',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        require 'render.php';
    }
}
