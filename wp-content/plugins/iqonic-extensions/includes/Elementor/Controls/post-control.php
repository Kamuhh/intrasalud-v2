<?php

namespace Elementor;

$this->add_control(
	'blog_cat',
	[
		'label' => esc_html__('Category', 'iqonic'),
		'type' => Controls_Manager::SELECT2,
		'return_value' => 'true',
		'multiple' => true,
		'options' => iq_by_blog_cat(),
	]
);

$this->add_responsive_control(
	'posts_per_page',
	[
		'label' => __('Posts Per Page', 'iqonic'),
		'type' => Controls_Manager::SLIDER,
		'default' => [
			'unit' => '%',
			'size' => 3,
		],

	]
);
$this->add_control(
	'pagination',
	[
		'label'   => __('Show Pagintion', 'iqonic'),
		'type'    => Controls_Manager::SELECT,
		'default' => 'no',
		'options' => [
			'yes' => esc_html__('yes', 'iqonic'),
			'no' => esc_html__('no', 'iqonic')
		],

	]
);
$this->add_control(
	'loadmore_button',
	[
		'label' => __('Use Loadmore Button', 'iqonic'),
		'type' => Controls_Manager::SWITCHER,
		'yes' => __('yes', 'iqonic'),
		'no' => __('no', 'iqonic'),
		'default' => 'no',
		'condition' => ['pagination' => ['no']],
	]
);
$this->add_responsive_control(
	'posts_per_loadmore',
	[
		'label' => __('Posts Per Load', 'iqonic'),
		'type' => Controls_Manager::SLIDER,
		'default' => [
			'unit' => '%',
			'size' => 3,
		],
		'condition' => ['loadmore_button' => ['yes']],
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
