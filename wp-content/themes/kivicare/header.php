<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

use Elementor\Plugin; ?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js" <?php echo esc_attr(kivicare()->kivicare_layout_add_attr()); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="profile" href="<?php echo is_ssl() ? 'https:' : 'http:' ?>//gmpg.org/xfn/11">
  <?php
  global $kivicare_options;
  if (!has_site_icon()) : ?>
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon.ico'); ?>" />
  <?php endif;

  wp_head(); ?>
</head>

<body id="skrollr-body" <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <!-- side area start-->
  <?php

  $page_id = (get_queried_object_id()) ? get_queried_object_id() : '';
  if (class_exists('ReduxFramework') && $kivicare_options['header_display_side_area'] == 'yes') { ?>
    <div id="has-side-bar" class="iq-menu-side-bar">
      <!-- side area btn container start-->
      <div class="iq-sidearea-btn-container btn-container-close" id="menu-btn-side-close">
        <span class="menu-btn d-inline-block is-active">
          <span class="line"></span>
          <span class="line"></span>
          <span class="line"></span>
        </span>
      </div>
      <!-- side area btn container end-->
      <div id="sidebar-scrollbar">
        <div class="iq-sidebar-container">
          <div class="iq-sidebar-content">
            <?php
            if (is_active_sidebar('kivi_side_area')) {
              dynamic_sidebar('kivi_side_area');
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <!-- side area end-->

  <!-- loading -->
  <?php
  $bgurl = '';
  if (!empty($kivicare_options['kivi_display_loader'])  && $kivicare_options['kivi_display_loader'] == "yes") {
    $options = $kivicare_options['kivi_display_loader'];
    $bgurl = $kivicare_options['kivi_loader_gif']['url'];
  }
  if (!empty($bgurl)) { ?>
    <div id="loading">
      <div id="loading-center">
        <img src="<?php echo esc_url($bgurl); ?>" alt="<?php esc_attr_e('loader', 'kivicare'); ?>">
      </div>
    </div>
  <?php } ?>
  <!-- loading End -->
  <?php
  $is_default_header = true;
  $header_response =  $has_sticky =  $kivi_container =   $site_classes = '';

  if (function_exists('get_field') || class_exists('ReduxFramework')) {
    if (isset($kivicare_options['sticky_header_display']) && $kivicare_options['sticky_header_display'] == 'yes') {
      $has_sticky = ' has-sticky';
    }
    if (isset($kivicare_options['header_menu_container']) && $kivicare_options['header_menu_container'] == 'container') {
      $kivi_container = 'container';
    } else {
      $kivi_container = 'container-fluid';
    }
    $id = (get_queried_object_id()) ? get_queried_object_id() : '';

    // ------------header
    if (class_exists("Elementor\Plugin")) {

      $header_display = !empty($id) ? get_post_meta($id, 'header_layout_display_header', true) : '';
      $header_layout = !empty($id) ? get_post_meta($id, 'header_layout_header_layout_type', true) : '';
      $header_name = !empty($id) ? get_post_meta($id, 'header_layout_header_layout_name', true) : '';

      if (function_exists('get_field') && $header_display === 'yes' && $header_layout != 'default' && !empty($header_name)) {
        $is_default_header = false;
        $header = $header_name;
        $has_sticky = '';
        $my_layout = get_page_by_path($header, '', 'iqonic_hf_layout');
        if ($my_layout) {
          $header_response =  kivicare()->kivicare_get_layout_content($my_layout->ID);
        }
      } else if (isset($kivicare_options['header_layout']) && $kivicare_options['header_layout'] == 'custom') {
        if (!empty($kivicare_options['menu_style'])) {
          $is_default_header = false;
          $header = $kivicare_options['menu_style'];
          $has_sticky = '';
          $my_layout = get_page_by_path($header, '', 'iqonic_hf_layout');
          if ($my_layout) {
            $header_response =  kivicare()->kivicare_get_layout_content($my_layout->ID);
          }
        }
      }
    }

    // ---------------header end
    $h_layout_position = !empty($id) ? get_post_meta($id, 'header_layout_position', true) : '';
    $h_position = !empty($id) ? get_post_meta($id, 'header_postion', true) : '';
    $site_classes = '';
    if ($h_position === 'over') {
      $site_classes .= ' header-over';
    } else {
      if (isset($kivicare_options['header_postion']) && $kivicare_options['header_postion'] == 'over') {
        $site_classes .= ' header-over';
      }
    }
    $classes = $header_display = $header_display_layout = '';

    if (function_exists('get_field')) {
      $header_display = get_field('key_header', $page_id);
      if ($header_display && is_array($header_display) && isset($header_display['header_layout_type'])) {
        $header_display_layout = $header_display['header_layout_type'];
      }
    }

    if (isset($header_display['display_header']) && $header_display['display_header'] == 'yes') {
      if (class_exists('ReduxFramework') && $header_display_layout != 'custom') {
        $classes = ' default-header';
      } else {
        $classes = ' custom-header';
      }
    } elseif (isset($header_display['display_header']) && $header_display['display_header'] == 'no') {
      $classes = ' default-header';
    } elseif (isset($kivicare_options['header_layout']) &&  $kivicare_options['header_layout'] == 'custom') {
      $classes = ' custom-header';
    } else {
      $classes = ' default-header';
    }
    $site_classes .= ' kivicare';
  } else {
    $classes = ' default-header';
  }
  ?>
  <div id="page" class="site <?php echo esc_attr(trim($site_classes)); ?>">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'kivicare'); ?></a>

    <header class="<?php echo esc_attr($has_sticky); ?> <?php echo esc_attr($classes); ?>" id="main-header">
      <?php
      $header_layout = '';
      if ($header_layout != 'default') {
        if (!$is_default_header && !empty($header_response)) {
          echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($header_response) : $header_response;
        } else {
          $is_default_header = true;
        }
      } elseif ($header_display['display_header'] == "default") {
        if (!$is_default_header && !empty($header_response)) {
          echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($header_response) : $header_response;
        } else {
          $is_default_header = true;
        }
      } else {
        $is_default_header = true;
      }


      if ($is_default_header) {
        if (isset($kivicare_options['email_and_button'])) {
          $options = $kivicare_options['email_and_button'];
          if ($options == "yes") { ?>
            <div class="<?php echo esc_attr($kivi_container); ?> sub-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                  <?php
                  if (!empty($kivicare_options['header_display_contact'])) {
                    $options = $kivicare_options['header_display_contact'];
                    if ($options == "yes") { ?>
                      <div class="number-info">
                        <ul class="list-inline">
                          <?php if (!empty($kivicare_options['header_email'])) { ?>
                            <li class="list-inline-item"><a href="mailto:<?php echo esc_html($kivicare_options['header_email']); ?>">
                                <i class="fa fa-envelope"></i><?php echo esc_html($kivicare_options['header_email']); ?></a></li>
                          <?php } ?>
                          <?php if (!empty($kivicare_options['header_phone'])) { ?>
                            <li class="list-inline-item">
                              <a href="tel:<?php echo str_replace(str_split('(),-" '), '', $kivicare_options['header_phone']); ?>">
                                <i class="fa fa-phone"></i><?php echo esc_html($kivicare_options['header_phone']); ?></a>
                            </li>
                          <?php } ?>
                        </ul>
                      </div> <?php
                            }
                          } ?>
                </div>
                <div class="col-auto col-auto ml-auto sub-main">
                  <?php
                  global $kivicare_options;
                  if (isset($kivicare_options['kivi_header_social_media'])) {
                    $options = $kivicare_options['kivi_header_social_media'];
                    if ($options == "yes") { ?>
                      <div class="social-icone">
                        <?php $data = $kivicare_options['social-media-iq']; ?>
                        <ul class="list-inline">
                          <?php
                          if (is_array($data)) {
                            foreach ($data as $key => $options) {
                              if ($options) { ?>
                                <li class="d-inline">
                                  <a href="<?php echo esc_url($options); ?>">
                                    <?php if ($key == 'twitter') { ?>
                                      <i class="fab fa-x-twitter"></i>
                                    <?php } else { ?>
                                      <i class="fab fa-<?php echo esc_attr($key); ?>"></i>
                                    <?php } ?>
                                  </a>
                                </li>
                          <?php  }
                            }
                          } ?>
                        </ul>
                      </div>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
        <?php
          }
        }
        ?>

        <div class="<?php echo esc_attr($kivi_container); ?> main-header">
          <div class="row align-items-center">
            <div class="col-sm-12">
              <?php get_template_part('template-parts/header/navigation'); ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </header><!-- #masthead -->

    <?php if ($is_default_header) : ?>
      <div class="iq-height"></div>
      <div class="kivicare-mobile-menu menu-style-one"><?php get_template_part('template-parts/header/navigation', 'mobile'); ?>
      </div>
    <?php endif; ?>
    <?php get_template_part('template-parts/breadcrumb/breadcrumb'); ?>