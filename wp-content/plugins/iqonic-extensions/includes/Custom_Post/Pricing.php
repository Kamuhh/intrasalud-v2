<?php
// Register Testimonial type custom post
add_action('init', 'iqonic_pricing');
function iqonic_pricing()
{
	$url = get_template_directory_uri();
	$labels = array(
		'name'                  => esc_html__('Pricing Plan', "iqonic"),
		'singular_name'         => esc_html__('Pricing Plan', "iqonic"),
		'menu_name'             => esc_html__('Pricing', "iqonic"),
		'name_admin_bar'        => esc_html__('Pricing', "iqonic"),
		'add_new'               => esc_html__('Add New', "iqonic"),
		'add_new_item'          => esc_html__('Title', "iqonic"),
		'new_item'              => esc_html__('New Price', "iqonic"),
		'edit_item'             => esc_html__('Edit Price', "iqonic"),
		'view_item'             => esc_html__('View Pricing', "iqonic"),
		'all_items'             => esc_html__('All Pricing', "iqonic"),
		'search_items'          => esc_html__('Search Price', "iqonic"),
		'parent_item_colon'     => esc_html__('Parent Price :', "iqonic"),
		'not_found'             => esc_html__('No Classs found.', "iqonic"),
		'not_found_in_trash'    => esc_html__('No Classs found in Trash.', "iqonic")
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'show_in_nav_menus'  => TRUE,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'             => 'dashicons-admin-site-alt2',
		'supports'           => array('title')
	);

	register_post_type('pricing', $args);
}

add_action('after_setup_theme', 'iqonic_pricing_taxonomy');
function iqonic_pricing_taxonomy()
{
	register_taxonomy(
		'pricing_categories',
		'pricing',
		array(
			'label'         => esc_html__('Pricing Categories', "iqonic"),
			'rewrite'       => true,
			'hierarchical'  => true,
			'meta_box_cb' => false,
		)
	);
}
