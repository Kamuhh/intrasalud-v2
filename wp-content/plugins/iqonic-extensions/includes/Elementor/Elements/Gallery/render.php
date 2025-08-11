<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$image_html = '';  ?>

<div class="kivicare-gallery">
    <div class="iqonic-masonry-block iqonic-metro-block">
        <div class="iqonic-masonry-grid">
            <div class="grid-sizer"></div>
            <?php
            $iqonic_masonary = 1;
            foreach ($tabs as $index => $item) {
                if (!empty($item['image']['url'])) {
                    $this->add_render_attribute('image', 'src', $item['image']['url']);
                    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($item['image']));
                    $this->add_render_attribute('image', 'title', Control_Media::get_image_title($item['image']));
                    if ($iqonic_masonary === 2 || $iqonic_masonary === 4) {
                        $image_html = wp_get_attachment_image_src($item['image']['id'], 'kivicare-verticle');
                        $mm_grid = "iqonic-masonry-item s-25 portrait";
                    } else {
                        $image_html = wp_get_attachment_image_src($item['image']['id'], 'kivicare-landscape');
                        $mm_grid = "iqonic-masonry-item s-25 sqaure";
                    }
                    $image_full = wp_get_attachment_image_src($item['image']['id'], 'full');
                }
                ?>
                <div class="<?php echo esc_attr($mm_grid); ?>">
                    <a href="<?php echo esc_url($image_full[0]); ?>">
                        <div class="gallery-overlay position-relative">
                            <?php if(!empty($image_html[0])){ ?>
                                <a class="iq-image-popup" href="<?php echo esc_url($image_full[0]); ?>" title="images">
                                    <img src="<?php echo esc_url($image_html[0]); ?>" class="gallery-image" alt="<?php echo esc_attr("Image", 'iqonic'); ?>">
                                    <div class="view-image">
                                        <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.8983 4.7877C15.7554 4.59216 12.3496 0 7.99992 0C3.65019 0 0.244313 4.59217 0.101531 4.78751C-0.0338438 4.97301 -0.0338438 5.2246 0.101531 5.4101C0.244313 5.60564 3.65019 10.1978 7.99992 10.1978C12.3496 10.1978 15.7554 5.60561 15.8983 5.41026C16.0339 5.22479 16.0339 4.97301 15.8983 4.7877ZM7.99992 9.14286C4.79588 9.14286 2.02085 6.09495 1.19938 5.09854C2.01979 4.10126 4.78901 1.05494 7.99992 1.05494C11.2038 1.05494 13.9787 4.10232 14.8005 5.09926C13.9801 6.09651 11.2108 9.14286 7.99992 9.14286Z" fill="var(--white-color)"/>
                                        <path d="M7.99981 1.93408C6.25474 1.93408 4.83496 3.35387 4.83496 5.09893C4.83496 6.844 6.25474 8.26378 7.99981 8.26378C9.74487 8.26378 11.1647 6.844 11.1647 5.09893C11.1647 3.35387 9.74487 1.93408 7.99981 1.93408ZM7.99981 7.20881C6.83637 7.20881 5.88993 6.26234 5.88993 5.09893C5.88993 3.93552 6.8364 2.98905 7.99981 2.98905C9.16321 2.98905 10.1097 3.93552 10.1097 5.09893C10.1097 6.26234 9.16325 7.20881 7.99981 7.20881Z" fill="var(--white-color)"/>
                                        </svg>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </a>
                </div>
                <?php
                if ($iqonic_masonary === 6) {
                    $iqonic_masonary = 1;
                } else {
                    $iqonic_masonary++;
                }
            }
            ?>
        </div>
    </div>
</div>