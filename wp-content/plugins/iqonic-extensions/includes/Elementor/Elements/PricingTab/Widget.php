<?php

namespace Iqonic\Elementor\Elements\PricingTab;

use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_pricing_tab';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Pricing Tab', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-link';
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section',
            [
                'label' => esc_html__('Pricing Tabs', 'iqonic'),
            ]
        );

        $repeater = new Repeater();
    
        $repeater->add_control(
            'list_title',
            [
                'label' => esc_html__('Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab one', 'iqonic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
			'list_shortcode',
			[
				'label' => esc_html__( 'Enter your shortcode', 'iqonic' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => '[gallery id="123" size="medium"]',
				'default' => '',
			]
		);

        $this->add_control(
            'list',
            [
                'label' => esc_html__('List', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'item_actions' => [
					'add'       => false,
					'duplicate' => true,
					'remove'    => true,
					'sort'      => true,
				],
                'default' => [
					[
					],
					[
					],
                ],
                '{{{title_field}}}' => '{{{list_title}}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_service_title_style',
            [
                'label' => esc_html__('Title', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'service_title_text_typography',
                'label' => esc_html__('Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-service-list .service-name',
            ]
        );

        $this->add_control(
            'service_title_text_normal_color',
            [
                'label' => esc_html__('Choose Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iq-price-container .service-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'service_title_text_active_color',
            [
                'label' => esc_html__('Active Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iq-price-container .service-name.active,
                    {{WRAPPER}}  .iq-price-container .service-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label' => esc_html__('Active Background Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iq-price-container .service-name.active,
                    {{WRAPPER}} .iq-price-container .service-name:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        require 'render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { ?>
            <script>
                (function($) {
                    pricingTab();
                })(jQuery);
            </script>
            <?php
        }
    }
}
