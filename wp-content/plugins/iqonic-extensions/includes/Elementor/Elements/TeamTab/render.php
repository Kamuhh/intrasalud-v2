<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$i = 0;

$php_prexix_class = '';

$this->add_render_attribute('kivicare-section', 'class', 'kivicare-title-box');
$this->add_render_attribute('kivicare-section', 'class', 'kivicare-title-box-1');
$cat = '';
if (isset($settings['port_cat']) && !empty($settings['port_cat'])) {
    $cat = $settings['port_cat'];
}
if (!empty($settings['post_view_type_order']) && $settings['post_view_type_order'] !== 'none') {
    if ($settings['post_view_type_order'] === 'latest') {
        $args['orderby'] = 'publish_date';
        $args['order'] = 'DESC';
    }
}
if (!empty($settings['order']) && $settings['post_view_type_order'] !== 'latest') {
    $args['order'] = $settings['order'];
}

$rand = rand(0, 100);
?>

<div id="features-<?php echo esc_attr($rand); ?>" class="kivicare-team-tab">

    <div class="row">
        <div class="col-lg-12 kivicare_filters">
            <ul class="nav kivicare-team-tab-nav justify-content-center" id="myTab-<?php echo esc_attr($rand); ?>" role="tablist">
                <?php
                if (isset($settings['port_cat']) && !empty($settings['port_cat'])) {
                    $terms = $settings['port_cat'];
                } else {
                    $terms = get_terms(array('taxonomy' => 'team-categories',));
                }
                ?>
                <li>
                    <a class="nav-link active show" id="all-tab-<?php echo esc_attr($rand); ?>" data-bs-toggle="tab" href="#all-<?php echo esc_attr($rand); ?>" role="tab" aria-selected="true"><span><?php esc_html_e('All', 'iqonic') ?></span>
                    </a>
                </li>
                <?php foreach ($terms as $term) {

                ?>
                    <li><a class="nav-link" id="<?php echo $term->slug; ?>-tab-<?php echo esc_attr($rand); ?>" data-bs-toggle="tab" href="#<?php echo $term->slug; ?>-<?php echo esc_attr($rand) ?>" role="tab"><span><?php echo $term->name; ?></span></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <?php
    $col = '';

    if ($settings['project_layout'] === "1-grid") {
        $col = 'col-lg-12';
    }
    if ($settings['project_layout'] === "2-grid") {
        $col = 'col-lg-6 col-md-6';
    }
    if ($settings['project_layout'] === "3-grid") {
        $col = 'col-lg-4 col-md-6';
    }
    if ($settings['project_layout'] === "4-grid") {
        $col = 'col-lg-3 col-md-6';
    } 

    if($settings['team_style'] == '1'){
        $style = 'iq-team-style-1';
    } elseif($settings['team_style'] == '2'){
        $style = 'iq-team-style-2';
    }
   ?>

    <div class="tab-content iq-team <?php echo esc_attr($style); ?>">
        <div class="tab-pane active" id="all-<?php echo esc_attr($rand); ?>">
            <div class="row">

                <?php
                global $post;
                $args = array(
                    'post_type' => 'team',
                    'posts_per_page' => '-1',
                    'post_status' => 'publish',
                    'posts_per_page' => $settings['posts_per_page'],
                );
                $wp_query = new \WP_Query($args);
                while ($wp_query->have_posts()) : $wp_query->the_post();
                    $term_list = wp_get_post_terms(get_the_ID(), 'team-categories');
                    $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "kivicare-project-1");
                    $slugs = array();

                    $li = '';

                    if(function_exists('get_field')){
                    $key =  get_field('key_pjros1245', get_the_ID());
                    $facebook   = $key['iqonic_team_facebook'];
                    $twitter   = $key['iqonic_team_twitter'];
                    $google   = $key['iqonic_team_google'];
                    $github   = $key['iqonic_team_github'];
                    $insta   = $key['iqonic_team_insta'];
                    $whatsapp  = $key['iqonic_team_whatsapp'];
                
                    if (!empty($facebook)) {
                        $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-facebook-f"></i></a></li>', esc_url($facebook));
                    }
                
                    if (!empty($twitter)) {
                        $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-x-twitter"></i></a></li>', esc_url($twitter));
                    }
                
                    if (!empty($google)) {
                        $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-google"></i></a></li>', esc_url($google));
                    }
                
                    if (!empty($github)) {
                        $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-github"></i></a></li>', esc_url($github));
                    }
                
                    if (!empty($insta)) {
                        $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-instagram"></i></a></li>', esc_url($insta));
                    }

                    if (!empty($whatsapp)) {
                        $li .= sprintf('<li><a href="%s"><i class="fab fa-whatsapp"></i></a></li>', esc_url($whatsapp));
                    }
                }

                    foreach ($term_list as $term)
                        $slugs[] = $term->slug;
                 ?>
                    <div class="<?php echo esc_attr($col); ?>">
                        <div class="iq-team-blog animated fadeInUp <?php echo implode(' ', $slugs); ?> blogBox moreBox">
                            <?php if (has_post_thumbnail()) { ?>
                                <div class="iq-team-img">
                                    <?php
                                    echo sprintf('<img src="%1$s" alt="iqonic-casestudy"/>', esc_url($full_image[0], 'iqonic'));
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="share iq-team-social">
                                <ul>
                                    <?php echo $li; ?>
                                </ul>
                            </div>
                            <div class="iq-team-info">
                                <div class="iq-team-main-detail">
                                    <a href="<?php the_permalink(); ?>">
                                        <h5 class="member-text iq-heading-title">
                                            <?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
                                        </h5>
                                    </a>
                                    <span class="iq-specialized">
                                        <?php echo iq_by_team_cat(get_the_ID()); ?>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php

        if (isset($settings['port_cat']) && !empty($settings['port_cat'])) {
            $terms = $settings['port_cat'];
        } else {
            $terms = get_terms(array('taxonomy' => 'team-categories',));
        }

        foreach ($terms as $term) {
        ?>
            <div class="tab-pane" id="<?php echo $term->slug; ?>-<?php echo esc_attr($rand); ?>">
                <div class="row">

                    <?php
                    $args = array(
                        'post_type' => 'team',
                        'posts_per_page' => $settings['posts_per_page'],
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'team-categories',
                                'field' => 'slug',
                                'terms' => $term->slug,
                            ),
                        ),
                    );

                    $wp_query = new \WP_Query($args);
                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        $term_list = wp_get_post_terms(get_the_ID(), 'team-categories');
                        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "kivicare-project-1");
                        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "kivicare-project-1");
                        $slugs = array();

                        $li = '';

                        if(function_exists('get_field')){

                        $key =  get_field('key_pjros1245', get_the_ID());
                        $facebook   = $key['iqonic_team_facebook'];
                        $twitter   = $key['iqonic_team_twitter'];
                        $google   = $key['iqonic_team_google'];
                        $github   = $key['iqonic_team_github'];
                        $insta   = $key['iqonic_team_insta'];
                        $whatsapp  = $key['iqonic_team_whatsapp'];
                    
                        if (!empty($facebook)) {
                            $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-facebook-f"></i></a></li>', esc_url($facebook));
                        }
                    
                        if (!empty($twitter)) {
                            $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-x-twitter"></i></a></li>', esc_url($twitter));
                        }
                    
                        if (!empty($google)) {
                            $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-google"></i></a></li>', esc_url($google));
                        }
                    
                        if (!empty($github)) {
                            $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-github"></i></a></li>', esc_url($github));
                        }
                    
                        if (!empty($insta)) {
                            $li .= sprintf('<li><a href="%s">'.'<i class="fab fa-instagram"></i></a></li>', esc_url($insta));
                        }

                        if (!empty($whatsapp)) {
                            $li .= sprintf('<li><a href="%s"><i class="fab fa-whatsapp"></i></a></li>', esc_url($whatsapp));
                        }
                    }

                        foreach ($term_list as $term)
                            $slugs[] = $term->slug;
                                ?>
                        <div class="<?php echo esc_attr($col); ?>">
                            <div class="iq-team-blog animated fadeInUp <?php echo implode(' ', $slugs); ?> blogBox moreBox">
                            
                                <?php
                                if (has_post_thumbnail()) { ?>
                                    <div class="kivicare-project-image">
                                        <?php echo sprintf('<img src="%1$s" alt="iqonic-casestudy"/>', esc_url($full_image[0], 'iqonic')); ?>
                                    </div>
                                <?php
                                } ?>

                                <div class="share iq-team-social">
                                    <ul>
                                        <?php echo $li; ?>
                                    </ul>
                                </div>
                                <div class="iq-team-info">
                                    <div class="iq-team-main-detail">
                                        <a href="<?php the_permalink(); ?>">
                                            <h5 class="member-text iq-heading-title">
                                                <?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
                                            </h5>
                                        </a>
                                        <span class="iq-specialized">
                                            <?php echo iq_by_team_cat(get_the_ID()); ?>
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
               <?php 
            $i++;
        }
        ?>
    </div>
</div>