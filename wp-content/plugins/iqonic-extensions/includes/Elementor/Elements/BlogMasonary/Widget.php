<?php

namespace Iqonic\Elementor\Elements\BlogMasonary;

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
        return 'Iq_Blog_Masonary';
    }

    public function get_title()
    {
        return __('Blog Masonary', 'iqonic');
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
			'Section_Portfolio',
			[
				'label' => __('Blog Post', 'iqonic'),
			]
		);
		$this->add_control(
			'title_size',
			[
				'label' => __('HTML Tag', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h5',
			]
		);

		$this->add_control(
			'dis_tabs',
			[
				'label' => __('Show Tab', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
				'default' => 'yes',
			]
		);


		$this->end_controls_section();

		/*Portfolio Tab start*/

		$this->start_controls_section(
			'section_tabASDADSAdfsdfSDubH84ygQCK15Ow',
			[
				'label' => __('Filter Tab', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['dis_tabs' => 'yes']
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfoliobox_tabs_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}}  .isotope-filters button',
			]
		);

		$this->start_controls_tabs('portfoliobox_tabs_tabs');
		$this->start_controls_tab(
			'tabs_tabsQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'portfoliobox_tabs_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}  .isotope-filters button ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}}  .isotope-filters button',
			]
		);



		$this->add_control(
			'iq_portfoliobox_tabs_block_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
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
					'{{WRAPPER}}  .isotope-filters button' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_tabsf34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'portfoliobox_tabs_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .isotope-filters button.active,{{WRAPPER}} .isotope-filters button:hover' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .isotope-filters button.active,{{WRAPPER}} .isotope-filters button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .isotope-filters button.active,{{WRAPPER}} .isotope-filters button:hover',
			]
		);




		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
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
					'{{WRAPPER}}  .isotope-filters button:hover , {{WRAPPER}} .isotope-filters button.active' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button:hover , {{WRAPPER}} .isotope-filters button.active' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button:hover, {{WRAPPER}} .isotope-filters button.active' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => ['iq_portfoliobox_tabs_block_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button:hover,{{WRAPPER}} .isotope-filters button.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_portfoliobox_tabs_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .isotope-filters button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_tabs_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .isotope-filters button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->end_controls_section();
		/* Portfolio Tab end*/

		/*Portfolio Box start*/
		$this->start_controls_section(
			'section_9S4dsPubH84ygQCK15Ow',

			[
				'label' => __('Blog Box', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('portfoliobox_tabs');
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9L',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq-portfolio_background',
				'label' => __('Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-portfolio ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq-portfolio_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-portfolio',
			]
		);

		$this->add_control(
			'iq-portfolio_block_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);

		$this->add_control(
			'iq-portfolio_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
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
					'{{WRAPPER}} .iq-portfolio' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq-portfolio_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq-portfolio_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq-portfolio_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_f34OqKF8Xeo9l3h4jUwH',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq-portfolio_hover_background',
				'label' => __('Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-portfolio:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq-portfolio_hover_box_shadow',
				'label' => __('Box Shadow', 'iqonic'),
				'selector' => '{{WRAPPER}} .iq-portfolio:hover',
			]
		);




		$this->add_control(
			'iq-portfolio_hover_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
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
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq-portfolio_hover_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iq-portfolio_hover_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq-portfolio_hover_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => ['iq-portfolio_block_has_border' => ['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq-portfolio_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq-portfolio_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();
		/* Portfolio box end*/

		/* Portfolio Details Start */

		/*Portfolio Title start*/
		$this->start_controls_section(
			'section_titlesASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __('Title', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfoliobox_title_text_typography',
				'label' => __('Typography', 'iqonic'),
				'selector' => '{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .post-title',
			]
		);

		$this->start_controls_tabs('portfoliobox_title_tabs');
		$this->start_controls_tab(
			'tabs_titleQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __('Normal', 'iqonic'),
			]
		);

		$this->add_control(
			'portfoliobox_title_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .post-title' => 'color: {{VALUE}};',
				],

			]

		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_titlef34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __('Hover', 'iqonic'),
			]
		);

		$this->add_control(
			'portfoliobox_title_hover_color',
			[
				'label' => __('Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .post-title:hover' => 'color: {{VALUE}};',
				],

			]

		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_portfoliobox_title_padding',
			[
				'label' => __('Padding', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_title_margin',
			[
				'label' => __('Margin', 'iqonic'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_9S4dsPubH84y15Ow',

			[
				'label' => __('Meta', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'post_meta_color',
			[
				'label' => __('Post Meta Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .iq-blog-meta ul li a , {{WRAPPER}}  .iq-portfolio .iq-portfolio-content .iq-blog-meta ul li i' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_control(
			'post_hover_meta_color',
			[
				'label' => __('Post Meta Hover Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .iq-blog-meta ul li:hover a , {{WRAPPER}}  .iq-portfolio .iq-portfolio-content .iq-blog-meta ul li:hover i' => 'color: {{VALUE}};',
				],

			]

		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_9S4dsPubH84y1w',

			[
				'label' => __('Tag', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'post_tag_color',
			[
				'label' => __('Post Tag Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .iq-cat-name' => 'color: {{VALUE}};',
				],

			]

		);

		$this->add_control(
			'post_hover_tag_color',
			[
				'label' => __('Post Tag Hover Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content .iq-cat-name:hover' => 'color: {{VALUE}};',
				],

			]

		);
		$this->add_control(
			'background_heading',
			[
				'label' => __('Tag Background', 'iqonic'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tag_background',
				'label' => __('Tag Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-cat-name',
			]
		);

		$this->add_control(
			'background_hover_heading',
			[
				'label' => __('Tag Hover Background', 'iqonic'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tag_hover_background',
				'label' => __('Tag Hover Background', 'iqonic'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-cat-name:hover',
			]
		);

		$this->end_controls_section();

		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_btn_controls.php';

		$this->start_controls_section(
			'section_21h1Myn3Vx5qrK29565',
			[
				'label' => __('Post Control', 'iqonic'),
			]
		);
		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/post-control.php';


    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/BlogMasonary/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
             ?>
            <script>
                (function(jQuery) {
                    callBlogMasonry();
                })(jQuery);
            </script> 
                <?php
        }
    }
}
