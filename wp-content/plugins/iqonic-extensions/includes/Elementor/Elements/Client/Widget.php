<?php

namespace Iqonic\Elementor\Elements\Client;

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
        return 'Client';
    }

    public function get_title()
    {
        return __('Iqonic Client', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-posts-carousel';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_client',
			[
				'label' => __('Client Post', 'iqonic'),

			]
		);

		$this->add_control(
			'client_style',
			[
				'label'      => __('Client Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'slider',
				'options'    => [

					'slider' => __('Client Slider', 'iqonic'),
					'2' => __('Client 2 Columns', 'iqonic'),
					'3' => __('Client 3 Columns', 'iqonic'),
					'4' => __('Client 4 Columns', 'iqonic'),
					'5' => __('Client 5 Columns', 'iqonic'),
					'6' => __('Client 6 Columns', 'iqonic'),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'clinet_name',
			[
				'label' => __('Clinet Name', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Clinet name', 'iqonic'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __('Description', 'iqonic'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter Title Description', 'iqonic'),
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __('Client Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],

				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __('List Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'clinet_name' => __('Client Name', 'iqonic'),
					]

				],
				'title_field' => '{{{ clinet_name }}}',
			]
		);

		$this->add_control(
			'iq_client_list_hover_shadow',
			[
				'label' => __('Use Shadow On Hover?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
				'condition' => [
					'client_style!' => 'slider'
				],
			]
		);

		$this->add_control(
			'iq_client_list_hover_grascale',
			[
				'label' => __('Use grayscale On Hover?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'desk_number',
			[
				'label' => __('Desktop view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'client_style' => 'slider',
				],
				'label_block' => true,
				'default'    => '3',
			]
		);

		$this->add_control(
			'lap_number',
			[
				'label' => __('Laptop view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'client_style' => 'slider',
				],
				'label_block' => true,
				'default'    => '3',
			]
		);

		$this->add_control(
			'tab_number',
			[
				'label' => __('Tablet view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'client_style' => 'slider',
				],
				'label_block' => true,
				'default'    => '2',
			]
		);

		$this->add_control(
			'mob_number',
			[
				'label' => __('Mobile view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'client_style' => 'slider',
				],
				'label_block' => true,
				'default'    => '1',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'      => __('Autoplay', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],
				'condition' => [
					'client_style' => 'slider',
				]
			]
		);

		$this->add_control(
			'loop',
			[
				'label'      => __('Loop', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],
				'condition' => [
					'client_style' => 'slider',
				]
			]
		);

		$this->add_control(
			'centermode',
			[
				'label'      => __('Center Mode', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),
				],
				'default'    => 'false',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'      => __('Pagination', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],
				'condition' => [
					'client_style' => 'slider',
				]
			]
		);

		$this->add_control(
			'nav-arrow',
			[
				'label'      => __('Arrow', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],
				'condition' => [
					'client_style' => 'slider',
				]
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::SLIDER,

				'condition' => [
					'client_style' => 'slider',
				]

			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __('Order By', 'iqonic'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'DESC' => esc_html__('Descending', 'iqonic'),
					'ASC' => esc_html__('Ascending', 'iqonic')
				],

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
					],

				]
			]
		);

		$this->end_controls_section();

		/* Client Box Start*/

		$this->start_controls_section(
			'section_jpdZo4adyfPfER8bqVQF',
			[
				'label' => __('Client Box', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('iq_client_box_tabs');
		$this->start_controls_tab(
			'tabs_Ad2RWVvjUsS088PCabdf',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_client_box_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-client',
			]
		);


		$this->add_control(
			'iq_client_box_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_client_box_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'iq_client_box_has_border' => 'yes',
				],
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
					'{{WRAPPER}} .iq-client, {{WRAPPER}} .iq-client ul ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_client_box_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_client_box_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-client,{{WRAPPER}} .iq-client ul' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_client_box_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_client_box_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client,{{WRAPPER}} .iq-client ul' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_client_box_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_client_box_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client,{{WRAPPER}} .iq-client ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_m3r8Z6h2ja8xSFVid4z8',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_client_box_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-client:hover,{{WRAPPER}} .iq-client.active ,{{WRAPPER}} .iq-client.active,{{WRAPPER}} .iq-client:hover ul,{{WRAPPER}} .iq-client.active ul',
			]
		);


		$this->add_control(
			'iq_client_box_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_client_box_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_client_box_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-client:hover,{{WRAPPER}} .iq-client.active,{{WRAPPER}} .iq-client:hover ul,{{WRAPPER}} .iq-client.active ul ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_client_box_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_client_box_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-client:hover,{{WRAPPER}} .iq-client.active,{{WRAPPER}} .iq-client:hover ul,{{WRAPPER}} .iq-client.active ul' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_client_box_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_client_box_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client:hover,{{WRAPPER}} .iq-client.active,{{WRAPPER}} .iq-client:hover ul,{{WRAPPER}} .iq-client.active ul' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_client_box_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_client_box_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client:hover,{{WRAPPER}} .iq-client.active,{{WRAPPER}} .iq-client:hover ul,{{WRAPPER}} .iq-client.active ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_client_box_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-client' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_client_box_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-client' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Client Box End*/

		/* Client List Start*/

		$this->start_controls_section(
			'section_avb386YbL4372yhufPre',
			[
				'label' => __('Client List', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('iq_client_list_tabs');
		$this->start_controls_tab(
			'tabs_j4aK4oUfabgwx9Zmv8eC',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_client_list_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-client li',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_client_list_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-client li',
			]
		);


		$this->add_control(
			'iq_client_list_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_client_list_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'iq_client_list_has_border' => 'yes',
				],
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
					'{{WRAPPER}} .iq-client li ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_client_list_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_client_list_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-client li' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_client_list_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_client_list_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client li' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_client_list_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_client_list_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_Xl7FbE1e30MZJaQn08m7',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_client_list_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-client li:hover ',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_client_list_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-client li:hover',
			]
		);

		$this->add_control(
			'iq_client_list_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_client_list_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_client_list_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-client li:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_client_list_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_client_list_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-client li:hover' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_client_list_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_client_list_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client li:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_client_list_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_client_list_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-client li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_responsive_control(
			'iq_client_list_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-client li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_client_list_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-client li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Client list End*/

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Client/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                   callOwlCarousel();
               })(jQuery);
           </script> 
               <?php
       }
    }
}