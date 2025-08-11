<?php

namespace Iqonic\Elementor\Elements\Title;

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
        return 'section_title';
    }

    public function get_title()
    {
        return __('Section Title', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-site-title';
    }
    protected function register_controls()
    {

       
		$this->start_controls_section(
			'section_3hF8Pm7ca35YJWo8kiTD',
			[
				'label' => __('Title Style', 'iqonic'),
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
					'3'          => __('Style-2', 'iqonic'),
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section',
			[
				'label' => __('Section Title', 'iqonic'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __('Section Title', 'iqonic'),
			]
		);

		$this->add_control(
			'section_title_2',
			[
				'label' => __('Section Title 2', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __('Section Title', 'iqonic'),
				'condition' => ['design_style' => '3']
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label' => __('Section Sub Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __('Section Sub Title', 'iqonic'),
			]
		);

		$this->add_control(
			'sub_title_position',
			[
				'label'      => __('Sub Title Position', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'before',
				'options'    => [

					'before' => __('Before Title', 'iqonic'),
					'after'  => __('After Title', 'iqonic'),

				],
			]
		);

		$this->add_control(
			'has_description',
			[
				'label' => __('Has Description?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
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
				'placeholder' => __('Enter Title Description', 'iqonic'),
				'default' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic'),
				'condition' => ['has_description' => 'yes']
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
				'default' => 'left',
				'selectors' => [
                    '{{WRAPPER}} .iq-title-box' => 'text-align: {{VALUE}};',
                ],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_cf6i4c8e7lf4ocrcLUGa',
			[
				'label' => __('Icon/Image', 'iqonic'),
			]
		);

		$this->add_control(
			'media_style',
			[
				'label'      => __('Icon / Image', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'none',
				'options'    => [
					'icon'          => __('Icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),
					'none'          => __('None', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'selected_icon',
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
				'skin' => 'inline',
				'label_block' => false,
				'show_label' => true
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

			]
		);
		$this->end_controls_section();
		// Container Style Section End



		$this->start_controls_section(
			'section_NIfezt7YM7feDaT9vP8J',
			[
				'label' => __('Title Box', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('titlebox_tabs');
		$this->start_controls_tab(
			'tabs_c8fpaelTGDkf951QeYf2',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'titlebox_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box',
			]
		);


		$this->add_control(
			'titlebox_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'titlebox_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'titlebox_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'titlebox_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'titlebox_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-title-box' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'titlebox_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'titlebox_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'titlebox_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'titlebox_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_49pcfagYof19beG4w8Ee',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'titlebox_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box:hover ',
			]
		);


		$this->add_control(
			'titlebox_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'titlebox_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'titlebox_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'titlebox_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'titlebox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-title-box:hover' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'titlebox_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'titlebox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'titlebox_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'titlebox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_responsive_control(
			'titlebox_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'titlebox_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Price table End*/

		// Title Style Section
		$this->start_controls_section(
			'section_f4aS9uHc50Of5eNP8jbc',
			[
				'label' => __('Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-title-box .iq-title',
			]
		);

		$this->start_controls_tabs('title_tabs');

		$this->start_controls_tab(
			'title_color_tab_normal',
			[
				'label' => __('normal', 'iqonic'),
			]
		);

		$this->add_control(
			'title_normal_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box .iq-title',
			]
		);

		$this->add_control(
			'iq_title_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_title_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_title_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box .iq-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_title_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_title_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box .iq-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_title_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_title_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box .iq-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_title_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_title_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box .iq-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_color_tab_hover',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_hover_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box:hover .iq-title',
			]
		);


		$this->add_control(
			'iq_title_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_title_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_title_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box:hover .iq-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_title_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_title_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box:hover .iq-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_title_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_title_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box:hover .iq-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_title_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_title_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box:hover .iq-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_section();
		// Title Style Section End

		// Sub Title Style Section
		$this->start_controls_section(
			'section_2DfcMGaqcAClSRKbf9e3',
			[
				'label' => __('Sub Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'titlebox_has_befor',
			[
				'label' => __('Show before line?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'sub_title_before_normal_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
                'condition' => [
					'titlebox_has_befor' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-befor-line .iq-subtitle:after' => 'background: {{VALUE}};',
				],

			]
		);

		$this->start_controls_tabs('sub_title_tabs');


		$this->start_controls_tab(
			'sub_title_color_tab_normal',
			[
				'label' => __('normal', 'iqonic'),
			]
		);

		$this->add_control(
			'sub_title_normal_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-subtitle' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sub_title_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box .iq-subtitle',
			]
		);

		$this->add_control(
			'iq_subtitle_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_subtitle_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_subtitle_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box .iq-subtitle' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_subtitle_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_subtitle_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box .iq-subtitle' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_subtitle_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_subtitle_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box .iq-subtitle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_subtitle_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_subtitle_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box .iq-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_title_color_tab_hover',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'sub_title_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-subtitle:hover' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sub_title_hover_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box:hover .iq-subtitle',
			]
		);

		$this->add_control(
			'iq_subtitle_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_subtitle_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_subtitle_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box:hover .iq-subtitle' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_subtitle_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_subtitle_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box:hover .iq-subtitle' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_subtitle_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_subtitle_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box:hover .iq-subtitle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_subtitle_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_subtitle_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box:hover .iq-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_title_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-title-box .iq-subtitle',
			]
		);


		$this->add_responsive_control(
			'sub_title_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'sub_title_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_section();
		// Sub Title Style Section End

		// Description Style Section
		$this->start_controls_section(
			'section_ZcASngaa14lc8er55aND',
			[
				'label' => __('Description', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['has_description' => 'yes']
			]
		);

		$this->add_control(
			'description_heading_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->start_controls_tabs('description_tabs');


		$this->start_controls_tab(
			'description_color_tab_normal',
			[
				'label' => __('normal', 'iqonic'),
			]
		);

		$this->add_control(
			'description_normal_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-desc' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'description_color_tab_hover',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'description_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-desc:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-title-box .iq-title-desc',
			]
		);

		$this->add_responsive_control(
			'desciption_marging',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'desciption_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_section();
		// Descrition Style Section End

		//Icon/Image

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __('Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'media_style' => 'icon',
				],
			]
		);

		$this->start_controls_tabs('_T3NeYU6fCH1wGcz2i8a8');

		$this->start_controls_tab(
			'tab_K5WaTg9S67MZfcGe8eq1',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon' => 'color: {{VALUE}};',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hcXRTgPKYfqasNo2dj2k',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon:hover' => 'color: {{VALUE}};',

				],
			]
		);

		$this->end_controls_tab();


		$this->end_controls_tabs();

		$this->add_control(
			'_4f2WU6NGf7wMFuT2x5b6',
			[
				'label' => __('BackGround', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('_b830MgE9c89T7n1OxklV');




		$this->start_controls_tab(
			'tab_eQKTH0lbfZFyeAf2MgGa',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_back',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box .iq-title-icon i',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_rUbtn7aANLzeIJvZx09E',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_hover_back',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box .iq-title-icon:hover i:hover',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'_bfE49enfZIet862YdhaS',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'_ccbj2gc7bQnSxa1LHNkd',
			[
				'label' => __('Icon Size Control', 'iqonic'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'has_font_size',
			[
				'label' => __('Use Custom Icon Size?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Icon Size', 'plugin-domain'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'condition' => ['has_font_size' => 'yes'],
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
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'_O2lwb6NdEe5cnf68hbbI',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'_b0vaQXRe7ab6894e72qi',
			[
				'label' => __('Icon Spacing', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __('Icon Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => __('Icon Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_control(
			'_6r00R9mi8nJcgVc01YIz',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'_mfueG0XoDBUr6tNc96ba',
			[
				'label' => __('Border', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
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
					'{{WRAPPER}} .iq-title-box .iq-title-icon i' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon i' => 'border-color: {{VALUE}};',

				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => __('Border radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box .iq-title-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Title/render.php';
    }
}
