<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$html = '';
$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$has_icon = !empty($settings['icon']);
$tabs = $this->get_settings_for_display('tabs');
$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' kivicare-box-shadow';
}

$active = $settings['active'];
if ($active === "yes") {
    $align .= ' active';
}

if (!empty($settings['image']['url'])) {
    $this->add_render_attribute('image', 'src', $settings['image']['url']);
    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
    $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
}

if($settings['pricing_style'] == '1') { ?>
    <div class="kivicare-price-container kivicare-price-table-1 <?php echo esc_attr($align); ?> kivicare-outerbox">
        <div class="kivicare-inner-box">
            <div class="kivicare-price-header">
                <div class="price-heading">
                    <div class="kivicare-price-box">
                        <div class="pricing-heading">
                            <<?php echo $settings['title_tag']; ?> class="kivicare-price-title">
                                <?php echo esc_html($settings['price_title']); ?>
                            </<?php echo $settings['title_tag']; ?>>
                            <?php echo esc_html($settings['price_label']); ?>
                        </div>
                        <?php
                        $currency = iqonic_currency('value', $settings['currency_symbol']); ?>
                        <div class="kivicare-price">
                            <div class="kivicare-Price-symbol">
                                <<?php echo $settings['price_tag']; ?> class="price">
                                    <small class="dollar"><?php echo $currency; ?></small><?php echo esc_html($settings['price']); ?><small class="month"><?php echo esc_html($settings['time_period']); ?></small>
                                </<?php echo $settings['price_tag']; ?>>
                            </div>
                        </div>               
                    </div>
                    <?php if(!empty($image_html)){ ?>
                        <div class="icon-box-img">
                            <?php echo $image_html; ?>
                        </div>
                    <?php } ?> 
                </div> 
                <?php
                if (!empty($settings['description'])) {
                    echo '<p class="kivicare-price-description">' . esc_html($settings['description']) . '</p>';
                }
                ?>           
            </div>
            
            <div class="kivicare-price-body">
                <?php if (!empty($settings['services_title'])) : ?>
                    <<?php echo $settings['services_title_tag']; ?>>
                        <?php echo $settings['services_title']; ?>
                    </<?php echo $settings['services_title_tag']; ?>>
                <?php endif; ?>
                <ul class="kivicare-price-service">
                    <?php
                    foreach ($tabs as $index => $item) {
                        if ($item['has_service_active'] == 'yes') {
                            $class = 'active';
                        } else {
                            $class = 'inactive';
                        }
                    ?>
                        <li class="<?php echo esc_attr($class); ?>">
                            <?php \Elementor\Icons_Manager::render_icon( $item['service_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html($item['tab_title']) ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="kivicare-price-footer">
                <?php if ($settings['button_text'] && $settings['link']) {
                    require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
                } ?>
            </div>
        </div>
    </div>

<?php } elseif($settings['pricing_style'] == '2') { ?>
    <div class="kivicare-price-container kivicare-price-table-2 <?php echo esc_attr($align); ?> kivicare-outerbox">
        <div class="kivicare-inner-box">
            <div class="kivicare-price-header">
                <div class="price-heading">
                    <div class="kivicare-price-box">
                        <div class="pricing-heading">
                            <<?php echo $settings['title_tag']; ?> class="kivicare-price-title">
                                <?php echo esc_html($settings['price_title']); ?>
                            </<?php echo $settings['title_tag']; ?>>
                                <?php echo esc_html($settings['price_label']); ?>
                        </div>

                        <?php
                        if (!empty($settings['description'])) {
                            echo '<p class="kivicare-price-description">' . esc_html($settings['description']) . '</p>';
                        } ?>
                    </div>

                    <?php if(!empty($image_html)){ ?>
                        <div class="icon-box-img">
                            <?php echo $image_html; ?>
                        </div>
                    <?php } ?>
                </div>     
            </div>
            
            <div class="kivicare-price-body">
                <?php if (!empty($settings['services_title'])) : ?>
                    <<?php echo $settings['services_title_tag']; ?> class="kivicare-service-title">
                        <?php echo $settings['services_title']; ?>
                    </<?php echo $settings['services_title_tag']; ?>>
                <?php endif;

                $currency = iqonic_currency('value', $settings['currency_symbol']); ?>
                <div class="kivicare-price">
                    <div class="kivicare-Price-symbol">
                        <<?php echo $settings['price_tag']; ?> class="price">
                            <small class="dollar"><?php echo $currency; ?></small><?php echo esc_html($settings['price']); ?><small class="month"><?php echo esc_html($settings['time_period']); ?></small>
                        </<?php echo $settings['price_tag']; ?>>
                    </div>
                </div>

                <ul class="kivicare-price-service">
                    <?php
                    foreach ($tabs as $index => $item) {
                        if ($item['has_service_active'] == 'yes') {
                            $class = 'active';
                        } else {
                            $class = 'inactive';
                        } ?>

                        <li class="<?php echo esc_attr($class); ?>">
                            <?php \Elementor\Icons_Manager::render_icon( $item['service_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html($item['tab_title']) ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="kivicare-price-footer">
                <?php if ($settings['button_text'] && $settings['link']) {
                    require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
                } ?>
            </div>
        </div>
    </div>

<?php } ?>