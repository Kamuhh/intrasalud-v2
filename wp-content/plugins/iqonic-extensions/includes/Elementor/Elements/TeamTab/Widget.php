<?php

namespace Iqonic\Elementor\Elements\TeamTab;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'team_tab';
    }

    public function get_title()
    {
        return __('iqonic Team Tab', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-person';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section_style',
			[
				'label' => __('Styles', 'iqonic'),
			]
		);

		$this->add_control(
            'team_style',
            [
                'label' => esc_html__('Style','iqonic' ),
                'type' => Controls_Manager::SELECT, 
                'options' => [
                    '1'    => esc_html__('Style 1', 'iqonic'),
                    '2'    => esc_html__('Style 2', 'iqonic'),
                ],
                'default' => '1',
            ]
        ); 

		$this->end_controls_section();

        $this->start_controls_section(
            'Section_Project',
            [
                'label' => __('Team Post', 'iqonic'),
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
            'project_layout',
            [
                'label' => esc_html__('Layout','iqonic' ),
                'type' => Controls_Manager::SELECT, 
                'options' => [
                    '1-grid'    => esc_html__('Blog 1 Columns', 'iqonic'),
                    '2-grid'    => esc_html__('Blog 2 Columns', 'iqonic'),
                    '3-grid'    => esc_html__('Blog 3 Columns', 'iqonic'),
                    '4-grid'    => esc_html__('Blog 4 Columns', 'iqonic'),
                ],
                'default' => '3-grid',
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'section_Project_cat',
            [
                'label' => __('Project Category', 'iqonic'),
                'condition' => ['has_cat'   =>  'inline-block']
            ]

        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'port_cat_typography',
                'label' => __('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-project-category span,{{WRAPPER}} .project-style-2 .tab-content .tab-pane .iqonic-masonry-block .iqonic-masonry-grid .iqonic-masonry-item .iqonic-project-box .iqonic-port-coverlay .iqonic-port-cat, {{WRAPPER}} .project-style-3 .tab-content .tab-pane .iqonic-masonry-block .iqonic-masonry-grid .iqonic-masonry-item .iqonic-project-box .iqonic-port-coverlay .iqonic-port-cat',
            ]
        );

        $this->start_controls_tabs('_dr6Yu5af63L5yHm3casd');
        $this->start_controls_tab(
            'tabs_cat',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'port_cat_color',
            [
                'label' => __('Title Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-project-category span,
                    {{WRAPPER}} .project-style-2 .tab-content .tab-pane .iqonic-masonry-block .iqonic-masonry-grid .iqonic-masonry-item .iqonic-project-box .iqonic-port-coverlay .iqonic-port-cat,
                    {{WRAPPER}} .project-style-3 .tab-content .tab-pane .iqonic-masonry-block .iqonic-masonry-grid .iqonic-masonry-item .iqonic-project-box .iqonic-port-coverlay .iqonic-port-cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs__cat_fghhgjhjkk',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );
        $this->add_control(
            'port_cat_hover_color',
            [
                'label' => __('Title Hover Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,

                'selectors' => ['
                    {{WRAPPER}} .kivicare-project-category:hover span,
                    {{WRAPPER}} .project-style-2 .tab-content .tab-pane .iqonic-masonry-block .iqonic-masonry-grid .iqonic-masonry-item .iqonic-project-box .iqonic-port-coverlay .iqonic-port-cat:hover,
                    {{WRAPPER}} .project-style-3 .tab-content .tab-pane .iqonic-masonry-block .iqonic-masonry-grid .iqonic-masonry-item .iqonic-project-box .iqonic-port-coverlay .iqonic-port-cat:hover' => 'color: {{VALUE}};',
                ],
        
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        // Title Style Section End

        $this->start_controls_section(
			'section_NIfezt7YM7feDaT9vP8J',
			[
				'label' => __('Tab text', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .kivicare-team-tab .kivicare-team-tab-nav .nav-link',
			]
		);

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings();
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/TeamTab/render.php';

    }
}
