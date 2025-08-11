<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class Iq_Section_Before_color
{

  public function load()
  {
    add_action('elementor/element/column/section_advanced/before_section_start', array($this, 'before_render'));
    add_action('elementor/element/section/section_layout/after_section_end', array($this, 'register_controls'), 1);
  }

  public function register_controls($element)
  {
    $element->start_controls_section(
      'iq_before_color_section',
      [
        'label' => __('Before Color', 'iqonic'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control(
      'enable_before_color',
      [
        'label' => esc_html__('Enable Before Color', 'iqonic'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'iq_section_before_color',
      [
        'label' => esc_html__('Background Color', 'iqonic'),
        'type' => Controls_Manager::COLOR,
        'default' => '#07182f',
        'condition' => [
          'enable_before_color' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();
  }

  public function before_render($element)
  {
    $settings = $element->get_settings();

    if ($settings['enable_before_color'] === 'yes') {
      $element->add_render_attribute(
        '_wrapper',
        [

          'class' => 'iq-shape-bg',

        ]
      );
    }
  }
}
