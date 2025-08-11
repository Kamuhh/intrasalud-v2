<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
global $theme_prefix_php;
$theme_prefix_php = !isset($theme_prefix_php) ? "php_prefix" : $theme_prefix_php;

$iq_logo_text   = isset($settings['logo_text']) ? get_bloginfo('name') : '';
$iq_logo_slogan = get_bloginfo('description', 'display');
$logo_option = ($settings['logo_option']) ? $settings['logo_option'] : 'custom';
?>
<a class="navbar-brand widget-logo  <?php echo esc_attr(!empty($settings['add_custom_class']) ? $settings['add_custom_class'] : ''); ?>" href="<?php echo esc_url(home_url('/')); ?>">
    <?php
    $logo = '';
    if (function_exists('get_field') &&  'acf' == $logo_option) {
        $key = get_field('header_logo', get_queried_object_id());
        if (!empty($key['url'])) {
            $logo = $key['url'];
            $alt = (!empty($key['alt'])) ? $key['alt'] : esc_html__("iqonic", 'iqonic-layouts');
            $logo = '<img class="logo_image" src="' . esc_url($logo) . '" alt="' . $alt . '">';
        }
    }
    if (function_exists('get_opt_name') && 'theme' == $logo_option) {
        $options = get_option(\get_opt_name());


        if (isset($options[$theme_prefix_php . '_logo']['url']) && !empty($options[$theme_prefix_php . '_logo']['url'])) {
            $settings['logo']['url'] = $options[$theme_prefix_php . '_logo']['url'];
        } /* else if (isset($options[$slug . '_logo']['url']) && !empty($options[$slug . '_logo']['url'])) {
            $settings['logo']['url'] = $options[$slug . '_logo']['url'];
        } */

        $alt = esc_html__("iqonic", 'iqonic-layouts');
        if ($settings['logo']['url']) {
            $logo = '<img class="logo_image" src="' . esc_url($settings['logo']['url']) . '" alt="' . $alt . '">';
        }
    }

    if ('custom' == $logo_option || empty($logo)) {
        $alt = esc_html__("iqonic", 'iqonic-layouts');
        if (!empty($settings['logo']['id'])) {
            $alt = get_post_meta($settings['logo']['id'], '_wp_attachment_image_alt', TRUE);
        }
        if ($settings['logo']['url']) {
            $logo = '<img class="logo_image" src="' . esc_url($settings['logo']['url']) . '" alt="' . $alt . '">';
        }
    }

    if (!empty($logo)) {
        echo $logo;
    } else {
        if (!empty($iq_logo_text)) {
            echo '<span class="logo_text">' . $iq_logo_text . '</span>';
        }
        if (!empty($iq_logo_slogan)) {
            echo '<span class="logo_slogan">' . $iq_logo_slogan . '</span>';
        }
    }
    ?>
</a>