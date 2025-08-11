<?php

namespace Iqonic\Elementor\Elements\VerticalTimeline;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
	public function get_name()
	{
		return 'iqonic-VerticalTimeline';
	}

	public function get_title()
	{
		return __('Iqonic Vertical Time Line', 'iqonic');
	}
	public function get_categories()
	{
		return ['iqonic-extension'];
	}

	public function get_icon()
	{
		return 'eicon-tabs';
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_v5Q8ddu4Dt3l9E51K89e',
			[
				'label' => __('Timeline Style', 'iqonic'),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Select Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1'          => __('Style-1', 'iqonic'),
					'2'          => __('Style-2', 'iqonic'),
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section',
			[
				'label' => __('Tabs', 'iqonic'),
			]
		);


		$repeater = new Repeater();

		$repeater->add_control(
			'tab_year',
			[
				'label' => __('Timeline Year', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('2000', 'iqonic'),
				'placeholder' => __('2000', 'iqonic'),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'tab_title',
			[
				'label' => __('Timeline Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Title', 'iqonic'),
				'placeholder' => __('Title', 'iqonic'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label' => __('Time Line Description', 'iqonic'),
				'default' => __('simply dummy text of the printing Lorem Ipsum is and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s', 'iqonic'),
				'placeholder' => __('Description', 'iqonic'),
				'type' => Controls_Manager::TEXTAREA,
				'show_label' => false,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __('Tabs Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __('Title #1', 'iqonic'),
						'tab_year' => __('2000', 'iqonic'),
						'tab_content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'iqonic'),

					]

				],
				'title_field' => '{{{ tab_title }}}',
			]
		);


		$this->add_control(
			'has_icon',
			[
				'label' => __('Use Icon?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
                'condition' => ['design_style' => ['1']],
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
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* timeline  title Start*/

		$this->start_controls_section(
			'section_1Z53s28c71M09TYpE7Ru',
			[
				'label' => __('Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __('Title Tag', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h5',
				'options'    => [

					'h1'          => __('h1', 'iqonic'),
					'h2'          => __('h2', 'iqonic'),
					'h3'          => __('h3', 'iqonic'),
					'h4'          => __('h4', 'iqonic'),
					'h5'          => __('h5', 'iqonic'),
					'h6'          => __('h6', 'iqonic'),
					'div'          => __('div', 'iqonic'),
					'span'          => __('span', 'iqonic'),
					'p'          => __('p', 'iqonic'),


				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .timeline-title',
			]
		);


		$this->start_controls_tabs('title_tabs');
		$this->start_controls_tab(
			'tabs_GcqaL53c172Vjmh2FKT6',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-title' => 'color: {{VALUE}};',
				],

			]

		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_6i7dbdabY91yE3cwL85Z',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'data_hover_text',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .kivicare-timeline .timeline-article:hover .timeline-title, {{WRAPPER}} .kivicare-timeline .timeline__content:hover  .timeline-title' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->end_controls_section();

		/* Title End*/
		/* Year  Start*/

		$this->start_controls_section(
			'section_8c71M09TYpE7Ru',
			[
				'label' => __('Year', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_year_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .timeline-year',
			]
		);


		$this->start_controls_tabs('year_tabs');
		$this->start_controls_tab(
			'tabs_c172Vjmh2FKT6',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'year_text_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-year' => 'color: {{VALUE}};',
				],

			]

		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_1yE3cwL85Z',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'year_hover_text',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .kivicare-timeline .timeline-article:hover .timeline-year, {{WRAPPER}} .kivicare-timeline .timeline__content:hover  .timeline-year' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->end_controls_section();

		/* Year End*/


		/* timeline  Content Start*/

		$this->start_controls_section(
			'section_ysQRPL5g7X9CJW53bvh7',
			[
				'label' => __('Description', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);



		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .timeline-content',
			]
		);


		$this->start_controls_tabs('content_tabs');
		$this->start_controls_tab(
			'tabs_YN0Ab6Ue02fa3rslT6o9',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-content' => 'color: {{VALUE}};',
				],

			]

		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_a5j0dT5cf589y4oicdOK',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'desc_hover_text',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .kivicare-timeline .timeline-article:hover .timeline-content ,{{WRAPPER}} .kivicare-timeline .timeline__content:hover .timeline-content ' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* Title End*/

	}

	protected function render()
	{
	  require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/VerticalTimeline/render.php';
	}
}
