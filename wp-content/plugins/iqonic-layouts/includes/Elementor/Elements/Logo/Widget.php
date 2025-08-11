<?php

namespace Iqonic_Layouts\Elementor\Elements\Logo;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;
class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_logo';
    }

    public function get_title()
    {
        return 'Layouts: Logo';
    }
    public function get_categories()
    {
        return ['iqonic-layouts-extension'];
    }

    public function get_icon()
    {
        return 'eicon-logo';
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section',
            [
                'label' => __('Layouts: Logo', 'iqonic-layouts'),
            ]
        );

        $this->add_responsive_control(
            'logo_height',
            [
                'label' => __('Max height', 'iqonic-layouts'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 80,
                    'unit' => 'px'
                ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-logo .logo_image' => 'height: {{SIZE}}{{UNIT}};max-height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => __('Width', 'iqonic-layouts'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-logo .logo_image' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'logo_option',
            [
                'label'     => esc_html__('Logo Options', 'iqonic-layouts'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'theme'   => esc_html__('Theme Logo', 'iqonic-layouts'),
                    'custom'   => esc_html__('Custom', 'iqonic-layouts'),
                    'acf'      => esc_html__('Page Option', 'iqonic-layouts'),
                ],
                'default' => 'theme',
            ]
        );

        $this->add_control(
            'logo',
            [
                'label' => __('Logo', 'iqonic-layouts'),
                'description' => __("Default Logo.Show if custom logo option is selected or if page option logo is empty.", 'iqonic-layouts'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'logo_text',
            [
                'label' => __('Logo text', 'iqonic-layouts'),
                'label_block' => false,
                'description' => __("Site name (used if logo is empty). If not specified - use blog name", 'iqonic-layouts'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_control(
            'logo_slogan',
            [
                'label' => __('Logo slogan', 'iqonic-layouts'),
                'label_block' => false,
                'description' => __("Slogan or description below site name (used if logo is empty). If not specified - use blog description", 'iqonic-layouts'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'iqonic-layouts'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'iqonic-layouts'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'iqonic-layouts'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'iqonic-layouts'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'add_custom_class',
            [
                'label' => __('Additional CSS Classes', 'iqonic-layouts'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
        // logo Style Section End
    }

    protected function render()
    {
        require 'render.php';
    }
}
