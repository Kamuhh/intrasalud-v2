<?php

namespace Iqonic\Elementor\Elements\HamburgerAnimatedIcon;

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
        return 'iqonic_hamburger_animatedicon';
    }

    public function get_title()
    {
        return __('Iqonic Hamburger Animated Icon', 'iqonic');
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
				'label' => __('Hamburger animated icon', 'iqonic'),
			]
		);

		$this->add_control(
			'Hamburger_style',
			[
				'label'      => __('Icon Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'style1',
				'options'    => [
					'style1'       => __('Style 1', 'iqonic'),
					'style2'       => __('Style 2', 'iqonic'),
					'style3'       => __('Style 3', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'iqonic' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'iqonic' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'iqonic'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'iqonic'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'iqonic'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'iqonic'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .hamburger-icon' => 'text-align: {{VALUE}};',
                ],
            ]
        );


		$this->end_controls_section();

		/* text field */
		$this->start_controls_section(
			'section_Q6mN5ctWhXf7textfield',
			[
				'label' => __('Icon', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('titlebox_tabs');
        $this->start_controls_tab(
            'tabs_c8fpaelTGDkf951QeYf2',
            [
                'label' => __('Normal', 'iqonic'),
            ]
        );

		$this->add_control(
			'iq_text_field_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .burger-menu-style > div::before,
					{{WRAPPER}} .burger-menu-style > div,
					{{WRAPPER}} .burger-menu-style > div::after' => 'background: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_background_color',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
					{{WRAPPER}} .kivicare-hamburger-icon' => 'background: {{VALUE}};',
				],


			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
            'tabs_49pcfagYof19beG4w8Ee',
            [
                'label' => __('Hover', 'iqonic'),
            ]
        );

		$this->add_control(
			'iq_hover_color',
			[
				'label' => __('Icon Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .burger-menu-style:hover > div::before,
					{{WRAPPER}} .burger-menu-style:hover > div,
					{{WRAPPER}} .burger-menu-style:hover > div::after' => 'background: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_hover_background_color',
			[
				'label' => __('Background Color', 'iqonic'),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
					{{WRAPPER}} .kivicare-hamburger-icon:hover' => 'background: {{VALUE}};',
				],


			]
		);

		$this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();


		/* Button */

		$this->start_controls_section(
			'section_Q6mN5ctWhXf7ea90border',
			[
				'label' => __('Border', 'iqonic'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'iq_lists_has_border',
			[
				'label' => __('Set Custom Border?', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __('yes', 'iqonic'),
				'no' => __('no', 'iqonic'),
			]
		);
		$this->add_control(
			'iq_lists_border_style',
			[
				'label' => __('Border Style', 'iqonic'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'condition' => [
					'iq_lists_has_border' => 'yes',
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
					'{{WRAPPER}} .kivicare-hamburger-icon' => 'border-style: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'iq_lists_border_color',
			[
				'label' => __('Border Color', 'iqonic'),
				'condition' => [
					'iq_lists_has_border' => 'yes',
				],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kivicare-hamburger-icon' => 'border-color: {{VALUE}};',
				],


			]
		);

		$this->add_control(
			'iq_lists_border_width',
			[
				'label' => __('Border Width', 'iqonic'),
				'condition' => [
					'iq_lists_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%','em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-hamburger-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'iq_lists_border_radius',
			[
				'label' => __('Border Radius', 'iqonic'),
				'condition' => [
					'iq_lists_has_border' => 'yes',
				],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%' ,'em'],
				'selectors' => [
					'{{WRAPPER}} .kivicare-hamburger-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/HamburgerAnimatedIcon/render.php';
		if (Plugin::$instance->editor->is_edit_mode()) { 
			?>
		   <script>
			   (function(jQuery) {
				    callburgerIcon();
			   })(jQuery);
		   </script> 
			   <?php
	   }
    }
}
