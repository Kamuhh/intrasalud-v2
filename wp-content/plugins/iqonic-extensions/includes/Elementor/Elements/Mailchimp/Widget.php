<?php

namespace Iqonic\Elementor\Elements\Mailchimp;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_mailchimp';
    }

    public function get_title()
    {
        return __('Iqonic Mailchimp', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-shortcode';
    }
    protected function register_controls()
    {

       
		$this->start_controls_section(
			'section_3hF8Pm7ca35YJWo8kiTD',
			[
				'label' => __('Shortcode', 'iqonic'),
			]
		);

		$this->add_control(
			'mailchimp_style',
			[
				'label'     => __( 'Style', 'iqonic' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1'     => __( 'Style 1', 'iqonic' ),
					'2'     => __( 'Style 2', 'iqonic' ),
				],
			]
		);

      
		$this->end_controls_section();

		/* text field */
		$this->start_controls_section(
			'section_Q6mN5ctWhXf7textfield',
			[
				'label' => __('Text field', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_field_typography',
				'label' => __('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .kivicare-mailchimp-1 input[type=email]',
			]
		);

		$this->add_control(
			'iq_text_field_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .kivicare-mailchimp-1 input[type=email],
					{{WRAPPER}} .kivicare-mailchimp-1 input[type="email"]::placeholder' => 'color: {{VALUE}};',
				],


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
					'{{WRAPPER}} .kivicare-mailchimp-1 input[type=email] ' => 'border-style: {{VALUE}};',

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
					'{{WRAPPER}} .kivicare-mailchimp-1 input[type=email]' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .kivicare-mailchimp-1 input[type=email]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .kivicare-mailchimp-1 input[type=email]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();


		/* Button */
		$this->start_controls_section(
			'section_Q6mN5ctWhXf7ea90VPz5',
			[
				'label' => __('Button', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_button_typography',
				'label' => __('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit',
			]
		);

		$this->add_control(
			'iq_fancybox_border_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit' => 'color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_background_color',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit' => 'background: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_lists_btn_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_lists_btn_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'iq_lists_btn_has_border' => 'yes',
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
					'{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_lists_btn_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_lists_btn_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_btn_lists_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_lists_btn_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_btn_btn_lists_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_lists_btn_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-mailchimp-1 .mc4wp-form button.btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();



    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Mailchimp/render.php';
    }
}
