<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;


$this->start_controls_section(
	'section_21eZ2eh1Myn3VrK29',
	[
		'label' => __('Blog Contain', 'iqonic'),
	]
);
$this->start_controls_tabs('_dr6u5af63L5yHm3c');
$this->start_controls_tab(
	'tabs_z5VRHMPjDcr6Jb0',
	[
		'label' => __('Normal', 'iqonic'),
	]
);
$this->add_group_control(
	Group_Control_Background::get_type(),
	[
		'name' => 'contain_data_background',
		'label' => __('Background', 'iqonic'),
		'types' => ['classic', 'gradient'],
		'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-detail',
	]
);

$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_z5VRHMPjDcr6Jb000',
	[
		'label' => __('Hover', 'iqonic'),
	]
);
$this->add_group_control(
	Group_Control_Background::get_type(),
	[
		'name' => 'contain_data_hoveer_background',
		'label' => __('Background', 'iqonic'),
		'types' => ['classic', 'gradient'],
		'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-detail:hover',
	]
);

$this->end_controls_tab();
$this->end_controls_tabs();

$this->add_control(
	'blog_effect_color',
	[
		'label' => __('Effect Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box:before' => 'background: {{VALUE}};',
		],


	]
);

$this->end_controls_section();

$this->start_controls_section(
	'section_21eZ2ehx5qrK29',
	[
		'label' => __('Blog Title', 'iqonic'),
	]

);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name' => 'blog_title_typography',
		'label' => __('Typography', 'iqonic'),
		'selector' => '{{WRAPPER}} .iq-blog-box .blog-title .blog-text',
	]
);

$this->start_controls_tabs('_dr6Yu5af63L5yHm3c');
$this->start_controls_tab(
	'tabs_z5VRHMPjDcr6wJb0',
	[
		'label' => __('Normal', 'iqonic'),
	]
);

$this->add_control(
	'blog_title_color',
	[
		'label' => __('Title Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .blog-title .blog-text' => 'color: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_z5VRHMPjDcr',
	[
		'label' => __('Hover', 'iqonic'),
	]
);
$this->add_control(
	'blog_title_hover_color',
	[
		'label' => __('Title Hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .blog-title .blog-text:hover' => 'color: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();


$this->start_controls_section(
	'section_21eZ2ehx5q',
	[
		'label' => __('Content', 'iqonic'),
	]

);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name' => 'content_title_typography',
		'label' => __('Typography', 'iqonic'),
		'selector' => '{{WRAPPER}} .iq-blog-box p',
	]
);

$this->start_controls_tabs('_dr6Yu5af635yHm3c');
$this->start_controls_tab(
	'tabs_z5VRHMPjDr6wJb0',
	[
		'label' => __('Normal', 'iqonic'),
	]
);

$this->add_control(
	'content_title_color',
	[
		'label' => __('Content Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box p' => 'color: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_z5VRHMPjD45cr',
	[
		'label' => __('Hover', 'iqonic'),
	]
);
$this->add_control(
	'content_title_hover_color',
	[
		'label' => __('Content Hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box p:hover' => 'color: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();

// Post meta Style
$this->start_controls_section(
	'section_21eZ2ehx5q56',
	[
		'label' => __('Meta', 'iqonic'),
	] 
);

$this->add_control(
	'show_meta',
	[
		'label' => esc_html__( 'Show meta', 'iqonic' ),
		'type' => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => esc_html__( 'Show', 'iqonic' ),
		'label_off' => esc_html__( 'Hide', 'iqonic' ),
		'return_value' => 'yes',
		'default' => 'yes',
	]
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name' => 'post_meta_typography',
		'label' => __('Typography', 'iqonic'),
		'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-meta ul li',
	]
);

$this->start_controls_tabs('_dr6Yu5af635yHm3c7952');
$this->start_controls_tab(
	'tabs_z5VRHMPjD56r6wJb0',
	[
		'label' => __('Normal', 'iqonic'),
	]
);

$this->add_control(
	'post_meta_color',
	[
		'label' => __('Meta  Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .iq-blog-meta ul li a , {{WRAPPER}} .iq-blog-box .iq-blog-meta ul li i' => 'color: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_z5VRHM48787PjD45cr',
	[
		'label' => __('Hover', 'iqonic'),
	]
);
$this->add_control(
	'post_meta_hover_color',
	[
		'label' => __('Meta Hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .iq-blog-meta ul li:hover a , {{WRAPPER}} .iq-blog-box .iq-blog-meta ul li:hover i' => 'color: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();

// Tag style


$this->start_controls_section(
	'section_21eZ2ehxq56',
	[
		'label' => __('Tag', 'iqonic'),
	]

);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name' => 'post_tag_typography',
		'label' => __('Typography', 'iqonic'),
		'selector' => '{{WRAPPER}} .iq-blog-box .iq-cat-name',
	]
);

$this->start_controls_tabs('_dr6Yu5af65yHm3c7952');
$this->start_controls_tab(
	'tabs_z5VRHMjD56r6wJb0',
	[
		'label' => __('Normal', 'iqonic'),
	]
);

$this->add_control(
	'post_tag_color',
	[
		'label' => __('Tag  Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .iq-cat-name' => 'color: {{VALUE}};',
		],


	]
);
$this->add_control(
	'post_tag_back_color',
	[
		'label' => __('Background  Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .iq-cat-name' => 'background: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->start_controls_tab(
	'tabs_z5VRHM48787jD45cr',
	[
		'label' => __('Hover', 'iqonic'),
	]
);
$this->add_control(
	'post_tag_hover_color',
	[
		'label' => __('Tag Hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .iq-cat-name:hover' => 'color: {{VALUE}};',
		],


	]
);
$this->add_control(
	'post_tag_back_hover_color',
	[
		'label' => __('Background Hover Color', 'iqonic'),
		'type' => Controls_Manager::COLOR,

		'selectors' => [
			'{{WRAPPER}} .iq-blog-box .iq-cat-name:hover' => 'background: {{VALUE}};',
		],


	]
);
$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();

// Post category
$this->start_controls_section(
	'section_21eZ2ecategory',
	[
		'label' => __('Category', 'iqonic'),
	] 
);

$this->add_control(
	'show_category',
	[
		'label' => esc_html__( 'Show Category', 'iqonic' ),
		'type' => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => esc_html__( 'Show', 'iqonic' ),
		'label_off' => esc_html__( 'Hide', 'iqonic' ),
		'return_value' => 'yes',
		'default' => 'yes',
	]
);

$this->end_controls_section();
