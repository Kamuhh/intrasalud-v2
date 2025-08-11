<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';
$image_scroll = '';
$settings = $this->get_settings_for_display();
$has_content = !Utils::is_empty($settings['title_text']) || !Utils::is_empty($settings['description_text']);
if ($settings['use_image_scroll'] == 'yes') {
    $image_scroll = ' hover-image-scroll';
}
$html = '<div class="scroll-img  kivicare-image-box ' . $image_scroll . '">';
if ($settings['image_has_link'] == 'yes') {
    if ($settings['imagebox_link_type'] == 'dynamic') {

        $url = '';

        if($settings['select_post_type'] == 'product'){
            $url = home_url().'/product/'.$settings['imagebox_product_link'];
        } elseif($settings['select_post_type'] == 'team'){
            $url = home_url().'/team/'.$settings['imagebox_team_link'];
        } elseif($settings['select_post_type'] == 'post'){
            $url = home_url().'/'.$settings['imagebox_post_link'];
        } elseif($settings['select_post_type'] == 'page'){
            $url =  get_permalink(get_page_by_path($settings['imagebox_dynamic_link']));
        }

        $this->add_render_attribute('link_attr', 'href', esc_url($url));
        $this->add_render_attribute('link_attr', 'rel', 'nofollow');

        if ($settings['is_new_tab'] == 'yes') {
            $this->add_render_attribute('link_attr', 'target', '_blank');
        }

    } else {
        if ($settings['image_box_link']['url']) {
            $url = $settings['image_box_link']['url'];
            $this->add_render_attribute('link_attr', 'href', esc_url($url));

            if ($settings['image_box_link']['nofollow']) {
                $this->add_render_attribute('link_attr', 'rel', 'nofollow');
            }
        }
    }
    $url = '';
}
if (!empty($settings['image']['url'])) {
    $this->add_render_attribute('image', 'src', $settings['image']['url']);
    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
    $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));

    if ($settings['hover_animation']) {
        $this->add_render_attribute('image', 'class', 'elementor-animation-' . $settings['hover_animation']);
    }

    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');

    if ($settings['image_has_link'] == 'yes') {
        $image_html = '<a ' . $this->get_render_attribute_string('link_attr') . '>' . $image_html . '</a>';
    }

    $html .= '<figure class="kivicare-image-box-img">' . $image_html . '</figure>';
}

if ($has_content) {
    $html .= '<div class="elementor-image-box-content">';

    if (!Utils::is_empty($settings['title_text'])) {
        $this->add_render_attribute('title_text', 'class', 'kivicare-image-box-title');
        $this->add_inline_editing_attributes('title_text', 'none');
        $title_html = $settings['title_text'];
        if ($settings['image_has_link'] == 'yes') {
            $title_html = '<a ' . $this->get_render_attribute_string('link_attr') . '>' . $title_html . '</a>';
        }

        $html .= sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['title_size']), $this->get_render_attribute_string('title_text'), $title_html);
    }

    if (!Utils::is_empty($settings['description_text'])) {
        $this->add_render_attribute('description_text', 'class', 'kivicare-image-box-description');

        $this->add_inline_editing_attributes('description_text');

        $html .= sprintf('<p %1$s>%2$s</p>', $this->get_render_attribute_string('description_text'), $settings['description_text']);
    }

    $html .= '</div>';
}

$html .= '</div>';

echo $html;
