<?php

namespace Elementor;

$html = '';
if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');

$args = array();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
global $post;

if ($settings['service_layout_option'] == 'static') {
    $tabs = $this->get_settings_for_display('tabs');
} else {

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
}

$hoverclass = '';
if ($settings['iqonic_hover_effect'] == 'yes') {
    $hoverclass = "kivicare-hovereffect";
}

$iconhoverclass = '';
if ($settings['iqonic_icon_hover_effect'] == 'yes') {
    $iconhoverclass = "pulse-shrink-on-hover";
}

$wp_query = new \WP_Query($args);

$blog_layout = '';
if ($settings['service_layout_style'] == 'style1') {
    $blog_layout = "kivicare-service-style1";
} else if ($settings['service_layout_style'] == 'style2') {
    $blog_layout = "kivicare-service-style2";
} else if ($settings['service_layout_style'] == 'style3') {
    $blog_layout = "kivicare-service-style3";
}

?>
<div class="kivicare-service-grid">
    <div class="row">
        <?php if ($settings['service_layout_option'] == 'static') {
            foreach ($tabs as $item) {

                if ($item['tab_link_type'] == 'dynamic') {
                    $url =  get_permalink(get_page_by_path($item['tab_dynamic_link'], OBJECT, 'service'));
                    $this->add_render_attribute('kivicare_class', 'href', esc_url($url));
                } else {
                    if ($item['tab_link']['url']) {
                        $url = $item['tab_link']['url'];
                        $this->add_render_attribute('kivicare_class', 'href', esc_url($url));

                        if ($item['tab_link']['is_external']) {
                            $this->add_render_attribute('kivicare_class', 'target', '_blank');
                        }

                        if ($item['tab_link']['nofollow']) {
                            $this->add_render_attribute('kivicare_class', 'rel', 'nofollow');
                        }
                    }
                }

                $static_link  = $url;
                if ($settings['service_layout_style'] == 'style1') { ?>
                    <div class="<?php echo esc_attr($settings['service_grid_style']); ?>">
                        <div class="kivicare-service-blog <?php echo esc_attr($blog_layout); ?> <?php echo esc_attr($hoverclass); ?>">
                            <div class="kivicare-box-title">
                                <a href="<?php echo !empty($static_link) ? esc_url($static_link) : '#' ?>">
                                    <<?php echo $settings['title_tag']; ?> class="kivicare-heading-title">
                                        <?php echo sprintf("%s", esc_html($item['tab_title'], 'iqonic')); ?>
                                    </<?php echo $settings['title_tag']; ?>>
                                </a>
                            </div>
                            <div class="kivicare-service-main-detail">
                                <?php if ($settings['iqonic_show_content'] == 'yes') { ?>
                                    <p class="kivicare-description">
                                        <?php echo $item['tab_content']; ?>
                                    </p>
                                <?php
                                } ?>
                            </div>
                            <div class="kivicare-image">
                                <div class="iq-service-image">
                                    <?php
                                    if ($item['media_style'] == 'icon') { ?>
                                        <div class="icon">
                                            <?php \Elementor\Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']); ?>
                                        </div>
                                        <!-- if image -->
                                    <?php
                                    } else if ($item['media_style'] == 'image') { ?>
                                        <img src="<?php echo esc_url($item['tab_image']['url']) ?>" alt="service-image" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php if ($item['has_icon'] == "yes") { ?>
                                <div class="kivicare-service-box-icon <?php echo esc_attr($iconhoverclass); ?>">
                                    <?php \Elementor\Icons_Manager::render_icon($item['selected_icon_before'], ['aria-hidden' => 'true']); ?>
                                </div>
                            <?php } ?>


                            <?php if ($settings['has_button'] == "yes") {
                                require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                            } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($settings['service_layout_style'] == 'style2') {
                ?>
                    <div class="<?php echo esc_attr($settings['service_grid_style']); ?>">
                        <div class="kivicare-service-blog <?php echo esc_attr($blog_layout); ?> <?php echo esc_attr($hoverclass); ?>">
                            <div class="kivicare-service-box-icon <?php echo esc_attr($iconhoverclass); ?>">
                                <?php
                                if ($item['media_style'] == 'icon') { ?>
                                    <div class="icon">
                                        <?php \Elementor\Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']); ?>
                                    </div>
                                    <!-- if image -->
                                <?php
                                } else if ($item['media_style'] == 'image') { ?>
                                    <img src="<?php echo esc_url($item['tab_image']['url']) ?>" alt="service-image" />
                                <?php
                                }
                                ?>
                            </div>
                            <div class="kivicare-service-info">
                                <div class="kivicare-service-main-detail">
                                    <a href="<?php echo !empty($static_link) ? esc_url($static_link) : '#' ?>">
                                        <<?php echo esc_attr($settings['title_tag']);  ?> class="kivicare-service-text kivicare-heading-title">
                                            <?php echo sprintf("%s", esc_html($item['tab_title'], 'iqonic')); ?>
                                        </<?php echo esc_attr($settings['title_tag']); ?>>
                                    </a>

                                    <?php if ($settings['iqonic_show_content'] == 'yes') {  ?>
                                        <p class="kivicare-description"> <?php echo $item['tab_content']; ?></p>
                                    <?php } ?>
                                    <?php
                                    if ($settings['has_button'] == "yes") {
                                        require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                if ($settings['service_layout_style'] == 'style3') { ?>
                    <div class="<?php echo esc_attr($settings['service_grid_style']); ?>">
                        <div class="kivicare-service-blog <?php echo esc_attr($blog_layout); ?>">
                            <div class="kivicare-image">
                                <?php
                                if ($item['media_style'] == 'icon') { ?>
                                    <div class="icon">
                                        <?php \Elementor\Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']); ?>
                                    </div>
                                    <!-- if image -->
                                <?php
                                } else if ($item['media_style'] == 'image') { ?>
                                    <img src="<?php echo esc_url($item['tab_image']['url']) ?>" alt="service-image" />
                                <?php
                                }
                                ?>
                            </div>

                            <div class="kivicare-service-inner">
                                <?php if ($item['iqonic_show_category'] == 'yes' && !empty($item['tab_category'])) { ?>
                                    <div class="kivicare_team-category">
                                        <a href="<?php echo esc_url($item['tab_category_link']['url']) ?>" class="kivicare-cat-link">
                                            <?php echo esc_html($item['tab_category']); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="kivicare-box-title">
                                    <a href=" <?php echo !empty($static_link) ? esc_url($static_link) : '#' ?>">
                                        <<?php echo $settings['title_tag']; ?> class="kivicare-heading-title">
                                            <?php echo sprintf("%s", esc_html($item['tab_title'], 'iqonic')); ?>
                                        </<?php echo $settings['title_tag']; ?>>
                                    </a>
                                </div>
                                <div class="kivicare-service-main-detail">
                                    <?php if ($settings['iqonic_show_content'] == 'yes') { ?>
                                        <p class="kivicare-description">
                                            <?php echo $item['tab_content']; ?>
                                        </p>
                                    <?php
                                    } ?>
                                </div>
                                <?php if ($settings['has_button'] == "yes") {
                                    require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                                } ?>
                                <div class="kivicare-service-box-icon <?php echo esc_attr($iconhoverclass); ?>">
                                    <?php \Elementor\Icons_Manager::render_icon($item['selected_icon_before'], ['aria-hidden' => 'true']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php }
            }
        } ?>
        <?php
        if ($wp_query->have_posts()) {
            $count = 0;
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "kivicare-small-thumbnail");
                $terms = wp_get_post_terms($post->ID, 'service_categories'); ?>

                <?php if ($settings['service_layout_style'] == 'style1') { ?>
                    <div class="<?php echo esc_attr($settings['service_grid_style']); ?>">
                        <div class="kivicare-service-blog <?php echo esc_attr($blog_layout); ?> <?php echo esc_attr($hoverclass); ?>">
                            <a href="<?php the_permalink(); ?>" target="_blank" class="card-link"></a>
                                <div class="kivicare-box-title">
                                    <<?php echo $settings['title_tag']; ?> class="kivicare-heading-title">
                                        <?php echo sprintf("%s", esc_html__(get_the_title($wp_query->ID), 'iqonic')); ?>
                                    </<?php echo $settings['title_tag']; ?>>
                                </div>
                                <div class="kivicare-service-main-detail">
                                    <?php
                                        if ($settings['iqonic_show_content'] == 'yes') {
                                            $post_object = get_post($post->ID);
                                            $excerpt = $post_object->post_excerpt;
                                            if (!empty($excerpt)) {
                                        ?>
                                                <p class="kivicare-description test">
                                                    <?php echo $excerpt; ?>
                                                </p>
                                        <?php
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="kivicare-image">
                                    <?php if (!empty($full_image[0])) { ?>
                                        <div class="iq-service-image">
                                            <?php echo get_the_post_thumbnail(); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="kivicare-service-box-icon <?php echo esc_attr($iconhoverclass); ?>">
                                    <?php
                                    if (function_exists('get_field')) {
                                    if (get_field('field_service_icon_one', get_the_ID())) {
                                        $icon = get_field('field_service_icon_one', get_the_ID());
                                        $svg = $icon['url'];
                                        $svg = file_get_contents($svg);
                                        $filetype = wp_check_filetype($icon['filename']);
                                        if ($filetype['ext'] == 'svg') { ?>
                                            <?php echo $svg; ?>
                                        <?php } else { ?>
                                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr__('image', 'iqonic'); ?>" />
                                    <?php }
                                    }
                                } else {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="57" viewBox="0 0 80 57" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M64.6851 0.23658C73.8999 1.98181 80.4261 10.2119 79.9783 19.5231C79.7594 24.0748 78.0107 28.1396 74.8489 31.4469C72.5035 33.9002 69.8073 35.5551 66.726 36.4325C65.9705 36.6476 65.3082 36.868 65.2541 36.922C65.1065 37.0696 66.078 39.2597 67.1179 41.1239C68.4731 43.5532 69.9336 45.6886 72.0944 48.3997C73.7245 50.4448 74.0487 50.9505 74.2195 51.7135C74.6033 53.4289 73.8001 55.1242 72.21 55.955C70.9319 56.6227 70.0235 56.5826 67.6159 55.7523C55.3711 51.5302 47.063 42.6593 43.9909 30.527C42.9663 26.4807 42.7312 24.5435 42.726 20.1075C42.7225 17.0117 42.7781 16.0352 43.0132 15.069C44.7698 7.84528 49.8193 2.42326 56.5282 0.556976C57.827 0.195507 58.5204 0.114197 60.7533 0.061271C62.6131 0.0171935 63.8077 0.0704543 64.6851 0.23658ZM22.418 0.341597C28.5396 1.62652 33.6893 5.89552 35.9609 11.5688C37.0362 14.254 37.1906 15.1299 37.2018 18.6049C37.2113 21.5751 37.1826 21.8819 36.7515 23.425C34.9568 29.8471 29.8711 34.9706 23.7281 36.5449C22.7315 36.8003 22.5285 36.9087 22.5706 37.163C22.5988 37.3326 23.1082 38.4561 23.7029 39.6595C25.0419 42.3698 27.258 45.7576 29.3785 48.3359C31.2253 50.5817 31.61 51.3057 31.6151 52.5448C31.6196 53.6317 31.333 54.3458 30.5392 55.2244C29.1777 56.7314 27.6505 56.7788 24.0221 55.4264C8.8271 49.7628 0.0189514 36.7205 8.39233e-05 19.8571C-0.00375366 16.388 0.128143 15.455 0.982643 12.9095C3.17033 6.39273 8.70922 1.49128 15.2985 0.241254C17.1853 -0.116708 20.454 -0.0706273 22.418 0.341597Z" fill="white"></path></svg>'; 
                                } ?>
                                </div>
                                <?php if ($settings['has_button'] == "yes") {
                                    require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                                } ?>    
                        </div>
                    </div>
                <?php } ?>

                <?php if ($settings['service_layout_style'] == 'style2') { ?>
                    <div class="<?php echo esc_attr($settings['service_grid_style']); ?>">
                        <div class="kivicare-service-blog <?php echo esc_attr($blog_layout); ?> <?php echo esc_attr($hoverclass); ?>">
                            <div class="kivicare-service-box-icon <?php echo esc_attr($iconhoverclass); ?>">
                                <?php
                                if (function_exists('get_field')) {
                                if (get_field('field_service_icon_one', get_the_ID())) {
                                    $icon = get_field('field_service_icon_one', get_the_ID());
                                    $svg = $icon['url'];
                                    $svg = file_get_contents($svg);
                                    $filetype = wp_check_filetype($icon['filename']);
                                    if ($filetype['ext'] == 'svg') { ?>
                                        <?php echo $svg; ?>
                                    <?php } else { ?>
                                        <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr__('image', 'iqonic'); ?>" />
                                <?php }
                                } 
                            } else {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="57" viewBox="0 0 80 57" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M64.6851 0.23658C73.8999 1.98181 80.4261 10.2119 79.9783 19.5231C79.7594 24.0748 78.0107 28.1396 74.8489 31.4469C72.5035 33.9002 69.8073 35.5551 66.726 36.4325C65.9705 36.6476 65.3082 36.868 65.2541 36.922C65.1065 37.0696 66.078 39.2597 67.1179 41.1239C68.4731 43.5532 69.9336 45.6886 72.0944 48.3997C73.7245 50.4448 74.0487 50.9505 74.2195 51.7135C74.6033 53.4289 73.8001 55.1242 72.21 55.955C70.9319 56.6227 70.0235 56.5826 67.6159 55.7523C55.3711 51.5302 47.063 42.6593 43.9909 30.527C42.9663 26.4807 42.7312 24.5435 42.726 20.1075C42.7225 17.0117 42.7781 16.0352 43.0132 15.069C44.7698 7.84528 49.8193 2.42326 56.5282 0.556976C57.827 0.195507 58.5204 0.114197 60.7533 0.061271C62.6131 0.0171935 63.8077 0.0704543 64.6851 0.23658ZM22.418 0.341597C28.5396 1.62652 33.6893 5.89552 35.9609 11.5688C37.0362 14.254 37.1906 15.1299 37.2018 18.6049C37.2113 21.5751 37.1826 21.8819 36.7515 23.425C34.9568 29.8471 29.8711 34.9706 23.7281 36.5449C22.7315 36.8003 22.5285 36.9087 22.5706 37.163C22.5988 37.3326 23.1082 38.4561 23.7029 39.6595C25.0419 42.3698 27.258 45.7576 29.3785 48.3359C31.2253 50.5817 31.61 51.3057 31.6151 52.5448C31.6196 53.6317 31.333 54.3458 30.5392 55.2244C29.1777 56.7314 27.6505 56.7788 24.0221 55.4264C8.8271 49.7628 0.0189514 36.7205 8.39233e-05 19.8571C-0.00375366 16.388 0.128143 15.455 0.982643 12.9095C3.17033 6.39273 8.70922 1.49128 15.2985 0.241254C17.1853 -0.116708 20.454 -0.0706273 22.418 0.341597Z" fill="white"></path></svg>'; 
                            }?>
                            </div>

                            <div class="kivicare-service-info">
                                <div class="kivicare-service-main-detail">
                                    <a href="<?php the_permalink(); ?>">
                                        <<?php echo esc_attr($settings['title_tag']);  ?> class="kivicare-service-text kivicare-heading-title">
                                            <?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
                                        </<?php echo esc_attr($settings['title_tag']); ?>>
                                    </a>

                                    <?php
                                    if ($settings['iqonic_show_content'] == 'yes') {
                                        $post_object = get_post($post->ID);
                                        $excerpt = $post_object->post_excerpt;
                                        if (!empty($excerpt)) {
                                            ?>
                                            <p class="kivicare-description test">
                                                <?php echo $excerpt; ?>
                                            </p>
                                            <?php
                                        }
                                    }

                                    if ($settings['has_button'] == "yes") {
                                        require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                if ($settings['service_layout_style'] == 'style3') { ?>
                    <div class="<?php echo esc_attr($settings['service_grid_style']); ?>">
                        <div class="kivicare-service-blog <?php echo esc_attr($blog_layout); ?>">
                            <div class="kivicare-image">
                                <?php if (!empty($full_image[0])) { ?>
                                    <div class="iq-service-image">
                                        <?php echo get_the_post_thumbnail(); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="kivicare-service-inner">
                                <div class="kivicare_team-category">
                                    <?php
                                    $total_post = count($terms);
                                    $count = 0;
                                    if ($terms) {
                                        foreach ($terms as $term) {
                                            $count++; ?>
                                            <a href="<?php echo esc_url(get_category_link($term->term_id)) ?>"><?php echo esc_html($term->name); ?></a>
                                    <?php }
                                        if ($count < $total_post) {
                                            echo '&ebsp;';
                                        }
                                    } ?>
                                </div>
                                <div class="kivicare-box-title">
                                    <a href=" <?php the_permalink(); ?>">
                                        <<?php echo $settings['title_tag']; ?> class="kivicare-heading-title">
                                            <?php echo sprintf("%s", esc_html(get_the_title($post->ID), 'iqonic')); ?>
                                        </<?php echo $settings['title_tag']; ?>>
                                    </a>
                                </div>
                                <div class="kivicare-service-main-detail">
                                <?php
                                if ($settings['iqonic_show_content'] == 'yes') {
                                    $post_object = get_post($post->ID);
                                    $excerpt = $post_object->post_excerpt;
                                    if (!empty($excerpt)) {
                                ?>
                                        <p class="kivicare-description test">
                                            <?php echo $excerpt; ?>
                                        </p>
                                <?php
                                    }
                                }
                                ?>
                                </div>
                                <?php if ($settings['has_button'] == "yes") {
                                    require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
                                } ?>
                                <div class="kivicare-service-box-icon <?php echo esc_attr($iconhoverclass); ?>">
                                    <?php
                                    if (function_exists('get_field')) {
                                    if (get_field('field_service_icon_one', get_the_ID())) {
                                        $icon = get_field('field_service_icon_one', get_the_ID());
                                        $svg = $icon['url'];
                                        $svg = file_get_contents($svg);
                                        $filetype = wp_check_filetype($icon['filename']);
                                        if ($filetype['ext'] == 'svg') { ?>
                                            <?php echo $svg; ?>
                                        <?php } else { ?>
                                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr__('image', 'iqonic'); ?>" />
                                    <?php }
                                    }
                                 } else {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="57" viewBox="0 0 80 57" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M64.6851 0.23658C73.8999 1.98181 80.4261 10.2119 79.9783 19.5231C79.7594 24.0748 78.0107 28.1396 74.8489 31.4469C72.5035 33.9002 69.8073 35.5551 66.726 36.4325C65.9705 36.6476 65.3082 36.868 65.2541 36.922C65.1065 37.0696 66.078 39.2597 67.1179 41.1239C68.4731 43.5532 69.9336 45.6886 72.0944 48.3997C73.7245 50.4448 74.0487 50.9505 74.2195 51.7135C74.6033 53.4289 73.8001 55.1242 72.21 55.955C70.9319 56.6227 70.0235 56.5826 67.6159 55.7523C55.3711 51.5302 47.063 42.6593 43.9909 30.527C42.9663 26.4807 42.7312 24.5435 42.726 20.1075C42.7225 17.0117 42.7781 16.0352 43.0132 15.069C44.7698 7.84528 49.8193 2.42326 56.5282 0.556976C57.827 0.195507 58.5204 0.114197 60.7533 0.061271C62.6131 0.0171935 63.8077 0.0704543 64.6851 0.23658ZM22.418 0.341597C28.5396 1.62652 33.6893 5.89552 35.9609 11.5688C37.0362 14.254 37.1906 15.1299 37.2018 18.6049C37.2113 21.5751 37.1826 21.8819 36.7515 23.425C34.9568 29.8471 29.8711 34.9706 23.7281 36.5449C22.7315 36.8003 22.5285 36.9087 22.5706 37.163C22.5988 37.3326 23.1082 38.4561 23.7029 39.6595C25.0419 42.3698 27.258 45.7576 29.3785 48.3359C31.2253 50.5817 31.61 51.3057 31.6151 52.5448C31.6196 53.6317 31.333 54.3458 30.5392 55.2244C29.1777 56.7314 27.6505 56.7788 24.0221 55.4264C8.8271 49.7628 0.0189514 36.7205 8.39233e-05 19.8571C-0.00375366 16.388 0.128143 15.455 0.982643 12.9095C3.17033 6.39273 8.70922 1.49128 15.2985 0.241254C17.1853 -0.116708 20.454 -0.0706273 22.418 0.341597Z" fill="white"></path></svg>'; 
                                } ?>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php }
            }
            wp_reset_postdata();
        } ?>

    </div>
</div>