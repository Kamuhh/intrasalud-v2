<?php
namespace Elementor;
use WP_Query;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$category = '';
if (!empty($settings['woo_category'])) {
	foreach ($settings['woo_category'] as $element) {
		$category .= $element . ",";
	}

	$category = "category=" . '"' . rtrim($category, ",") . '"';
}

if ($settings['show_pagination'] == 'yes') {
	$pagination = 'paginate="true"';
} else {
	$pagination = 'paginate="false"';
}

if (!$settings['show_catalog']) {

	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

	add_action('woocommerce_before_shop_loop', function () {
		echo '</div>';
	}, 999);
}

remove_all_actions('woocommerce_after_shop_loop');
add_action('woocommerce_after_shop_loop',  array($this, 'kivicare_widget_loadmore'));

add_filter('woocommerce_shortcode_products_query', function ($args) {
	$this->product_query = $args;
	$this->max_page = (new WP_Query($this->product_query))->max_num_pages;
	$args["paged"] = get_query_var("paged");
	wp_reset_postdata();

	return $args;
});


$class = $settings['woo_column'] == 'list' ?  'product-list-style' : 'product-grid-style'; ?>
<div class="woocommerce iq-woocommerce woocommerce-widget">
	<div class="woof_results_by_ajax" data-shortcode="woof_products is_ajax=1">
		<?php
		echo do_shortcode('[' . $settings['product_type'] . ' limit="6" per_page="' . $settings['woo_per_page'] . '" columns="' . $settings['woo_column'] . '" ' . $category . ' order="' . $settings['woo_order'] . '" ' . $pagination . ' class="' . $class . '" is_ajax=1 ]');
		?>
	</div>
</div>