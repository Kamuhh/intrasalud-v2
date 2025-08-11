<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
if (!empty($settings['orientation']) && $settings['orientation'] === 'vertical') {
    $this->add_render_attribute('ba-attributes', 'data-orientation', $settings['orientation']);
}
?>
<div class='kivicare-ba-img-container' <?php echo $this->get_render_attribute_string('ba-attributes'); ?>>
    <img src="<?php echo esc_url($settings['image_before']['url']); ?>" alt="<?php esc_attr_e($settings['image_before']['alt']); ?>"/>
    <img src="<?php echo esc_url($settings['image_after']['url']); ?>" alt="<?php esc_attr_e($settings['image_after']['alt']); ?>"/>
</div>