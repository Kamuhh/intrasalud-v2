<?php

namespace Iqonic\Elementor\Elements\IconBox_List;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use \Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
	public function get_name()
	{
		return 'iqonic_icon_list';
	}

	public function get_title()
	{
		return esc_html__('Iqonic Iconlist', 'iqonic');
	}

	public function get_categories()
	{
		return ['iqonic-extension'];
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-icon-box';
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section',
			[
				'label' => esc_html__('Iconbox With List ', 'iqonic'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => esc_html__('Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__('Add Your Title Text Here', 'iqonic'),
			]
		);
		
		$this->add_control(
			'media_style',
			[
				'label'      => esc_html__('Icon / Image', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'icon',
				'options'    => [

					'icon'          => esc_html__('Icon', 'iqonic'),
					'image'          => esc_html__('Image', 'iqonic'),
					'text'          => esc_html__('Text', 'iqonic'),
					'none'          => esc_html__('None', 'iqonic'),

				]
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__('Icon', 'iqonic'),
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
				'label' => esc_html__('Choose Image', 'iqonic'),
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
			'choose_text',
			[
				'label' => esc_html__('Choose Text', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'media_style' => 'text',
				],
				'label_block' => true,
				'default' => esc_html__('$29', 'iqonic'),
			]
		);
		
		$this->add_control(
			'display_list',
			[
				'label' => esc_html__('Display List', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'yes' => esc_html__('yes', 'iqonic'),
				'no' => esc_html__('no', 'iqonic'),
			]
		);

	

		$this->end_controls_section();



		/* List Section*/
		$this->start_controls_section(
			'section_Geu9beBjZK1b086Tf3q7',
			[
				'label' => esc_html__('List', 'iqonic'),

			]
		);

		$this->add_control(
			'list_style',
			[
				'label'      => esc_html__('List Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'icon',
				'options'    => [
					'icon'          => esc_html__('icon', 'iqonic'),
					'image'          => esc_html__('Image', 'iqonic'),
				],
			]
		);
	

		$this->add_control(
			'list_icon',
			[
				'label' => esc_html__('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'

				],
				'condition' => [
					'list_style' => 'icon',
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list .kivicare-list-with-icon li' => 'list-style-type: none;',
				],
			]
		);

		$this->add_control(
			'list_image',
			[
				'label' => esc_html__('Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'list_style' => 'image',
				],
			]
		);

	
		$repeater = new Repeater();
		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__('List Items', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('List Item', 'iqonic'),
				'placeholder' => esc_html__('Tab Title', 'iqonic'),
				'label_block' => true,
			]
		);


		$this->add_control(
			'tabs',
			[
				'label' => esc_html__('Lists Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__('List Items', 'iqonic'),

					]

				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label' => esc_html__('Show Button', 'iqonic'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'iqonic'),
				'label_off' => esc_html__('Hide', 'iqonic'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		/* List Section End*/

		$this->end_controls_section();

		/*Button Start*/
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
		/*Button End*/
		
		/*Icon Box start*/

		$this->start_controls_section(
			'section_NdRqkC1e0bI553e1b2fX',
			[
				'label' => esc_html__('Iconbox', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('Iconbox_tabs');
		$this->start_controls_tab(
			'tabs_NdRqkC1e0bI553e1b2fX',
			[
				'label' => esc_html__('Normal', 'iqonic'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_background',
				'label' => esc_html__('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_icon_box_list_shadow',
				'label' => esc_html__('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list',
			]
		);

		$this->add_control(
			'iq_iconbox_has_border',
			[
				'label' => esc_html__('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => esc_html__('yes', 'iqonic'),
				'no' => esc_html__('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq_iconbox_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'iq_iconbox_has_border' => 'yes',
				],
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_iconbox_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'condition' => [
					'iq_iconbox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_iconbox_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'condition' => [
					'iq_iconbox_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_iconbox_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'condition' => [
					'iq_iconbox_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_5ZASitWXe7aGDw5U7Lbz',
			[
				'label' => esc_html__('Hover', 'iqonic'),
			]
		);



		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_hover_background',
				'label' => esc_html__('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list:hover,{{WRAPPER}} .kivicare-icon-box-list.acitve'

			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_icon_box_list_shadow_hover',
				'label' => esc_html__('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list:hover',
			]
		);

		$this->add_control(
			'iq_iconbox_hover_has_border',
			[
				'label' => esc_html__('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => esc_html__('yes', 'iqonic'),
				'no' => esc_html__('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq_iconbox_hover_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'iq_iconbox_hover_has_border' => 'yes',
				],
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),
				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq_iconbox_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'condition' => [
					'iq_iconbox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq_iconbox_hover_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'condition' => [
					'iq_iconbox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_iconbox_hover_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'condition' => [
					'iq_iconbox_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'divider_89V9pWsezJHkflibIA90',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);


		$this->add_responsive_control(
			'iq_iconbox_padding',
			[
				'label' => esc_html__('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' , 'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_iconbox_margin',
			[
				'label' => esc_html__('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' , 'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();

		/* icon Box  End*/

		/*iconlist Icon start*/

		$this->start_controls_section(
			'section_1zTpb6WY9f210c8R3Fhr',
			[
				'label' => esc_html__('Iconbox Icon/Image', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'has_icon_size',
			[
				'label' => esc_html__('Set Custom Icon Size?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => esc_html__('yes', 'iqonic'),
				'no' => esc_html__('no', 'iqonic'),
				'condition'=>['media_style'=>'icon']
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__('Icon Size', 'iqonic'),
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
				'condition' => ['has_icon_size' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area i,
					{{WRAPPER}} .iq-icon-box-list .iq-img-area' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('_cbNonlL191pcPbB9h28v');
		$this->start_controls_tab(
			'tabs_WmyT8vBx3MR89Xba9eKC',
			[
				'label' => esc_html__('Normal', 'iqonic'),
			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area i,
					{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'color: {{VALUE}};',
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area i,
					{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'fill: {{VALUE}};',
				],

			]

		);

		$this->add_control(
			'iq_iconbox_icon_background',
			[
				'label' => esc_html__('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'border-style: {{VALUE}};',

				],
			]
		);

		

		$this->add_control(
			'iq_iconbox_icon_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_yr3Gedx7RB8VCu7ktg7S',
			[
				'label' => esc_html__('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-img-area i,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-img-area i,{{WRAPPER}} .iq-icon-box-list:hover .iq-img-area ,{{WRAPPER}} .iq-icon-box-list.active .iq-img-area ' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_hover_background',
				'label' => esc_html__('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => ' {{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-img-area,
				 {{WRAPPER}} .kivicare-icon-box-list.active .kivicare-img-area ,{{WRAPPER}} .kivicare-icon-box-list-style-6:hover .kivicare-img-area:before,{{WRAPPER}} .iq-icon-box-list-style-6.active .iq-img-area:before',
			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-img-area,
				 {{WRAPPER}} .kivicare-icon-box-list.active .kivicare-img-area' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-img-area,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-img-area' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-img-area,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-img-area' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-img-area,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-img-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'divider_Q1jNG1bxD9dse8kfu3T7',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__('Width', 'iqonic'),
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
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area,{{WRAPPER}} .kivicare-icon-box-list-style-6 .kivicare-img-area:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label' => esc_html__('Height', 'iqonic'),
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
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area , {{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area i' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area i,{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area ' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_iconbox_icon_padding',
			[
				'label' => esc_html__('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_iconbox_icon_margin',
			[
				'label' => esc_html__('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list .kivicare-img-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();

		/* icon Box  icon*/



		/* iconbox Title start*/

		$this->start_controls_section(
			'section_Q1jNG1bxD9dse8kfu3T7',
			[
				'label' => esc_html__('iconbox Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => esc_html__('Title Tag', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h4',
				'options'    => [

					'h1'          => esc_html__('h1', 'iqonic'),
					'h2'          => esc_html__('h2', 'iqonic'),
					'h3'          => esc_html__('h3', 'iqonic'),
					'h4'          => esc_html__('h4', 'iqonic'),
					'h5'          => esc_html__('h5', 'iqonic'),
					'h6'          => esc_html__('h6', 'iqonic'),

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_content_text_typography',
				'label' => esc_html__('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title',
			]
		);

		$this->start_controls_tabs('tabs_74hO776fjer38coDbCa1');
		$this->start_controls_tab(
			'tabs_ueEfbr5177bm77Fcwd33',
			[
				'label' => esc_html__('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'iconbox_title_color',
			[
				'label' => esc_html__('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_title_background',
				'label' => esc_html__('Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title',
			]
		);

		$this->add_control(
			'iconbox_title_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iconbox_title_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iconbox_title_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iconbox_title_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list  .kivicare-icon-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_77Al1eF4QO9d48273Ete',
			[
				'label' => esc_html__('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'iconbox_title_hover_color',
			[
				'label' => esc_html__('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-icon-title, {{WRAPPER}} .kivicare-icon-box-list.active .kivicare-icon-title' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_title_hover_background',
				'label' => esc_html__('Title Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-icon-title,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-icon-title',
			]
		);

		$this->add_control(
			'iconbox_title_hover_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-icon-title,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-icon-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iconbox_title_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-icon-title,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-icon-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iconbox_title_hover_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-icon-title,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-icon-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iconbox_title_hover_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-icon-box-list:hover .kivicare-icon-title,{{WRAPPER}} .kivicare-icon-box-list.active .kivicare-icon-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iconbox_title_padding',
			[
				'label' => esc_html__('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}}  .kivicare-icon-box-list   .kivicare-icon-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iconbox_title_margin',
			[
				'label' => esc_html__('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}}  .kivicare-icon-box-list  .kivicare-icon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
		/* iconbox Title End*/



		$this->start_controls_section(
			'section_cF58Y7Ih1bt0zxf8Dn1i',
			[
				'label' => esc_html__('List', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);



		$this->start_controls_tabs('iq_lists_tabs');

		$this->start_controls_tab(
			'tabs_350c1a5XeRKaHFbx0P8e',
			[
				'label' => esc_html__('Normal', 'iqonic'),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iq_lists_text_typography',
				'label' => esc_html__('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}}  .kivicare-list li',
			]
		);

		$this->add_control(
			'iq_list_color',
			[
				'label' => esc_html__('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-list li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tabs_WFvIG3TMan19Dswpj8K8',
			[
				'label' => esc_html__('Hover', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iq_lists_text_typography_hover',
				'label' => esc_html__('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}}  .kivicare-list li:hover',
			]
		);

		$this->add_control(
			'iq_list_color_hover',
			[
				'label' => esc_html__('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-list li:hover' => 'color: {{VALUE}};',
				],

			]

		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

		/*Iconlist Icon start*/

		$this->start_controls_section(
			'section_XZGzehHLI52s8a35jep1',
			[
				'label' => esc_html__('List Icon/Image', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_size_list',
			[
				'label' => esc_html__('Icon Size', 'iqonic'),
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
					'{{WRAPPER}} .kivicare-list-with-icon li i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('tabs_5fej35C77eNFw1rdB6vh');
		$this->start_controls_tab(
			'tabs_kxST1whl8s3KcY37j7Q5',
			[
				'label' => esc_html__('Normal', 'iqonic'),
			]
		);


		$this->add_control(
			'icon_color_list',
			[
				'label' => esc_html__('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_list_icon_background_list',
				'label' => esc_html__('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img',
			]
		);

		$this->add_control(
			'iq_list_icon_border_style_list',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_list_icon_border_color_list',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_list_icon_border_width_list',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_list_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_CP35pHb96ScOZJK912q4',
			[
				'label' => esc_html__('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_hover_color_list',
			[
				'label' => esc_html__('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li:hover i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_list_icon_hover_background',
				'label' => esc_html__('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => ' {{WRAPPER}} .kivicare-list-with-icon li:hover i,{{WRAPPER}} .kivicare-list-with-img li:hover img',
			]
		);


		$this->add_control(
			'iq_list_icon_hover_border_style',
			[
				'label' => esc_html__('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'  => esc_html__('Solid', 'iqonic'),
					'dashed' => esc_html__('Dashed', 'iqonic'),
					'dotted' => esc_html__('Dotted', 'iqonic'),
					'double' => esc_html__('Double', 'iqonic'),
					'outset' => esc_html__('outset', 'iqonic'),
					'groove' => esc_html__('groove', 'iqonic'),
					'ridge' => esc_html__('ridge', 'iqonic'),
					'inset' => esc_html__('inset', 'iqonic'),
					'hidden' => esc_html__('hidden', 'iqonic'),
					'none' => esc_html__('none', 'iqonic'),

				],

				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li:hover i,{{WRAPPER}} .kivicare-list-with-img li:hover img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li:hover i,{{WRAPPER}} .kivicare-list-with-img li:hover img' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_width',
			[
				'label' => esc_html__('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li:hover i,{{WRAPPER}} .kivicare-list-with-img li:hover img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_radius',
			[
				'label' => esc_html__('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i:hover,{{WRAPPER}} .kivicare-list-with-img li img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'icon_width_list',
			[
				'label' => esc_html__('Width', 'iqonic'),
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
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height_list',
			[
				'label' => esc_html__('Height', 'iqonic'),
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
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .kivicare-list-with-icon li i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_list_icon_padding',
			[
				'label' => esc_html__('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_list_icon_margin',
			[
				'label' => esc_html__('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-list-with-icon li i,{{WRAPPER}} .kivicare-list-with-img li img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();

		/* Icon Box  icon*/
	}

	protected function render()
	{
		require   'render.php';
	}
}
