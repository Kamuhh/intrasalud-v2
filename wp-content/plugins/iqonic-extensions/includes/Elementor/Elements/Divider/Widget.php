<?php

namespace Iqonic\Elementor\Elements\Divider;

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
        return 'iq_divider';
    }

    public function get_title()
    {
        return __('Iqonic Divider', 'iqonic');
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
			'section_G0075p26eJla0uKTb4yv',
			[
				'label' => __('Divider Style', 'iqonic'),
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
					'2'          => __('Style-2', 'iqonic'),
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section',
			[
				'label' => __('Divider', 'iqonic'),
			]
		);

		$this->add_control(
			'alert_custom_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-divider' => 'border-top: 1px solid {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'section_title',
			[
				'label' => __('Message', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __('Section Title', 'iqonic'),
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
					'design_style' => ['2']

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


		$this->end_controls_section();

		$this->start_controls_section(
			'section_border_style',
			[
				'label' => __('Border', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'has_border',
			[
				'label' => __('Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
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
					'{{WRAPPER}} .iq-divider' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-divider' => 'border-color: {{VALUE}};',

				],
				'condition' => [
					'has_border' => 'yes',
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
					'{{WRAPPER}} .iq-divider' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ZKbb98G4saC2R2fDyY5i',
			[
				'label' => __('Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'design_style' => ['2']

				]

			]
		);

		$this->add_control(
			'icon_back_color',
			[
				'label' => __('Icon Box Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-divider i' => 'background: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-divider i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'iq_icon_border_color',
			[
				'label' => __('Icon Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-divider i' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'iq_icon_border_style',
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
					'{{WRAPPER}} .iq-divider i' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-divider i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-divider i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],


			]
		);
		$this->add_control(
			'iq_icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-divider i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],


			]
		);
		$this->add_control(
			'iq_icon_size',
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
					'{{WRAPPER}} .iq-divider i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Divider/render.php';
    }
}
