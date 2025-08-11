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
	'slick_pagination',
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
    'sw_space_slide',
    [
        'label' => esc_html__('Space Between Slide', 'iqonic'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 100,
        'step' => 1,
        'default' => 40,
    ]
);

$this->add_control(
	'arrow_back_normal_color',
	[
		'label' => __('Arrow Background Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .iq-testimonial-slick .iq-swiper-arrow .swiper-button-next , {{WRAPPER}} .iq-testimonial-slick .iq-swiper-arrow .swiper-button-prev' => 'background: {{VALUE}};',

		],
	]
);

$this->add_control(
	'arrow_back_hover_color',
	[
		'label' => __('Arrow Background hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .iq-testimonial-slick .iq-swiper-arrow .swiper-button-next:hover , {{WRAPPER}} .iq-testimonial-slick .iq-swiper-arrow .swiper-button-prev:hover' => 'background: {{VALUE}};',

		],
	]
);

$this->add_control(
	'icon_color',
	[
		'label' => __('Icon Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .swiper-button-next::after,{{WRAPPER}} .swiper-button-prev::after' => 'color: {{VALUE}};',

		],
	]
);




$this->add_control(
	'pagination__hover_color',
	[
		'label' => __('Pagination Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .swiper-pagination-current , {{WRAPPER}} .swiper-pagination-total' => 'color: {{VALUE}};',
			'{{WRAPPER}} .iq-swiper-line:before' => 'background: {{VALUE}};',

		],
	]
);
