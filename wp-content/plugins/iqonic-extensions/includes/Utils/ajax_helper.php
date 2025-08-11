<?php

// ajax search
add_action('wp_ajax_data_fetch_search', 'data_fetch_search');
add_action('wp_ajax_nopriv_data_fetch_search', 'data_fetch_search');

/* Start ajax search */

function data_fetch_search() {

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 3,
        's' => esc_attr($_POST['keyword']),
        'post_status' => 'publish',
    );

    $wp_query = new \WP_Query($args); ?>
    <div class="widget kivicare-widget-menu mb-0">
        <div class="list-inline iq-widget-menu">
            <ul class="kivicare-post">
                <?php
                if ($wp_query->have_posts()) :
                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <li>
                            <div class="post-img">
                                <div class="post-img-holder">
                                    <a href="<?php echo esc_url(get_permalink($wp_query->ID)); ?>" style="background-image:url('<?php echo get_the_post_thumbnail_url($wp_query->ID); ?>')"></a>
                                </div>
                                <div class="post-blog">
                                    <div class="blog-box">
                                        <a class="new-link" href="<?php echo esc_url(get_permalink($wp_query->ID)); ?>">
                                            <h6 class="kivicare_post_title">
                                                <?php the_title(); ?>
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li> <?php
                    endwhile;
                    wp_reset_postdata();
                ?>

            </ul>
            <?php
            else :
                echo '<p class="no-result text-center">' . esc_html__('No Results Found', 'kivicare') . '</p>';
            endif;
        ?>
        </div>
        <?php
         $total_pages = $wp_query->max_num_pages;
         if ($total_pages > 1) { ?>
             <button type="submit" class="kivicare-button kivicare-button-link btn w-100 mt-3"><?php esc_html_e('More Results', 'kivicare'); ?></button>
         <?php 
        }?>
    </div>
    <?php
    die();
}
/* End ajax search */