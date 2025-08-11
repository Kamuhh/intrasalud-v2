<?php

namespace Iqonic\Elementor\Elements\WoocommerceLogin;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_woocommerce_login';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Woocommerce Login', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-lock-user';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_woocommerce_login',
            [
                'label' => esc_html__('Woocommerce Login', 'iqonic'),
            ]
        );

        $this->add_control(
            'woocommerce_login_form',
            [
                'label'      => esc_html__('Select option', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'signup-form',
                'options'    => [
                    'signup-form'    => esc_html__('Signup Form', 'iqonic'),
                    'login-form'     => esc_html__('Login Form', 'iqonic'),
                    'track-order'    => esc_html__('Track Order', 'iqonic'),
                    'lost-password'  => esc_html__('Lost Password', 'iqonic'),
                ],
            ]
        );

        $this->end_controls_section();

        /* Start Signup URL */

        $this->start_controls_section(
            'section_woocommerce_signup',
            [
                'label' => esc_html__('Signup URL', 'iqonic'),
                'condition' => ['woocommerce_login_form' => 'login-form']
            ]
        );

        $this->add_control(
            'button_text_string',
            [
                'label' => esc_html__('Label string', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__("Don't have an account yet?", 'iqonic'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__('Sign Up', 'iqonic'),
            ]
        );


        $this->add_control(
            'link_type',
            [
                'label' => esc_html__('Link Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [
                    'dynamic' => esc_html__('Dynamic', 'iqonic'),
                    'custom' => esc_html__('Custom', 'iqonic'),
                ],
            ]
        );
        
        $this->add_control(
            'dynamic_link',
            [
                'label' => esc_html__('Select Page', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'link_type' => 'dynamic',
                ],
                'options' => iqonic_get_posts("page"),
            ]
        );
        
        
        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'iqonic'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'iqonic'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'link_type' => 'custom',
                ]
            ]
        );

        $this->end_controls_section();

        /* End Signup URL */

        /* Start Forgot Password URL */

        $this->start_controls_section(
            'section_woocommerce_forgot_password',
            [
                'label' => esc_html__('Forgot Password URL', 'iqonic'),
                'condition' => ['woocommerce_login_form' => 'login-form']
            ]
        );

        $this->add_control(
            'forgot_password_text',
            [
                'label' => esc_html__('Text', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__('Forgot Password?', 'iqonic'),
            ]
        );


        $this->add_control(
            'forgot_password_link_type',
            [
                'label' => esc_html__('Link Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [
                    'dynamic' => esc_html__('Dynamic', 'iqonic'),
                    'custom' => esc_html__('Custom', 'iqonic'),
                ],
            ]
        );
        
        $this->add_control(
            'forgot_password_dynamic_link',
            [
                'label' => esc_html__('Select Page', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'link_type' => 'dynamic',
                ],
                'options' => iqonic_get_posts("page"),
            ]
        );
        
        
        $this->add_control(
            'forgot_password_link',
            [
                'label' => esc_html__('Link', 'iqonic'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'iqonic'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'link_type' => 'custom',
                ]
            ]
        );

        $this->end_controls_section();

        /* End Forgot Password URL */

         /* Start logo */

         $this->start_controls_section(
            'section_woocommerce_logo',
            [
                'label' => esc_html__('Logo', 'iqonic'),
            ]
        );

        $this->add_control(
            'kivicare_has_logo',
            [
                'label' => esc_html__('Display Logo?', 'iqonic'),
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
                'condition' => ['kivicare_has_logo' => 'yes'],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .kivicare-form-logo, {{WRAPPER}} .kivicare-woocommerce-custom-form' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* End start logo */

        $this->start_controls_section(
            'section_woocommerce_signin',
            [
                'label' => esc_html__('Sign In URL', 'iqonic'),
                'condition' => ['woocommerce_login_form' => 'signup-form']
            ]
        );

        $this->add_control(
            'signin_text_string',
            [
                'label' => esc_html__('Label string', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__("Don't have an account yet?", 'iqonic'),
            ]
        );

        $this->add_control(
            'signin_button_text',
            [
                'label' => esc_html__('Button Text', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__('Sign Up', 'iqonic'),
            ]
        );


        $this->add_control(
            'signin_link_type',
            [
                'label' => esc_html__('Link Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [
                    'dynamic' => esc_html__('Dynamic', 'iqonic'),
                    'custom' => esc_html__('Custom', 'iqonic'),
                ],
            ]
        );
        
        $this->add_control(
            'signin_dynamic_link',
            [
                'label' => esc_html__('Select Page', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'link_type' => 'dynamic',
                ],
                'options' => iqonic_get_posts("page"),
            ]
        );
        
        
        $this->add_control(
            'signin_link',
            [
                'label' => esc_html__('Link', 'iqonic'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'iqonic'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'link_type' => 'custom',
                ]
            ]
        );

        $this->end_controls_section();

        /* End Sign In form URL */
     
    }

    protected function render()
    {
        require 'render.php';
    }
}
