<?php

namespace Iqonic\Elementor\Elements\FancyBox;

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
        return 'iqonic_fancybox';
    }

    public function get_title()
    {
        return __('Iqonic FancyBox', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-icon-box';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_hd84m01bE0apigBn95o3',
			[
				'label' => __('Fancy Box Style', 'iqonic'),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Select Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '7',
				'options'    => [
					'4'          => __('Style-1', 'iqonic'),
					'7'          => __('Style-2', 'iqonic'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section',
			[
				'label' => __('FancyBox', 'iqonic'),
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

				]
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

				]
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
				]
			]
		);

		$this->add_control(
			'active_onoff',
			[
				'label' => __('Is Active', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
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
					]
				]
			]
		);


		$this->end_controls_section();
		/*Button Start*/

        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
		/*Button End*/

		/*Fancy Box start*/

		$this->start_controls_section(
			'section_Q6mN5ctWhXf7ea90VPz5',
			[
				'label' => __('Fancybox', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs('Fancybox_tabs');
		$this->start_controls_tab(
			'tabs_MH3BIO7c384gsSryDblf',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box,{{WRAPPER}} .iq-fancy-box-style-4 .iq-fancy-box-content ',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_fancybox_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-fancy-box,{{WRAPPER}} .iq-fancy-box-style-4 .iq-fancy-box-content',
			]
		);

		$this->add_control(
			'section_kf55cBzVoaLG6qacS3Na',
			[
				'label' => __('Before Background ', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style' => ['4']],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_before_background',
				'label' => __('Before Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'condition' => ['design_style' => ['4']],
				'selector' => '{{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-4:before ,{{WRAPPER}} .iq-fancy-box-style-6:before',
			]
		);



		$this->add_control(
			'iq_fancybox_border_style',
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
					'{{WRAPPER}} .iq-fancy-box' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_fancybox_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_fancybox_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_fancybox_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_K6bEb6i9508300v8ase1',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box:hover,{{WRAPPER}} .iq-fancy-box.acitve,
				{{WRAPPER}} .iq-fancy-box-style-1:hover:before,
				 {{WRAPPER}} .iq-fancy-box-style-1.active:before,
				 {{WRAPPER}} .iq-fancy-box-style-4:hover .iq-fancy-box-content,
				  {{WRAPPER}} .iq-fancy-box-style-4.active .iq-fancy-box-content,
				  {{WRAPPER}} .iq-fancy-box-style-5:hover:before,
				 {{WRAPPER}} .iq-fancy-box-style-5.active:before,
				 {{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-6:hover,
				  {{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-6.active,
				 {{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-6:hover:before,
				 {{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-6.active:before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_fancybox_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-fancy-box:hover,{{WRAPPER}} .iq-fancy-box-style-4 .iq-fancy-box-content:hover,{{WRAPPER}} .iq-fancy-box.active,{{WRAPPER}} .iq-fancy-box-style-4 .iq-fancy-box-content.active',
			]
		);
		$this->add_control(
			'section_076OcwvUjJbiXADeQgK9',
			[
				'label' => __('Before Background ', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style' => ['4', '6']],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_before_hover_background',
				'label' => __('Before Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'condition' => ['design_style' => ['4', '6']],
				'selector' => '{{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-4:hover:before ,{{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-4.active:before,{{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-6:hover:before ,{{WRAPPER}} .iq-fancy-box-style-6.active:before ',
			]
		);

		$this->add_control(
			'iq_fancybox_hover_border_style',
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
					'{{WRAPPER}} .iq-fancy-box:hover,{{WRAPPER}} .iq-fancy-box.acitve,{{WRAPPER}} .iq-fancy-box-style-1:hover:before,
				 {{WRAPPER}} .iq-fancy-box-style-1.active:before' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_fancybox_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover ,{{WRAPPER}} .iq-fancy-box.acitve,{{WRAPPER}} .iq-fancy-box-style-1:hover:before,
				 {{WRAPPER}} .iq-fancy-box-style-1.active:before' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_fancybox_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover,{{WRAPPER}} .iq-fancy-box.acitve,{{WRAPPER}} .iq-fancy-box-style-1:hover:before,
				 {{WRAPPER}} .iq-fancy-box-style-1.active:before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_fancybox_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover,{{WRAPPER}} .iq-fancy-box.acitve,{{WRAPPER}} .iq-fancy-box-style-1:hover:before,
				 {{WRAPPER}} .iq-fancy-box-style-1.active:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_fancybox_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  , {{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-4 .iq-fancy-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_fancybox_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box , {{WRAPPER}} .iq-fancy-box.iq-fancy-box-style-4 .iq-fancy-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_section();

		/* Fancy Box  End*/

		/*Fancy Icon start*/

		$this->start_controls_section(
			'section_5j51b9yGeuYfcNkF8bUa',
			[
				'label' => __('Fancybox Icon/Image', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __('Icon Size <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
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
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('Fancybox_icon_tabs');
		$this->start_controls_tab(
			'tabs_gPcbi95Jw7su4FkZWdvx',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __('Choose Color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area i' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_icon_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box .iq-img-area,{{WRAPPER}} .iq-fancy-box-style-6 .iq-img-area:before',
			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_style',
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
					'{{WRAPPER}} .iq-fancy-box .iq-img-area' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area, {{WRAPPER}} .iq-fancy-box .iq-img-area img,{{WRAPPER}} .iq-fancy-box-style-6 .iq-img-area:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_kh0UTfec4SuGvORHF50V',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __('Choose Color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-img-area i,{{WRAPPER}} .iq-fancy-box.active .iq-img-area i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_icon_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => ' {{WRAPPER}} .iq-fancy-box:hover .iq-img-area,
				 {{WRAPPER}} .iq-fancy-box.active .iq-img-area ,{{WRAPPER}} .iq-fancy-box-style-6:hover .iq-img-area:before,{{WRAPPER}} .iq-fancy-box-style-6.active .iq-img-area:before',
			]
		);


		$this->add_control(
			'iq_fancybox_icon_hover_border_style',
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
					'{{WRAPPER}} .iq-fancy-box:hover .iq-img-area,
				 {{WRAPPER}} .iq-fancy-box.active .iq-img-area' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_fancybox_icon_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-img-area,{{WRAPPER}} .iq-fancy-box.active .iq-img-area' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_fancybox_icon_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-img-area,{{WRAPPER}} .iq-fancy-box.active .iq-img-area' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_fancybox_icon_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-img-area,{{WRAPPER}} .iq-fancy-box.active .iq-img-area, {{WRAPPER}} .iq-fancy-box:hover .iq-img-area img,{{WRAPPER}} .iq-fancy-box.active .iq-img-area img,{{WRAPPER}} .iq-fancy-box-style-6:hover .iq-img-area:before,{{WRAPPER}} .iq-fancy-box-style-6.active .iq-img-area:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'icon_width',
			[
				'label' => __('Width', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area,{{WRAPPER}} .iq-fancy-box-style-6 .iq-img-area:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label' => __('Height', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area , {{WRAPPER}} .iq-fancy-box .iq-img-area i , {{WRAPPER}} .iq-fancy-box-style-6 .iq-img-area:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-fancy-box .iq-img-area i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_fancybox_icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_fancybox_icon_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .iq-img-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Fancy Box  icon*/

		/* Fancybox Title start*/

		$this->start_controls_section(
			'section_8cHVvYcmq8izaFafIbhk',
			[
				'label' => __('Fancybox Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __('Title Tag', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h5',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_content_text_typography',
				'label' => __('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-fancy-box  .iq-fancy-title',
			]
		);

		$this->start_controls_tabs('fancybox_title_tabs');
		$this->start_controls_tab(
			'tabs_YdgkAl8cefKGbhtwj1q9',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'fancybox_title_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .iq-fancy-title' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_title_background',
				'label' => __('Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box  .iq-fancy-title',
			]
		);

		$this->add_control(
			'fancybox_title_border_style',
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
					'{{WRAPPER}} .iq-fancy-box  .iq-fancy-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'fancybox_title_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .iq-fancy-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'fancybox_title_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .iq-fancy-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'fancybox_title_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .iq-fancy-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_Vyt0bR9UWgwap8Z6KffH',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'fancybox_title_hover_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-fancy-title, {{WRAPPER}} .iq-fancy-box.active .iq-fancy-title' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_title_hover_background',
				'label' => __('Title Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box.active .iq-fancy-title',
			]
		);

		$this->add_control(
			'fancybox_title_hover_border_style',
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
					'{{WRAPPER}} .iq-fancy-box:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box.active .iq-fancy-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'fancybox_title_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box.active .iq-fancy-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'fancybox_title_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box.active .iq-fancy-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'fancybox_title_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box.active .iq-fancy-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'fancybox_title_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box   .iq-fancy-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'fancybox_title_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box  .iq-fancy-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
		/* Fancybox Title End*/

		/* Fancybox Content start*/
		$this->start_controls_section(
			'section_ZxvGgo55PfOdqt0zIjsA',
			[
				'label' => __('Fancybox Description', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_content_text_typography',
				'label' => __('Description Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-fancy-box  .fancy-box-content',
			]
		);

		$this->start_controls_tabs('fancybox_desc_tabs');
		$this->start_controls_tab(
			'tabs_M9Yca4P37zNTau5899G5',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'fancybox_desc_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box .fancy-box-content' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_desc_background',
				'label' => __('Icon Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box  .fancy-box-content',
			]
		);

		$this->add_control(
			'fancybox_desc_border_style',
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
					'{{WRAPPER}} .iq-fancy-box  .fancy-box-content' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'fancybox_desc_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .fancy-box-content' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'fancybox_desc_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .fancy-box-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'fancybox_desc_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box  .fancy-box-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_c0c6aiA3OoHMrP9lR818',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'fancybox_desc_hover_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box.active .fancy-box-content' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_desc_hover_background',
				'label' => __('Icon Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-fancy-box:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box.active .fancy-box-content',
			]
		);

		$this->add_control(
			'fancybox_desc_hover_border_style',
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
					'{{WRAPPER}} .iq-fancy-box:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box.active .fancy-box-content' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'fancybox_desc_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box.active .fancy-box-content' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'fancybox_desc_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box.active .fancy-box-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'fancybox_desc_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box.active .fancy-box-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'fancybox_desc_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box  .fancy-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);



		$this->add_responsive_control(
			'fancybox_desc_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box  .fancy-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
		/* Fancybox Description End*/

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/FancyBox/render.php';
    }
}
