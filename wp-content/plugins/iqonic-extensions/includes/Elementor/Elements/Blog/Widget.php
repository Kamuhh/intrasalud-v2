<?php

namespace Iqonic\Elementor\Elements\Blog;

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
        return 'Iq_Blog';
    }

    public function get_title()
    {
        return __('Iqonic Blog', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section_FdQDBHfO5ay2X8xzR30d',
			[
				'label' => __('Layouts', 'iqonic'),
			]
		);

		$this->add_control(
			'post_layout',
			[
				'label'      => __('Select post layouts', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'style1',
				'options'    => [
					'styel1'          => __('Style-1', 'iqonic'),
					'style2'          => __('Style-2', 'iqonic'),
					'style3'          => __('Style-3', 'iqonic'),
					'style4'          => __('Style-4', 'iqonic'),
					'style5'          => __('Style-5', 'iqonic'),
				],
				'default' => 'styel1'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog',
			[
				'label' => __('Blog Post', 'iqonic'),
			]
		);

		$this->add_control(
			'blog_style',
			[
				'label'      => __('Blog Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1'          => __('Blog Slider', 'iqonic'),
					'2'          => __('Blog 1 Columns', 'iqonic'),
					'3'          => __('Blog 2 Columns', 'iqonic'),
					'4'          => __('Blog 3 Columns', 'iqonic'),
					'5'          => __('Blog 4 Columns', 'iqonic'),
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

		$this->add_control(
			'show_description',
			[
				'label'      => __('Show Description', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'none',
				'options'    => [
					'block'          => __('Yes', 'iqonic'),
					'none'          => __('No', 'iqonic'),
				],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box p' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'iqonic'),
				'type' => Controls_Manager::CHOOSE,
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
					],
					'text-justify' => [
						'title' => __('Justified', 'iqonic'),
						'icon' => 'eicon-text-align-justify',
					],
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_21h1Myn3Vx5qrK29565',
			[
				'label' => __('Post Control', 'iqonic'),
			]
		);
		require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/post-control.php';

		$this->end_controls_section();

		$this->start_controls_section(
			'owl_control_section',
			[
				'label' => __('Slider Control', 'iqonic'),
			]
		);

		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/owl-control.php';

		$this->end_controls_section();

		require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_btn_controls.php';

		require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/blog-colors.php';


    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Blog/render.php';
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
