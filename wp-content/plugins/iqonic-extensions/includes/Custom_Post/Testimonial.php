<?php

// Register Testimonial type custom post
add_action('init', 'iqonic_testimonial_gallery');
function iqonic_testimonial_gallery()
{
    $labels = array(
        'name' => esc_html__('Testimonial', 'iqonic'),
        'singular_name' => esc_html__('Testimonial', 'iqonic'),
        'featured_image' => esc_html__('Photo', 'iqonic'),
        'set_featured_image' => esc_html__('Set Photo', 'iqonic'),
        'remove_featured_image' => esc_html__('Remove Photo', 'iqonic'),
        'use_featured_image' => esc_html__('Use as Photo', 'iqonic'),
        'menu_name' => esc_html__('Testimonial', 'iqonic'),
        'name_admin_bar' => esc_html__('Testimonial', 'iqonic'),
        'add_new' => esc_html__('Add New', 'iqonic'),
        'add_new_item' => esc_html__('Add New Testimonial', 'iqonic'),
        'new_item' => esc_html__('New Testimonial', 'iqonic'),
        'edit_item' => esc_html__('Edit Testimonial', 'iqonic'),
        'view_item' => esc_html__('View Testimonial', 'iqonic'),
        'all_items' => esc_html__('All Testimonial', 'iqonic'),
        'search_items' => esc_html__('Search Testimonial', 'iqonic'),
        'parent_item_colon' => esc_html__('Parent Testimonial:', 'iqonic'),
        'not_found' => esc_html__('No Testimonial found.', 'iqonic'),
        'not_found_in_trash' => esc_html__('No Testimonial found in Trash.', 'iqonic')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonial'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('testimonial', $args);
}