<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$container_id = !empty($settings['panel_id']) ? $settings['panel_id'] : '';
$class = !empty($settings['class']) ? $settings['class'] : '';

$position = !empty($settings['position']) ? $settings['position'] . '-slide' : '';
$uniq_class = !empty($settings['hidden_class']) ? $settings['hidden_class'] : '';
$class .= ' ' . 'iqonic-custom-layout-' . $this->get_id() . ' ' . $position . ' ' . $uniq_class;

$style = 'style=display:none;';
if ($settings['hide_close'] == 'yes') {
    $icon = false;
} elseif ($settings['panel_close_btn_icon']['library'] == 'svg') {
    $icon['value'] = $settings['panel_close_btn_icon']['value']['url'];
    $icon['type'] = true;
} else {
    $icon['value'] = $settings['panel_close_btn_icon']['value'];
    $icon['type'] = false;
}

if ($settings['set_heigth_width'] == 'yes') {
    if ($settings['position'] === 'left' || $settings['position'] === 'right'); {
        $style .= ($settings['width']['size'] !== 0) ? 'width:' . $settings['width']['size'] . $settings['width']['unit'] . ';' : '';
    }
    if ($settings['position'] == 'top' || $settings['position'] == 'bottom') {
        $style .= ($settings['height']['size'] !== 0) ? 'height:' . $settings['height']['size'] . $settings['height']['unit'] . ';' : '';
    }
}
if (!empty($container_id) && isset($settings['layout'])) {
    $my_layout = get_page_by_path($settings['layout'], '', 'iqonic_hf_layout');
    $template_id = isset($my_layout->ID) ? $my_layout->ID : '';
    if (!empty($template_id)) {
        if (get_option('_custom_layout_ids') && !empty(get_option('_custom_layout_ids'))) {
            $old_option = get_option('_custom_layout_ids');
            $has_same_id = false;
            foreach ($old_option as $key => $val) {
                if ($container_id == $val['container_id']) {
                    $has_same_id = true;
                }
            }
            if (!$has_same_id) {
                $new_option = [['template_id' => $template_id, 'container_id' => $container_id, 'class' => trim($class), 'style' => $style, 'panel_icon' => $icon]];
                $options = array_merge($new_option, $old_option);
                update_option('_custom_layout_ids', $options);
            }
        } else {
            $option = [['template_id' => $template_id, 'container_id' => $container_id, 'class' => trim($class), 'style' => $style, 'panel_icon' => $icon]];
            update_option('_custom_layout_ids', $option);
        }
    }
}
?>
<label style="display: none;"></label>