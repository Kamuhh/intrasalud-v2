<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';


$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');

$image_html = '';
if ($settings['media_style'] == 'image') {
    if (!empty($settings['image']['url'])) {
        $this->add_render_attribute('image', 'src', $settings['image']['url']);
        $this->add_render_attribute('image', 'srcset', $settings['image']['url']);
        $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
        $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
    }
}

if ($settings['media_style'] == 'icon') {
    if (!isset($settings['selected_icon']['value']['url'])) {
        $image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['selected_icon']['value']));
    } else {
        $image_html = file_get_contents($settings['selected_icon']['value']['url']);
    }
}
if ($settings['media_style'] == 'text') {
    $image_html = sprintf('<span>%1$s</span>', esc_html($settings['choose_text']));
}
?>

<div class="kivicare-icon-box-list">
    <div class="kivicare-icon-box-content">
        <div class="kivicare-img-area">
            <?php
            echo $image_html; ?>
        </div>
        <div class="kivicare-icon-details">
            <?php if ($settings['section_title']) { ?>
                <<?php echo esc_attr($settings['title_tag']);  ?> class="kivicare-icon-title"> <?php echo sprintf('%1$s', esc_html($settings['section_title'])); ?></<?php echo esc_attr($settings['title_tag']);  ?>>
            <?php } ?>

            <?php if ($settings['display_list'] == 'yes') {
             
                if ($settings['list_style'] == 'icon') {
                ?>
                    <div class="kivicare-list">
                        <ul class="kivicare-list-with-icon">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <?php if ($settings['list_style'] == 'icon') {
                                        if (!empty($settings['list_icon']['value']) || !empty($settings['list_icon']['value']['url'])) {
                                            Icons_Manager::render_icon($settings['list_icon'], ['aria-hidden' => 'true']);
                                        }
                                    }  ?>
                                <p><?php echo esc_html($item['tab_title']); ?></p>
                                </li>

                            <?php  }
                            ?>
                        </ul>
                    </div>

                <?php }
                if ($settings['list_style'] == 'image') {
                ?>
                    <div class="kivicare-list">
                        <ul class="kivicare-list-with-img">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <img src="<?php echo esc_url($settings['list_image']['url']); ?>">
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ul>
                    </div>
            <?php }
            } ?>

            <?php if (!empty($settings['button_text']) && $settings['show_button'] == 'yes') {
				require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			} ?>

        </div>
    </div>
</div>