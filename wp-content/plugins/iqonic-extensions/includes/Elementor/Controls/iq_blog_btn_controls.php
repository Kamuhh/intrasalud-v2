<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$this->start_controls_section(
	'section_21eZ2eh1Myn3Vx5qrK29',
	[
		'label' => __('Button', 'iqonic'),
	]
);

$this->add_control(
	'has_button',
	[
		'label' => __('Use Button?', 'iqonic'),
		'type' => Controls_Manager::SWITCHER,
		'yes' => __('yes', 'iqonic'),
		'no' => __('no', 'iqonic'),
		'default' => 'yes',
	]
);

$this->add_control(
	'button_text',
	[
		'label' => __('Text', 'iqonic'),
		'type' => Controls_Manager::TEXT,
		'dynamic' => [
			'active' => true,
		],
		'label_block' => true,
		'default' => __('Read More', 'iqonic'),
		'condition' => ['has_button' => 'yes'],
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
		'condition' => ['has_button' => 'yes'],
	]
);

$this->add_control(
	'button_icon',
	[
		'label' => __('Icon', 'iqonic'),
		'type' => Controls_Manager::ICONS,
		'fa4compatibility' => 'icon',
		'default' => [
			'value' => 'fas fa-angle-right'
		],
		'condition' => [
			'has_button' => 'yes',
			'has_icon' => 'yes',
		],
	]
);

$this->add_responsive_control(
	'icon_position',
	[
		'label' => __('Icon Position', 'iqonic'),
		'type' => Controls_Manager::CHOOSE,
		'default' => 'right',
		'options' => [
			'left' => [
				'title' => __('Left', 'iqonic'),
				'icon' => 'eicon-text-align-left',
			],
			'right' => [
				'title' => __('Right', 'iqonic'),
				'icon' => 'eicon-text-align-right',
			],
		],
		'condition' => [
			'has_button' => 'yes',
			'has_icon' => 'yes',
		],
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_header',
	[
		'label' => __('Model Header', 'iqonic'),
		'condition' => ['button_action' => 'popup']
	]
);

$this->add_control(
	'model_title',
	[
		'label' => __('Title', 'iqonic'),
		'type' => Controls_Manager::TEXT,
		'dynamic' => [
			'active' => true,
		],
		'label_block' => true,
		'default' => __('Model Title', 'iqonic'),
	]
);


$this->add_control(
	'model_selected_icon',
	[
		'label' => __('Icon', 'iqonic'),
		'type' => Controls_Manager::ICONS,
		'fa4compatibility' => 'icon',
		'default' => [
			'value' => 'fas fa-star'
		],

	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_body',
	[
		'label' => __('Model Body', 'iqonic'),
		'condition' => ['button_action' => 'popup']
	]
);

$this->add_control(
	'model_body',
	[
		'label' => __('Description', 'iqonic'),
		'type' => Controls_Manager::WYSIWYG,
		'default' => __('Default description', 'iqonic'),
		'placeholder' => __('Type your description here', 'iqonic'),
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_uxf6ePJ1WkNzb9E5h72H',
	[
		'label' => __('Button Container', 'iqonic'),
		'tab' => Controls_Manager::TAB_STYLE,
		'condition' => ['has_button' => 'yes']
	]
);

$this->add_responsive_control(
	'container_padding',
	[
		'label' => __('Padding', 'iqonic'),
		'type' => Controls_Manager::DIMENSIONS,
		'size_units' => ['px', '%'],
		'selectors' => [
			'{{WRAPPER}} .iq-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
		'condition' => ['button_type' => 'default']
	]
);

$this->add_responsive_control(
	'container_margin',
	[
		'label' => __('Margin', 'iqonic'),
		'type' => Controls_Manager::DIMENSIONS,
		'size_units' => ['px', '%'],
		'selectors' => [
			'{{WRAPPER}} .iq-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
		'condition' => ['button_type' => 'default']
	]
);

$this->add_responsive_control(
	'text_holder_padding',
	[
		'label' => __('Text Holder Padding', 'iqonic'),
		'type' => Controls_Manager::DIMENSIONS,
		'size_units' => ['px', '%'],
		'selectors' => [
			'{{WRAPPER}} .iq-button-style-2 .iq-btn-text-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
		'condition' => ['button_type' => 'styled']
	]
);

$this->add_responsive_control(
	'icon_holder_padding',
	[
		'label' => __('Icon Holder Padding', 'iqonic'),
		'type' => Controls_Manager::DIMENSIONS,
		'size_units' => ['px', '%'],
		'selectors' => [
			'{{WRAPPER}} .iq-button-style-2 .iq-btn-icon-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
		'condition' => ['button_type' => 'styled']
	]
);

$this->add_responsive_control(
	'align_btn',
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
		],
		'selectors' => [
			'{{WRAPPER}} .iq-btn-container' => 'text-align: {{value}};',
		]
	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_d6iw352ACG3c5r1zvhYp',
	[
		'label' => __('Button Style', 'iqonic'),
		'tab' => Controls_Manager::TAB_STYLE,
		'condition' => ['has_button' => 'yes']
	]
);

$this->add_control(
	'button_type',
	[
		'label' => __('Type', 'iqonic'),
		'type' => Controls_Manager::SELECT,
		'default' => 'default',
		'options' => [
			'default' => __('Default', 'iqonic'),
			'styled' => __('Styled', 'iqonic'),
		],
	]
);

$this->add_control(
	'button_size',
	[
		'label' => __('Size', 'iqonic'),
		'type' => Controls_Manager::SELECT,
		'default' => 'default',
		'options' => [
			'iq-btn-small'  => __('Small', 'iqonic'),
			'iq-btn-medium' => __('Medium', 'iqonic'),
			'iq-btn-large' => __('Large', 'iqonic'),
			'iq-btn-extra-large' => __('Extra Large', 'iqonic'),
			'default' => __('Default', 'iqonic'),
		],
		'condition' => ['button_type' => 'default']
	]
);

$this->add_control(
	'button_shape',
	[
		'label' => __('Shape', 'iqonic'),
		'type' => Controls_Manager::SELECT,
		'default' => 'default',
		'options' => [
			'iq-btn-round'  => __('Round', 'iqonic'),
			'iq-btn-semi-round' => __('Semi Round', 'iqonic'),
			'iq-btn-circle' => __('Circle', 'iqonic'),
			'default' => __('Default', 'iqonic'),
		],
		'condition' => ['button_type' => 'default']
	]
);

$this->add_control(
	'button_style',
	[
		'label' => __('Button Style', 'iqonic'),
		'type' => Controls_Manager::SELECT,
		'default' => 'iq-btn-link',
		'options' => [
			'iq-btn-flat'  => __('Flat', 'iqonic'),
			'iq-btn-outline' => __('Outline', 'iqonic'),
			'iq-btn-link' => __('Link Button', 'iqonic'),
			'default' => __('Default', 'iqonic'),
		],
		'condition' => ['button_type' => 'default']
	]
);

$this->end_controls_section();
// Button style End

// Button Text Style
$this->start_controls_section(
	'section_d1da6dnvYM43C71weL29',
	[
		'label' => __('Button Text Color', 'iqonic'),
		'tab' => Controls_Manager::TAB_STYLE,
		'condition' => ['has_button' => 'yes']
	]
);

$this->start_controls_tabs('contact_tabs');
$this->start_controls_tab(
	'tabs_o8I22AKRc2bJa7BgdwHW',
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
			'{{WRAPPER}} .iq-button,
			{{WRAPPER}} .iq-button i,
			{{WRAPPER}} .iq-btn-link i,
			{{WRAPPER}} .iq-button-style-2,
			{{WRAPPER}} .iq-button-style-2 span i,
			{{WRAPPER}} .iq-button.iq-btn-link,
			{{WRAPPER}} .iq-button-style-2 span.iq-btn-text-holder' => 'color: {{VALUE}};',
		],
	]
);
$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_1322c8M564ER8L6I65U0',
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
			'{{WRAPPER}} .iq-button:hover i,
			{{WRAPPER}} .iq-btn-link:hover i,
			{{WRAPPER}} .iq-button-style-2:hover,
			{{WRAPPER}} .iq-button-style-2:hover span i,
			{{WRAPPER}} .iq-button.iq-btn-link:hover,
			{{WRAPPER}} .iq-button-style-2:hover span.iq-btn-text-holder' => 'color: {{VALUE}};',
		],
	]
);

$this->end_controls_tab();
$this->end_controls_tabs();
$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name' => 'btn_text_typography',
		'label' => __('Typography', 'iqonic'),
		'selector' => '{{WRAPPER}} .iq-button , {{WRAPPER}} .iq-button-style-2',
	]
);

$this->end_controls_section();
// Button Text Style

// Background Style Start

$this->start_controls_section(
	'section_0s6Y4c68qoBcctzHf68f',
	[
		'label' => __('Button Background', 'iqonic'),
		'tab' => Controls_Manager::TAB_STYLE,
		'condition' => ['has_button' => 'yes']
	]
);

$this->start_controls_tabs('_dr6Yu5af63L5yHm3cGc1');
$this->start_controls_tab(
	'tabs_z5VRHMPjDcr6wJb0a4vF',
	[
		'label' => __('Normal', 'iqonic'),
	]
);

$this->add_group_control(
	Group_Control_Background::get_type(),
	[
		'name' => 'data_background',
		'label' => __('Background', 'iqonic'),
		'types' => ['classic', 'gradient'],
		'selector' => '
		{{WRAPPER}} .iq-button, 
		{{WRAPPER}} .iq-button-style-2 .iq-btn-text-holder,
		{{WRAPPER}} .iq-button-style-2 .iq-btn-icon-holder:after',
	]
);

$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_Xa27O3BGf5k23KqHfeNM',
	[
		'label' => __('Hover', 'iqonic'),
	]
);

$this->add_group_control(
	Group_Control_Background::get_type(),
	[
		'name' => 'data_hover',
		'label' => __('Background', 'iqonic'),
		'types' => ['classic', 'gradient'],
		'selector' => '
		{{WRAPPER}} .iq-button:hover,
		{{WRAPPER}} .iq-button-style-2:hover .iq-btn-text-holder,
		{{WRAPPER}} .iq-button-style-2:hover .iq-btn-icon-holder:after',
	]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->end_controls_section();

// Border Style Start
$this->start_controls_section(
	'section_iD8bVLQc8q83f4j5cnJk',
	[
		'label' => __('Button Border', 'iqonic'),
		'tab' => Controls_Manager::TAB_STYLE,
		'condition' => ['has_button' => 'yes']
	]
);
$this->add_control(
	'has_custom_border',
	[
		'label' => __('Use Custom Border?', 'iqonic'),
		'type' => Controls_Manager::SWITCHER,
		'default' => 'no',
		'yes' => __('yes', 'iqonic'),
		'no' => __('no', 'iqonic'),
	]
);

$this->add_control(
	'data_border',
	[
		'label' => __('Border Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .iq-button , {{WRAPPER}} .iq-button-style-2' => 'border-color: {{VALUE}};',
		],
		'condition' => ['has_custom_border' => 'yes'],
	]
);

$this->add_control(
	'data_hover_border_outline',
	[
		'label' => __('Hover Border Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-button:hover , {{WRAPPER}} .iq-button-style-2:hover' => 'border-color: {{VALUE}};',
		],
		'condition' => ['has_custom_border' => 'yes'],
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
		'condition' => ['has_custom_border' => 'yes'],

		'selectors' => [
			'{{WRAPPER}} .iq-button , {{WRAPPER}} .iq-button-style-2' => 'border-style: {{VALUE}};',
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
			'{{WRAPPER}} .iq-button , {{WRAPPER}} .iq-button-style-2' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
		'condition' => ['has_custom_border' => 'yes'],
	]
);

$this->add_control(
	'border_radius',
	[
		'label' => __('Border Radius', 'iqonic'),
		'type' => Controls_Manager::DIMENSIONS,
		'size_units' => ['px', '%'],
		'selectors' => [
			'{{WRAPPER}} .iq-button , {{WRAPPER}} .iq-button-style-2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
		'condition' => ['has_custom_border' => 'yes'],
	]
);

$this->end_controls_section();
// Border Style Start

// Icon Style Start
$this->start_controls_section(
	'section_qfCKlSw4To1FsPY6B33a',
	[
		'label' => __('Icon', 'iqonic'),
		'tab' => Controls_Manager::TAB_STYLE,
		'condition' => [
			'has_button' => 'yes',
			'has_icon' => 'yes',
			]
	]
);

$this->add_control(
	'icon_spacing_left',
	[
		'label' => __('Icon Spacing', 'iqonic'),
		'type' => Controls_Manager::SLIDER,
		'size_units' => ['px', '%'],
		'range' => [
			'px' => [
				'min' => 0,
				'max' => 1000,
				'step' => 1,
			],
			'%' => [
				'min' => 0,
				'max' => 100,
				'step' => 1,
			],
		],
		'condition' => ['icon_position' => 'left'],
		'selectors' => [
			'{{WRAPPER}} .iq-button.has-icon.btn-icon-left i , .iq-button-style-2.has-icon.btn-icon-left i
			,{{WRAPPER}} .iq-btn-container .iq-button.iq-btn-link i' => 'margin-right: {{SIZE}}{{UNIT}};'
		],
	]
);

$this->add_control(
	'icon_spacing_right',
	[
		'label' => __('Icon Spacing', 'iqonic'),
		'type' => Controls_Manager::SLIDER,
		'size_units' => ['px', '%'],
		'range' => [
			'px' => [
				'min' => 0,
				'max' => 1000,
				'step' => 1,
			],
			'%' => [
				'min' => 0,
				'max' => 100,
				'step' => 1,
			],
		],
		'condition' => ['icon_position' => 'right'],
		'selectors' => [
			'{{WRAPPER}} .iq-button.has-icon.btn-icon-right i,
			{{WRAPPER}} .iq-btn-container .iq-button.iq-btn-link i,
			{{WRAPPER}} .iq-button-style-2 .iq-btn-icon-holder i' => 'margin-left: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'button_set_icon_size',
	[
		'label' => __('Set Icon Size?', 'iqonic'),
		'type' => Controls_Manager::SWITCHER,
		'yes' => __('Yes', 'iqonic'),
		'no' => __('no', 'iqonic'),
		'return_value' => 'yes',
		'default' => 'no',
	]
);

$this->add_control(
	'button_icon_size',
	[
		'label' => __('Icon Size', 'iqonic'),
		'type' => Controls_Manager::SLIDER,
		'size_units' => ['px', '%'],
		'range' => [
			'px' => [
				'min' => 0,
				'max' => 1000,
				'step' => 1,
			],
			'%' => [
				'min' => 0,
				'max' => 100,
				'step' => 1,
			],
		],
		'condition' => ['button_set_icon_size' => 'yes'],
		'selectors' => [
			'{{WRAPPER}} .iq-button i,
			{{WRAPPER}} .iq-button-style-2 span i,
			{{WRAPPER}} .iq-button-style-2 .iq-btn-icon-holder i' => 'font-size: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->end_controls_section();
