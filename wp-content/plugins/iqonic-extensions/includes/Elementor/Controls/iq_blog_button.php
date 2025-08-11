<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';

$settings = $this->get_settings();

$align = '';
$iq_container = array();
$iq_class = array();
$target = '';
$rel = '';

array_push($iq_container, 'iq-btn-container');

$icon = '';

if ($settings['button_type'] === "styled") {
    array_push($iq_class, 'iq-button-style-2');
    $html .= '<span class="iq-btn-text-holder">' . esc_html($settings['button_text']) . '</span>';
} else {
    array_push($iq_class, 'iq-button');
    $html .=  esc_html($settings['button_text']);
}

if ($settings['button_size'] != 'default') {
    array_push($iq_class, $settings['button_size']);
}

if ($settings['button_shape'] != 'default') {
    array_push($iq_class, $settings['button_shape']);
}

if ($settings['button_style'] != 'default') {
    array_push($iq_class, $settings['button_style']);
}

if ($settings['has_icon'] == 'yes') {
    array_push($iq_class, $settings['has_icon']);
    if ($settings['button_type'] === "styled") {
        $icon = sprintf(
            '<span class="iq-btn-icon-holder">
                                <i aria-hidden="true" class="%1$s"></i>
                                </span>',
            esc_attr($settings['button_icon']['value'])
        );
    } else {
        $icon = sprintf(
            '<i aria-hidden="true" class="%1$s"></i>
                                ',
            esc_attr($settings['button_icon']['value'])
        );
    }


    if ($settings['icon_position'] == 'right') {
        $html .= $icon;
        array_push($iq_class, 'btn-icon-right');
    }

    if ($settings['icon_position'] == 'left') {

        $html = $icon . $html;
        array_push($iq_class, 'btn-icon-left');
    }
}
$link =  isset($static_link) ?  $static_link : get_the_permalink();

$target_attr = '';
$rel_attr = '';

if (!empty($target)) {
    $target_attr = 'target = "' . $target . '"';
}

if (!empty($rel)) {
    $rel_attr = 'rel = "' . $rel . '"';
}

?>
<div class="<?php echo esc_attr(implode(" ", $iq_container)); ?>">

    <a class="<?php echo esc_attr(implode(" ", $iq_class));  ?>" href="<?php echo esc_url($link); ?>" <?php echo $target_attr . "  " . $rel_attr; ?>>
        <?php
        echo $html;
        ?>
    </a>
</div>

<?php
$align = '';
$iq_container = array();
$iq_class = array();
$target = '';
$rel = '';
$html = '';
?>