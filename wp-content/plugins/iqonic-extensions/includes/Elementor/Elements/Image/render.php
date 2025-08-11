<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';
$image_html = "";
$page_name = array();
$pages=iqonic_get_posts('page');


$settings = $this->get_settings_for_display();
$settings = $this->get_settings();
if (isset($settings['image']['url']) && !empty($settings['image']['url'])) {
    $this->add_render_attribute('image', 'src', $settings['image']['url']);
    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
}
$this->add_render_attribute('container_class', 'class', 'wow kivicare-image-effect');
if ("tilt" === $settings['image_effect']) {
    $this->add_render_attribute('container_class', 'class', 'tilt-effect');
    $this->add_render_attribute('tilt_effect', 'data-tilt', '');
    $this->add_render_attribute('tilt_effect', 'data-tilt-speed', $settings['data_tilt']);
    $this->add_render_attribute('tilt_effect', 'data-tilt-perspective', $settings['data_tilt_perspective']);
}
if ("rotation" === $settings['image_effect']) {
    $this->add_render_attribute('container_class', 'class', 'rotation-effect');
}

?>
<div <?php echo $this->get_render_attribute_string('container_class') ?> <?php echo $this->get_render_attribute_string('tilt_effect') ?>>
    <?php
    if ('custom' === $settings['link_type'] && isset($settings['link']['url'])) {
        $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
        echo !empty($settings['link']['url']) ? '<a class="image-box-link" href="' . esc_url($settings['link']['url']) . '"' . $target . $nofollow . '></a>' : '';
    }
    elseif ('page' === $settings['link_type']) {
        $link = home_url().'/'.$settings['pages_link'];
        echo '<a class="image-box-link" href="' . esc_url($link) . '"></a>' ;
    }
    ?>
    <?php echo ($image_html) ? $image_html : ''; ?>
</div>