<?php

namespace Iqonic\Elementor\Elements\CircleChart;

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
        return 'circle_chart';
    }

    public function get_title()
    {
        return __('Iqonic Circle Chart', 'iqonic');
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
			'Section_circle_chart',
			[
				'label' => __('Circle Chart', 'iqonic'),
			]
		);

		$this->add_control(
			'show_section_title',
			[
				'label' => __('Show Section Title?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
				'default' => 'no',
			]
		);

		$this->add_control(
			'circle_subtitle',
			[
				'label' => __('Sub Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Sub-Title', 'iqonic'),
				'label_block' => true,
				'condition' => ['show_section_title' => 'yes']
			]
		);

		$this->add_control(
			'circle_title',
			[
				'label' => __('Title', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Title', 'iqonic'),
				'label_block' => true,
				'condition' => ['show_section_title' => 'yes']
			]
		);

		$this->add_control(
			'chart_percentage_data',
			[
				'label' => __('Percentage Data', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'default' => __('33', 'iqonic'),
				'placeholder' => __('Enter data', 'iqonic'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'progress_color',
			[
				'label' => __('Progress Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000'

			]
		);

		$this->add_control(
			'empty_color',
			[
				'label' => __('Empty Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'default' => '#e6e6e6'

			]
		);

		$this->add_control(
			'value_text_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'default' => '#171c26',
				'selectors' => [
					'{{WRAPPER}} .circleChart .circleChart_text' => 'color: {{VALUE}};',

				],

			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __('Speed', 'iqonic'),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 1,
				'default' => 2000,
			]
		);

		$this->add_control(
			'linecap',
			[
				'label'      => __('Line Cap', 'iqonic'),
				'description'      => __('This attribute defines the type of the circle line endings', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'round',
				'options'    => [

					'butt'          => __('butt', 'iqonic'),
					'round'          => __('round', 'iqonic'),
					'square'          => __('square', 'iqonic')
				],
			]
		);

		$this->add_control(
			'direction',
			[
				'label'      => __('Direction', 'iqonic'),

				'type'       => Controls_Manager::SELECT,
				'default'    => 'false',
				'options'    => [

					'true'          => __('Anti clock wise', 'iqonic'),
					'false'          => __('clock wise', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __('Size', 'iqonic'),
				'type' => Controls_Manager::NUMBER,
				'min' => 10,
				'step' => 1,
				'default' => 110,


			]
		);

		$this->add_control(
			'widthRatio',
			[
				'label' => __('Width Ratio', 'iqonic'),
				'description' => __('This attribute defines the Width Ratio from which the circle line should be displayed.', 'iqonic'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'default' => 0.2
			]
		);

		$this->add_control(
			'start_angle',
			[
				'label' => __('Start Angle', 'iqonic'),
				'description' => __('This attribute defines the starting angle from which the circle line should be displayed.', 'iqonic'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'default' => 75
			]
		);

		$this->end_controls_section();

    }

    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/CircleChart/render.php';
		if (Plugin::$instance->editor->is_edit_mode()) { 
			?>
		   <script>
			   (function(jQuery) {
				    callCircleChart();
			   })(jQuery);
		   </script> 
			   <?php
	   }
    }

}
