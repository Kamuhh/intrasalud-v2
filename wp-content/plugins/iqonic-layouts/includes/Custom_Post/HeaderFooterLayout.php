<?php
// Register Layout custom post type
add_action('init', 'iqonic_header_footer');
function iqonic_header_footer()
{
    $labels = array(
        'name'               => esc_html__('Layout', 'iqonic-layouts'),
        'singular_name'      => esc_html__('Layout', 'iqonic-layouts'),
        'menu_name'          => esc_html__('Layout', 'iqonic-layouts'),
        'name_admin_bar'     => esc_html__('Layout', 'iqonic-layouts'),
        'add_new'            => esc_html__('Add New', 'iqonic-layouts'),
        'add_new_item'       => esc_html__('Add New Layout', 'iqonic-layouts'),
        'new_item'           => esc_html__('New Layout', 'iqonic-layouts'),
        'edit_item'          => esc_html__('Edit Layout', 'iqonic-layouts'),
        'view_item'          => esc_html__('View Layout', 'iqonic-layouts'),
        'all_items'          => esc_html__('All Layout', 'iqonic-layouts'),
        'search_items'       => esc_html__('Search Layout', 'iqonic-layouts'),
        'parent_item_colon'  => esc_html__('Parent Layout:', 'iqonic-layouts'),
        'not_found'          => esc_html__('No Layout found.', 'iqonic-layouts'),
        'not_found_in_trash' => esc_html__('No Layout found in Trash.', 'iqonic-layouts')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'iqonic_hf_layout'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-schedule',
        'supports'           => array('title', 'editor')
    );

    register_post_type('iqonic_hf_layout', $args);
}
