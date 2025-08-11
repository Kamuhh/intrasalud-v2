<?php

namespace Iqonic\Elementor\Elements\RecentPost;

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
        return 'iqonic_recent_post';
    }

    public function get_title()
    {
        return __('Iqonic Recent Post', 'iqonic');
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
				'label' => __('Recent Post', 'iqonic'),
			]
		);

        $this->add_control(
			'iqonic-title',
			[
				'label' => esc_html__( 'title', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __('Title Tag', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h2',
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

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Post per page', 'iqonic' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'max' => 10000,
				'step' => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => esc_html__( 'Show Image', 'iqonic' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'iqonic' ),
				'label_off' => esc_html__( 'Hide', 'iqonic' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label' => esc_html__( 'Show meta', 'iqonic' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'iqonic' ),
				'label_off' => esc_html__( 'Hide', 'iqonic' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		/* Start Title */
		$this->start_controls_section(
			'section_Q6mN5ctWhXf7textfield',
			[
				'label' => __('Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_field_typography',
				'label' => __('Title Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-widget-menu .post-title',
			]
		);


		$this->start_controls_tabs('title_tabs');
		$this->start_controls_tab(
			'tabs_c8fpaelTGDkf95title',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

        $this->add_control(
			'iq_text_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu .post-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_49pcfagYof19bhover',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

        $this->add_control(
			'iq_text_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu .post-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* End Title */


		/* Start Meta */
		$this->start_controls_section(
			'section_Q6mN5ctWhXf7meta',
			[
				'label' => __('Meta', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_field_typography_meta',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-widget-menu.widget .iq-widget-menu .iq-post li .post-img .post-blog .blog-box ul li a',
			]
		);


		$this->start_controls_tabs('meta_tabs');
		$this->start_controls_tab(
			'tabs_c8fpaelTGDkf95meta',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

        $this->add_control(
			'iq_meta_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu.widget .iq-widget-menu .iq-post li .post-img .post-blog .blog-box ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq_meta_icon_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu.widget .iq-widget-menu .iq-post li .post-img .post-blog .blog-box ul li a i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_49pcfagYof19meta_bhover',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

        $this->add_control(
			'iq_meta_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu.widget .iq-widget-menu .iq-post li .post-img .post-blog .blog-box ul li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq_meta_icon_hover_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu.widget .iq-widget-menu .iq-post li .post-img .post-blog .blog-box ul li a:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* End Meta */

		$this->start_controls_section(
			'section_Q6mN5ctWhXf7textfielda',
			[
				'label' => __('BackGround', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'iq_background_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-widget-menu.widget' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();



    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/RecentPost/render.php';
    }
}
