<?php

namespace Iqonic\Elementor\Elements\FlipBox;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iq_flip_box';
    }

    public function get_title()
    {
        return __('Iqonic Flip Box', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-flip-box';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_flip_front',
			[
				'label' => __('Flip Box Content', 'iqonic'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __('Add Your Title Text Here', 'iqonic'),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __('Title Tag', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h2',
				'options'    => [

					'h1'          => __('h1', 'iqonic'),
					'h2'          => __('h2', 'iqonic'),
					'h3'          => __('h3', 'iqonic'),
					'h4'          => __('h4', 'iqonic'),
					'h5'          => __('h5', 'iqonic'),
					'h6'          => __('h6', 'iqonic'),


				],
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __('Description', 'iqonic'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter your Description', 'iqonic'),
				'default' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic'),
			]
		);

		$this->add_control(
			'media_style',
			[
				'label'      => __('Icon / Image', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'icon',
				'options'    => [

					'icon'          => __('Icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),
					'none'          => __('None', 'iqonic'),

				],
			]
		);

		$this->add_control(
			'selected_icon_flip_box',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'media_style' => 'icon',
				],
				'default' => [
					'value' => 'fas fa-star'

				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __('Choose Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'media_style' => 'image',
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_responsive_control(
			'flip',
			[
				'label' => __('Flip Direction', 'iqonic'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'flip-left',
				'options' => [
					'flip-left' => [
						'title' => __('Left', 'iqonic'),
						'icon' => ' eicon-h-align-left',
					],
					'flip-right' => [
						'title' => __('Right', 'iqonic'),
						'icon' => 'eicon-h-align-right',
					],
					'flip-top' => [
						'title' => __('Top', 'iqonic'),
						'icon' => 'eicon-v-align-top',
					],
					'flip-bottom' => [
						'title' => __('Bottom', 'iqonic'),
						'icon' => ' eicon-v-align-bottom',
					],


				]
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'iqonic'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'text-left',
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

		$this->add_control(
			'use_button',
			[
				'label' => __('Use Button', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_flip_back',
			[
				'label' => __('Button', 'iqonic'),
				'condition' => ['use_button' => 'yes']
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
			]
		);


		$this->add_control(
			'button_style',
			[
				'label' => __('Button Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'iq-btn-flat'  => __('Flat', 'iqonic'),
					'iq-btn-outline' => __('Outline', 'iqonic'),
					'iq-btn-link' => __('Link Button', 'iqonic'),
					'default' => __('Default', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'has_icon',
			[
				'label' => __('Use Icon?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'

				],
				'condition' => [
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
					'has_icon' => 'yes',
				],
			]
		);




		$this->add_control(
			'link',
			[
				'label' => __('Link', 'iqonic'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('https://your-link.com', 'iqonic'),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'has_box_shadow',
			[
				'label' => __('Use Box Shadow?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_control(
			'data_background',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'background: {{VALUE}};',

				],

			]
		);
		$this->add_control(
			'data_border',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => 'iq-btn-outline',


				],

			]
		);

		$this->add_control(
			'border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
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
					'button_style' => 'iq-btn-outline',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-button.iq-btn-outline' => 'border-style: {{VALUE}};',

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
					'{{WRAPPER}} .iq-button.iq-btn-outline' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => 'iq-btn-outline',
				],
			]
		);

		$this->add_control(
			'data_hover',
			[
				'label' => __('Hover Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'background: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'data_hover_text',
			[
				'label' => __('Hover Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-button:hover ' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'data_hover_border_outline',
			[
				'label' => __('Hover Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['button_style' => 'iq-btn-outline'],

				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'border-color: {{VALUE}};',
				],

			]
		);
		$this->add_responsive_control(
			'flipbox_button_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_7Ct0934eLcuccbba411H',
			[
				'label' => __('Flip Content Position', 'iqonic'),

			]
		);


		$this->add_control(
			'title_position',
			[
				'label' => __('Title Position', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'front',
				'options' => [
					'front'  => __('front', 'iqonic'),
					'back' => __('back', 'iqonic'),

				],
			]
		);

		$this->add_control(
			'desc_position',
			[
				'label' => __('Description Position', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'front',
				'options' => [
					'front'  => __('front', 'iqonic'),
					'back' => __('back', 'iqonic'),

				],
			]
		);
		$this->add_control(
			'flip_icon_position',
			[
				'label' => __('Icon/Image Position', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'front',
				'options' => [
					'front'  => __('front', 'iqonic'),
					'back' => __('back', 'iqonic'),

				],
			]
		);

		$this->add_control(
			'button_position',
			[
				'label' => __('Button Position', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'front',
				'options' => [
					'front'  => __('front', 'iqonic'),
					'back' => __('back', 'iqonic'),

				],
				'condition' => ['use_button' => 'yes']
			]
		);



		$this->end_controls_section();
		$this->start_controls_section(
			'section_8xW7dmbfOHi9Swzka4fC',
			[
				'label' => __('Flip Box', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_content_text_typography',
				'label' => __('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-flip-box .flipbox-title',
			]
		);


		$this->add_control(
			'flip_front_text_color',
			[
				'label' => __('Title Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .flipbox-title' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_content_text_typography',
				'label' => __('Description Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-flip-box .flipbox-details',
			]
		);


		$this->add_control(
			'flip_front_desc_color',
			[
				'label' => __('Description Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .flipbox-details' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'flip_box_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'box_border_style',
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

				'selectors' => [
					'{{WRAPPER}} .iq-flip-box' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'box_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_7Pefbqv1VdMwd21S4C4r',
			[
				'label' => __('Flip Box Front', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'flip_front_back',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-flip-box .front-side',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
			]
		);

		$this->add_control(
			'image_opacity_color',
			[
				'label' => __('Image opacity color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .front-side::before' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'flip_image_bg_opacity',
			[
				'label' => __('Image Opacity', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .front-side::before' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'flipbox_front_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .front-side' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'flip_front_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-flip-box .front-side',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_iRuI4Of4eQq2DzvPKjc3',
			[
				'label' => __('Flip Box Back', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'flip_back_back',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-flip-box .back-side',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
			]
		);

		$this->add_control(
			'image_back_opacity_color',
			[
				'label' => __('Image opacity color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .back-side::before' => 'background-color: {{VALUE}} !important;',
				],

			]

		);

		$this->add_control(
			'flip_back_image_bg_opacity',
			[
				'label' => __('Image Opacity', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .back-side::before' => 'opacity: {{SIZE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'flipbox_back_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .back-side' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'flip_back_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-flip-box .back-side',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_gy7cXcheU4bedaEJknZd',
			[
				'label' => __('Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'media_style' => 'icon',
				],
			]
		);

		$this->add_control(
			'flip_icon_back_color',
			[
				'label' => __('Icon Box Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-flip-box  .flip-media i' => 'background: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'flip_icon_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .flip-media i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'flip_icon_border_color',
			[
				'label' => __('Icon Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-flip-box  .flip-media i' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'icon_border_style',
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

				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .flip-media i' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box  .flip-media i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box  .flip-media i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],


			]
		);
		$this->add_control(
			'icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box .flip-media i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],


			]
		);
		$this->add_control(
			'icon_size',
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
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .iq-flip-box  .flip-media i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/FlipBox/render.php';
    }
}
