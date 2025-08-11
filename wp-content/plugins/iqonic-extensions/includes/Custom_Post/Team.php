<?php

// Register Team Member custom post type
add_action('init', 'iqonic_team');
function iqonic_team()
{
    $labels = array(
        'name' => esc_html__('Team Member','iqonic'),
        'singular_name' => esc_html__('Team Member', 'iqonic'),
        'featured_image' => esc_html__('Team Member Photo', 'iqonic'),
        'set_featured_image' => esc_html__('Set Team Member Photo', 'iqonic'),
        'remove_featured_image' => esc_html__('Remove Team Member Photo', 'iqonic'),
        'use_featured_image' => esc_html__('Use as Team Member Photo', 'iqonic'),
        'menu_name' => esc_html__('Our Team', 'iqonic'),
        'name_admin_bar' => esc_html__('Team Member', 'iqonic'),
        'add_new' => esc_html__('Add New', 'iqonic'),
        'add_new_item' => esc_html__('Add New Team Member', 'iqonic'),
        'new_item' => esc_html__('New Team Member', 'iqonic'),
        'edit_item' => esc_html__('Edit Team Member', 'iqonic'),
        'view_item' => esc_html__('View Team Member', 'iqonic'),
        'all_items' => esc_html__('All Team Members', 'iqonic'),
        'search_items' => esc_html__('Search Team Member', 'iqonic'),
        'parent_item_colon' => esc_html__('Parent Team Member:', 'iqonic'),
        'not_found' => esc_html__('No Classs found.', 'iqonic'),
        'not_found_in_trash' => esc_html__('No Classs found in Trash.', 'iqonic')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'team'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-businessman',
        'supports' => array('title', 'thumbnail', 'editor', 'excerpt')
    );

    register_post_type('team', $args);
}

// Custom taxonomy
add_action('after_setup_theme', 'iqonic_custom_taxonomy');
function iqonic_custom_taxonomy()
{
    $labels = '';

    register_taxonomy(
        'team-categories',
        'team',
        array(
            'label' => esc_html__('Team Category', 'iqonic'),
            'rewrite' => true,
            'hierarchical' => true,
            
        )
    );
}

add_action('manage_team_posts_custom_column', 'iqonic_show_team_category_column', 10, 2);
function iqonic_show_team_category_column( $column, $post_id ) {
    if ($column == 'team_categories') {
        $terms = get_the_terms($post_id, 'team-categories');
        if (!empty($terms) && !is_wp_error($terms)) {
            $term_list = array();
            foreach ($terms as $term) {
                $term_list[] = esc_html($term->name);
            }
            echo implode(', ', $term_list);
        } else {
            echo esc_html__('No Team Categories', 'iqonic');
        }
    }
}

add_filter('manage_edit-team_columns', 'iqonic_add_team_category_column');
function iqonic_add_team_category_column( $columns ) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key == 'title') {
            $new_columns[$key] = $value;
            $new_columns['team_categories'] = esc_html__('Team Categories', 'iqonic');
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
