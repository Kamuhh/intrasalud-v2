<?php

namespace Iqonic\Elementor\Elements\Team;

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
        return 'team';
    }

    public function get_title()
    {
        return __('iqonic Team', 'iqonic');
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
			'section_711rNK9oIdi6RuT0z72g',
			[
				'label' => __('Team Style', 'iqonic'),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Select Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1'          => __('Style 1', 'iqonic'),
					'2'          => __('Style 2', 'iqonic'),
					'3'          => __('Style 3', 'iqonic'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_Team',
			[
				'label' => __('Team Post', 'iqonic'),
			]
		);

		$this->add_control(
			'team_style',
			[
				'label'      => __('Team Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'slider',
				'options'    => [
					'none'       => __('None', 'iqonic'),
					'slider'          => __('Team Slider', 'iqonic'),
					'grid'          => __('Team Grid', 'iqonic'),

				],
			]
		);

		$this->add_control(
			'team_grid_style',
			[
				'label'      => __('Team Grid', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1'       	 => __('One', 'iqonic'),
					'2'          => __('Two', 'iqonic'),
					'3'          => __('Three', 'iqonic'),
					'4'          => __('Four', 'iqonic'),
				],
				'condition' => ['team_style' => 'grid']
			]
		);
		$this->add_control(
			'pagination',
			[
				'label'   => __('Show Pagintion', 'xamin'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes' => esc_html__('yes', 'xamin'),
					'no' => esc_html__('no', 'xamin')
				],
				'condition' => ['team_style' => 'grid']

			]
		);
		

		$this->add_control(
			'team_cat',
			[
				'label' => esc_html__('Category', 'xamin'),
				'type' => Controls_Manager::SELECT2,
				'return_value' => 'true',
				'multiple' => true,
				'options' => iq_all_team_cat(),
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
			'order',
			[
				'label'   => __('Order By', 'iqonic'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'DESC' => esc_html__('Descending', 'iqonic'),
					'ASC' => esc_html__('Ascending', 'iqonic')
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
			'owl_control_section',
			[
				'label' => __('Slider Control', 'iqonic'),

			]
		);

		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/owl-control.php';


		$this->end_controls_section();



		/* Team start*/

		$this->start_controls_section(
			'section_kA7uL7eHU0wfNt124e2g',
			[
				'label' => __('Team', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('team_tabs');
		$this->start_controls_tab(
			'tabs_qNU781zj1ck660yd2vn7',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog',

			]
		);

		$this->add_control(
			'section_4R7js019Dgc232O5Fm3U',
			[
				'label' => __('Before Background', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => ['2', '4', '5', '6', '9', '10']
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_before_background',
				'label' => __('Before Background', 'iqonic'),
				'condition' => [
					'design_style' => ['2', '4', '5', '6', '9', '10']
				],
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team-style-2 .iq-team-content:before,{{WRAPPER}} .iq-team-style-4:hover .iq-team-img:before,{{WRAPPER}} .iq-team-style-5 .iq-team-blog .team-blog:before,{{WRAPPER}} .iq-team-style-6 .iq-team-blog .iq-team-img:before,{{WRAPPER}} .iq-team-style-9 .iq-team-blog .iq-team-img:before,{{WRAPPER}} .iq-team-style-10 .iq-team-blog:before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog',
			]
		);
		$this->add_control(
			'team_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);




		$this->add_control(
			'team_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'team_has_border' => 'yes',
				],
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
					'{{WRAPPER}} .iq-team .iq-team-blog' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'team_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'team_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'team_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'team_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'team_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'team_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_rKkxfU2on94gt7b3FyCS',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_hover_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover',

			]
		);
		$this->add_control(
			'section_U4F0LE2HrZ16d9chO3kW',
			[
				'label' => __('Before Background', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => ['2', '4', '5', '6', '9', '10']
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_before_hover_background',
				'label' => __('Before Background', 'iqonic'),
				'condition' => [
					'design_style' => ['2', '4', '5', '6', '9', '10'],
				],
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team-style-2 .iq-team-content:hover:before, {{WRAPPER}} .iq-team-style-4:hover .iq-team-img:before,{{WRAPPER}} .iq-team-style-5 .iq-team-blog .team-blog:before,{{WRAPPER}} .iq-team-style-6 .iq-team-blog:hover .iq-team-img:before, {{WRAPPER}} .iq-team-style-9 .iq-team-blog:hover .iq-team-img:before, {{WRAPPER}} .iq-team-style-10 .iq-team-blog:hover:before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover',
			]
		);

		$this->add_control(
			'team_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);


		$this->add_control(
			'team_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'team_hover_has_border' => 'yes',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'team_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'team_hover_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'team_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'team_hover_has_border' => 'yes',
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'team_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'team_hover_has_border' => 'yes',
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'team_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'team_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/*team End*/


		/* team info start*/

		$this->start_controls_section(
			'section_Ja72qNLpe2h7tlV1598b',
			[
				'label' => __('Team Info', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('team_info_tabs');
		$this->start_controls_tab(
			'tabs_NJ5v9R21We1wEbhK12yb',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_info_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info,{{WRAPPER}} .iq-team-style-7 .iq-team-blog .iq-team-description',

			]
		);

		$this->add_control(
			'section_r1025znoJek22dmYbI1b',
			[
				'label' => __('Before Background', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => ['6']
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_before_info_color',
				'types' => ['classic', 'gradient'],
				'condition' => [
					'design_style' => ['6']
				],
				'selector' => '{{WRAPPER}} .iq-team-style-6 .iq-team-description .line
				',

			]
		);

		$this->add_control(
			'section_32vfF5P1eA6E072cgVGi',
			[
				'label' => __('After Background', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => ['7']
				],
			]
		);

		$this->add_control(
			'team_info_after_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'design_style' => ['7']
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team-style-7 .iq-tooltip-item' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-team-style-7 .iq-team-description:after' => 'border-top-color: {{VALUE}};',

				],


			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_info_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info, {{WRAPPER}} .iq-team-style-7 .iq-team-blog .iq-team-description',
			]
		);
		$this->add_control(
			'team_info_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);




		$this->add_control(
			'team_info_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'team_info_has_border' => 'yes',
				],
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'team_info_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'team_info_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'team_info_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'team_info_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'team_info_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'team_info_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_301xXls5AF5eJem2beQ6',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_info_hover_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-team-info,{{WRAPPER}} .iq-team-style-7 .iq-team-blog:hover .iq-team-description',

			]
		);

		$this->add_control(
			'section_2x6Ab10v4T96z6i92Gm7',
			[
				'label' => __('After Hover Background', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => ['7']
				],
			]
		);

		$this->add_control(
			'team_info_after_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'design_style' => ['7']
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team-style-7 .iq-team-blog:hover .iq-tooltip-item' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-team-style-7 .iq-team-blog:hover  .iq-team-description:after' => 'border-top-color: {{VALUE}};',

				],


			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_info_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-team-info,{{WRAPPER}} .iq-team-style-7 .iq-team-blog:hover .iq-team-description',
			]
		);

		$this->add_control(
			'team_info_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);


		$this->add_control(
			'team_info_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'team_info_hover_has_border' => 'yes',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-info' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'team_info_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'team_info_hover_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-info' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'team_info_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'team_info_hover_has_border' => 'yes',
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-info' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'team_info_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'team_info_hover_has_border' => 'yes',
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'team_info_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog .iq-team-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'team_info_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/*team End*/



		/* Team Image start*/

		$this->start_controls_section(
			'section_c2ZGc6820Ja02vsM2Arx',
			[
				'label' => __('Team Image', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('team_image_tabs');
		$this->start_controls_tab(
			'tabs_0bBTZl2C2Ri5yqe4dP69',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_image_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img',

			]
		);



		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_image_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img',
			]
		);
		$this->add_control(
			'team_image_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);




		$this->add_control(
			'team_image_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'team_image_has_border' => 'yes',
				],
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'team_image_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'team_image_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'team_image_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'team_image_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'team_image_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'team_image_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_rePeJ7y0c26LF2M5U25Q',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_image_hover_back_color',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-team-img',

			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_image_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-team-img',
			]
		);

		$this->add_control(
			'team_image_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);


		$this->add_control(
			'team_image_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'team_image_hover_has_border' => 'yes',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-img' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'team_image_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'team_image_hover_has_border' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-img' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'team_image_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'team_image_hover_has_border' => 'yes',
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'team_image_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'team_image_hover_has_border' => 'yes',
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .iq-team-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'team_image_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog .iq-team-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'team_image_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/*team  Image End*/


		/* Author Name  Start*/

		$this->start_controls_section(
			'section_3001b3d2SJ2q2t2eQpZ0',
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
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .member-text',
			]
		);

		$this->start_controls_tabs('auther_text_tabs');
		$this->start_controls_tab(
			'tabs_50PBuiNQ6t2eAe3q83f4',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog .member-text' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'author_text_back_color',
				'label' => __('Author Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}  .iq-team .iq-team-blog .member-text',

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
					'{{WRAPPER}}  .iq-team .iq-team-blog .member-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'author_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog .member-text' => 'border-color: {{VALUE}};',

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
					'{{WRAPPER}}  .iq-team .iq-team-blog .member-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog .member-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_Sl0cVY2qv5F5035M4be7',
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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .member-text' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'author_text_hover_back_color',
				'label' => __('Author Title Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}  .iq-team .iq-team-blog:hover .member-text',

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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .member-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'author_text_border_hover_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .member-text' => 'border-color: {{VALUE}};',

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
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .member-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog:hover .member-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog .member-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .member-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Author Name */



		/*  Designation Start*/

		$this->start_controls_section(
			'section_h8XA016qebeQ7aWb7xgC',
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
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized',
			]
		);


		$this->start_controls_tabs('auther_designationt_tabs');
		$this->start_controls_tab(
			'tabs_62jiY5Ub1Av280f5dP73',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized' => 'color: {{VALUE}};',

				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desig_text_back_color',
				'label' => __('Designation Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized',

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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'desig_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized' => 'border-color: {{VALUE}};',

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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_n2Le1sN1r2PuD2oj5l6d',
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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-specialized' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desig_text_hover_back_color',
				'label' => __('Designation Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-specialized',

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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-specialized' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'desig_text_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-specialized' => 'border-color: {{VALUE}};',

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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-specialized' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .iq-specialized' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-specialized' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}  .iq-team .iq-team-blog .iq-specialized' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* Author Name and Designation End*/



		/*  Content Start*/

		$this->start_controls_section(
			'section_1cGfa5wR2bt298y164FY',
			[
				'label' => __('Team Description', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'design_style' => ['7', '8'],
				],

			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_text_typography',
				'label' => __('Description Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .content-text',
			]
		);


		$this->start_controls_tabs('auther_desc_tabs');
		$this->start_controls_tab(
			'tabs_2eIBVdtW201CbuK1hLdS',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'desc_text_color',
			[
				'label' => __('Description Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .content-text' => 'color: {{VALUE}};',

				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desc_text_back_color',
				'label' => __('Designation Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .content-text',

			]
		);
		$this->add_control(
			'desc_text_border_style',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .content-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'desc_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .content-text' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'desc_text_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .content-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'desc_text_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .content-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_R11I2KhksF7woVd0e8HA',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'desc_hover_text_color',
			[
				'label' => __('Description Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .content-text' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desc_text_hover_back_color',
				'label' => __('Description Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .content-text',

			]
		);
		$this->add_control(
			'desc_text_hover_border_style',
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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .content-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'desc_text_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .content-text' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'desc_text_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .content-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'desc_text_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .content-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();





		$this->add_responsive_control(
			'desc_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .content-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'desc_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog .content-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* content End*/

		/*  phone Start*/

		$this->start_controls_section(
			'section_50cmj7pe52wCd1h1ZgtN',
			[
				'label' => __('Team Conact No:', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'design_style' => ['2', '5'],
				],

			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'phone_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .contact-text',
			]
		);


		$this->start_controls_tabs('auther_phone_tabs');
		$this->start_controls_tab(
			'tabs_4w2B3cN0mAFX1025lcCd',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'phone_text_color',
			[
				'label' => __('Contact Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .contact-text' => 'color: {{VALUE}};',

				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'phone_text_back_color',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .contact-text',

			]
		);
		$this->add_control(
			'phone_text_border_style',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .contact-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'phone_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .contact-text' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'phone_text_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .contact-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'phone_text_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .contact-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_c1c0ee6KmMbgAk27t6OZ',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'phone_hover_text_color',
			[
				'label' => __('Contact Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .contact-text' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'phone_text_hover_back_color',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .contact-text',

			]
		);
		$this->add_control(
			'phone_text_hover_border_style',
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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .contact-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'phone_text_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .contact-text' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'phone_text_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .contact-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'phone_text_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .contact-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();





		$this->add_responsive_control(
			'phone_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .contact-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'phone_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog .contact-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* phone End*/

		/*  Email Start*/

		$this->start_controls_section(
			'section_0Tx2k5e0ct75Mqs6ae24',
			[
				'label' => __('Team Email:', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'design_style' => ['2', '5'],
				],

			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'email_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .email-text',
			]
		);


		$this->start_controls_tabs('auther_email_tabs');
		$this->start_controls_tab(
			'tabs_zW5ha2P2e9mbJ8gIVRE1',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);
		$this->add_control(
			'email_text_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .email-text' => 'color: {{VALUE}};',

				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'email_text_back_color',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .email-text',

			]
		);
		$this->add_control(
			'email_text_border_style',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .email-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'email_text_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .email-text' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'email_text_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .email-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'email_text_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .email-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_r1RS6TlpbO8JIcd0WMay',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);
		$this->add_control(
			'email_hover_text_color',
			[
				'label' => __('Text Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .email-text' => 'color: {{VALUE}};',

				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'email_text_hover_back_color',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog:hover .email-text',

			]
		);
		$this->add_control(
			'email_text_hover_border_style',
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
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .email-text' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'email_text_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .email-text' => 'border-color: {{VALUE}};',

				],


			]
		);

		$this->add_control(
			'email_text_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .email-text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'email_text_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog:hover .email-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'email_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .email-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'email_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .iq-team .iq-team-blog .email-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		/* phone End*/

		/*Icon Icon start*/

		$this->start_controls_section(
			'section_fWfDo2d5TaiyzmcaU6f6',
			[
				'label' => __('Social Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'icon_color_svg_icon',
			[
				'label' => __('SVG Circle Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'design_style' => '2',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a svg circle' => 'stroke: {{VALUE}};',
				],

			]

		);

		$this->add_control(
			'icon_size',
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
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('Iconbox_icon_tabs');
		$this->start_controls_tab(
			'tabs_Nz2MVxYKZe02c1Tb3Oa0',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_color_2323',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'color: {{VALUE}};',
				],

			]

		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_iconbox_icon_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a',
			]
		);


		$this->add_control(
			'iq_iconbox_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => ['iq_iconbox_has_border' => ['yes']],
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => ['iq_iconbox_has_border' => ['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'border-color: {{VALUE}};',
				],


			]
		);



		$this->add_control(
			'iq_iconbox_icon_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => ['iq_iconbox_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => ['iq_iconbox_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_2VTw7g6fE2Dhzma2M12F',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __('Choose Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_iconbox_icon_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover',
			]
		);


		$this->add_control(
			'iq_iconbox_hover_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_style',
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
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],

				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover' => 'border-color: {{VALUE}};',
				],


			]
		);


		$this->add_control(
			'iq_iconbox_icon_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => ['iq_iconbox_hover_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'icon_width',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
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
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_iconbox_icon_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_iconbox_icon_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-team .iq-team-blog .iq-team-social ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Team/render.php';
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
