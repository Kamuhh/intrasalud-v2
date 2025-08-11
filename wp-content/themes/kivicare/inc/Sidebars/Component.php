<?php

/**
 * Kivicare\Utility\Sidebars\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Sidebars;

use Kivicare\Utility\Component_Interface;
use Kivicare\Utility\Templating_Component_Interface;
use function add_action;
use function add_filter;
use function register_sidebar;
use function is_active_sidebar;
use function dynamic_sidebar;

/**
 * Class for managing sidebars.
 *
 * Exposes template tags:
 * * `kivicare()->is_primary_sidebar_active()`
 * * `kivicare()->display_primary_sidebar()`
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	const PRIMARY_SIDEBAR_SLUG = 'sidebar-1';
	public $get_option = '';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'sidebars';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('widgets_init', array($this, 'action_register_sidebars'));
		add_filter('body_class', array($this, 'filter_body_classes'));
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `kivicare()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'is_primary_sidebar_active' => array($this, 'is_primary_sidebar_active'),
			'display_primary_sidebar' => array($this, 'display_primary_sidebar'),
			'post_style' => array($this, 'post_style'),
		);
	}

	/**
	 * Registers the sidebars.
	 */
	public function action_register_sidebars()
	{
		register_sidebar(
			array(
				'name' => esc_html__('Blog Sidebar', 'kivicare'),
				'id' => static::PRIMARY_SIDEBAR_SLUG,
				'description' => esc_html__('Add widgets here.', 'kivicare'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title"> <span>  ',
				'after_title' => ' </span></h5>',
			)
		);

		if( class_exists('ReduxFramework') ) {

			register_sidebar( array(
				'name'          => esc_html__('Side Area','kivicare'),
				'class'         => 'nav-list',
				'id'            => 'kivi_side_area',
				'before_widget' => '<div class="widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="iq-side-area-title mt-0">',
				'after_title'   => '</h4>',
			) );
		}

		if( class_exists('ReduxFramework') ) {

			register_sidebar( array(
				'name'          => esc_html__( 'Page Sidebar', 'kivicare' ),
				'id'            => 'page-1',
				'description'   => esc_html__( 'Add widgets here to appear in your sidebar on Pages.', 'kivicare' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );
		}	

		if (class_exists('WooCommerce')) {
			register_sidebar(array(
				'name'          => esc_html__('Product Sidebar', 'kivicare'),
				'class'         => 'nav-list',
				'id'            => 'product_sidebar',
				'before_widget' => '<div class="sidebar_widget widget-woof %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title">',
				'after_title' => '<span class="line_"></span></h5>',
			));
		}
		
	}

	/**
	 * Adds custom classes to indicate whether a sidebar is present to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes(array $classes): array
	{
		if ($this->is_primary_sidebar_active()) {
			global $template;

			if (!in_array(basename($template), array('front-page.php', 'FourZeroFour.php', 'offline.php'))) {
				$classes[] = 'has-sidebar';
			}
		}

		return $classes;
	}

	/**
	 * Checks whether the primary sidebar is active.
	 *
	 * @return bool True if the primary sidebar is active, false otherwise.
	 */
	public function is_primary_sidebar_active(): bool
	{
		global $kivicare_options;
		$this->get_option =  $kivicare_options;

		if (class_exists('ReduxFramework') && $this->get_option != '') {
			if (is_search()) {
				$option = $this->get_option['search_page'];
			} else {
				if (class_exists('WooCommerce') && is_shop()) {
					$option = $this->get_option['woocommerce_shop_grid'];
				} else {
					$option = is_single() ? $this->get_option['kivi_blog_type'] : $this->get_option['kivi_blog'];
				}
			}

			if (in_array($option, [4, 5])) {
				return (bool)is_active_sidebar(static::PRIMARY_SIDEBAR_SLUG);
			} else {
				return false;
			}
		}

		if (is_search()) {
			return false;
		} else {
			return (bool)is_active_sidebar(static::PRIMARY_SIDEBAR_SLUG);
		}
	}

	/**
	 * Displays the primary sidebar.
	 */
	public function display_primary_sidebar()
	{
		if (class_exists('WooCommerce') && is_shop() || is_tax('product_cat')) {
			dynamic_sidebar('product_sidebar');
		} else {
			dynamic_sidebar(static::PRIMARY_SIDEBAR_SLUG);
		}
	}

	public function post_style(): array
	{
		$option = 'kivi_blog';
		if (class_exists('WooCommerce') && (is_shop())) {
			if (isset($this->get_option['woocommerce_shop_grid']) && !empty($this->get_option['woocommerce_shop_grid'])) {
				$option = 'woocommerce_shop_grid';
			}
		}

		$section['row_reverse'] = '';
		$section['post'] = 'col-lg-12 col-sm-12 p-0';

		if (is_search()) {
			$options = !empty($this->get_option['search_page']) ? $this->get_option['search_page'] : '';
		} else if (is_single()) {
			$options = !empty($this->get_option['kivi_blog_type']) ? $this->get_option['kivi_blog_type'] : '';
		} else {
			$options = !empty($this->get_option[$option]) ? $this->get_option[$option] : '';
		}

		switch ($options) {
			case 2:
				$section['post'] = 'col-lg-6 col-sm-12';
				break;
			case 3:
				$section['post'] = 'col-lg-4 col-sm-12';
				break;
			case 5:
				$section['row_reverse'] = ' flex-row-reverse';
				break;
			}
		return $section;
	}
}
