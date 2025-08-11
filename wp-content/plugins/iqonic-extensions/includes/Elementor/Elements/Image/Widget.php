<?php

namespace Iqonic\Elementor\Elements\Image;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
	public function get_name()
	{
		return 'iqonic_image';
	}

	public function get_title()
	{
		return __('Iqonic Image', 'iqonic');
	}
	public function get_categories()
	{
		return ['iqonic-extension'];
	}

	public function get_icon()
	{
		return 'eicon-image';
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_image_main',
			[
				'label' => __('Image', 'iqonic'),
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
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image_effect',
			[
				'label' 		=> __('Choose Effect', 'iqonic'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'default',
				'label_block'	=> false,
				'options' 	=> [
					'default'  	=> __('Default', 'iqonic'),
					'tilt' 		=> __('Tilt', 'iqonic'),
					'rotation' 	=> __('Rotation', 'iqonic'),
				],
			]
		);

		$this->add_responsive_control(
			'iqonic_image_width',
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
					'{{WRAPPER}} .kivicare-image-effect img ' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'data_tilt',
			[
				'label' 	=> __('Tilt Speed', 'iqonic'),
				'type' 		=> Controls_Manager::NUMBER,
				'label_block'	=> false,
				'min' 		=> 100,
				'max' 		=> 10000,
				'step' 		=> 100,
				'default' 	=> 2500,
				'condition'	=> ['image_effect' => 'tilt']
			]
		);

		$this->add_control(
			'data_tilt_perspective',
			[
				'label' 	=> __('Tilt Perspective', 'iqonic'),
				'type' 		=> Controls_Manager::NUMBER,
				'label_block'	=> false,
				'min' 		=> 100,
				'max' 		=> 10000,
				'step' 		=> 100,
				'default' 	=> 800,
				'condition'	=> ['image_effect' => 'tilt']
			]
		);

		$this->add_control(
			'image_rotation',
			[
				'label' 	=> __('Rotation Speed', 'iqonic'),
				'type' 		=> Controls_Manager::NUMBER,
				'label_block'	=> false,
				'min' 		=> 1,
				'max' 		=> 100,
				'step' 		=> 0.5,
				'default' 	=> 12,
				'condition'	=> ['image_effect' => 'rotation'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect img' => 'animation: rotation {{VALUE}}s linear infinite;-webkit-animation: rotation {{VALUE}}s linear infinite;
					-moz-animation: rotation {{VALUE}}s linear infinite;',
				],
			]
		);

		$this->add_control(
			'image_transition',
			[
				'label' 	=> __('Transition speed', 'iqonic'),
				'type' 		=> Controls_Manager::NUMBER,
				'label_block'	=> false,
				'min' 		=> 0,
				'max' 		=> 100,
				'step' 		=> 0.5,
				'default' 	=> 1.2,
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect' => 'transition: {{VALUE}}s cubic-bezier(.63,.25,.25,1);',
				],
			]
		);

		$this->add_control(
			'link_type',
			[
				'label' => __('Link', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __('None', 'iqonic'),
					'custom' => __('Custom', 'iqonic'),
					'page' => __('Page', 'iqonic'),
				],
			]
		);
		$pages=iqonic_get_posts('page');
		$this->add_control(
			'pages_link',
			[
				'label' => __('Page', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition'=> ['link_type' => 'page'],
				'options' => $pages,
			]
		);
		$this->add_control(
			'link',
			[
				'label' => '',
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('https://your-link.com', 'iqonic'),
				'default' => [
					'url' => '',
				],
				'condition' => [
					'link_type' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'image_box_border_devider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'box_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'solid'     => __('Solid', 'iqonic'),
					'dashed'    => __('Dashed', 'iqonic'),
					'dotted'    => __('Dotted', 'iqonic'),
					'double'    => __('Double', 'iqonic'),
					'outset'    => __('outset', 'iqonic'),
					'groove'    => __('groove', 'iqonic'),
					'ridge'     => __('Ridge', 'iqonic'),
					'inset'     => __('Inset', 'iqonic'),
					'none'      => __('None', 'iqonic'),
				],
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect img' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect img' => 'border-color: {{VALUE}};',
				],
				'condition' => ['box_border_style!' => 'none']
			]
		);

		$this->add_control(
			'box_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => ['box_border_style!' => 'none']
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __('Border radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-image-effect img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => ['box_border_style!' => 'none']
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		require 'render.php';
		if (Plugin::$instance->editor->is_edit_mode()) {
?>
			<script>
				(function(jQuery) {
					jQuery('[data-tilt]').tilt();
				})(jQuery);
			</script>
<?php
		}
	}
}
