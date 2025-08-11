<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}
$this->add_render_attribute('render_attribute', 'data-date', esc_attr($settings['future_date']));

if ($settings['show_label']) {
    $label = "true";
} else {
    $label = "false";
}
$this->add_render_attribute('render_attribute', 'data-labels', esc_attr($label));
$this->add_render_attribute('render_attribute', 'data-format', esc_attr($settings['timer_format']));
?>

<div class="iq-count-down <?php echo esc_attr($align); ?>">
    <span class="iq-data-countdown-timer" <?php echo $this->get_render_attribute_string('render_attribute'); ?>></span>
</div>