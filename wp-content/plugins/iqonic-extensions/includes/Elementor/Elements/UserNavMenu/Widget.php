<?php

namespace Iqonic\Elementor\Elements\UserNavMenu;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_user_nav_menu';
    }

    public function get_title()
    {
        return __('Iqonic User Navigation', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-user-circle-o';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_sc_layouts_user_button',
            [
                'label' => esc_html__('Layouts: User Button', 'iqonic'),
            ]
        );
        $this->add_control(
            'user_login',
            [
                'label'         => esc_html__('User Login?', 'iqonic'),
                'description'   => esc_html__('This is Option is only for Preview', 'iqonic'),
                'type'          => Controls_Manager::SWITCHER,
                'true'          => esc_html__('Yes', 'iqonic'),
                'false'         => esc_html__('No', 'iqonic'),
                'default'       => 'yes',
                'condition'     => ['user_avatar_fix!' => 'yes']
            ]
        );


        $this->add_control(
            'user_avatar_fix',
            [
                'label' => esc_html__('Fixed User Avatar', 'iqonic'),
                'description' => esc_html__('Enable this to display your selected icon/image after login rather than a user profile image.', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Show', 'iqonic'),
                'false' => esc_html__('Hide', 'iqonic'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'title_before_login_start',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'title_before_login',
            [
                'label' => esc_html__('Title before login', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Leave empty for only icon/image.', 'iqonic'),
                'default' => esc_html__('Login', 'iqonic'),
                'label_block' => false,
            ]
        );

        $this->add_control(
            'title_after_login_start',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'title_after_login',
            [
                'label' => esc_html__('Title after login', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Leave empty for only icon/image.', 'iqonic'),
                'default' => esc_html__('Logout', 'iqonic'),
                'label_block' => false,
            ]
        );

        $this->add_control(
            'avatar_start',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'avatar_type',
            [
                'label' => esc_html('Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__('Image', 'iqonic'),
                    'icon' => esc_html__('Icon', 'iqonic'),
                    'none' => esc_html__('None', 'iqonic')
                ],
                'description' => esc_html__('Select none to dispaly only text link', 'iqonic'),
                'default'   => "icon",
                'label_block' => false,
            ]
        );

        $this->add_control(
            'avatar_icon',
            [
                'label' => esc_html__('User Avatar icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-user',
                    'library' => 'Font Awesome 6 Free',
                ],
                'condition' => ['avatar_type' => 'icon']
            ]
        );

        $this->add_control(
            'avatar_image',
            [
                'label' => esc_html__('Choose Image', 'iqonic'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => ['avatar_type' => 'image']
            ]
        );

        $this->add_control(
            'use_ajax',
            [
                'label' => esc_html__('Enable AJAX?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'iqonic'),
                'label_off' => esc_html__('No', 'iqonic'),
                'return' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_sc_layouts_user',
            [
                'label' => esc_html__('Layouts: Login User Link', 'iqonic'),
            ]
        );



        $repeater = new Repeater();

        $repeater->add_control(
            'list_title',
            [
                'label' => esc_html__('Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('User', 'iqonic'),
                'label_block' => true,
            ]
        );



        $repeater->add_control(
            'list_icon',
            [
                'label' => esc_html__('Select Icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
            ]
        );
        $repeater->add_control(
            'is_logout',
            [
                'label' => esc_html__('Is Logout Button?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'no' => esc_html__('No', 'iqonic'),
                'yes' => esc_html__('Yes', 'iqonic'),
            ]
        );
        $repeater->add_control(
            'list_page_link',
            [
                'label' => esc_html('Select Page ', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => iqonic_get_posts('page', array(), 'slug'),
                'label_block' => true,
                'condition' => ['is_logout!' => 'yes']
            ]
        );

        $this->add_control(
            'list_user',
            [
                'label' => esc_html__('Login User Settings', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__('Account', 'iqonic'),
                        'list_icon' => esc_html__('fa fa-start', 'iqonic'),

                    ],
                    [
                        'list_title' => esc_html__('Logout', 'iqonic'),
                        'list_icon' => esc_html__('fa fa-start', 'iqonic'),

                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_sc_layouts_user_non_login',
            [
                'label' => esc_html__('Layouts: Non Login User Link', 'iqonic'),
            ]
        );



        $repeater = new Repeater();

        $repeater->add_control(
            'list_title',
            [
                'label' => esc_html__('Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('User', 'iqonic'),
                'label_block' => true,
            ]
        );



        $repeater->add_control(
            'list_icon',
            [
                'label' => esc_html__('Select Icon', 'iqonic'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'list_page_link',
            [
                'label' => esc_html('Select Page ', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'options' => iqonic_get_posts('page', array(), 'slug'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list_user_non_login',
            [
                'label' => esc_html__('Non Login User Settings', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__('Sign in', 'iqonic'),
                        'list_icon' => esc_html__('fa fa-start', 'iqonic'),

                    ],
                    [
                        'list_title' => esc_html__('Sign Up', 'iqonic'),
                        'list_icon' => esc_html__('fa fa-start', 'iqonic'),

                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();

        // style tab
        $this->start_controls_section(
            'section_title_style',
            [
                'label'     => __('Title', 'iqonic'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'terms' => [
                                [
                                    'name' => 'title_before_login',
                                    'operator' => '!=',
                                    'value' => ''
                                ]
                            ]
                        ],
                        [
                            'terms' => [
                                [
                                    'name' => 'title_after_login',
                                    'operator' => '!=',
                                    'value' => ''
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_typography',
                'label' => __('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-users-settings span.user-nav-title',
            ]
        );


        $this->add_control(
            'title_normal_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings span.user-nav-title' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Hover color', 'iqonic'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings:hover span.user-nav-title' => 'color: {{VALUE}};',
                ],

            ]
        );


        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings span.user-nav-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings span.user-nav-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Icon/Image
        $this->start_controls_section(
            'section_avatar_icon',
            [
                'label' => __('Avatar icon / svg', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['avatar_type' => 'icon']
            ]
        );
        $this->add_control(
            'icon_head',
            [
                'label'         => esc_html__('Icon', 'iqonic'),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );
        $this->add_responsive_control(
            'avatar_icon_size',
            [
                'label' => __('Icon size', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings .kivicare-avatar-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'svg_head',
            [
                'label'         => esc_html__('SVG', 'iqonic'),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );
        $this->add_responsive_control(
            'avatar_svg_width',
            [
                'label' => __('Width', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings .kivicare-avatar-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'avatar_svg_height',
            [
                'label' => __('Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings .kivicare-avatar-icon svg' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        //Icon/Image
        $this->start_controls_section(
            'section_avatar_image',
            [
                'label' => __('Avatar image', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['avatar_type' => 'image']
            ]
        );

        $this->add_responsive_control(
            'avatar_image_width',
            [
                'label' => __('Width', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings .kivicare-avatar-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'avatar_image_height',
            [
                'label' => __('Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-users-settings .kivicare-avatar-image' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
