<?php

namespace Iqonic\Elementor\Elements\Gallery;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_gallery';
    }

    public function get_title()
    {
        return __('Iqonic Gallery', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-posts-carousel';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_client',
            [
                'label' => __('Gallery Post', 'iqonic'),

            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Choose Image', 'iqonic'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'tabs',
            [
                'label' => __('List Items', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );


        $this->add_control(
            'has_icon',
            [
                'label' => __('Use Icon', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'block',
                'options'    => [
                    'block'          => __('Yes', 'iqonic'),
                    'none'          => __('No', 'iqonic'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .iqonic-masonry-grid .gallery-overlay .view-image' => 'display: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();


        /* Gallery Box Start*/

        $this->start_controls_section(
            'section_jpdZo4adyfPfER8bqVQF',
            [
                'label' => __('Gallery Box', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_client_box_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-gallery',
            ]
        );


        $this->add_control(
            'kivicare_client_box_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );
        $this->add_control(
            'kivicare_client_box_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'condition' => [
                    'kivicare_client_box_has_border' => 'yes',
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
                    '{{WRAPPER}} .kivicare-gallery' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'kivicare_client_box_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'condition' => [
                    'kivicare_client_box_has_border' => 'yes',
                ],
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-gallery' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'kivicare_client_box_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'condition' => [
                    'kivicare_client_box_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-gallery' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_client_box_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'condition' => [
                    'kivicare_client_box_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-gallery' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_client_box_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-gallery' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_client_box_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-gallery' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );


        $this->end_controls_section();

        /* Gallery Box End*/

        /* Gallery List Start*/

        $this->start_controls_section(
            'section_avb386YbL4372yhufPre',
            [
                'label' => __('Gallery List', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_client_list_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .kivicare-gallery .iqonic-masonry-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kivicare_client_list_box_shadow',
                'label' => __('Box Shadow', 'iqonic'),
                'selector' => '{{WRAPPER}} .kivicare-gallery .iqonic-masonry-item',
            ]
        );


        $this->add_control(
            'kivicare_client_list_has_border',
            [
                'label' => __('Set Custom Border?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );
        $this->add_control(
            'kivicare_client_list_border_style',
            [
                'label' => __('Border Style', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'condition' => [
                    'kivicare_client_list_has_border' => 'yes',
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
                    '{{WRAPPER}} .kivicare-gallery .iqonic-masonry-item ' => 'border-style: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'kivicare_client_list_border_color',
            [
                'label' => __('Border Color', 'iqonic'),
                'condition' => [
                    'kivicare_client_list_has_border' => 'yes',
                ],
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .kivicare-gallery .iqonic-masonry-item' => 'border-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_control(
            'kivicare_client_list_border_width',
            [
                'label' => __('Border Width', 'iqonic'),
                'condition' => [
                    'kivicare_client_list_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-gallery .iqonic-masonry-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'kivicare_client_list_border_radius',
            [
                'label' => __('Border Radius', 'iqonic'),
                'condition' => [
                    'kivicare_client_list_has_border' => 'yes',
                ],
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .kivicare-gallery .iqonic-masonry-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_client_list_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-gallery .iqonic-masonry-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'kivicare_client_list_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .kivicare-gallery .iqonic-masonry-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'section_TndjH507wEm8s',
            [
                'label' => __('Before Hover', 'iqonic'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'kivicare_client_list_before_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .iqonic-masonry-grid .gallery-overlay::before',
            ]
        );

        $this->end_controls_section();

        /* Gallery list End*/

        // Icon Style Start
        $this->start_controls_section(
            'section_iconTo1FsPY6B33a',
            [
                'label' => __('Icon', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['has_icon' => 'block'],
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label' => __('Icon Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iqonic-masonry-grid .gallery-overlay .view-image svg path' => 'fill: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'btn_icon_bg_color',
            [
                'label' => __('Background Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .iqonic-masonry-grid .gallery-overlay .view-image' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Gallery/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                   callMasonry();
               })(jQuery);
           </script> 
               <?php
       }    }
}
