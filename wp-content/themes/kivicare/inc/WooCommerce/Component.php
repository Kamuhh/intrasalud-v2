<?php

/**
 * Kivicare\Utility\Woocommerce\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Woocommerce;

use Kivicare\Utility\Component_Interface;
use Kivicare\Utility\Templating_Component_Interface;
use function add_action;

/**
 * Class for managing Woocommerce UI.
 *
 * Exposes template tags:
 * * `kivicare()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Woocommerce slug.
	 */

	public function get_slug(): string
	{
		return 'woocommerce';
	}

	function __construct()
	{
		add_filter('woocommerce_gallery_thumbnail_size', function ($size) {
			return array(300, 300);
		});
		setcookie('done', '', -1, '/');
		add_filter('woof_sort_terms_before_out', array($this, 'kivicare_woof_hide_zero_term'));
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{

		add_filter("woof_products_query", function ($query) {
			$_SESSION['kivicare_woof_query_ajax'] = $query;
			return $query;
		});

		add_action('init', array($this, 'kivicare_set_default_cookie'), -91);

		add_filter('woocommerce_show_page_title', '__return_false');

		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_btn_view_cart'), 10);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_checkout'), 20);

		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
		add_action('woocommerce_before_shop_loop_item_title', array($this, 'kivicare_loop_product_thumbnail'), 10);

		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

		// WooCommerce Checkout Fields Hook
		add_filter('woocommerce_checkout_fields',  array($this, 'custom_wc_checkout_fields'));

		add_filter( 'woocommerce_billing_fields', array($this, 'kivicare_edit_billing_fields'),10,1 );

		// Single
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_single_product_summary',  array($this, 'woocommerce_my_single_title'), 5);
		add_action('after_setup_theme', array($this, 'kivicare_add_woocommerce_support'));
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

		// Remove add to cart
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);

		// Remove product title
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

		// Remove product price
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

		add_filter('get_the_archive_title', array($this, 'kivicare_product_archive_title'));

		/* Rating Create For Product Loop */
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

		add_filter('woocommerce_add_to_cart_fragments', array($this, 'kivicare_refresh_mini_cart_count'));

		add_filter('woocommerce_sale_flash', array($this, 'lw_hide_sale_flash'));

		/* products loop_columns */
		add_filter('loop_shop_columns', array($this, 'kivicare_loop_columns'), 21);

		/* wishlist title hide */
		add_filter('yith_wcwl_wishlist_params', array($this, 'kivicare_wishlist_remove_title'), 10, 3);

		/* hide terms and conditions toggle */
		add_action('wp_enqueue_scripts', array($this, 'kivicare_disable_terms'), 1000);

		/* woocommerce redirection after login registration */
		add_filter('woocommerce_registration_redirect', array($this, 'kivicare_after_login_registration'), 10, 1);
		add_filter('woocommerce_login_redirect', array($this, 'kivicare_after_login_registration'), 10, 1);
		add_filter('wc_get_template_part', array($this, 'kivicare_wc_template_part'), 10, 3);

		add_filter('woocommerce_privacy_policy_page_id',array($this, 'kivicare_privacy_policy_page_id'), 10, 1);

		add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

		add_filter('loop_shop_per_page', array($this, 'kivicare_product_perpage'), 99999);

		add_action('woocommerce_before_checkout_form', array($this, 'kivicare_woocomerce_page_header'), -999);
		add_action('woocommerce_before_cart', array($this, 'kivicare_woocomerce_page_header'));
		add_action('kivicare_order_summary_before', array($this, 'kivicare_woocomerce_page_header'));

		add_filter('woocommerce_get_script_data', function ($params) {
			if (isset($params['i18n_view_cart'])) {
				$params['i18n_view_cart'] = '<span>' . $params['i18n_view_cart'] . '</span>';
			}
			return $params;
		});

		add_filter('woocommerce_quantity_input_args', array($this,'cart_min_quantity'),10,2);

	}

	public function template_tags(): array {
		return array(
			'get_single_product_dependent_script' 	=> array($this, 'get_single_product_dependent_script')
		);
	}

	public function kivicare_privacy_policy_page_id() {
		$page = get_page_by_path('privacy-policy');
		return $page->ID;
	}

	public function get_single_product_dependent_script()
	{
		wp_enqueue_style('swiper-bundle', get_template_directory_uri() . '/assets/css/vendor/swiper-bundle.min.css', array(), '1.0', "all");
		wp_enqueue_script('swiper-min', get_template_directory_uri() . '/assets/js/vendor/swiper-bundle.min.js', array(), '1.0', true);
		wp_enqueue_script('products-swiper', get_template_directory_uri() . '/assets/js/products-swiper.min.js', array(), '1.0', true);
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `kivicare()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */

	public function lw_hide_sale_flash()
	{
		return false;
	}

	function kivicare_product_archive_title($title)
	{
		if (is_post_type_archive('product')) $title = esc_html__("Shop", 'kivicare');
		return $title;
	}

	function kivicare_add_woocommerce_support()
	{
		add_theme_support('woocommerce');
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
		// Declare WooCommerce support.
	}

	function woocommerce_my_single_title() { ?>
		<h3 class="product_title entry-title">
			<span><?php the_title(); ?></span>
		</h3> <?php
	}

	function kivicare_loop_product_thumbnail($args = array()) {
		$kivicare_options = get_option( 'kivi_options' );

		if ( is_shop() && ( isset( $kivicare_options['woocommerce_shop']) && $kivicare_options['woocommerce_shop'] == '1' ) ) {
			get_template_part('template-parts/wocommerce/entry', 'listing');
		} else {
			get_template_part('template-parts/wocommerce/entry');
		}
	}

	// Change the format of fields with type, label, placeholder, class, required, clear, label_class, options
	function custom_wc_checkout_fields($fields)
	{
		//BILLING
		$fields['billing']['billing_first_name']['label'] = false;
		$fields['billing']['billing_first_name']['placeholder'] =esc_html__("First Name",'kivicare');

		$fields['billing']['billing_last_name']['label'] = false;
		$fields['billing']['billing_last_name']['placeholder'] = esc_html__("Last Name",'kivicare');

		$fields['billing']['billing_company']['label'] = false;
		$fields['billing']['billing_company']['placeholder'] = esc_html__("Company",'kivicare');

		$fields['billing']['billing_country']['label'] = false;
		$fields['billing']['billing_address_1']['label'] = false;
		$fields['billing']['billing_city']['label'] = false;
		$fields['billing']['billing_state']['label'] = false;
		$fields['billing']['billing_postcode']['label'] = false;
		$fields['billing']['billing_phone']['label'] = false;
		$fields['billing']['billing_phone']['placeholder'] = esc_html__("Phone Number",'kivicare');
		$fields['billing']['billing_email']['label'] = false;
		$fields['billing']['billing_email']['placeholder'] = esc_html__("E-mail Address",'kivicare');

		return $fields;
	}

	public function kivicare_set_default_cookie()
	{
		if (!wp_doing_ajax() && $GLOBALS["_SERVER"]['REQUEST_METHOD'] !== 'POST' ) {
			self::set_cookie();
		}
	}

	public static function set_cookie()
	{
		$kivicare_options = get_option('kivi_options');
		ob_start();
		$kivicare_options['woocommerce_shop_grid'] = isset($kivicare_options['woocommerce_shop_grid']) && $kivicare_options['woocommerce_shop_grid'] > 2 ? $kivicare_options['woocommerce_shop_grid'] - 1 : 3;
		$arr = array(
			'is_grid' => isset($kivicare_options['woocommerce_shop']) ? $kivicare_options['woocommerce_shop'] : 2,
			'col_no' => isset($kivicare_options['woocommerce_shop']) && $kivicare_options['woocommerce_shop'] == '2' && isset($kivicare_options['woocommerce_shop_grid']) ? $kivicare_options['woocommerce_shop_grid']  : 3
		);

		foreach ($arr as $key => $value) {
			setcookie('product_view[' . $key . ']', $value, time() + 62208000, '/');
			$_COOKIE['product_view'][$key] = $value;
		}
	}

	// refresh mini cart ------------//
	function kivicare_refresh_mini_cart_count( $fragments )
	{
		ob_start();	?>
		<div id="mini-cart-count" class="cart-items-count count">
			<?php echo (WC()->cart->get_cart_contents_count() > 9) ? '9+' : WC()->cart->get_cart_contents_count(); ?>
		</div> <?php
		$fragments['#mini-cart-count'] = ob_get_clean();
		return $fragments;
	}

	// Mini cart View Cart Button
	function custom_widget_cart_btn_view_cart()
	{ ?>
		<a class="iq-new-btn-style iq-button-style-2 has-icon btn-icon-right view_cart wc-forward" href="<?php echo esc_url(wc_get_cart_url()); ?>">
			<span class="iq-btn-text-holder"><?php esc_html_e('View Cart', 'kivicare'); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
		</a> <?php
	}

	//Mini Cart Checkout Button
	function custom_widget_cart_checkout()
	{ ?>
		<a class="iq-new-btn-style iq-button-style-2 has-icon btn-icon-right checkout wc-forward" href="<?php echo esc_url(wc_get_checkout_url()); ?>">
			<span class="iq-btn-text-holder"><?php esc_html_e('Checkout', 'kivicare'); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
		</a> <?php
	}

	/* products loop_columns */
	function kivicare_loop_columns()
	{
		if ($_COOKIE['product_view']['is_grid'] == '2') {
			return $_COOKIE['product_view']['col_no'];
		} elseif ($_COOKIE['product_view']['is_grid'] == '1') {
			return 1;
		}
		return 3;
	}

	/* wishlist title hide */
	function kivicare_wishlist_remove_title($args, $action, $action_params)
	{
		if (isset($args['wishlist_meta']) && $args['wishlist_meta']['is_default'] && !empty($args['wishlist_meta']['wishlist_name'])) {
			$args['page_title'] = $args['wishlist_meta']['wishlist_name'];
		}
		return $args;
	}

	/* hide terms and conditions toggle */
	function kivicare_disable_terms()
	{
		wp_add_inline_script('wc-checkout', "jQuery( document ).ready( function() { jQuery( document.body ).off( 'click', 'a.woocommerce-terms-and-conditions-link' ); } );");
	}

	/* woocommerce redirection after login & registration */
	function kivicare_after_login_registration($kivicare_redirection_url)
	{
		$kivicare_redirection_url = esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . 'my-account');
		return $kivicare_redirection_url;
	}

	public function kivicare_wc_template_part($template, $slug, $name)
			{
				if (is_shop() || is_product_category() || is_product_tag()) {
					$template_page = $_COOKIE['product_view']['is_grid'] == '2' ? 'entry.php' : 'entry-listing.php';
					$custom_template = locate_template('template-parts/wocommerce/' . $template_page);

					if ($custom_template) {
						return $custom_template;
					}
				}
				return $template;
			}

	public function kivicare_product_perpage($per_page)
	{
		$kivicare_options = get_option('kivi_options');
		$is_loadmore_pagination = isset($kivicare_options['kivicare_woocommerce_display_pagination']) && $kivicare_options['kivicare_woocommerce_display_pagination'] == 'pagination';

		if (isset($kivicare_options['woocommerce_product_per_page'])) {
			if (isset($_REQUEST['loaded_paged'])  &&  !$is_loadmore_pagination) {
				return $_REQUEST['loaded_paged'] * (int)$kivicare_options['woocommerce_product_per_page'];
			}
			return (int)$kivicare_options['woocommerce_product_per_page'];
		}
		return $per_page;
	}
	
	public function kivicare_woocomerce_page_header()
	{
		$links = array(
			array(
				'name' => esc_html__('Shopping Cart', 'kivicare'),
				'class' => is_cart() ? 'active' : '',
			),
			array(
				'name' => esc_html__('Checkout', 'kivicare'),
				'class' => is_checkout() && empty(is_wc_endpoint_url('order-received'))  ? 'active' : '',
			),
			array(
				'name' => esc_html__('Order Summary', 'kivicare'),
				'class' => is_checkout() && !empty(is_wc_endpoint_url('order-received'))  ? 'active' : '',
			),
		); ?>
		<div class="kivicare-page-header">
			<ul class="kivicare-page-items">
				<?php
				foreach ($links as $key => $link) {
				?>
					<li class="kivicare-page-item <?php echo esc_attr($link['class']) ?>">
						<span class="kivicare-pre-heading"> <?php echo esc_html($key + 1) ?> </span>
						<span class="kivicare-page-link ">
							<?php
							echo esc_html($link['name']);
							?>
						</span>
					</li>
				<?php
				}
				?>
			</ul>
		</div> <?php
	}

	public function kivicare_woof_hide_zero_term($val)
	{
		$new_term_arr = [];
		foreach ($val as $key => $value) {
			if ($value['count'] > 0) {
				$new_term_arr[$key] = $value;
			}
		}
		return $new_term_arr;
	}

	public function cart_min_quantity($args, $product) {
		$args['min_value'] = 0;
		return $args;
	}

	function kivicare_edit_billing_fields( $fields ) {
		$fields[ 'billing_state' ]['placeholder'] = '';
		return $fields;
	}
}
