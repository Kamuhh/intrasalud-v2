<?php

namespace Iqonic\Elementor\Elements\Testimonial;

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
        return 'iq_testimonial';
    }

    public function get_title()
    {
        return __('Iqonic Testimonial', 'iqonic');
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
			'section_ct92P94qs7SJnoBrEd6y',
			[
				'label' => __('Testimonial Style', 'iqonic'),
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
					'4'          => __('Style-4', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'use_seprator',
			[
				'label' => __('Use sepretor', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
				'default' => 'no',
				'condition' => [
					'design_style' => '4',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_TeamImage',
			[
				'label' => __('Testimonial Image', 'iqonic'),
				'condition' => [
					'design_style' => '4',
				],
			]
		);

		$this->add_control(
            'iqonic_avatar_image',
            [
                'label'   => __('Show avatar image?', 'iqonic'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes'     => __('yes', 'iqonic'),
                'no'      => __('no', 'iqonic'),
            ]
        );


		$this->end_controls_section();

		$this->start_controls_section(
			'section_Team',
			[
				'label' => __('Testimonial Post', 'iqonic'),
			]
		);

		$this->add_control(
			'display_quote',
			[
				'label' => __('Display Quote Icon?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'media_style',
			[
				'label'      => __('Icon / Image', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'icon',
				'options'    => [

					'icon'          => __('Icon', 'iqonic'),
					'image'          => __('Image', 'iqonic'),

				],
				'condition' => ['display_quote' => 'yes']
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __('Icon', 'iqonic'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'media_style' => 'icon',
					'display_quote' => 'yes'
				],
				'default' => [
					'value' => 'fas fa-star'

				],
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
				'condition' => [
					'media_style' => 'image',
					'display_quote' => 'yes'
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);



		$this->add_control(
			'desk_number',
			[
				'label' => __('Desktop view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
					'design_style' => array('1','2'),
				],
				'label_block' => true,
				'default' => '3',
			]
		);

		$this->add_control(
			'lap_number',
			[
				'label' => __('Laptop view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
					'design_style' => array('1','2'),
				],
				'label_block' => true,
				'default' => '3',
			]
		);

		$this->add_control(
			'tab_number',
			[
				'label' => __('Tablet view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
					'design_style' => array('1','2'),
				],
				'label_block' => true,
				'default' => '2',
			]
		);

		$this->add_control(
			'mob_number',
			[
				'label' => __('Mobile view', 'iqonic'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
					'design_style' => array('1','2'),
				],
				'label_block' => true,
				'default' => '1',
			]
		);

		$this->add_control(
			'dot_each',
			[
				'label' => esc_html__('Pagination Each', 'iqonic'),
				'type' => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'      => __('Autoplay', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],

			]
		);

		$this->add_control(
			'loop',
			[
				'label'      => __('Loop', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],

			]
		);

		$this->add_control(
			'centermode',
			[
				'label'      => __('Center Mode', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),
				],
				'default'    => 'false',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'      => __('Pagination', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],

			]
		);

		$this->add_control(
			'nav-arrow',
			[
				'label'      => __('Arrow', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __('True', 'iqonic'),
					'false'      => __('False', 'iqonic'),

				],

			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::SLIDER,


				'default' => [
					'size' => 30
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

		/* Testimonial content start*/

		$this->start_controls_section(
			'section_U4o0fTi9d90YQL50K7GB',
			[
				'label' => __('Content', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-content p,
				  {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info p,
				  {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p',
			]
		);


		$this->start_controls_tabs('testimonial_content_tabs');
		$this->start_controls_tab(
			'tabs_C3P7D90JarMz1c5nduaV',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'content_text_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content p ,
					{{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info p,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'color: {{VALUE}};',


				],

			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '
                    {{WRAPPER}} .iq-testimonial-1 .iq-testimonial-info .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info P,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p',
			]
		);

		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_terstimonial_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '
                {{WRAPPER}} .iq-testimonial .iq-testimonial-info .iq-testimonial-content, 
                {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info, 
                {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:before,
                {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:after, 
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p',
			]
		);



		$this->add_control(
			'content_before_border_color',
			[
				'label' => __('Below Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info .iq-testimonial-content:before' => 'border-top-color: {{VALUE}};',
				],
				'condition' => ['design_style' => '1']

			]
		);

		$this->add_control(
			'content_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content,
                     {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info,
                     {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'content_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_ba4cBNdeMno5053j6395',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'content_hover_text_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial  .iq-testimonial-info:hover  .iq-testimonial-content p ,{{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover p,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p' => 'color: {{VALUE}};',
                   


				],

			]
		);

	
        $this->add_group_control(
            Group_Control_Background::get_type(),
			[
				'name' => 'quote_hover_back_color',
				'label' => esc_html__( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '
                    {{WRAPPER}} .iq-testimonial-1 .iq-testimonial-info:hover .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover P,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_terstimonial_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover  .iq-testimonial-content,
                {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover,
                {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover:before,
                {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover:after,
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p',
			]
		);



		$this->add_control(
			'content_hover_before_border_color',
			[
				'label' => __('Below Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [

					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-content:before' => 'border-top-color: {{VALUE}};',

				],
                'condition' => ['design_style' => '1']

			]
		);

		$this->add_control(
			'content_hover_border_style',
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
					'{{WRAPPER}} .iq-testimonial  .iq-testimonial-info:hover  .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'content_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial  .iq-testimonial-info:hover  .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'content_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial  .iq-testimonial-info:hover  .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'content_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial  .iq-testimonial-info:hover  .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec:hover p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content,
                    {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-content,
                     {{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info,
                     {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .text-dec p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);



		$this->end_controls_section();

		/* Testimonial content end*/

		/* Quote Start*/
		$this->start_controls_section(
			'section_0a849dad5SaFs50PGIrp',
			[
				'label' => __('Quote', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_icon_size',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('quote_icon_tabs');
		$this->start_controls_tab(
			'tabs_Z9d7p6tqdzSd6e050BNm',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'quote_icon_color',
			[
				'label' => __('Choose color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote i' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'quote_icon_background',
				'label' => __('Icon Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-quote',
			]
		);

		$this->add_control(
			'quote_icon_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'quote_icon_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'quote_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'quote_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_3aWr40Ztjdy93beGd7Qd',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'quote_icon_hover_color',
			[
				'label' => __('Choose color <br> <span style="color: #5bc0de"> (Note : working only for icon) </span>', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-quote i,
					 {{WRAPPER}} .iq-testimonial:hover .iq-testimonial-quote i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'quote_icon_hover_background',
				'label' => __('Icon Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-quote,
				{{WRAPPER}} .iq-testimonial:hover .iq-testimonial-quote ',
			]
		);


		$this->add_control(
			'quote_icon_hover_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-quote,
					{{WRAPPER}} .iq-testimonial:hover .iq-testimonial-quote ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'quote_icon_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-quote,
					{{WRAPPER}} .iq-testimonial:hover .iq-testimonial-quote ' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'quote_icon_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-quote,
					{{WRAPPER}} .iq-testimonial:hover .iq-testimonial-quote ' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'quote_icon_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-quote,
					{{WRAPPER}} .iq-testimonial:hover .iq-testimonial-quote ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'quote_icon_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'quote_icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->add_responsive_control(
			'quote_icon_width',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'quote_icon_height',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-quote' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* Quote End*/

		/* Author Image Start*/

		$this->start_controls_section(
			'section_6Ok0qBAc5URV0M9JWXdw',
			[
				'label' => __('Author Image', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
					'design_style' => array('1','2','3'),
				],
			]
		);


		$this->start_controls_tabs('auth_img_tabs');
		$this->start_controls_tab(
			'tabs_ams3cek58jnOT0Ux0CFa',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'auth_back_color',
				'label' => __('Author Image Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],

				],
			]
		);
		$this->add_control(
			'auth_img_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial .testimonial-slider-img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'auth_img_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial .testimonial-slider-img' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'auth_img_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial .testimonial-slider-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'auth_img_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial .testimonial-slider-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_0d0B0IDN5T9GutacSU7i',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'auth_hover_back_color',
				'label' => __('Author Image Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-avtar',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],

				],
			]
		);
		$this->add_control(
			'auth_hover_img_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial:hover .testimonial-slider-img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'auth_hover_img_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial:hover .testimonial-slider-img' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'auth_hover_img_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial:hover .testimonial-slider-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'auth_hover_img_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-avtar, {{WRAPPER}} .iq-testimonial:hover .testimonial-slider-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_responsive_control(
			'auth_img_width',
			[
				'label' => __('Author Image Width', 'iqonic'),
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'auth_img_height',
			[
				'label' => __('Author Image Height', 'iqonic'),
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);




		$this->add_responsive_control(
			'auth_img_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'auth_img_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-avtar' => 'margin: {{TOP}}{{UNIT}}  {{BOTTOM}}{{UNIT}} ;',
				],

			]
		);




		$this->end_controls_section();

		/* Author Image End*/

		/* Author Name and Designation Start*/

		$this->start_controls_section(
			'section_jaSF5vQVDeG70e6H39e7',
			[
				'label' => __('Author Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_text_typography',
				'label' => __('Author Typography', 'iqonic'),
				'selector' => '{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
				{{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4',
			]
		);

		$this->start_controls_tabs('auther_text_tabs');
		$this->start_controls_tab(
			'tabs_ayOB60g3uX0C27UdaanS',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'author_text_color',
			[
				'label' => __('Author Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'author_text_back_color',
				'label' => __('Author Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,
                {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4',
				
			]
	
		);
		$this->add_control(
			'author_text_border_style',
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
					'{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4 ' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'author_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'author_text_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'author_text_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-testimonial .iq-testimonial-member .avtar-name .iq-lead,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_ydJ0bNC6788H90mOr7ga',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'author_hover_text_color',
			[
				'label' => __('Author Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-lead,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover h4' => 'color: {{VALUE}};',

				],

			]
		);
		
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'author_text_hover_back_color',
				'label' => __('Author Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content,
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover h4',
				
			]
		);
       
		$this->add_control(
			'author_text_border_hover_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover h4' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'author_text_border_hover_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover h4' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'author_text_border_hover_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover h4' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'author_text_border_hover_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover h4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'post_meta_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-post-meta,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'post_meta_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-post-meta,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Author Name and Designation End*/



		/* Author Name and Designation Start*/

		$this->start_controls_section(
			'section_U27ec1SYp8z8Oy9L00WE',
			[
				'label' => __('Author Designation', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desig_text_typography',
				'label' => __('Designation Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation',
			]
		);


		$this->start_controls_tabs('auther_designationt_tabs');
		$this->start_controls_tab(
			'tabs_IxH4B209hsd0d0fe10AV',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'desig_text_color',
			[
				'label' => __('Designation Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'color: {{VALUE}};',

				],

			]
		);

	

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desig_text_back_color',
				'label' => __('Designation Background',  'iqonic' ),
				'types' => ['classic', 'gradient'],
				'selector' => '
                {{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,
                {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation',
			]
		);
		$this->add_control(
			'desig_text_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'desig_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'desig_text_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'desig_text_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,
                     {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                     {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_deA084MfdaYHdI44rpn5',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'desig_hover_text_color',
			[
				'label' => __('Designation Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation:hover' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desig_text_hover_back_color',
				'label' => __('Designation Background',  'iqonic' ),
				'types' => ['classic', 'gradient'],
				'selector' => '
                {{WRAPPER}} .iq-testimonial .iq-testimonial-member .avtar-name .iq-post-meta,
                {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info:hover .kivicare-testimonial-user .kivicare-designation',
			]
		);
        
		$this->add_control(
			'desig_text_hover_border_style',
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
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'desig_text_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation:hover' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'desig_text_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'desig_text_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'desig_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-post-meta,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'desig_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-testimonial .iq-post-meta,
                    {{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title,
                    {{WRAPPER}} .kivicare-testimonial-style-1 .kivicare-slider .kivicare-main-slider .kivicare-slider_content .kivicare-lead .kivicare-user-info .kivicare-testimonial-user .kivicare-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Testimonial/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) { 
                   callOwlCarousel();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
