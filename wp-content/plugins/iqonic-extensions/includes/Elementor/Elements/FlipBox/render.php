<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = $settings['align'];
$image_html = '';
$html = '';

if($align == "text-left") {
    $align = "text-start" . ' ' . $settings['flip'];
} elseif($align == "text-right") {
    $align = "text-end" . ' ' . $settings['flip'];
} elseif($align == "text-center") {
    $align = "text-center" . ' ' . $settings['flip'];
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

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
    $image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['selected_icon_flip_box']['value'], 'iqonic'));
}
// Get Button Style
$this->add_render_attribute('iq_container', 'class', 'iq-flip-button');
$icon = '';
$this->add_render_attribute('iq_class', 'class', 'iq-button');
$html .= esc_html($settings['button_text']);

if ($settings['button_size'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_size']));
}
if ($settings['button_shape'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_shape']));
}

if ($settings['button_style'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_style']));

    if ($settings['button_style'] == 'iq-btn-outline') {
        if (!empty($settings['data_border'])) {
            $this->add_render_attribute('iq_class', 'style', 'border-color:' . $settings['data_border'] . ';');
        }
    }
}

if ($settings['has_icon'] == 'yes') {
    $this->add_render_attribute('iq_class', 'class', 'has-icon');
    $icon = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['selected_icon']['value']));

    if ($settings['icon_position'] == 'right') {
        $html .= $icon;
        $this->add_render_attribute('iq_class', 'class', 'btn-icon-right');
    }

    if ($settings['icon_position'] == 'left') {

        $html = $icon . $html;
        $this->add_render_attribute('iq_class', 'class', 'btn-icon-left');
    }
}
if ($settings['has_box_shadow'] == 'yes') {

    $this->add_render_attribute('iq_class', 'class', 'iq-btn-shadow');
}

if ($settings['link']['url']) {
    $this->add_render_attribute('iq_class', 'href', esc_url($settings['link']['url']));

    if ($settings['link']['is_external']) {
        $this->add_render_attribute('iq_class', 'target', '_blank');
    }

    if ($settings['link']['nofollow']) {
        $this->add_render_attribute('iq_class', 'rel', 'nofollow');
    }
}
// Button Style End  
?>

<div class="iq-flip-box <?php echo esc_attr($align); ?>">
    <div class="flipbox-wrapper">
        <div class="front-side">
            <?php
            if ($settings['flip_icon_position'] == 'front' && $settings['media_style'] != 'none') {
            ?>
                <div class="flip-media">
                    <?php echo $image_html; ?>
                </div>

            <?php }  ?>

            <?php
            if ($settings['title_position'] == 'front' && !empty($settings['section_title'])) {
            ?>
                <<?php echo esc_attr($settings['title_tag']); ?> class="flipbox-title iq-heading-title">
                    <?php echo esc_html($settings['section_title']) ?>
                </<?php echo esc_attr($settings['title_tag']); ?>>
            <?php }
            if ($settings['desc_position'] == 'front' && !empty($settings['description'])) {
            ?>
                <div class="flipbox-details">
                    <?php echo $this->parse_text_editor($settings['description']);  ?>
                </div>
            <?php }
            if ($settings['button_position'] == 'front' && $settings['use_button'] == 'yes') {
            ?>
                <div <?php echo $this->get_render_attribute_string('iq_container') ?>>
                    <a <?php echo $this->get_render_attribute_string('iq_class') ?>>
                        <?php
                        echo $html;
                        ?>
                    </a>
                </div>
            <?php } ?>
        </div>

        <div class="back-side">
            <div class="flipbox-content">
                <?php
                if ($settings['flip_icon_position'] == 'back' && $settings['media_style'] != 'none') {
                ?>
                    <div class="flip-media">
                        <?php echo $image_html; ?>
                    </div>

                <?php }  ?>

                <?php
                if ($settings['title_position'] == 'back' && !empty($settings['section_title'])) {
                ?>
                    <<?php echo esc_attr($settings['title_tag']); ?> class="flipbox-title iq-heading-title">
                        <?php echo esc_html($settings['section_title']) ?>
                    </<?php echo esc_attr($settings['title_tag']); ?>>
                <?php }
                if ($settings['desc_position'] == 'back' && !empty($settings['description'])) {
                ?>
                    <div class="flipbox-details">
                        <?php echo $this->parse_text_editor($settings['description']);  ?>
                    </div>

                <?php }
                if ($settings['button_position'] == 'back' && $settings['use_button'] == 'yes') {
                ?>
                    <div <?php echo $this->get_render_attribute_string('iq_container') ?>>
                        <a <?php echo $this->get_render_attribute_string('iq_class') ?>>
                            <?php
                            echo $html;
                            ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
