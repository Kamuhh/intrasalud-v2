<?php

namespace Iqonic\Elementor\Elements\TitleSlider;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'section_title_slider';
    }

    public function get_title()
    {
        return __('Section Title Slider', 'iqonic');
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
			'st_section_style',
			[
				'label' => __('Style', 'iqonic'),
			]
		);

		$this->add_control(
			'st_design_style',
			[
				'label'      => __('Design Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [

					'1'          => __('Style 1', 'iqonic'),
					'2'          => __('Style 2', 'iqonic'),

				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style1',
			[
				'label' => __('Section Title', 'iqonic'),
				'condition' =>  [
					'st_design_style' => ['2'],
				],

			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'st_title_2',
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
		$repeater->add_control(
			'st_subtitle_2',
			[
				'label' => __('Sub Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __('Add Your Title Text Here', 'iqonic'),
			]
		);

		$repeater->add_control(
			'st_media_style2',
			[
				'label'      => __('Icon / Image', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'image',
				'options'    => [

					'icon'          => __('Icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),
					'none'          => __('None', 'iqonic'),

				]
			]
		);

		$repeater->add_control(
			'st_icon2',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'st_media_style2' => 'icon',
				],
				'default' => [
					'value' => 'fas fa-star'

				]
			]
		);

		$repeater->add_control(
			'st_image2',
			[
				'label' => __('Choose Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'st_media_style2' => 'image',
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'title_tag2',
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

		$repeater->add_control(
			'st_button_text',
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

		$repeater->add_control(
			'st_button_icon',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'

				]
			]
		);

		$repeater->add_control(
			'st_link',
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
			'tabs2',
			[
				'label' => __('Lists Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'st_title_2' => __('Title', 'iqonic'),

					]

				],
				'title_field' => '{{{ st_title_2 }}}',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'section',
			[
				'label' => __('Section Title', 'iqonic'),
				'condition' =>  [
					'st_design_style' => ['1'],
				],

			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
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
		$repeater->add_control(
			'media_style',
			[
				'label'      => __('Media Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'none',
				'options'    => [

					'none'          => __('none', 'iqonic'),
					'icon'          => __('icon', 'iqonic'),
					'image'        => __('image', 'iqonic'),
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'

				],
				'condition' => [
					'media_style' => 'icon',
				],

			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __('Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],

				'condition' => [
					'media_style' => 'image',
				],
			]
		);

		$repeater->add_control(
			'has_description',
			[
				'label' => __('Has Description?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
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
				'default' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic'),
				'condition' => ['has_description' => 'yes']
			]
		);
		$repeater->add_control(
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
			'tabs',
			[
				'label' => __('Lists Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'section_title' => __('Title', 'iqonic'),

					]

				],
				'title_field' => '{{{ section_title }}}',
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
			'alignment',
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
					]
				],
				'default' => 'text-left',
			]
		);

		$this->end_controls_section();




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
				'selector' => '{{WRAPPER}} .iq-title-box-slider,.iq-title-box-slider-two',
			]
		);

		$this->add_control(
			'titlebox_before_color',
			[
				'label' => __('Before Color <br> <span style="color: #5bc0de"> (Note : working only for style1) </span>', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-title-box-slider.owl-carousel:before' => 'border-color: transparent transparent {{VALUE}} transparent;',
				],


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
					'{{WRAPPER}} .iq-title-box-slider ' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two ' => 'border-style: {{VALUE}};',

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
					'{{WRAPPER}} .iq-title-box-slider' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .iq-title-box-slider' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-title-box-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .iq-title-box-slider:hover,.iq-title-box-slider-two:hover ',
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
					'{{WRAPPER}} .iq-title-box-slider:hover' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two:hover' => 'border-style: {{VALUE}};',

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
					'{{WRAPPER}} .iq-title-box-slider:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .iq-title-box-slider:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-title-box-slider:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-title-box-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}  .iq-title-box-slider-two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-title-box-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}  .iq-title-box-slider-two' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .iq-title-box-slider .iq-title, .iq-title-box-slider-two .iq-title',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two .iq-title' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box-slider .iq-title',
				'selector' => '{{WRAPPER}} .iq-title-box-slider-two .iq-title',
			]
		);

		$this->add_control(
			'Iq_Title_Slider_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'Iq_Title_Slider_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two .iq-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'Iq_Title_Slider_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box-slider .iq-title' => 'border-color: {{VALUE}};',
					'{{WRAPPER}}  .iq-title-box-slider-two .iq-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'Iq_Title_Slider_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box-slider .iq-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}  .iq-title-box-slider-two .iq-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'Iq_Title_Slider_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box-slider .iq-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}  .iq-title-box-slider-two .iq-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two .iq-title:hover' => 'color: {{VALUE}};',
				],


			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_hover_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-title-box-slider:hover .iq-title, .iq-title-box-slider-two .iq-title',
			]

		);


		$this->add_control(
			'Iq_Title_Slider_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'Iq_Title_Slider_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-title-box-slider:hover .iq-title' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two:hover .iq-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'Iq_Title_Slider_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box-slider:hover .iq-title' => 'border-color: {{VALUE}};',
					'{{WRAPPER}}  .iq-title-box-slider-two:hover .iq-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'Iq_Title_Slider_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box-slider:hover .iq-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}  .iq-title-box-slider-two:hover .iq-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

				],

			]
		);

		$this->add_control(
			'Iq_Title_Slider_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'Iq_Title_Slider_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-title-box-slider:hover .iq-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}  .iq-title-box-slider-two:hover .iq-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two .iq-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two .iq-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_section();

		// Description Style Section
		$this->start_controls_section(
			'section_ZcASngaa14lc8er55aND',
			[
				'label' => __('Description', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-title-box-slider .text-slider-content .iq-title-desc',
			]
		);

		$this->add_responsive_control(
			'desciption_marging',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-title-box-slider .iq-title-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two .slider-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iq-title-box-slider-two .slider-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

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
					'{{WRAPPER}} .iq-title-box-slider .iq-title-desc' => 'color: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two .slider-desc' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .iq-title-box-slider .iq-title-desc:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .iq-title-box-slider-two .slider-desc:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		
		$this->end_controls_section();

		$this->start_controls_section(
			'owl_control_section',
			[
				'label' => __('Slider Control', 'iqonic'),
			]
		);

		require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/owl-control.php';

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/TitleSlider/render.php';
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
