<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
  <!-- Required meta tags -->
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <?php
  remove_action('wp_head', 'wp_generator');
  wp_head(); ?>
</head>

<body data-spy="scroll" data-offset="80">
  <?php wp_body_open(); ?>
  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html__('Skip to content', 'xamin'); ?></a>
    <div class="site-content-contain">
      <div id="content" class="site-content">