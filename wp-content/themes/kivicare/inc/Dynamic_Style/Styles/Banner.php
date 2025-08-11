<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class Banner extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'kivicare_banner_dynamic_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'kivicare_featured_hide'), 20);
    }

    public function kivicare_banner_dynamic_style()
    {
        $page_id = get_queried_object_id();
        global $kivicare_options;

        $dynamic_css = '';

        if (function_exists('get_field') && get_field('field_QnF1', $page_id) != 'default') {
            if (get_field('field_QnF1', $page_id) == 'no') {
                $dynamic_css .=
                    '.iq-breadcrumb-one { display: none !important; }
                    .content-area .site-main {padding : 0 !important; }';
            }
        } else if (isset($kivicare_options['display_banner'])) {
            if ($kivicare_options['display_banner'] == 'no') {

                $dynamic_css .=
                    '.iq-breadcrumb-one { display: none !important; }
                    .content-area .site-main {padding : 150 0 !important; }';
            }
        }
        $key = (function_exists('get_field')) ? get_field('key_pjros', $page_id) : "";
        if (isset($key['display_title']) && $key['display_title'] != 'default'  && $key['display_title'] == 'no') {
            $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
        } else if (isset($kivicare_options['display_title'])) {
            if ($kivicare_options['display_title'] == 'no') {
                $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
            }
        }

        if (isset($key['display_breadcumb']) && $key['display_breadcumb'] != 'default'  && $key['display_breadcumb'] == 'no') {
            $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
        } else if (isset($kivicare_options['display_breadcumb'])) {
            if ($kivicare_options['display_breadcumb'] == 'no') {
                $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
            }
        }

        if (isset($kivicare_options['bg_title_color'])) {
            if ($kivicare_options['display_breadcrumbs'] == 'yes') {
                $dynamic = $kivicare_options['bg_title_color'];
                $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one .title { color: ' . $dynamic . ' !important; }' : '';
            }
        }

        $key =  (function_exists('get_field')) ? get_field('key_banner_back', $page_id) : "";

        if ( (function_exists('get_field')) && $key['banner_background_type'] != 'default' && get_field('field_QnF1', $page_id) != 'default') {
            if ($key['banner_background_type'] == 'color') {
                $dynamic_css .= '.iq-breadcrumb-one{
                    background:' . $key['banner_background_color'] . '!important
                }';
            }

            if ($key['banner_background_type'] == 'image') {
                $dynamic_css .= '.iq-breadcrumb-one {
                    background:url(' . $key['banner_background_image']['url'] . ') !important
                }';

                if (!empty($key['banner_background_size'])) {
                    $dynamic_css .= '.iq-breadcrumb-one{
                        background-size:' . $key['banner_background_size'] . '!important
                    }';
                }

                if (!empty($key['banner_background_repeat'])) {
                    $dynamic_css .= '.iq-breadcrumb-one{
                        background-repeat:' . $key['banner_background_repeat'] . '!important
                    }';
                }
            }
        } else if (isset($kivicare_options['bg_type'])) {
            $opt = $kivicare_options['bg_type'];
            if ($opt == '1') {
                if (isset($kivicare_options['bg_color']) && !empty($kivicare_options['bg_color'])) {
                    $dynamic = $kivicare_options['bg_color'];
                    $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one { background: ' . $dynamic . ' !important; }' : '';
                }
            }
            if ($opt == '2') {
                if (isset($kivicare_options['banner_image']['url'])) {
                    $dynamic = $kivicare_options['banner_image']['url'];
                    $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one { background-image: url(' . $dynamic . ') ; }' : '';
                }
            }

            if (isset($kivicare_options['product_display_banner']) && $kivicare_options['product_display_banner'] == 'no') {
                $dynamic_css .= !empty($dynamic) ? '.kivicare-breadcrumb { display:none !important; }' : '';
            }
        }

        if (!empty($dynamic_css)) {
            wp_add_inline_style('kivicare-global', $dynamic_css);
        }
    }
    /* hide featured image for post formate */
    public function kivicare_featured_hide()
    {
        /*
        * Get Post Formate and set featured image display none
        */
        global $kivicare_options;
        $featured_hide = '';
        $post_format = "";

        if (isset($kivicare_options['posts_select'])) {

            $posts_format = $kivicare_options['posts_select'];
            $post_format = get_post_format();

            if (is_array($posts_format) && in_array(get_post_format(), $posts_format)) {
                $featured_hide .= '.format-' . $post_format . ' .iq-blog-box .iq-blog-image { display: none !important; }';
            }
            wp_add_inline_style('kivicare-global', $featured_hide);
        }
    }
}
