<?php

namespace Iqonic\Elementor\Elements\Social_Icons;

use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
	public function get_name()
	{
		return 'iqonic_social_icons';
	}

	public function get_title()
	{
		return __('Iqonic Social Icons', 'iqonic');
	}
	public function get_categories()
	{
		return ['iqonic-layouts-extension'];
	}

	public function get_icon()
	{
		return 'eicon-social-icons';
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => __('Social Icons', 'iqonic'),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_icon',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'iqonic',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'x-twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __('Link', 'iqonic'),
				'type' => Controls_Manager::URL,
				'default' => [
					'is_external' => 'true',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('https://your-link.com', 'iqonic'),
			]
		);

		$repeater->add_control(
			'social_text',
			[
				'label' => __('Text', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);


		$this->add_control(
			'social_icon_list',
			[
				'label' => __('Social Icons', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
						'social_text' => __('Facebook', 'iqonic'),
					],
					[
						'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
						'social_text' => __('Twitter', 'iqonic'),
					],
					[
						'social_icon' => [
							'value' => 'fab fa-youtube',
							'library' => 'fa-brands',
						],
						'social_text' => __('Youtube', 'iqonic'),
					],
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __('Layout', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __('Only Icons', 'iqonic'),
					'names' => __('Only Names', 'iqonic'),
					'icons_names' => __('Icon + name', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __('Position', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __('Horizontal', 'iqonic'),
					'verticle' => __('Verticle', 'iqonic'),
				],
				'prefix_class' => 'iqonic-social-position-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __('Shape', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => [
					'rounded' => __('Rounded', 'iqonic'),
					'square' => __('Square', 'iqonic'),
					'circle' => __('Circle', 'iqonic'),
					'svg-circle' => __('SVG Circle', 'iqonic'),
				],
				'prefix_class' => 'iqonic-shape-',
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'iqonic'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'prefix_class' => 'e-grid-align-',
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .kivicare-socials-share' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __('View', 'iqonic'),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_style',
			[
				'label' => __('Social Icons', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __('Official Color', 'iqonic'),
					'custom' => __('Custom', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label' => __('Primary Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-share' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => __('Secondary Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-share i, {{WRAPPER}} .kivicare-share' => 'color: {{VALUE}};',
					'{{WRAPPER}} .kivicare-share svg,{{WRAPPER}} .kivicare-share svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_container_size',
			[
				'label' => __('Icon container size', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' => '--icon-container-size: {{SIZE}}{{UNIT}}; line-size: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Icon size', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-social-icons-names .kivicare-share i' => '--icon-size: {{SIZE}}{{UNIT}}; line-size: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __('Spacing', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-socials-share' => 'word-spacing: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => __('Rows Gap', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-social-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border', // We know this mistake - TODO: 'icon_border' (for hover control condition also)
				'selector' => '{{WRAPPER}} .kivicare-share',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-share' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_hover',
			[
				'label' => __('Icon Hover', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __('Primary Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-share:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __('Secondary Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-share:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .kivicare-share:hover svg,{{WRAPPER}} .kivicare-share:hover svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'image_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-share:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __('Hover Animation', 'iqonic'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings();
		require 'render.php';
	}
}
