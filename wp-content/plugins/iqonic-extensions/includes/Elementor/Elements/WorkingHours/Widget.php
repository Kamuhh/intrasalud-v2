<?php

namespace Iqonic\Elementor\Elements\WorkingHours;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_working_hours';
    }

    public function get_title()
    {
        return __('Iqonic Working Hours', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-kit-details';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section',
            [
                'label' => __('Working Hours', 'iqonic'),
            ]
        );

        $this->add_control(
            'working_title',
            [
                'label' => __('Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Working Hours', 'iqonic'),
            ]
        );

        // weekdays

        $this->add_control(
            'section_weekdays_heading',
            [
                'label' => esc_html__('Weekdays', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_weekdays',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Monday TO Friday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_weekdays',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );

        // Monday

        $this->add_control(
            'section_monday_heading',
            [
                'label' => esc_html__('Monday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_monday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Monday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_monday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );

        // Tuesday

        $this->add_control(
            'section_tuesday_heading',
            [
                'label' => esc_html__('Tuesday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_tuesday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Tuesday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_tuesday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );


        // Wednesday

        $this->add_control(
            'section_wednesday_heading',
            [
                'label' => esc_html__('Wednesday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_wednesday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Wednesday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_wednesday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );


        // Thursday

        $this->add_control(
            'section_thursday_heading',
            [
                'label' => esc_html__('Thursday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_thursday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Thursday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_thursday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );


        // Friday

        $this->add_control(
            'section_friday_heading',
            [
                'label' => esc_html__('Friday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_friday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Friday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_friday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );

        // Saturday

        $this->add_control(
            'section_saturday_heading',
            [
                'label' => esc_html__('Saturday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_saturday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Saturday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_saturday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('10:00 am to 11:00 am ', 'iqonic'),
            ]
        );

        // Sunday

        $this->add_control(
            'section_sunday_heading',
            [
                'label' => esc_html__('Sunday', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_sunday',
            [
                'label' => __('Label', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Sunday', 'iqonic'),
            ]
        );

        $this->add_control(
            'time_sunday',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => __('Close', 'iqonic'),
            ]
        );

        $this->end_controls_section();

        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';

        // start title style
        $this->start_controls_section(
			'section_f4aS9uHc50Of5eNP8jbcas',
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
				'selector' => '{{WRAPPER}} .kivicare-working-hours .contact-info',
			]
		);

        $this->add_control(
            'weekdays_color',
            [
                'label' => __('Title', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-working-hours .iq-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'working_title_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .contact-info.iq-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'working_title_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .contact-info.iq-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        // start label style
        $this->start_controls_section(
			'section_f4Ahg9uHc50Of5eNP8jbcas',
			[
				'label' => __('Label', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-contact',
			]
		);

        $this->add_control(
            'weekdays_label_color',
            [
                'label' => __('label', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-working-hours .iq-week' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'time_color',
            [
                'label' => __('Time', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-working-hours ul li .iq-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'iq_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_label_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_border' => 'yes',
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
					'{{WRAPPER}} .kivicare-working-hours .iq-contact li.iq-week' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_label_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-working-hours .iq-contact li.iq-week' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'iq_label_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-working-hours .iq-contact li.iq-week' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'working_label_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-working-hours .iq-contact li.iq-week' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'working_label_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-working-hours .iq-contact li.iq-week' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
