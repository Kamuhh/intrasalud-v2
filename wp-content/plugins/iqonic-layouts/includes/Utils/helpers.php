<?php

use Elementor\Plugin;

function get_iqonic_layouts_config()
{
    return $GLOBALS['iqonic_layouts_config']['Elements'];
}

if (!function_exists('layout_get_post')) {
    function layout_get_post($post_type = "", $post_status = "publish")
    {
        $args = array(
            'post_type'         => $post_type,
            'post_status'       => $post_status,
            'posts_per_page'    => -1
        );
        $get_posts = get_posts($args);
        $iqonic_blog_list = [];

        if ($get_posts) {
            foreach ($get_posts as $post) {
                $iqonic_blog_list[$post->post_name] = get_the_title($post->ID);
            }
            return $iqonic_blog_list;
        }
        wp_reset_postdata();
    }
}

if (!function_exists('iqonic_addons_get_list_layouts')) {
    function iqonic_addons_get_list_layouts($not_selected = false, $type = 'custom', $order = 'ID')
    {
        $args = array(
            'post_type'         => 'iqonic_hf_layout',
            'meta_key'          => '_layout_meta_key',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_value'        => $type,
            'orderby'           => $order,
            'order'             => 'asc',
            'not_selected'      => $not_selected
        );
        $get_layouts = get_posts($args);
        $iqonic_hr_layout_list = [];
        if ($get_layouts) {
            foreach ($get_layouts as $layout) {
                $iqonic_hr_layout_list[$layout->post_name] = get_the_title($layout->ID);
            }
        }
        return $iqonic_hr_layout_list;
    }
}

if (!function_exists('layout_get_nav_menus')) {
    function layout_get_nav_menus($fetch = 'menu')
    {
        if ($fetch === 'location') {
            $iqonic_location_list = ['select' => '-No Select-'];
            $locations = get_nav_menu_locations();
            if ($locations) {
                foreach ($locations as $key => $val) {
                    $iqonic_location_list[$key] = ucfirst($key);
                }
                return $iqonic_location_list;
            }
        } else {
            $menus = wp_get_nav_menus();
            $iqonic_menu_list = [];
            if ($menus) {
                foreach ($menus as $key => $val) {
                    $iqonic_menu_list[$val->slug] = $val->name;
                }
                return $iqonic_menu_list;
            }
        }
    }
}

add_filter('single_template', 'iqonic_load_template', 999, 1);
function iqonic_load_template($template)
{
    // global $post;
    if ('iqonic_hf_layout' === get_post_type() && !locate_template('single-iqonic_hf_layout.php')) {
        return IQONIC_LAYOUTS_EXTENSION_PLUGIN_PATH . 'includes/Layouts/single-iqonic_hf_layout.php';
    }
    return $template;
}

// Return list of post's types
if (!function_exists('iqonic_addons_get_list_posts_types')) {
    function iqonic_addons_get_list_posts_types()
    {
        $post_types = get_post_types(array('public' => true), 'objects');
        $posts = array();
        foreach ($post_types as $post_type) {
            $posts[$post_type->name] = $post_type->labels->singular_name;
        }
        return $posts;
    }
}

//add custom layouts in footer
if (!function_exists('iqonic_render_layout')) {
    add_action('wp_footer', 'iqonic_render_layout');
    function iqonic_render_layout()
    {
        $layout_options = get_option('_custom_layout_ids');

        if ($layout_options && !empty($layout_options)) {
            foreach ($layout_options as $key => $val) {
                if (!empty($val['template_id'])) {
                    $class = !empty($val['class']) ? ' ' . $val['class'] : '';
                    $style = !empty($val['style']) ? ' ' . $val['style'] : '';

                    $response = Plugin::instance()->frontend->get_builder_content_for_display($val['template_id']);
                    if (!empty($response)) {
?>
                        <div id="<?php echo esc_attr($val['container_id']); ?>" class="iqonic-custom-layouts hidden-custom-layout <?php echo esc_attr($class); ?>" <?php echo esc_attr($style); ?>>
                            <?php
                            if ($val['panel_icon']) : ?>
                                <button class="btn-close">
                                    <?php if (!$val['panel_icon']['type']) { ?>
                                        <i class="<?php echo esc_attr(!empty($val['panel_icon']['value']) ? $val['panel_icon']['value'] : 'fas fa-times'); ?>"></i>
                                    <?php
                                    } else {
                                        echo file_get_contents($val['panel_icon']['value']);
                                    }
                                    ?>
                                </button>
                            <?php endif; ?>
                            <div class="sidebar-scrollbar">
                                <?php echo iqonic_return_elementor_res($response); ?>
                            </div>
                        </div>
    <?php
                    }
                }
            }
            update_option('_custom_layout_ids', NULL);
        }
    }
}


if (!function_exists('iqonic_return_elementor_res')) {
    function iqonic_return_elementor_res($response)
    {

        return $response;
    }
}

//layout shortcode
add_shortcode('iqonic_layout', 'get_layout_content');
function get_layout_content($atts)
{
    if (!is_array($atts)) {
        return;
    }
    if (!isset($atts['id']) || empty($atts['id'])) {
        return;
    }
    $html = Plugin::instance()->frontend->get_builder_content_for_display($atts['id']);
    return $html;
}

function iqonic_layout_add_editor_layout_option($id)
{
    $iq_layout_type = get_post_meta($id, '_layout_meta_key', true);
    $iq_layouts_list = iqonic_addons_get_list_layouts(false, $iq_layout_type);

    ?>
    <div class="iq-layout-editor">
        <div class="iq-layout-btn-wrapper">
            <a href="<?php echo add_query_arg(['post' => $id, 'action' => 'elementor'], admin_url('post.php')) ?>" target="_blank" class="iq-layout-edit-btn" onclick="iq_hf_layout_open_layout_editor(this)">
                <?php printf('%s %s %s', __("Edit ", 'iqonic-layouts'), get_the_title($id), __('With Elementor', 'iqonic-layouts'));                 ?>
            </a>
            <button class="iq-layout-change-dropdown-btn" onclick="iq_hf_layout_toggle_dropdown(this)">
                <span class="layout-icon"></span>
            </button>
        </div>
        <div class="iq-layout-selector-wrapper">
            <ul class="iq-layout-selector" data-layout-type="<?php echo esc_attr($iq_layout_type) ?>" style="display: none;">
                <?php
                foreach ($iq_layouts_list as $key => $iq_layouts) {
                ?>
                    <li data-value="<?php echo esc_attr($key) ?>" onclick="iq_hf_layout_change_layout_value(this)"> <?php echo esc_html($iq_layouts) ?> </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

<?php
}
add_action('iqonic_hf_layout/editor/layout_content_after', 'iqonic_layout_add_editor_layout_option');
function iqonic_layout_add_editor_layout_option_scripts()
{
    wp_register_script('elementor-editor-script', plugin_dir_url(__DIR__)  . '/Admin/assets/js/elementor-editor-script.js');
    wp_localize_script('elementor-editor-script', 'iq_layout_params', array('ajaxURL' => admin_url('admin-ajax.php'), 'page_ID' => get_queried_object_id()));
    wp_enqueue_script('elementor-editor-script');
    wp_enqueue_style('elementor-editor-style', plugin_dir_url(__DIR__)  . '/Admin/assets/css/elementor-editor-style.css');
}
add_action('elementor/preview/enqueue_scripts', 'iqonic_layout_add_editor_layout_option_scripts');

function iq_change_page_layout()
{
    $layout_type = $_REQUEST['layout_type'];
    $page_id = $_REQUEST['page_id'];
    $layout =  $_REQUEST['layout'];

    if (isset($layout_type) && isset($page_id) && isset($layout)) {
        $is_success = update_post_meta($page_id, apply_filters("iqonic_hf_metakey_display", 'dispaly_' . $layout_type,) , 'yes');
        $is_success = update_post_meta($page_id, apply_filters("iqonic_hf_metakey_type", $layout_type . '_layout_type'), 'custom');
        $is_success = update_post_meta($page_id, apply_filters("iqonic_hf_metakey_name", $layout_type . '_layout_name'), $layout);
        
        if ($is_success) {
            wp_send_json_success();
        }
    }

    wp_send_json_error();
}

add_action('wp_ajax_iq_change_page_layout', 'iq_change_page_layout');
