<?php

/**
 * Kivicare\Utility\Scripts\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Scripts;

use Kivicare\Utility\Component_Interface;
use Kivicare\Utility\Templating_Component_Interface;
use function Kivicare\Utility\kivicare;
use function add_action;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;

class Component implements Component_Interface
{

	/**
	 * Associative array of CSS files, as $handle => $data pairs.
	 * $data must be an array with keys 'file' (file path relative to 'assets/css' directory), and optionally 'global'
	 * (whether the file should immediately be enqueued instead of just being registered) and 'preload_callback'
	 * (callback function determining whether the file should be preloaded for the current request).
	 *
	 * Do not access this property directly, instead use the `get_css_files()` method.
	 *
	 * @var array
	 */
	protected $js_files;

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'scripts';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('wp_enqueue_scripts', array($this, 'action_enqueue_scripts'));
	}

	/**
	 * Registers or enqueues stylesheets.
	 *
	 * Stylesheets that are global are enqueued. All other stylesheets are only registered, to be enqueued later.
	 */
	public function action_enqueue_scripts()
	{

		global $wp_query;
		$js_uri = get_theme_file_uri('/assets/js/');
		$js_dir = get_theme_file_path('/assets/js/');
		$js_files = $this->get_js_files();

		foreach ($js_files as $handle => $data) {
			$src     = $js_uri . $data['file'];
			$version = kivicare()->get_asset_version($js_dir . $data['file']);

			wp_enqueue_script($handle, $src, $data['dependency'], $version, $data['in_footer']);
		}

		wp_localize_script('kivicare-loadmore', 'kivicare_loadmore_params', array(
			'ajaxurl' => home_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
			'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
			'max_page' => $wp_query->max_num_pages,
			'template_dir' => get_template_directory_uri()
		));
		wp_enqueue_script('kivicare-loadmore');
	}

	/**
	 * Gets all JS files.
	 *
	 * @return array Associative array of $handle => $data pairs.
	 */
	protected function get_js_files(): array
	{
		if (is_array($this->js_files)) {
			return $this->js_files;
		}

		$js_files = array(
			'bootstrap'     => array(
				'file'   => 'vendor/bootstrap.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'wow'     => array(
				'file'   => 'vendor/wow.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'nice-select'     => array(
				'file'   => 'vendor/jquery.nice-select.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'select2'     => array(
				'file'   => 'vendor/select2.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),	
			'customizer'     => array(
				'file'   => 'custom.min.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
			'superfish'     => array(
				'file'   => 'vendor/superfish.js',
				'dependency' => array('jquery'),
				'in_footer' => true,
			),
		);

		if(class_exists("WooCommerce")) {
			$woo_js = array(
				'kivicare-loadmore'     => array(
					'file'   => 'loadmore.min.js',
					'dependency' => array('jquery'),
					'in_footer' => true,
				),
				'kivicare-woocomerce-product-dependency' => array(
					'file'	=> 'woocommerce.min.js',
					'dependency' => array('jquery'),
					'in_footer' => true,
				),
				'kivicare-woocomerce-product-loadmore' => array(
					'file'	=> 'ajax-product-load.min.js',
					'dependency' => array('jquery'),
					'in_footer' => true,
				),
			);
			$js_files = array_merge($js_files, $woo_js);
		}

		$this->js_files = array();
		foreach ($js_files as $handle => $data) {
			if (is_string($data)) {
				$data = array('file' => $data);
			}

			if (empty($data['file'])) {
				continue;
			}

			$this->js_files[$handle] = array_merge(
				array(
					'global'           => false,
					'preload_callback' => null,
					'media'            => 'all',
				),
				$data
			);
		}

		return $this->js_files;
	}
}
