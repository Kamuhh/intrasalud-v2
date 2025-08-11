<?php

namespace Elementor;

$this->add_control(
	'desk_number',
	[
		'label' => __('Desktop view', 'iqonic'),
		'type' => Controls_Manager::TEXT,
		'dynamic' => [
			'active' => true,
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

$this->add_responsive_control(
	'margin',
	[
		'label' => __('Margin', 'iqonic'),
		'type' => Controls_Manager::SLIDER,
	]
);

$this->add_control(
	'dot_each',
	[
		'label' => esc_html__('Pagination Each', 'iqonic'),
		'type' => Controls_Manager::NUMBER,
	]
);

$this->add_control(
	'dot_active_color',
	[
		'label' => __('Pagination Active Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}}  .owl-carousel .owl-dots .owl-dot.active' => 'background: {{VALUE}};',
			'{{WRAPPER}}  .owl-dot.active' => 'border-color: {{VALUE}};',
			'{{WRAPPER}}  .owl-dot' => 'border-color: {{VALUE}};',
			'{{WRAPPER}}  .owl-carousel .owl-dots .owl-dot:hover' => 'background: {{VALUE}};',
			'{{WRAPPER}}  .owl-dot:hover' => 'border-color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'dot_in_active_color',
	[
		'label' => __('Pagination Inactive Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}}  .owl-dot' => 'background: {{VALUE}};',

		],
	]
);

$this->add_control(
	'arrow_back_normal_color',
	[
		'label' => __('Arrow Background Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .owl-carousel .owl-nav i' => 'background: {{VALUE}};',

		],
	]
);

$this->add_control(
	'arrow_back_hover_color',
	[
		'label' => __('Arrow Background hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .owl-carousel .owl-nav i:hover' => 'background: {{VALUE}};',

		],
	]
);

$this->add_control(
	'icon_color',
	[
		'label' => __('Icon Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .owl-carousel .owl-nav i' => 'color: {{VALUE}};',

		],
	]
);

$this->add_control(
	'icon__hover_color',
	[
		'label' => __('Icon hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .owl-carousel .owl-nav i:hover' => 'color: {{VALUE}};',

		],
	]
);
