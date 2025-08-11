<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$html = '';
$align = '';
$icon = '';

$this->add_render_attribute('iq_container', 'class', 'iq-btn-container');

if ($settings['button_type'] === "styled") {
    $this->add_render_attribute('iq_class', 'class', 'iq-button-style-2');
    $html .= '<span class="iq-btn-text-holder">' . esc_html($settings['button_text']) . '</span>';
} elseif ($settings['button_type'] === "style3") {
    $this->add_render_attribute('iq_class', 'class', 'iq-new-btn-style iq-button-style-2');
    $html .= '<span class="iq-btn-text-holder">' . esc_html($settings['button_text']) . '</span>';
} elseif ($settings['button_type'] === "style4") {
    $this->add_render_attribute('iq_class', 'class', 'iq-button iq-btn-link iq-btn-link-new');
    $html .=  esc_html($settings['button_text']);
} else {
    $this->add_render_attribute('iq_class', 'class', 'iq-button');
    $html .=  esc_html($settings['button_text']);
}

if ($settings['button_size'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_size']));
}

if ($settings['button_shape'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_shape']));
}

if ($settings['button_style'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_style']));
}

if ($settings['has_icon'] == 'yes') {
    $this->add_render_attribute('iq_class', 'class', 'has-icon');
    if ($settings['button_type'] === "styled") {
        $icon = sprintf(
            '<span class="iq-btn-icon-holder">
                                <i aria-hidden="true" class="%1$s"></i>
                                </span>',
            esc_attr($settings['button_icon']['value'], 'iqonic')
        );
    } else {
        $icon = sprintf(
            '<i aria-hidden="true" class="%1$s"></i>
                                ',
            esc_attr($settings['button_icon']['value'], 'iqonic')
        );
    }


    if ($settings['icon_position'] == 'right') {

        if ( $settings['button_type'] === "style3" ){
            $html .= '<span class="iq-btn-icon-holder">'.$icon.'</span>';
        } elseif( $settings['button_type'] === "style4" ){
            $html .= '<span class="btn-link-icon">'.$icon.'</span>';
        } else {
            $html .= $icon;
        }

        $this->add_render_attribute('iq_class', 'class', 'btn-icon-right');
    }

    if ($settings['icon_position'] == 'left') {

        $html = $icon . $html;

        $this->add_render_attribute('iq_class', 'class', 'btn-icon-left');
    }
}

if ($settings['button_action'] == 'dynamic') {

    $url = '';

    if($settings['select_post_type'] == 'product'){
        $url = home_url().'/product/'.$settings['dynamic_link_product'];
    } elseif($settings['select_post_type'] == 'team'){
        $url = home_url().'/team/'.$settings['dynamic_link_team'];
    } elseif($settings['select_post_type'] == 'post'){
        $url = home_url().'/'.$settings['dynamic_link_post'];
    } elseif($settings['select_post_type'] == 'page'){
        $url =  get_permalink(get_page_by_path($settings['dynamic_link']));
    }

    $this->add_render_attribute('iq_class', 'href', esc_url($url));

} elseif ($settings['button_action'] == 'link') {
    if ($settings['link']['url']) {
        $url = $settings['link']['url'];
        $this->add_render_attribute('iq_class', 'href', esc_url($url));

        if ($settings['link']['is_external']) {
            $this->add_render_attribute('iq_class', 'target', '_blank');
        }

        if ($settings['link']['nofollow']) {
            $this->add_render_attribute('iq_class', 'rel', 'nofollow');
        }
        $url = '';
    }
}

$modalid = '';
if ($settings['button_action'] == 'popup') {
    $modalid = 'mymodal' . rand(10, 1000);

    $this->add_render_attribute('iq_class', 'data-toggle', 'modal');
    $this->add_render_attribute('iq_class', 'data-target', '#' . $modalid);
    $this->add_render_attribute('iq_class', 'href', '#' . $modalid);
}

if(  !empty($settings['button_text']) && $settings['has_butoon'] == 'yes' ) { ?>
    <div <?php echo $this->get_render_attribute_string('iq_container') ?>>
        <a <?php echo $this->get_render_attribute_string('iq_class') ?>>
            <?php echo $html; ?>
        </a>
    </div>
    <?php
}

if ($settings['button_action'] == 'popup') {
    $icon = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['model_selected_icon']['value']));
?>
    <div class="iq-modal">
        <div class="modal fade" id="<?php echo esc_attr($modalid); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo $settings['model_title'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><?php echo $icon; ?></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $this->parse_text_editor($settings['model_body']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <?php 
}
