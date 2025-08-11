<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="profile" href="<?php echo is_ssl() ? 'https:' : 'http:' ?>//gmpg.org/xfn/11">
    <?php
    if (!function_exists('has_site_icon') || !wp_site_icon()) {
    ?>
        <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/favicon.png'); ?>" />
    <?php
    }
    ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    wp_footer();
    ?>
</body>

</html>