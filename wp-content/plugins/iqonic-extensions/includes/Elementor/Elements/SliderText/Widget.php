<?php

namespace Iqonic\Elementor\Elements\SliderText;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'Iq_Slider_With_Text';
    }

    public function get_title()
    {
        return __('Iqonic Slider With Text', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section_8weFRbC075mgara3qa2f',
			[
				'label' => __('Slider With Text Style', 'iqonic'),
			]
		);

		$this->add_control(
			'design_style',
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
			'section_slider',
			[
				'label' => __('Iqonic Slider With Text', 'iqonic'),
			]
		);

		$rep1 = new Repeater();
		$rep1->add_control(
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

			]
		);
		$rep1->add_control(
			'tab_title',
			[
				'label' => __('Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Tab Title', 'iqonic'),
				'placeholder' => __('Tab Title', 'iqonic'),
				'label_block' => true,
			]
		);

		$rep1->add_control(
			'description',
			[
				'label' => __('Description', 'iqonic'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter Title Description', 'iqonic'),
				'default' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic')

			]
		);

		$rep1->add_control(
			'tab_date',
			[
				'label' => __('Date', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Tab Date', 'iqonic'),
				'placeholder' => __('2006', 'iqonic'),
				'label_block' => true,


			]
		);

		$this->add_control(
			'rep_tabs1',
			[
				'label' => __('Lists Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $rep1->get_controls(),
				'default' => [
					[
						'tab_title' => __('List Items', 'iqonic'),
					]
				],
				'condition' =>  [
					'design_style' => ['2'],
				],
				'title_field' => '{{{ tab_date }}}',
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

		$repeater->add_control(
			'description',
			[
				'label' => __('Description', 'iqonic'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter Title Description', 'iqonic'),
				'default' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic')

			]
		);

		$repeater->add_control(
			'media_style',
			[
				'label'      => __('List Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'image',
				'options'    => [

					'icon'          => __('icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),


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
				'selectors' => [
					'{{WRAPPER}} .iq-list .iq-list-with-icon li' => 'list-style-type: none;',
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __('Event Image', 'iqonic'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_style' => 'image',
				],
			]
		);

		$repeater->add_control(
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
				]
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
				'condition' =>  [
					'design_style' => ['1'],
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_jt2BxXQMdC0cZpKb9Y14',
			[
				'label' => __('Button', 'iqonic'),
				'condition' =>  [
					'design_style' => ['1'],
				],
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


		$this->end_controls_section();


		$this->start_controls_section(
			'section_GidcK4ls2IL0a9z5wbP6',
			[
				'label' => __('Button Container', 'iqonic'),
				'condition' =>  [
					'design_style' => ['1'],
				],
				'tab' => Controls_Manager::TAB_STYLE,

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
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-button',
			]
		);

		$this->add_control(
			'icon_spacing_left',
			[
				'label' => __('Icon Spacing', 'iqonic'),
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
				'condition' => ['icon_position' => 'left', 'has_icon' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button.has-icon.btn-icon-left i,{{WRAPPER}} .iq-button.has-icon.btn-icon-left svg' => 'margin-right: {{SIZE}}{{UNIT}};'

				],
			]
		);
		$this->add_control(
			'icon_spacing_right',
			[
				'label' => __('Icon Spacing', 'iqonic'),
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
				'condition' => ['icon_position' => 'right', 'has_icon' => 'yes'],
				'selectors' => [

					'{{WRAPPER}} .iq-button.has-icon.btn-icon-right i,{{WRAPPER}} .iq-button.has-icon.btn-icon-right svg' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'set_icon_size',
			[
				'label' => __('Set Icon Size?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __('Yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
				'return_value' => 'yes',
				'default' => 'no',
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
						'step' => 1,
					],
				],
				'condition' => ['set_icon_size' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button i,{{WRAPPER}} .iq-button svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-button.has-icon.btn-icon-right i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('contact_tabs');
		$this->start_controls_tab(
			'tabs_vc4ga9cZhb6bcNWdJbMp',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .iq-slider-with-text .btn-icon-right' => 'color: {{VALUE}} !important;',
				],

			]
		);
		$this->add_control(
			'text_icon_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-btn-container .iq-button i,{{WRAPPER}} .iq-btn-container .iq-button svg' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'data_background',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => ['iq-btn-flat', 'default', 'iq-btn-outline']
				],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'background: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'has_border_style',
			[
				'label' => __('Has Custom Border Style?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'data_border',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['has_border_style' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-color: {{VALUE}};',
				],


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

				'condition' => ['has_border_style' => 'yes'],

				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['has_border_style' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['has_border_style' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_OlfLAZaexcXSaR1IGQ95',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'data_hover_text',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'color: {{VALUE}} !important;',
				],

			]
		);
		$this->add_control(
			'text_icon_hover_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-button:hover i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'data_hover',
			[
				'label' => __('Hover Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => ['iq-btn-flat', 'default', 'iq-btn-outline']
				],
				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'background: {{VALUE}};',
				],

			]
		);
		
		$this->add_control(
			'data_hover_border_outline',
			[
				'label' => __('Hover Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['has_border_style' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'data_hover_border_style',
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

				'condition' => ['has_border_style' => 'yes'],

				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'data_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['has_border_style' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'data_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['has_border_style' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'container_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_bZxDecfIlJCcbhted48u',
			[
				'label' => __('Slider Icon <br> <span style="color: #5bc0de"> (Note : icon portion apply only for icon) </span>', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'set_slider_icon_size',
			[
				'label' => __('Set Icon Size?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __('Yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'slider_icon_size',
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
						'step' => 1,
					],
				],
				'condition' => ['set_slider_icon_size' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .iq-slider-nav i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('slider_icon_tabs');
		$this->start_controls_tab(
			'tabs_L7qc4NicKazBtOXIJyP0',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);


		$this->add_control(
			'slider_icon_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .iq-slider-nav i' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'slider_icon_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}  .iq-slider-with-text .iq-slider-nav i',
			]
		);

		$this->add_control(
			'iq_iconbox_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'slider_icon_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => ['iq_iconbox_has_border' => ['yes']],
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
					'{{WRAPPER}}  .iq-slider-with-text .iq-slider-nav i' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'slider_icon_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => ['iq_iconbox_has_border' => ['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .iq-slider-nav i' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'slider_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => ['iq_iconbox_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .iq-slider-nav i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'slider_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => ['iq_iconbox_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .iq-slider-nav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_dXYRcwcZ5G57Vb2bmN9a',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .slider-nav li.slick-current i,{{WRAPPER}}  .iq-slider-with-text .slider-nav li:hover i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'slider_icon_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-nav li.slick-current i,{{WRAPPER}}  .iq-slider-with-text .slider-nav li:hover i',
			]
		);

		$this->add_control(
			'iq_iconbox_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'slider_icon_hover_border_style',
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
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],

				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-nav li.slick-current i,{{WRAPPER}}  .iq-slider-with-text .slider-nav li:hover i' => 'border-style: {{VALUE}};',


				],
			]
		);

		$this->add_control(
			'slider_icon_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-nav li.slick-current i,{{WRAPPER}}  .iq-slider-with-text .slider-nav li:hover i' => 'border-color: {{VALUE}};',
				],


			]
		);


		$this->add_control(
			'slider_icon_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-nav li.slick-current i,{{WRAPPER}}  .iq-slider-with-text .slider-nav li:hover i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'slider_icon_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-nav li.slick-current i,{{WRAPPER}}  .iq-slider-with-text .slider-nav li:hover i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-slider-with-text .slider-nav li i' => 'width: {{SIZE}}{{UNIT}};',
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

					'{{WRAPPER}} .iq-slider-with-text .slider-nav li i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'slider_icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-nav li i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'slider_icon_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-nav li i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();


		/* Iconbox Title start*/

		$this->start_controls_section(
			'section_gVc1aIHhbaQejs4834AB',
			[
				'label' => __('Slider Title', 'iqonic'),
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
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title',
			]
		);

		$this->start_controls_tabs('slider_title_tabs');
		$this->start_controls_tab(
			'tabs_jrXTYth45vn48caG5Fa4',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'slider_title_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'slider_title_background',
				'label' => __('Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title',
			]
		);

		$this->add_control(
			'slider_title_border_style',
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
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'slider_title_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'slider_title_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'slider_title_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_wg0xrV0tbbMT9ci3h5ba',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'slider_title_hover_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title:hover, .iq-slider-with-text-2 .slider-title:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'slider_title_hover_background',
				'label' => __('Title Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title:hover, .iq-slider-with-text-2 .slider-title:hover',
			]
		);

		$this->add_control(
			'slider_title_hover_border_style',
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
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title:hover, .iq-slider-with-text-2 .slider-title:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'slider_title_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title:hover, .iq-slider-with-text-2 .slider-title:hover' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'slider_title_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title:hover, .iq-slider-with-text-2 .slider-title:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'slider_title_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-title:hover, .iq-slider-with-text-2 .slider-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'slider_title_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'slider_title_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .slider-for .slider-text .slider-title, .iq-slider-with-text-2 .slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
		/* Iconbox Title End*/


		/* Iconbox Content start*/

		$this->start_controls_section(
			'section_7j7b42cHbgf7hxbMPedm',
			[
				'label' => __('Slider Description', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_content_text_typography',
				'label' => __('Description Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc',
			]
		);

		$this->start_controls_tabs('slider_desc_tabs');
		$this->start_controls_tab(
			'tabs_7F71Z47a8jcf049gbc2f',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'slider_desc_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .slider-desc' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'slider_desc_background',
				'label' => __('Icon Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .slider-desc',
			]
		);

		$this->add_control(
			'slider_desc_border_style',
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
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .slider-desc' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'slider_desc_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .slider-desc' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'slider_desc_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'slider_desc_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .slider-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_bF2Et4jhCVburd2ascTd',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'slider_desc_hover_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text.slick-active .slider-desc,{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text:hover .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .project-year:hover .slider-desc' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'slider_desc_hover_background',
				'label' => __('Icon Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text.slick-active .slider-desc,{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text:hover .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .project-year:hover .slider-desc',
			]
		);

		$this->add_control(
			'slider_desc_hover_border_style',
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
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text.slick-active .slider-desc:hover,{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text:hover .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .project-year:hover .slider-desc' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'slider_desc_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text.slick-active .slider-desc,{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text:hover .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .project-year:hover .slider-desc' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'slider_desc_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text.slick-active .slider-desc,{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text:hover .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .project-year:hover .slider-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'slider_desc_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text.slick-active .slider-desc,{{WRAPPER}} .iq-slider-with-text .slider-for .slider-text:hover .slider-desc,{{WRAPPER}} .iq-slider-with-text-2 .project-year:hover .slider-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'slider_desc_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .slider-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'slider_desc_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-slider-with-text .slider-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_j1SIbdawV5a6aEZqPWAG',
			[
				'label' => __('popup Model', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['button_action' => 'link'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slick_control_section',
			[
				'label' => __('Slider Control', 'iqonic'),
				'condition' =>  [
					'design_style' => '2',
				],
			]
		);

		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/owl-control.php';

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/SliderText/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                   callOwlCarousel();
                   callSlickSlider();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
