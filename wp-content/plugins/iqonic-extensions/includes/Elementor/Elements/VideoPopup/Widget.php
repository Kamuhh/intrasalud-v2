<?php

namespace Iqonic\Elementor\Elements\VideoPopup;

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
        return 'iqonic_popup_video';
    }

    public function get_title()
    {
        return __('Iqonic Popup Video', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-video-camera';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section',
			[
				'label' => __('Popup Video', 'iqonic'),
			]
		);

		$this->add_control(
			'video_type',
			[
				'label' => __('Source', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => [
					'video_link' => __('Link', 'iqonic'),
					'hosted' => __('Self Hosted', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'hosted_url',
			[
				'label' => __('Choose File', 'iqonic'),
				'type' => Controls_Manager::MEDIA,

				'media_type' => 'video',
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'link_url',
			[
				'label' => __('Link', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter your URL', 'iqonic'),
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition' => [
					'video_type' => 'video_link',
				],
			]
		);

		$this->add_control(
			'media_style',
			[
				'label'      => __('Select Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'none',
				'options'    => [

					'icon'          => __('Icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),
					'none'          => __('none', 'iqonic'),

				],
			]
		);

		$this->add_control(
			'image_icon',
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
				],
			]
		);


		$this->add_control(
			'selected_icon',
			[
				'label' => __('Play Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',

				'default' => [
					'value' => 'fas fa-star'

				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'media_style' => 'icon',
				],


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
			'section_NZk6cbrofHfRt2C5bJS9',
			[
				'label' => __('Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,


			]
		);

		$this->add_control(
			'icon_back_color',
			[
				'label' => __('Icon Box Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'alpha' => true,


				'selectors' => [
					'{{WRAPPER}} .iq-popup-video .iq-video-icon .iq-video,.iq-popup-video .iq-video-icon .iq-waves .waves' => 'background: {{VALUE}};',
				],

			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'media_style' => 'icon',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-popup-video .iq-video-icon i' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'has_border',
			[
				'label' => __('Use Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq_icon_border_color',
			[
				'label' => __('Icon Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,


				'selectors' => [
					'{{WRAPPER}} .iq-popup-video .iq-video-icon .iq-video' => 'border-color: {{VALUE}};',
				],

				'condition' => ['has_border' => 'yes']

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
					'{{WRAPPER}} .iq-popup-video .iq-video-icon .iq-video' => 'border-style: {{VALUE}};',

				],
				'condition' => ['has_border' => 'yes']
			]
		);

		$this->add_control(
			'iq_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-popup-video .iq-video-icon .iq-video' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => ['has_border' => 'yes']

			]
		);

		$this->add_control(
			'iq_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-popup-video .iq-video-icon .iq-video ,{{WRAPPER}} .iq-popup-video .iq-waves .waves' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => ['has_border' => 'yes']


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
					'{{WRAPPER}} .iq-popup-video .iq-video-icon .iq-video i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['has_border' => 'yes']
			]
		);

		$this->add_responsive_control(
			'iq_icon_width',
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
					'{{WRAPPER}} .iq-video' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iq_icon_height',
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
					'{{WRAPPER}} .iq-video' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/VideoPopup/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                    callVideoPopup();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
