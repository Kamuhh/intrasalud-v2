<?php

namespace Iqonic\Elementor\Elements\Accordion;

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
        return 'iqonic_accordion';
    }

    public function get_title()
    {
        return __('Iqonic Accordion', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-help-o';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section',
			[
				'label' => __('Accordion', 'iqonic'),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'tab_title',
			[
				'label' => __('Question', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('What is Lorem Ipsum?', 'iqonic'),
				'placeholder' => __('Tab Title', 'iqonic'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label' => __('Answer', 'iqonic'),
				'default' => __('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'iqonic'),
				'placeholder' => __('Tab Content', 'iqonic'),
				'type' => Controls_Manager::TEXTAREA,
				'show_label' => false,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __('Tabs Items', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __('Tab #1', 'iqonic'),
						'tab_content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'iqonic'),

					]

				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		$this->add_control(
			'has_icon',
			[
				'label' => __('Use Icon?', 'iqonic'),
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

		$this->add_control(
			'active_icon',
			[
				'label' => __('Active Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'

				],
				'condition' => [
					'has_icon' => 'yes',
				],
				'label_block' => false,
				'skin' => 'inline',


			]
		);
		$this->add_control(
			'inactive_icon',
			[
				'label' => __('Inactive Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'

				],
				'condition' => [
					'has_icon' => 'yes',
				],
				'label_block' => false,
				'skin' => 'inline',


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
			'title_tag',
			[
				'label'      => __('Title Tag', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h4',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-title .accordion-title' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label' => __('Text Active Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-active .iq-accordion-title .accordion-title' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'title_back_color',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-title' => 'background: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'title_back_active_color',
			[
				'label' => __('Active Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-active .iq-accordion-title' => 'background: {{VALUE}};',

				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __('Content', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __('Content Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-details' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'content_back_color',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-details' => 'background: {{VALUE}};',

				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __('Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'has_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => __('Active Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-block.iq-active .iq-accordion-title i.active' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'icon_inactive_color',
			[
				'label' => __('Inactive Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-block .iq-accordion-title i.inactive' => 'color: {{VALUE}};',

				],
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
					'{{WRAPPER}} .iq-accordion .iq-accordion-block' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'border_active_color',
			[
				'label' => __('Active Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-block.iq-active' => 'border-color: {{VALUE}};',

				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'border_inactive_color',
			[
				'label' => __('Inactive Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-block' => 'border-color: {{VALUE}};',

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
					'{{WRAPPER}} .iq-accordion .iq-accordion-block' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);


		$this->add_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion .iq-accordion-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Accordion/render.php';
		if (Plugin::$instance->editor->is_edit_mode()) { 
			?>
		   <script>
			   (function(jQuery) {
				    callAccordion();
			   })(jQuery);
		   </script> 
			   <?php
	   }
    }
}
