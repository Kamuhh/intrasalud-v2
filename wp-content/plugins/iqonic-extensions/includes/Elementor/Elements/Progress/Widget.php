<?php

namespace Iqonic\Elementor\Elements\Progress;

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
        return 'iqonic_progressbar';
    }

    public function get_title()
    {
        return __('Iqonic Progressbar', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-skill-bar';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section_rtqCSgd6aLy7Pc23Q5bI',
			[
				'label' => __('Progress Bar Style', 'iqonic'),
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
					'3'          => __('Style-3', 'iqonic'),
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section',
			[
				'label' => __('Progressbar', 'iqonic'),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
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

		$repeater->add_control(
			'tab_score',
			[
				'label' => __('Score out of 100', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', '$'],
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
				'default' => [
					'unit' => '%',
					'size' => 50,
				],

			]
		);
		$this->add_control(
			'progress_bar',
			[
				'label' => __('Add Progress Bar', 'iqonic'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'section_title' => __('List Items', 'iqonic'),
						'tab_score' => __('50', 'iqonic'),

					]

				],
				'title_field' => '{{{ section_title }}}',
				'figure_field' => '{{{ tab_score }}}',
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
			'section_progress_style',
			[
				'label' => __('Progress Bar Style', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'progress_back_color',
			[
				'label' => __('Progress Bar Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-progress-bar' => 'background: {{VALUE}};',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_text_typography',
				'label' => __('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-progressbar-box .progress-title',
			]
		);


		$this->add_control(
			'title_color',
			[
				'label' => __('Title Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-progressbar-box .progress-title' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_text_typography',
				'label' => __('Number Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-progressbar-box .progress-value',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => __('Number Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-progressbar-box .progress-value' => 'color: {{VALUE}};'


				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'flip_back_back',
				'types' => ['classic', 'gradient'],

				'selector' => '{{WRAPPER}} .iq-progressbar-box .show-progress ,{{WRAPPER}}  .iq-progressbar-style-3 .progress-value, {{WRAPPER}} .iq-progressbar-style-3 .progress-value::before',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					]

				],
			]
		);



		$this->add_responsive_control(
			'progressbar_height',
			[
				'label' => __('Height', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-progress-bar' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-progressbar-style-3 .progress-value' => 'margin-top: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'progressbar_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-progress-bar,{{WRAPPER}} .iq-progress-bar>span' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Progress/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                    callProgress();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
