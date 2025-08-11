<?php

namespace Iqonic\Elementor\Elements\CountDown;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_count_down';
    }

    public function get_title()
    {
        return __('Iqonic Count Down Timer', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section',
			[
				'label' => __('Count Down Timer', 'iqonic'),
			]
		);

		$this->add_control(
			'future_date',
			[
				'label' => __('Select Date', 'iqonic'),
				'type' => Controls_Manager::DATE_TIME,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'picker_options' => ['enableTime' => true]

			]
		);

		$this->add_control(
			'timer_format',
			[
				'label'      => __('Select Format', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'YODHMS',
				'options'    => [
					'YODHMS'          => __('Year / Month / Day / Hour / Minute / Second', 'iqonic'),
					'ODHMS'          => __('Month / Day/ Hour / Minute / Second', 'iqonic'),
					'DHMS'          => __('Day / Hour / Minute / Second', 'iqonic'),
					'HMS'          => __(' Hour / Minute / Second', 'iqonic'),
					'MS'          => __('Minute / Second', 'iqonic'),
					'S'          => __(' Second', 'iqonic'),
				],

			]
		);

		$this->add_control(
			'show_label',
			[
				'label' => __('Show Labels', 'iqonic'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'iqonic'),
				'label_off' => __('Hide', 'iqonic'),
				'return_value' => 'true',
				'default' => 'true',

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
		$this->start_controls_section(
			'section_count_down_style',
			[
				'label' => __('Timer Text', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_label' => 'true'
				]
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Timer Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .iq-data-countdown-timer .numberDisplay' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .iq-data-countdown-timer .periodDisplay' => 'color: {{VALUE}};',

				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'flip_back_back',
				'types' => ['classic', 'gradient'],

				'selector' => '{{WRAPPER}} .iq-count-down .iq-data-countdown-timer .numberDisplay',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					]

				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_border_style',
			[
				'label' => __('Border', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_label' => 'true'
				]
			]
		);

		$this->add_control(
			'has_border',
			[
				'label' => __('Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'border_style',
			[
				'label' => __('Border Style', 'iqonic'),
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
				'condition' => [
					'has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .numberDisplay' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .numberDisplay' => 'border-color: {{VALUE}};',

				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);



		$this->add_control(
			'border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .numberDisplay' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'count_down_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .numberDisplay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-count-down .numberDisplay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/CountDown/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
				    callCountDown();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
