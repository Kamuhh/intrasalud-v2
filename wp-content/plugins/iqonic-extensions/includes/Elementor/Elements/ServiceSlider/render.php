<?php

namespace Elementor;

$html = '';
if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$args = array();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
global $post;



$args = array(
    'post_type' => 'service',
    'post_status' => 'publish',
    'paged' => $paged,
    'order' => $settings['order'],
    'posts_per_page' => $settings['dis_number'],
);

if (!empty($settings['iqonic_select_services'])) {
    $args['post_name__in'] = $settings['iqonic_select_services'];
}

$wp_query = new \WP_Query($args);

$id = iqonic_random_strings();

if ($wp_query->have_posts()) { ?>

    <?php if ($settings['service_style'] == '1') {
        
        $this->add_render_attribute('slider', 'data-items', $settings['sw_slide']);
        $this->add_render_attribute('slider', 'data-items-laptop', $settings['sw_laptop_no']);
        $this->add_render_attribute('slider', 'data-items-tab', $settings['sw_tab_no']);
        $this->add_render_attribute('slider', 'data-items-mobile', $settings['sw_mob_no']);
        $this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['sw_mob_no']);
        $this->add_render_attribute('slider', 'data-loop', $settings['sw_loop']);
        $this->add_render_attribute('slider', 'data-centered_slides', $settings['centered_slides']);
        $this->add_render_attribute('slider', 'data-enable_autoplay', $settings['sw_enable_autoplay']);
        $this->add_render_attribute('slider', 'data-autoplay', $settings['sw_autoplay']);
        $this->add_render_attribute('slider', 'data-spacebtslide', $settings['sw_space_slide']); ?>

        <div class="swiper swiper-container kivicare-service-slider kivicare-service-slider-1 <?php echo esc_attr($id); ?>" data-id="<?php echo esc_attr($id); ?>" <?php echo $this->get_render_attribute_string('slider'); ?>>
            <div class="swiper-wrapper">
                <?php 
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full"); ?>
                    <div class="swiper-slide iq-service-slide">

                        <div class="service-content "> <?php
                        if (function_exists('get_field')) {
                            if (get_field('field_service_icon_one', get_the_ID() , true)) {
                                $icon = get_field('field_service_icon_one', get_the_ID() , true);
                                $svg = $icon['url'];
                                $svg = file_get_contents($svg);
                                $filetype = wp_check_filetype($icon['filename']);
                                    if ($filetype['ext'] == 'svg') { ?>
                                        <?php echo $svg; ?>
                                <?php } else { ?>
                                    <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr__('image', 'iqonic'); ?>" />
                                <?php }
                            }
                         }  else {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="57" viewBox="0 0 80 57" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M64.6851 0.23658C73.8999 1.98181 80.4261 10.2119 79.9783 19.5231C79.7594 24.0748 78.0107 28.1396 74.8489 31.4469C72.5035 33.9002 69.8073 35.5551 66.726 36.4325C65.9705 36.6476 65.3082 36.868 65.2541 36.922C65.1065 37.0696 66.078 39.2597 67.1179 41.1239C68.4731 43.5532 69.9336 45.6886 72.0944 48.3997C73.7245 50.4448 74.0487 50.9505 74.2195 51.7135C74.6033 53.4289 73.8001 55.1242 72.21 55.955C70.9319 56.6227 70.0235 56.5826 67.6159 55.7523C55.3711 51.5302 47.063 42.6593 43.9909 30.527C42.9663 26.4807 42.7312 24.5435 42.726 20.1075C42.7225 17.0117 42.7781 16.0352 43.0132 15.069C44.7698 7.84528 49.8193 2.42326 56.5282 0.556976C57.827 0.195507 58.5204 0.114197 60.7533 0.061271C62.6131 0.0171935 63.8077 0.0704543 64.6851 0.23658ZM22.418 0.341597C28.5396 1.62652 33.6893 5.89552 35.9609 11.5688C37.0362 14.254 37.1906 15.1299 37.2018 18.6049C37.2113 21.5751 37.1826 21.8819 36.7515 23.425C34.9568 29.8471 29.8711 34.9706 23.7281 36.5449C22.7315 36.8003 22.5285 36.9087 22.5706 37.163C22.5988 37.3326 23.1082 38.4561 23.7029 39.6595C25.0419 42.3698 27.258 45.7576 29.3785 48.3359C31.2253 50.5817 31.61 51.3057 31.6151 52.5448C31.6196 53.6317 31.333 54.3458 30.5392 55.2244C29.1777 56.7314 27.6505 56.7788 24.0221 55.4264C8.8271 49.7628 0.0189514 36.7205 8.39233e-05 19.8571C-0.00375366 16.388 0.128143 15.455 0.982643 12.9095C3.17033 6.39273 8.70922 1.49128 15.2985 0.241254C17.1853 -0.116708 20.454 -0.0706273 22.418 0.341597Z" fill="white"></path></svg>'; 
                          }  ?>
                            <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-title iq-heading-title">
                                <?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
                            </<?php echo esc_attr($settings['title_tag']); ?>>

                            <?php if ($settings['iqonic_show_content'] == 'yes') {  ?>
                                <p class="iq-service-desc m-0"><?php echo sprintf("%s", esc_html(get_the_excerpt($wp_query->ID))); ?></p>
                            <?php }

                            if ($settings['has_button'] == "yes") {
                                require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                            }
                            ?>
                        </div>

                    </div> <?php
                }
                wp_reset_postdata(); ?>
            </div>
            <?php if ($settings['want_pagination'] == "true") { ?>
                <div class="swiper-pagination"></div> <?php
            } ?>

            <?php if ($settings['want_nav'] == "true") { ?>
                <div class="iq-swiper-arrow">
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>
                </div> <?php
        } ?>
        </div>

    <?php } ?>

    <?php if ($settings['service_style'] == '2') { ?>
        <div class="swiper kivicare-service-slider kivicare-service-slider-2 <?php echo esc_attr($id); ?>" data-id="<?php echo esc_attr($id); ?>" >
            <div class="swiper-wrapper">
                <?php 
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full"); ?>
                    <div class="swiper-slide iq-service-slide">
                        <div class="service-content">
                            <div class="service-content-image">
                                <?php echo sprintf('<img src="%1$s" alt="iqonic-service"/>', esc_url($full_image[0], 'iqonic')); ?>
                            </div>
                            <div class="service-content-inner">
                                <div class="service-content-wrapper">
                                    <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-title iq-heading-title">
                                        <?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
                                    </<?php echo esc_attr($settings['title_tag']); ?>>

                                    <?php if ($settings['iqonic_show_content'] == 'yes') {  ?>
                                        <p class="iq-service-desc"><?php echo sprintf("%s", esc_html(get_the_excerpt($wp_query->ID))); ?></p>
                                    <?php }

                                    if ($settings['has_button'] == "yes") {
                                        require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                                    }
                                    ?>
                                </div> 
                            </div>
                        </div>
                    </div> <?php
                }
                wp_reset_postdata(); ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>