<?php

use Elementor\Plugin;

function get_iqonic_config()
{
    return $GLOBALS['iqonic_config']['Elements'];
}

if (!function_exists('iqonic_blog_time_link')) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function iqonic_blog_time_link()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            get_the_date(DATE_W3C),
            get_the_date(),
            get_the_modified_date(DATE_W3C),
            get_the_modified_date()
        );

        $year = get_post_time('Y');
        $month = get_post_time('m');
        $day = get_post_time('j');
        // Wrap the time string in a link, and preface it with 'Posted on'.
        return sprintf(
            /* translators: %s: post date */
            __('<span class="screen-reader-text">Posted on</span> %s', 'iqonic'),
            '<a href="' . esc_url(get_day_link($year, $month, $day)) . '" rel="bookmark">' . $time_string . '</a>'
        );
    }
endif;
if (!function_exists('iqonic_random_strings')) {
    function iqonic_random_strings($random = '')
    {

        // String of all alphanumeric character 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $random;

        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($str_result), 0, 5);
    }
}

if (!function_exists('iqonic_get_post')) {
    function iqonic_get_post($post_type = "", $post_status = "publish")
    {
        $args = array(
            'post_type'         => $post_type,
            'post_status'       => $post_status,
            'posts_per_page'    => -1
        );
        global $post;
        $wp_query = new \WP_Query($args);
        $iqonic_blog_list = [];

        if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                $post_status = '';
                $iqonic_blog_list[$post->post_name] = get_the_title() . '' . $post_status;
            }

            return $iqonic_blog_list;
        }
        wp_reset_postdata();
    }
}

if (!function_exists('iqonic_blog_time_link')) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function iqonic_blog_time_link()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            get_the_date(DATE_W3C),
            get_the_date(),
            get_the_modified_date(DATE_W3C),
            get_the_modified_date()
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        return sprintf(
            /* translators: %s: post date */
            __('<span class="screen-reader-text">Posted on</span> %s', 'iqonic'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );
    }
endif;
if (!function_exists('iqonic_random_strings')) {
    function iqonic_random_strings($random = '')
    {
        // String of all alphanumeric character 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $random;

        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($str_result), 0, 5);
    }
}

// localize loadmore
function iqonic_scripts()
{
    global $wp_query;
    wp_register_script('iqonic_ajax', false);
    wp_localize_script('iqonic_ajax', 'iqonic_loadmore_params', array(
        'ajaxurl'       => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
        'posts'         => json_encode($wp_query->query_vars), // everything about your loop is here
        'current_page'  => get_query_var('paged') ? get_query_var('paged') : 1,
        'max_page'      => $wp_query->max_num_pages,
        'template_dir' => get_template_directory_uri()
    ));

    wp_enqueue_script('iqonic_ajax');
}
add_action('wp_enqueue_scripts', 'iqonic_scripts', 15);

// get Blog Category
if (!function_exists('iq_by_blog_cat')) {
    function iq_by_blog_cat($taxo = '')
    {
        $taxonomy = 'category';

        $iq_blog_cat = array();
        $terms = get_terms($taxonomy);

        foreach ($terms as $term) {
            $iq_blog_cat[$term->slug] = $term->name;
        }
        return $iq_blog_cat;
    }
}

if (!function_exists('iq_by_team_cat')) {
    function iq_by_team_cat($id)
    {
        $cat_name = '';
        $category = get_the_terms($id, 'team-categories');
        if (!empty($category)) {
            foreach ($category as $cat) {
                $cat_name .= $cat->name . ",";
            }
        }
        return rtrim($cat_name, ',');
    }
}

if (!function_exists('iq_all_team_cat')) {

    function iq_all_team_cat()
    {
        $iq_blog_cat = array();
        $args = array(
            'taxonomy' => 'team-categories',
            'orderby' => 'name',
            'order'   => 'ASC',
            'hide_empty' => false,
        );

        $cats = get_categories($args);

        foreach ($cats as $cat) {
            $iq_blog_cat[$cat->term_id] = $cat->name;
        }

        return $iq_blog_cat;
    }
}

function iqonic_get_category()
{
    $taxonomy = 'product_cat';
    $orderby = 'name';
    $show_count = 0; // 1 for yes, 0 for no
    $pad_counts = 0; // 1 for yes, 0 for no
    $hierarchical = 1; // 1 for yes, 0 for no
    $title = '';
    $empty = 0;

    $args = array(
        'taxonomy' => $taxonomy,
        'orderby' => $orderby,
        'show_count' => $show_count,
        'pad_counts' => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li' => $title,
        'hide_empty' => $empty,
        'parent' => 0
    );
    
    $array = get_categories($args);
    return $array;
}

// return posts array
if (!function_exists('iqonic_get_posts')) {
    function iqonic_get_posts($post_type = "post", $post_status = "publish")
    {
        $args = array(
            'post_type'         => $post_type,
            'post_status'       => $post_status,
            'posts_per_page'    => -1
        );
        $post_query = get_posts($args);
        $iqonic_posts = [];

        if ($post_query) {
            foreach ($post_query as $post) {
                $iqonic_posts[$post->post_name] = get_the_title($post->ID);
            }
            return $iqonic_posts;
        }
        wp_reset_postdata();
    }
}

/*teamtab*/
if (!function_exists('iqonic_get_custom_taxonomy')) {
    function iqonic_get_custom_taxonomy($taxo = '')
    {
        if (empty($taxo)) {
            return;
        }

        $show_count = 0; // 1 for yes, 0 for no
        $pad_counts = 0; // 1 for yes, 0 for no
        $hierarchical = 1; // 1 for yes, 0 for no
        $array = array();
        $args = array(
            'taxonomy' => $taxo,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hierarchical' => $hierarchical,
            'hide_empty' => false,
            'parent' => 0
        );
        $wp_object =  get_categories($args);

        if (!empty($wp_object)) {
            foreach ($wp_object as $val) {
                $array[$val->slug] = $val->name;
            }
        }

        return $array;
    }
}



//return currency symbols
if (!function_exists('iqonic_currency')) {
    function iqonic_currency($type = 'options', $val = '')
    {
        $currrency = [
            'none' => '', // ?
            'AED' => '&#1583;.&#1573;', // ?
            'AFN' => '&#65;&#102;',
            'ALL' => '&#76;&#101;&#107;',
            'ANG' => '&#402;',
            'AOA' => '&#75;&#122;', // ?
            'ARS' => '&#36;',
            'AUD' => '&#36;',
            'AWG' => '&#402;',
            'AZN' => '&#1084;&#1072;&#1085;',
            'BAM' => '&#75;&#77;',
            'BBD' => '&#36;',
            'BDT' => '&#2547;', // ?
            'BGN' => '&#1083;&#1074;',
            'BHD' => '.&#1583;.&#1576;', // ?
            'BIF' => '&#70;&#66;&#117;', // ?
            'BMD' => '&#36;',
            'BND' => '&#36;',
            'BOB' => '&#36;&#98;',
            'BRL' => '&#82;&#36;',
            'BSD' => '&#36;',
            'BTN' => '&#78;&#117;&#46;', // ?
            'BWP' => '&#80;',
            'BYR' => '&#112;&#46;',
            'BZD' => '&#66;&#90;&#36;',
            'CAD' => '&#36;',
            'CDF' => '&#70;&#67;',
            'CHF' => '&#67;&#72;&#70;',
            'CLP' => '&#36;',
            'CNY' => '&#165;',
            'COP' => '&#36;',
            'CRC' => '&#8353;',
            'CUP' => '&#8396;',
            'CVE' => '&#36;', // ?
            'CZK' => '&#75;&#269;',
            'DJF' => '&#70;&#100;&#106;', // ?
            'DKK' => '&#107;&#114;',
            'DOP' => '&#82;&#68;&#36;',
            'DZD' => '&#1583;&#1580;', // ?
            'EGP' => '&#163;',
            'ETB' => '&#66;&#114;',
            'EUR' => '&#8364;',
            'FJD' => '&#36;',
            'FKP' => '&#163;',
            'GBP' => '&#163;',
            'GEL' => '&#4314;', // ?
            'GHS' => '&#162;',
            'GIP' => '&#163;',
            'GMD' => '&#68;', // ?
            'GNF' => '&#70;&#71;', // ?
            'GTQ' => '&#81;',
            'GYD' => '&#36;',
            'HKD' => '&#36;',
            'HNL' => '&#76;',
            'HRK' => '&#107;&#110;',
            'HTG' => '&#71;', // ?
            'HUF' => '&#70;&#116;',
            'IDR' => '&#82;&#112;',
            'ILS' => '&#8362;',
            'INR' => '&#8377;',
            'IQD' => '&#1593;.&#1583;', // ?
            'IRR' => '&#65020;',
            'ISK' => '&#107;&#114;',
            'JEP' => '&#163;',
            'JMD' => '&#74;&#36;',
            'JOD' => '&#74;&#68;', // ?
            'JPY' => '&#165;',
            'KES' => '&#75;&#83;&#104;', // ?
            'KGS' => '&#1083;&#1074;',
            'KHR' => '&#6107;',
            'KMF' => '&#67;&#70;', // ?
            'KPW' => '&#8361;',
            'KRW' => '&#8361;',
            'KWD' => '&#1583;.&#1603;', // ?
            'KYD' => '&#36;',
            'KZT' => '&#1083;&#1074;',
            'LAK' => '&#8365;',
            'LBP' => '&#163;',
            'LKR' => '&#8360;',
            'LRD' => '&#36;',
            'LSL' => '&#76;', // ?
            'LTL' => '&#76;&#116;',
            'LVL' => '&#76;&#115;',
            'LYD' => '&#1604;.&#1583;', // ?
            'MAD' => '&#1583;.&#1605;.', //?
            'MDL' => '&#76;',
            'MGA' => '&#65;&#114;', // ?
            'MKD' => '&#1076;&#1077;&#1085;',
            'MMK' => '&#75;',
            'MNT' => '&#8366;',
            'MOP' => '&#77;&#79;&#80;&#36;', // ?
            'MRO' => '&#85;&#77;', // ?
            'MUR' => '&#8360;', // ?
            'MVR' => '.&#1923;', // ?
            'MWK' => '&#77;&#75;',
            'MXN' => '&#36;',
            'MYR' => '&#82;&#77;',
            'MZN' => '&#77;&#84;',
            'NAD' => '&#36;',
            'NGN' => '&#8358;',
            'NIO' => '&#67;&#36;',
            'NOK' => '&#107;&#114;',
            'NPR' => '&#8360;',
            'NZD' => '&#36;',
            'OMR' => '&#65020;',
            'PAB' => '&#66;&#47;&#46;',
            'PEN' => '&#83;&#47;&#46;',
            'PGK' => '&#75;', // ?
            'PHP' => '&#8369;',
            'PKR' => '&#8360;',
            'PLN' => '&#122;&#322;',
            'PYG' => '&#71;&#115;',
            'QAR' => '&#65020;',
            'RON' => '&#108;&#101;&#105;',
            'RSD' => '&#1044;&#1080;&#1085;&#46;',
            'RUB' => '&#1088;&#1091;&#1073;',
            'RWF' => '&#1585;.&#1587;',
            'SAR' => '&#65020;',
            'SBD' => '&#36;',
            'SCR' => '&#8360;',
            'SDG' => '&#163;', // ?
            'SEK' => '&#107;&#114;',
            'SGD' => '&#36;',
            'SHP' => '&#163;',
            'SLL' => '&#76;&#101;', // ?
            'SOS' => '&#83;',
            'SRD' => '&#36;',
            'STD' => '&#68;&#98;', // ?
            'SVC' => '&#36;',
            'SYP' => '&#163;',
            'SZL' => '&#76;', // ?
            'THB' => '&#3647;',
            'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
            'TMT' => '&#109;',
            'TND' => '&#1583;.&#1578;',
            'TOP' => '&#84;&#36;',
            'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
            'TTD' => '&#36;',
            'TWD' => '&#78;&#84;&#36;',
            'UAH' => '&#8372;',
            'UGX' => '&#85;&#83;&#104;',
            'USD' => '&#36;',
            'UYU' => '&#36;&#85;',
            'UZS' => '&#1083;&#1074;',
            'VEF' => '&#66;&#115;',
            'VND' => '&#8363;',
            'VUV' => '&#86;&#84;',
            'WST' => '&#87;&#83;&#36;',
            'XAF' => '&#70;&#67;&#70;&#65;',
            'XCD' => '&#36;',
            'XPF' => '&#70;',
            'YER' => '&#65020;',
            'ZAR' => '&#82;',
            'ZMK' => '&#90;&#75;', // ?
            'ZWL' => '&#90;&#36;',
        ];

        if ($type == 'options') {
            $resultarr = [];
            foreach ($currrency as $key => $value) {
                $resultarr[$key] = $value . ' ' . $key;
            }
            return $resultarr;
        } elseif ($type == 'value') {
            if (!empty($val)) {
                return $currrency[$val];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}
