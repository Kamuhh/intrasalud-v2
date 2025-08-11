<?php
// Register Services CPT
add_action('init', 'iqonic_services');
function iqonic_services()
{
    $labels = array(
        'name'                  => esc_html__('Services', 'iqonic'), //post type general name
        'singular_name'         => esc_html__('Service', 'iqonic'), //post type singular name
        'featured_image'        => esc_html__('Photo', 'iqonic'),
        'set_featured_image'    => esc_html__('Set Photo', 'iqonic'),
        'remove_featured_image' => esc_html__('Remove Photo', 'iqonic'),
        'use_featured_image'    => esc_html__('Use as Photo', 'iqonic'),
        'menu_name'             => esc_html__('Services','iqonic'),
        'name_admin_bar'        => esc_html__('Services','iqonic'),
        'add_new'               => esc_html__('Add New', 'iqonic'),
        'add_new_item'          => esc_html__('Add New Services', 'iqonic'),
        'new_item'              => esc_html__('New Services', 'iqonic'),
        'edit_item'             => esc_html__('Edit Services', 'iqonic'),
        'view_item'             => esc_html__('View Services', 'iqonic'),
        'all_items'             => esc_html__('All Services', 'iqonic'),
        'search_items'          => esc_html__('Search Services', 'iqonic'),
        'parent_item_colon'     => esc_html__('Parent Services:', 'iqonic'),
        'not_found'             => esc_html__('No Services found.', 'iqonic'),
        'not_found_in_trash'    => esc_html__('No Services found in Trash.', 'iqonic')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'service'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-grid-view',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt')
    );

    register_post_type('service', $args);
}

// Custom taxonomy
add_action('after_setup_theme', 'iqonic_service_taxonomy');
function  iqonic_service_taxonomy()
{
    $labels = '';

    register_taxonomy(
        'service_categories',
        'service',
        array(
            'label' => esc_html__('Service Category', 'iqonic'),
            'rewrite' => true,
            'hierarchical' => true,
        )
    );
}

add_action('init', 'iqonic_service_tag_taxonomies', 0);

//create two tags for the post type "tag"
function iqonic_service_tag_taxonomies()
{
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name' => esc_html__('Tags', 'iqonic'),
        'singular_name' => esc_html__('Tag', 'iqonic'),
        'search_items' =>  esc_html__('Search Tags', 'iqonic'),
        'popular_items' => esc_html__('Popular Tags', 'iqonic'),
        'all_items' => esc_html__('All Tags', 'iqonic'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => esc_html__('Edit Tag', 'iqonic'),
        'update_item' => esc_html__('Update Tag', 'iqonic'),
        'add_new_item' => esc_html__('Add New Tag', 'iqonic'),
        'new_item_name' => esc_html__('New Tag Name', 'iqonic'),
        'separate_items_with_commas' => esc_html__('Separate tags with commas', 'iqonic'),
        'add_or_remove_items' => esc_html__('Add or remove tags', 'iqonic'),
        'choose_from_most_used' => esc_html__('Choose from the most used tags', 'iqonic'),
        'menu_name' => esc_html__('Tags', 'iqonic'),
    );

    register_taxonomy('service_tags', 'service', array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array('slug' => 'service_tags'),
    ));
}
