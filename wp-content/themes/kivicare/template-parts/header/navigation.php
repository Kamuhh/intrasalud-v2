<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

global $kivicare_options;
?>

<nav class="navbar navbar-expand-xl navbar-light">
  <?php
    if (isset($kivicare_options['header_radio']) && $kivicare_options['header_radio'] == 1) { ?>
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php
          if (!empty($kivicare_options['header_text'])) { ?>
            <h1 class="logo-text"><?php echo esc_html($kivicare_options['header_text']); ?></h1><?php
          } ?>
      </a> <?php
    } else {
      $logo = ''; ?>
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"> <?php
        if (function_exists('get_field') && class_exists('ReduxFramework')) {
          $key = get_field('key_header');

          if (!empty($key['header_logo']['url'])) {
            $logo = $key['header_logo']['url']; ?>
            <img class="img-fluid logo" src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr_e('image', 'kivicare'); ?>"> <?php
          } else if (isset($kivicare_options['kivi_logo']['url']) && !empty($kivicare_options['kivi_logo']['url'])) {
              $logo = $kivicare_options['kivi_logo']['url']; ?>
              <img class="img-fluid logo" src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr_e('image', 'kivicare'); ?>"> <?php
          } else { ?>
            <img class="img-fluid logo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('image', 'kivicare'); ?>"> <?php
          }
        } else { ?>
          <img class="img-fluid logo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('image', 'kivicare'); ?>"> <?php
        } ?>
      </a> <?php
    }
  ?>
  <?php if (has_nav_menu('top')) { ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <span class="menu-btn d-inline-block" id="menu-btn">
          <span class="line"></span>
          <span class="line"></span>
          <span class="line"></span>
        </span>
      </span>
    </button>
  <?php } ?>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php
    if (has_nav_menu('top')) : ?>
      <?php
      wp_nav_menu(array(
        'theme_location' => 'top',
        'menu_class'     => 'navbar-nav ml-auto',
        'menu_id'        => 'top-menu',
        'container_id'   => 'iq-menu-container',
      )); ?>
    <?php
    endif;

    if ((!empty($kivicare_options['kivi_download_link'])) && (!empty($kivicare_options['kivi_download_title']))) { ?>
      <div class="iq-mobile-main">
        <nav aria-label="breadcrumb">
          <?php
          $dlink = $kivicare_options['kivi_download_link'];
          $dtitle = $kivicare_options['kivi_download_title']; ?>
          <a class="iq-button-style-2 has-icon btn-icon-right mr-20" href="<?php echo esc_url(site_url() . $dlink) ?>">
            <span class="iq-btn-text-holder"><?php echo esc_html($dtitle); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
          </a> <?php
                if ((!empty($kivicare_options['kivi_btn2_link'])) && (!empty($kivicare_options['kivi_btn2_title']))) {
                  $dlink = $kivicare_options['kivi_btn2_link'];
                  $dtitle = $kivicare_options['kivi_btn2_title']; ?>

            <a class="iq-button-style-1 has-icon btn-icon-right" href="<?php echo esc_url($dlink); ?>">
              <span class="iq-btn-text-holder"><?php echo esc_html($dtitle); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
            </a>
          <?php
                } else {
                  $dtitle = $kivicare_options['kivi_btn2_title']; ?>

            <a class="iq-button-style-1 has-icon btn-icon-right" href="<?php echo wp_login_url(); ?>">
              <span class="iq-btn-text-holder"><?php echo esc_html($dtitle); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
            </a>
          <?php
                } ?>
        </nav>
      </div>
    <?php
    }
    ?>

  </div>

  <div class="sub-main">

    <nav aria-label="breadcrumb">
      <?php

      if (isset($kivicare_options['header_display_button']) && $kivicare_options['header_display_button'] == "yes" && !empty($kivicare_options['kivi_download_title'])) {
        $dlink = isset($kivicare_options['kivi_download_link']) && !empty($kivicare_options['kivi_download_link']) ? $kivicare_options['kivi_download_link'] : '#';
        $dtitle = $kivicare_options['kivi_download_title']; ?>

        <a class="iq-button-style-2 has-icon btn-icon-right mr-3" href="<?php echo esc_url(site_url() . $dlink) ?>">
          <span class="iq-btn-text-holder"><?php echo esc_html($dtitle); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
        </a> <?php
      }

            if (isset($kivicare_options['header_display_btn2']) && $kivicare_options['header_display_btn2'] == "yes" && !empty($kivicare_options['kivi_btn2_link']) && !empty($kivicare_options['kivi_btn2_title'])) {
              $dlink = $kivicare_options['kivi_btn2_link'];
              $dtitle = $kivicare_options['kivi_btn2_title']; ?>

        <a class="iq-button-style-1 has-icon btn-icon-right" href="<?php echo esc_url(site_url() . $dlink); ?>">
          <span class="iq-btn-text-holder"><?php echo esc_html($dtitle); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
        </a> <?php
            } else {

              if (isset($kivicare_options['header_display_btn2']) && $kivicare_options['header_display_btn2'] == "yes" && isset($kivicare_options['kivi_btn2_title'])) {

                $dtitle = $kivicare_options['kivi_btn2_title']; ?>

          <a class="iq-button-style-1 has-icon btn-icon-right" href="<?php echo wp_login_url(); ?>">
            <span class="iq-btn-text-holder"><?php echo esc_html($dtitle); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
          </a> <?php
              }
            } ?>
      <!-- shop page button start -->
      <!--mobile View-->
      <?php
      if (class_exists('WooCommerce') && isset($kivicare_options['header_display_shop']) && $kivicare_options['header_display_shop'] == 'yes') {
      ?>
        <div class="woo-menu">
          <div id="shop-toggle">
            <div class="kivi-res-shop-btn-container" id='x-ver-res-btn'>
              <?php
              $shop_url = '';
              if (isset($kivicare_options['shop_link']) && !empty($kivicare_options['shop_link'])) {
                $shop_url = get_page_link($kivicare_options['shop_link']);
              }
              ?>
              <a href="<?php echo esc_url($shop_url); ?>">
                <span class="kivi-res-shop-btn">
                  <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                </span>
              </a>
            </div>
            <ul class="shop_list">
              <!-- wishlist -->
              <?php
              if (function_exists('YITH_WCWL') && isset($kivicare_options['header_display_shop']) && $kivicare_options['header_display_shop'] == 'yes') {
                $wish_url = '';
                if (isset($kivicare_options['wishlist_link']) && !empty($kivicare_options['wishlist_link'])) {
                  $wish_url = get_page_link($kivicare_options['wishlist_link']);
                }
              ?>
                <li class="wishlist-btn kivi-shop-btn">
                  <div class="wishlist_count">
                    <?php $wishlist_count = YITH_WCWL()->count_products(); ?>
                    <a href="<?php echo esc_url($wish_url); ?>">
                      <i class="fa fa-heart"></i>
                      <span class="wcount"><?php echo esc_html($wishlist_count); ?></span>
                    </a>
                  </div>
                </li>
              <?php } ?>
              <!-- mini cart -->
              <?php
              if (isset($kivicare_options['header_display_shop'])) {
                $options = $kivicare_options['header_display_shop'];
                if ($options == "yes") { ?>
                  <li class="cart-btn kivi-shop-btn">
                    <div class="cart_count">
                      <a class="parents mini-cart-count" href="<?php echo wc_get_cart_url(); ?>">
                        <i class="fa fa-shopping-cart"></i>
                        <span id="mini-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                      </a>
                    </div>
                  </li>

              <?php
                }
              }
              ?>
            </ul>
          </div>
        </div>
      <?php } ?>
      <!-- shop page button end-->
      <!-- side area btn container start-->
      <?php
      if (isset($kivicare_options['header_display_side_area']) && $kivicare_options['header_display_side_area'] == 'yes') {
        if (is_active_sidebar('kivi_side_area')) {
      ?>
        <div class="iq-sidearea-btn-container" id="menu-btn-side-open">
          <span class="menu-btn d-inline-block">
            <span class="line one"></span>
            <span class="line two"></span>
            <span class="line three"></span>
          </span>
        </div>
         <?php } 
     } ?>
      <!-- side area btn container end-->
    </nav>

  </div>
</nav>