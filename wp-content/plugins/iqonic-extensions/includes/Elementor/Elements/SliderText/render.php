<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$icon = '';
$html = '';
$tabs = $this->get_settings_for_display('tabs');
$tabs1 = $this->get_settings_for_display('rep_tabs1');
$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

$desk = $settings['desk_number'];
$lap = $settings['lap_number'];
$tab = $settings['tab_number'];
$mob = $settings['mob_number'];

$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
$this->add_render_attribute('slider', 'data-doteach', $settings['dot_each']);
$this->add_render_attribute('slider', 'data-centermode', $settings['centermode']);

$id = iqonic_random_strings();
if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

$this->add_render_attribute('iq_container', 'class', 'iq-btn-container');

$icon = '';
$this->add_render_attribute('iq_class', 'class', 'iq-button');
$html .= esc_html($settings['button_text']);

if (!empty($settings['text_color'])) {
    $this->add_render_attribute('iq_class', 'style', 'color:' . $settings['text_color'] . ';');
}

if ($settings['button_size'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_size']));
}
if ($settings['button_shape'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_shape']));
}

if ($settings['button_style'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_style']));

    if ($settings['button_style'] == 'iq-btn-flat') {
        if (!empty($settings['data_background'])) {
            $this->add_render_attribute('iq_class', 'style', 'background:' . $settings['data_background'] . ';');
        }
    }
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
if ($settings['design_style'] == '1') {
?>
    <div class="iq-slider-with-text <?php echo esc_attr($align);  ?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="slider slider-nav center">
                        <?php
                        foreach ($tabs as $index => $item) {
                            if ($item['media_style'] == 'image') {
                                if (!empty($item['image']['url'])) {
                                    $this->add_render_attribute('image', 'src', $item['image']['url']);
                                    $this->add_render_attribute('image', 'srcset', $item['image']['url']);
                                    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($item['image']));
                                    $this->add_render_attribute('image', 'title', Control_Media::get_image_title($item['image']));
                                    $image_html = Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'image');
                                }
                            }

                            if ($item['media_style'] == 'icon') {
                                $image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($item['selected_icon']['value']));
                            }
                        ?>
                            <li class="iq-slider-nav">
                                <?php echo $image_html; ?>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="slider slider-for center">
                        <?php
                        $url = '';
                        foreach ($tabs as $index => $item) {
                            $attr = '';
                            if ($item['link']['url']) {

                                $url = $item['link']['url'];
                                $attr .= ' href =' . $url;

                                if ($item['link']['is_external']) {
                                    $this->add_render_attribute('iq_class', 'target', '_blank');
                                    $attr .= ' target = _blank';
                                }

                                if ($item['link']['nofollow']) {
                                    $this->add_render_attribute('iq_class', 'rel', 'nofollow');
                                    $attr .= ' rel = nofollow';
                                }
                            }
                               ?>
                            <div class="slider-text">
                                <<?php echo esc_attr($settings['title_tag']);  ?> class="slider-title iq-heading-title">
                                    <?php echo esc_html($item['tab_title']); ?>
                                </<?php echo esc_attr($settings['title_tag']);  ?>>
                                <p class="slider-desc"><?php echo $this->parse_text_editor($item['description']); ?></p>
                                <div <?php echo $this->get_render_attribute_string('iq_container') ?>>
                                    <a <?php echo esc_attr($attr); ?> <?php echo $this->get_render_attribute_string('iq_class') ?>>
                                        <?php
                                        echo $html;
                                        ?>
                                    </a>
                                </div>
                            </div>
                               <?php
                            $attr = '';
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
<?php }

if ($settings['design_style'] == '2') { ?>

    <div class="iq-slider-with-text-2  owl-carousel <?php echo esc_attr($align);  ?>" data-id="<?php echo $id; ?>" <?php echo $this->get_render_attribute_string('slider'); ?>>
            <?php
            $url = '';
            foreach ($tabs1 as $index => $item) {
                if (!empty($item['image']['url'])) {
                    $this->add_render_attribute('image', 'src', $item['image']['url']);
                    $this->add_render_attribute('image', 'srcset', $item['image']['url']);
                    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($item['image']));
                    $this->add_render_attribute('image', 'title', Control_Media::get_image_title($item['image']));
                    $image_html = Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'image');
                }
            ?>
                <div class="item">
                    <div class="project-year">
                        <h5 class="slider-date text-center"><?php echo $item['tab_date']; ?></h5>
                        <div class="consulting-project">
                            <div class="consult-detail">
                                <?php echo $image_html; ?>
                            </div>

                            <div class="main-project clearfix text-left">
                                <div class="project-details">

                                    <<?php echo esc_attr($settings['title_tag']);  ?> class="slider-title mb-2 iq-heading-title">
                                        <?php echo esc_html($item['tab_title']); ?>
                                    </<?php echo esc_attr($settings['title_tag']);  ?>>
                                    <p class="slider-desc mb-0"><?php echo $this->parse_text_editor($item['description']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
    </div>
<?php }
