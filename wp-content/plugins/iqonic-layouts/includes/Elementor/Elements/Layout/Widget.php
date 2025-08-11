<?php

namespace Iqonic_Layouts\Elementor\Elements\Layout;


use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return __('iqonic_layouts', 'iqonic-layouts');
    }

    public function get_title()
    {
        return __('Layouts', 'iqonic-layouts');
    }
    public function get_categories()
    {
        return ['iqonic-layouts-extension'];
    }

    public function get_icon()
    {
        return 'eicon-gallery-masonry';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_iqonic_layouts',
            [
                'label' => __('Layouts', 'iqonic-layouts'),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => __("Custom Layout", 'iqonic-layouts'),
                'label_block' => false,
                'type' => Controls_Manager::SELECT,
                'options' => iqonic_addons_get_list_layouts(),
                'description' => __("Select any previously created layout to insert to this sidebar", 'iqonic-layouts'),
            ]
        );

        $this->add_control(
            'panel_id',
            [
                'label' => __("Popup (panel) ID", 'iqonic-layouts'),
                'label_block' => false,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __("Popup (panel) ID is required!", 'iqonic-layouts'),
                'default' => '',
            ]
        );

        $this->add_control(
            'important_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<i aria-hidden="true" class="eicon-arrow-up"></i>' . esc_html__(' Add this Popup (panel) ID  with # prefix in any link  for the dynamic close button.', 'iqonic-layouts'),
                'condition' => ['hide_close' => 'yes']
            ]
        );

        $this->add_control(
            'hide_close',
            [
                'label' => __('Hide close button ?', 'iqonic-layouts'),
                'description' => __('Hide default close button if you want dynamic close button.', 'iqonic-layouts'),
                'type' => Controls_Manager::SWITCHER,
                'yes' => __('Yes', 'iqonic-layouts'),
                'no' => __('No', 'iqonic-layouts'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => __('Panel Position', 'iqonic-layouts'),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'      => __('Left', 'iqonic-layouts'),
                    'right'     => __('Right', 'iqonic-layouts'),
                    'top'       => __('Top', 'iqonic-layouts'),
                    'bottom'    => __('Bottom', 'iqonic-layouts'),
                    'top-left-corner'   => __('Top left corner', 'iqonic-layouts'),
                    'top-right-corner'  => __('Top right corner', 'iqonic-layouts'),
                ],
            ]
        );

        $this->add_control(
            'set_heigth_width',
            [
                'label' => __('Custom Height / Width', 'iqonic-layouts'),
                'description' => __('Widht: Right/Left Toggle, Height: Top/Bottom Toggle', 'iqonic-layouts'),
                'type' => Controls_Manager::SWITCHER,
                'yes' => __('Yes', 'iqonic-layouts'),
                'no' => __('No', 'iqonic-layouts'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => __('Width', 'iqonic-layouts'),
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
                        'max' => 20
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'condition' => [
                    'set_heigth_width' => 'yes',
                    'position' => ['right', 'left']
                ]
            ]
        );
        $this->add_control(
            'height',
            [
                'label' => __('Height', 'iqonic-layouts'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'condition' => [
                    'set_heigth_width' => 'yes',
                    'position' => ['top', 'bottom']
                ]
            ]
        );
        $this->add_control(
            'panel_bg_color',
            [
                'label' => __('Set Panel Background Color', 'iqonic-layouts'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.iqonic-custom-layout-{{ID}}.iqonic-custom-layouts' => 'background: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => __('Panel Box Shadow', 'iqonic-layouts'),
                'selector' =>  '.iqonic-custom-layout-{{ID}}.iqonic-custom-layouts',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_iqonic_panel_btn',
            [
                'label'     => __('Close Button', 'iqonic-layouts'),
                'condition' => ['hide_close!' => 'yes']
            ]
        );

        $this->add_control(
            'panel_close_btn_icon',
            [
                'label' => __('Button Icon', 'iqonic-layouts'),
                'type' => Controls_Manager::ICONS,

            ]
        );


        $this->add_control(
            'panel_icon_color',
            [
                'label' => __(' Button Color', 'iqonic-layouts'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.iqonic-custom-layout-{{ID}}.iqonic-custom-layouts .btn-close > i' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'panel_icon_bg_color',
            [
                'label' => __('Button Background Color', 'iqonic-layouts'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.iqonic-custom-layout-{{ID}}.iqonic-custom-layouts .btn-close' => 'background: {{VALUE}} !important',
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
