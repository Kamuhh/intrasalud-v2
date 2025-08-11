<?php

namespace Iqonic\Elementor\Elements\ServiceGrid;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;
use \Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_service_grid';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Service Grid', 'iqonic');
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
            'service_layout_style',
            [
                'label'      => __('Service style', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'style1',
                'options'    => [
                    'style1'     => __('style1', 'iqonic'),
                    'style2'     => __('style2', 'iqonic'),
                    'style3'     => __('style3', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'service_layout_option',
            [
                'label'      => __('Service Layout', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'dynamic',
                'options'    => [
                    'static'            => __('Static', 'iqonic'),
                    'dynamic'          => __('Dynamic', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'service_grid_style',
            [
                'label'      => esc_html__('Service Columns', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'options'    => [
                    'col-lg-12'      => esc_html__('One', 'iqonic'),
                    'col-lg-6 col-md-6'      => esc_html__('Two', 'iqonic'),
                    'col-lg-4 col-md-6'      => esc_html__('Three', 'iqonic'),
                    'col-lg-3 col-md-6'      => esc_html__('Four', 'iqonic'),
                ],
                'default'    => 'col-lg-4 col-md-6',
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

        $repeater = new Repeater();
        $repeater->add_control(
            'tab_title',
            [
                'label' => __('Enter Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('Title', 'iqonic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => __('Enter Description', 'iqonic'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter Description', 'iqonic'),
                'default' => __('Description.', 'iqonic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'media_style',
            [
                'label'      => esc_html__('Icon / Image', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'icon',
                'options'    => [
                    'icon'   => esc_html__('Icon', 'iqonic'),
                    'image'  => esc_html__('Image', 'iqonic'),
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label'           => esc_html__('Icon', 'iqonic'),
                'type'            => Controls_Manager::ICONS,
                'condition'       => [
                    'media_style' => 'icon',
                ],
                'default'         => [
                    'value'       => 'fas fa-star'
                ],
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label' => __('Choose Image', 'iqonic'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'condition'       => [
                    'media_style' => 'image',
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'iqonic_show_category',
            [
                'label'   => __('Show Category?', 'iqonic'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes'     => __('yes', 'iqonic'),
                'no'      => __('no', 'iqonic'),
            ]
        );

        $repeater->add_control(
            'tab_category',
            [
                'label' => __('Enter Category', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'iqonic_show_category' => 'yes',
                ],
                'default' => __('category', 'iqonic'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'tab_category_link',
            [
                'label' => __('Category Link', 'iqonic'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'iqonic'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'iqonic_show_category' => 'yes',
                ]
            ]
        );

        $repeater->add_control(
            'has_icon',
            [
                'label'   => __('Show icon?', 'iqonic'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes'     => __('yes', 'iqonic'),
                'no'      => __('no', 'iqonic'),
            ]
        );

        $repeater->add_control(
            'selected_icon_before',
            [
                'label'           => esc_html__('Icon', 'iqonic'),
                'type'            => Controls_Manager::ICONS,
                'condition'       => [
                    'has_icon' => 'yes',
                ],
                'default'         => [
                    'value'       => 'fas fa-star'
                ],
            ]
        );

        $repeater->add_control(
            'tab_link_type',
            [
                'label' => __('Link Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [
                    'dynamic' => __('Dynamic', 'iqonic'),
                    'custom' => __('Custom', 'iqonic'),
                ],
            ]
        );

        $repeater->add_control(
            'tab_dynamic_link',
            [
                'label' => esc_html__('Select Page', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'tab_link_type' => 'dynamic',
                ],
                'options' => iqonic_get_post("service"),
            ]
        );

        $repeater->add_control(
            'tab_link',
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
                'condition' => [
                    'tab_link_type' => 'custom',
                ]
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => __('Services List', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __(' Relationship Issues ', 'iqonic'),
                        'tab_content' => __('unde omnis iste natus error sit volupta accusant dolore rem aperiam.', 'iqonic'),
                        'tab_image' => '',
                        'tab_link_type' => 'custom',
                        'tab_link' => '#',
                    ],

                ],
                'condition' => [
                    'service_layout_option' => 'static',
                ],
                'title_field' => '{{{ tab_title }}}',
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
                'condition' => [
                    'service_layout_option' => 'dynamic',
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
            'iqonic_hover_effect',
            [
                'label'   => __('Show hover effect?', 'iqonic'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes'     => __('yes', 'iqonic'),
                'no'      => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'iqonic_icon_hover_effect',
            [
                'label'   => __('Show icon hover effect?', 'iqonic'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes'     => __('yes', 'iqonic'),
                'no'      => __('no', 'iqonic'),
            ]
        );

        $this->end_controls_section();

        /*Service Box start*/

        $this->start_controls_section(
            'section_NELc08X86U4tghy38J8ZmnxQ',
            [
                'label' => __('Service Select', 'iqonic'),
                'condition' => [
                    'service_layout_option' => 'dynamic',
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

        $this->end_controls_section();


        /*** Start Style Tab ***/


        $this->start_controls_section(
            'section_sdfdfxdfdxfc',
            [
                'label' => esc_html__('Service', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('service_tabs');
        $this->start_controls_tab(
            'tabs_qNU781zj1ck660yd2vn7',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'service_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-service .kivicare-service-blog,{{WRAPPER}} .kivicare-service-inner',

            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-service-blog',
            ]
        );

        $this->add_control(
            'service_has_border',
            [
                'label' => esc_html__('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'service_border_style',
            [
                'label' => esc_html__('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'service_has_border' => 'yes',
                ],
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
                    '{{WRAPPER}} .kivicare-service-blog ' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'service_border_color',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'service_has_border' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-service-blog ' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'service_border_width',
            [
                'label' => esc_html__('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'service_has_border' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-service-blog ' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'service_border_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'service_has_border' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-service-blog' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_rKkxfU2on94gt7b3FyCS',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'service_hover_back_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-service .kivicare-service-blog:hover, {{WRAPPER}} .kivicare-service-inner:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_hover_box_shadow',
                'label' => esc_html__('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-service-blog:hover',
            ]
        );

        $this->add_control(
            'service_hover_has_border',
            [
                'label' => esc_html__('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => esc_html__('yes', 'iqonic'),
                'no' => esc_html__('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'service_hover_border_style',
            [
                'label' => esc_html__('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'condition' => [
                    'service_hover_has_border' => 'yes',
                ],
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
                    '{{WRAPPER}}  .kivicare-service-blog:hover' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'service_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'service_hover_has_border' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-service-blog:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'service_hover_border_width',
            [
                'label' => esc_html__('Border Width', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'service_hover_has_border' => 'yes',
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-service-blog:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'service_hover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'service_hover_has_border' => 'yes',
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-service-blog:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                    '{{WRAPPER}}  .kivicare-service-blog' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}}  .kivicare-service-blog' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ujfvjh',
            [
                'label'    => esc_html__('Section Title', 'iqonic'),
                'tab'      => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .kivicare-service-blog .kivicare-heading-title',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-service-blog .kivicare-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .kivicare-service-blog .kivicare-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tab_gijgjh'
        );

        $this->add_control(
            'title-color',
            [
                'label'    => esc_html__('Color', 'iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .kivicare-service-blog .kivicare-heading-title' => 'color:{{VALUE}}']
            ]
        );

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_dfgbdfgbdfb',
            [
                'label'    => esc_html__('Section Content', 'iqonic'),
                'tab'      => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'iqonic_show_content' => 'yes', // This should match the return value exactly
                    'service_layout_option' => 'static',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .kivicare-service-blog .kivicare-description',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-service-blog .kivicare-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .kivicare-service-blog .kivicare-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tab_content'
        );

        $this->start_controls_tab(
            'section_normal_tab_content',
            [
                'label'    => esc_html__('Normal', 'iqonic')
            ]
        );

        $this->add_control(
            'content-color',
            [
                'label'    => esc_html__('Color', 'iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .kivicare-service-blog .kivicare-description' => 'color:{{VALUE}}']
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'section_hover_tab_content',
            [
                'label'    => esc_html__('Hover', 'iqonic')
            ]
        );

        $this->add_control(
            'content-color-hover',
            [
                'label'    => esc_html__('Color', 'iqonic'),
                'type'     => Controls_Manager::COLOR,
                'selectors' => ['
                {{WRAPPER}} .kivicare-service-blog .kivicare-description:hover p,
                {{WRAPPER}} .kivicare-service-style1 .kivicare-service-blog:hover .kivicare-service-info .kivicare-service-main-detail .kivicare-description,
                {{WRAPPER}} .kivicare-service-blog:hover .kivicare-service-info .kivicare-service-main-detail .kivicare-description' => 'color:{{VALUE}}']
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_btn_controls.php';

        $this->start_controls_section(
            'section_dthsficon_image',
            [
                'label'     => esc_html__('Icon/Image', 'iqonic'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'iq_servicebox_icon_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'default'    => '#7093e5',
                'selector' => '{{WRAPPER}} .kivicare-service-blog .kivicare-service-box-icon',

            ]
        );

        $this->start_controls_tabs('Service_icon_tabs');
        $this->start_controls_tab(
            'tabs_jeBef2kCfHObvih40638',
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
                    '{{WRAPPER}} .kivicare-service-style2 svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .kivicare-service-grid .iq-btn-link i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_aJ0C3kdUL5G4tW12awyR',
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
                    '{{WRAPPER}} .kivicare-service-style2:hover svg path' => 'fill: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'icon_image_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .service-icon-box-one' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_image_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .service-icon-box-one' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        require 'render.php';
        if (Plugin::$instance->editor->is_edit_mode()) {  ?>
            <script>
                (function(jQuery) {
                    callSwiper();
                })(jQuery);
            </script> <?php
                    }
                }
            }
