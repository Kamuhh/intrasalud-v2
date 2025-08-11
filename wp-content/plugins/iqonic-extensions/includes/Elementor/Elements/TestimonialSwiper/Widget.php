<?php

namespace Iqonic\Elementor\Elements\TestimonialSwiper;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'Iq_Testimonial_slick';
    }

    public function get_title()
    {
        return __('Iqonic Testimonial Slick', 'iqonic');
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
				],
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
			'display_image',
			[
				'label' => __('Display Image?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
				'selector' => '{{WRAPPER}} .iq-testimonial-slick .iq-testimonial-content p,{{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info p',
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
					'{{WRAPPER}} .iq-testimonial-slick .iq-testimonial-content p ,{{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info p' => 'color: {{VALUE}};',


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
					'{{WRAPPER}} .iq-testimonial-slick  .iq-testimonial-info:hover  .iq-testimonial-content p ,{{WRAPPER}} .iq-testimonial-2 .iq-testimonial-info:hover p' => 'color: {{VALUE}};',


				],

			]
		);



		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->end_controls_section();

		/* Testimonial content end*/




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
				'selector' => '{{WRAPPER}}  .iq-testimonial-slick .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content',
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
					'{{WRAPPER}}  .iq-testimonial-slick .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .content' => 'color: {{VALUE}};',

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
					'{{WRAPPER}} .iq-testimonial-slick .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-lead,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .content' => 'color: {{VALUE}};',

				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();




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
				'selector' => '{{WRAPPER}} .iq-testimonial-slick-1 .iq-post-meta, {{WRAPPER}} .iq-testimonial-slick-2 .iq-testimonial-info .iq-post-meta',
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
					'{{WRAPPER}} .iq-testimonial-slick .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-member .sub-title' => 'color: {{VALUE}};',

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
					'{{WRAPPER}} .iq-testimonial-slick .iq-testimonial-info:hover .iq-testimonial-member .avtar-name .iq-post-meta,{{WRAPPER}} .iq-testimonial.iq-testimonial-2 .iq-testimonial-info:hover .iq-testimonial-member .sub-title' => 'color: {{VALUE}};',

				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->end_controls_section();

		/* Author Name and Designation End*/

		$this->start_controls_section(
			'slick_control_section',
			[
				'label' => __('Slider Control', 'iqonic'),
			]
		);

        require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/slick-control.php';

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/TestimonialSwiper/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                    callSwiper();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
