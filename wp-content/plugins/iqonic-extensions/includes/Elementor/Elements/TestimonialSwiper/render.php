<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = $settings['align'];

if ($align == "text-left") {
    $align = "text-start";
} elseif ($align == "text-right") {
    $align = "text-end";
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {

    $align .= ' iq-box-shadow';
}
$args = array(
    'post_type'         => 'testimonial',
    'post_status'       => 'publish',
    'suppress_filters'  => 0,
    'posts_per_page'    => -1,
);

$wp_query = new \WP_Query($args);

$out = '';

global $post;

$desk = $settings['desk_number'];
$lap = $settings['lap_number'];
$tab = $settings['tab_number'];
$mob = $settings['mob_number'];


$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
$this->add_render_attribute('slider', 'data-spacebtslide', $settings['sw_space_slide']);

if ($settings['design_style'] == 1) {
    $align .= ' iq-testimonial-slick-1';
}

if ($settings['design_style'] == 2) {
    $align .= ' iq-testimonial-slick-2';
}

remove_filter('the_content', 'wpautop');

$id = iqonic_random_strings(); ?>

<div class="iq-testimonial-slick <?php echo esc_attr($align);  ?>">
    <div class="swiper <?php echo esc_attr($id); ?>" data-id="<?php echo esc_attr($id); ?>" <?php echo $this->get_render_attribute_string('slider'); ?>>
        <div class="swiper-wrapper">
            <?php
            if ($wp_query->have_posts()) {
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    if (function_exists('get_field')) {
                        $key =  get_field('key_pjros12', get_the_ID());
                        $designation  = $key['iqonic_testimonial_designation'];
                        $company  = $key['iqonic_testimonial_company'];
                        $star  = $key['star_select'];
                    }
                    
                    $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full"); ?>
                    <?php
                    if ($settings['design_style'] == 1) { ?>
                        <div class="swiper-slide" data-swiper-autoplay="2000">
                            <div class="iq-testimonial-info">
                                <div class="iq-testimonial-content">
                                    <p><?php the_content($wp_query->ID); ?></p>
                                </div>

                                <div class="iq-testimonial-member">
                                    <?php
                                    if ($settings['display_image'] == 'yes') {
                                    ?>
                                        <div class="iq-testimonial-avtar">
                                            <img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
                                        </div>
                                    <?php } ?>

                                    <div class="avtar-name">
                                        <div class="iq-lead">
                                            <?php the_title($wp_query->ID); ?>
                                        </div>
                                        <?php if(class_exists('get_field')) { ?>
                                        <span class="iq-post-meta">
                                            <?php echo esc_html($designation); ?> <?php echo esc_html($company); ?>
                                        </span>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php

                        wp_reset_postdata();
                    }
                    ?>
                    <?php
                    if ($settings['design_style'] == 2) {
                    ?>
                        <div class="swiper-slide" data-swiper-autoplay="2000">
                            <div class="iq-testimonial-info">
                                <div class="iq-testimonial-member">
                                    <?php
                                    if ($settings['display_image'] == 'yes') {
                                    ?>
                                        <div class="iq-testimonial-avtar">
                                            <img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
                                        </div>
                                    <?php } ?>

                                    <div class="avtar-name">
                                        <div class="iq-lead">
                                            <?php the_title($wp_query->ID); ?>
                                        </div>

                                        <?php if(class_exists('get_field')) { ?>
                                        <span class="iq-post-meta">
                                            <?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?>
                                        </span>
                                        <?php } ?>
                                    </div>

                                </div>

                                <div class="iq-testimonial-content">
                                    <p><?php the_content($wp_query->ID); ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                        wp_reset_postdata();
                    }
                }
                ?>
        </div>
        <!-- Add Pagination -->
        <?php
                if ($settings['slick_pagination'] == 'true') {
        ?>
            <div class="swiper-pagination"></div>
        <?php } ?>
        <!-- Add Arrows -->
        <?php
                if ($settings['nav-arrow'] == 'true') {
        ?>
            <div class="iq-swiper-arrow">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
    <?php }
            }
    ?>
    </div>
</div>