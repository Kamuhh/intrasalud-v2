<?php

namespace Iqonic\Elementor\Elements\Lists;

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
        return 'iqonic_lists';
    }

    public function get_title()
    {
        return __('Iqonic Lists', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-bullet-list';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section',
			[
				'label' => __('Lists', 'iqonic'),
			]
		);

		$this->add_control(
			'list_style',
			[
				'label'      => __('List Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'unorder',
				'options'    => [

					'order'          => __('Order List', 'iqonic'),
					'unorder'          => __('Unorder List', 'iqonic'),
					'icon'          => __('icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),


				],
			]
		);

		$this->add_control(
			'list_style_type_ol',
			[
				'label'      => __('List Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'decimal',
				'options'    => [
					'decimal'          => __('Decimal', 'iqonic'),
					'decimal-leading-zero' => __('Decimal Leading Zero', 'iqonic'),
					'lower-alpha'          => __('Lower Alpha', 'iqonic'),
					'lower-greek'          => __('Lower Greek', 'iqonic'),
					'lower-latin'          => __('Lower Latin', 'iqonic'),
					'lower-roman'          => __('Lower Roman', 'iqonic'),
					'upper-alpha'          => __('Upper Alpha', 'iqonic'),
					'upper-roman'          => __('Upper Roman', 'iqonic'),
				],
				'condition' => [
					'list_style' => 'order',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-list .iq-order-list li' => 'list-style-type: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_style_type_ul',
			[
				'label'      => __('List Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'circle',
				'options'    => [
					'circle' => __('Circle', 'iqonic'),
					'disc'   => __('Disc', 'iqonic'),
					'square' => __('Square', 'iqonic'),

				],
				'condition' => [
					'list_style' => 'unorder',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-list .iq-unoreder-list li' => 'list-style-type: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_column',
			[
				'label'      => __('No. Of column', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'one',
				'options'    => [

					'one'          => __('1 column', 'iqonic'),
					'two'          => __('2 column', 'iqonic'),
					'three'        => __('3 column', 'iqonic'),
					'four'         => __('4 column', 'iqonic'),
					'five' 		   => __('5 column', 'iqonic'),
					'six'		   => __('6 column', 'iqonic'),

				],
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
					'list_style' => 'icon',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-list .iq-list-with-icon li' => 'list-style-type: none;',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __('Image', 'iqonic'),
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
				'label' => __('Title & Description', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Tab Title', 'iqonic'),
				'placeholder' => __('Tab Title', 'iqonic'),
				'label_block' => true,
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
						'tab_title' => __('List Items', 'iqonic'),

					]

				],
				'title_field' => '{{{ tab_title }}}',
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

		$this->start_controls_section(
			'section_6etDdWFTgLOef0R9zMse',
			[
				'label' => __('List', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iq_lists_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}}  .iq-list li',
			]
		);

		$this->start_controls_tabs('iq_lists_tabs');

		$this->start_controls_tab(
			'tabs_rpv2n9KXlxDj14M0La0F',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_list_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list li' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_lists_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-list',
			]
		);


		$this->add_control(
			'iq_lists_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_lists_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'iq_lists_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-list ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_lists_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_lists_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_lists_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_lists_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_lists_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_lists_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_xa5Ad6Ea1dZjeSNHgYzh',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_list_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list li:hover' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_lists_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-list:hover ',
			]
		);


		$this->add_control(
			'iq_lists_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_lists_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => [
					'iq_lists_hover_has_border' => 'yes',
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
					'{{WRAPPER}} .iq-list:hover ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_lists_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_lists_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list:hover' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_lists_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_lists_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_lists_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_lists_hover_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_responsive_control(
			'iq_lists_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_lists_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();

	/* listitem start */

	$this->start_controls_section(
		'section_UxR43b7bcjsZ65dcsfeey0V',
		[
			'label' => __('List Item', 'iqonic'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);
	$this->add_control(
		'service_has_border',
		[
			'label' => esc_html__('Set Custom Border?', 'iqonic'),
			'type' => Controls_Manager::SWITCHER,
			'default' => 'no',
			'yes' => esc_html__('yes', 'iqonic'),
			'no' => esc_html__('no', 'iqonic'),
		]
	);

	$this->add_control(
		'service_border_style',
		[
			'label' => esc_html__('Border Style', 'iqonic'),
			'type' => Controls_Manager::SELECT,
			'condition' => [
				'service_has_border' => 'yes',
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
				'{{WRAPPER}} .kivicare-list-all ' => 'border-style: {{VALUE}};',

			],
		]
	);

	$this->add_control(
		'service_border_color',
		[
			'label' => esc_html__('Border Color', 'iqonic'),
			'type' => Controls_Manager::COLOR,
			'condition' => [
				'service_has_border' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .kivicare-list-all ' => 'border-color: {{VALUE}};',

			],
		]
	);

	$this->add_control(
		'service_border_width',
		[
			'label' => esc_html__('Border Width', 'iqonic'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'condition' => [
				'service_has_border' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .kivicare-list-all ' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_control(
		'service_border_radius',
		[
			'label' => esc_html__('Border Radius', 'iqonic'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'condition' => [
				'service_has_border' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .kivicare-list-all' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);


	$this->end_controls_section();
 

		/*Fancy Icon start*/

		$this->start_controls_section(
			'section_UxR43bcXm9c7bcjeey0V',
			[
				'label' => __('List Icon/Image', 'iqonic'),
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
					'{{WRAPPER}} .iq-list-with-icon li i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('Fancybox_icon_tabs');
		$this->start_controls_tab(
			'tabs_8O8eC1f3ecBWhTpj9AlJ',
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
					'{{WRAPPER}} .iq-list-with-icon li i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_list_icon_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img',
			]
		);

		$this->add_control(
			'iq_list_icon_border_style',
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
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_list_icon_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_list_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_list_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_oQUHWq6F3sZfKh75bNzd',
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
					'{{WRAPPER}} .iq-list-with-icon li:hover i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_list_icon_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => ' {{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img',
			]
		);


		$this->add_control(
			'iq_list_icon_hover_border_style',
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
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-list-with-icon li i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_list_icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_list_icon_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Lists/render.php';
    }
}
