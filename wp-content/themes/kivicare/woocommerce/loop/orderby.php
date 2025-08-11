<?php

use function Kivicare\Utility\kivicare;

/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     15.6.0
 */


if (!defined('ABSPATH')) {
	exit;
}
$is_sidebar = kivicare()->is_primary_sidebar_active();

$is_view_listing = $_COOKIE['product_view']['is_grid'] == '1' ? 'active' : '';
$is_view_grid = array(
	'3' => '',
	'4' => '',
	'5' => '',
);
if ($_COOKIE['product_view']['is_grid'] == '2') {
	$is_view_grid[$_COOKIE['product_view']['col_no'] + 1] = 'active';
}

echo '<div class="kivicare-product-view-wrapper">';
	if (is_shop() && $is_sidebar) { ?>
		<div class="kivicare-filter-button shop-filter-sidebar">
			<i class="fas fa-filter"></i>
			<span class="kivicare-btn-text"><?php esc_html_e("Filter", "kivicare"); ?></span>
		</div> <?php
	}

	if (is_shop() ||is_product_category() || is_archive()) { ?>
		<input id="skeleton_template_url" type="hidden" value="<?php echo esc_url(get_template_directory_uri()); ?>" name="skeleton_template_url">
		<div class="kivicare-product-view-buttons">
			<ul>
				<li>
					<a class="btn kivicare-listing <?php echo esc_attr($is_view_listing) ?> ">
						<svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_1379_355)">
								<path d="M3.42857 0H0V3.42857H3.42857V0Z" fill="currentColor" />
								<path d="M18 0.857422H6V2.57171H18V0.857422Z" fill="currentColor" />
								<path d="M3.42857 6H0V9.42857H3.42857V6Z" fill="currentColor" />
								<path d="M18 6.85742H6V8.57171H18V6.85742Z" fill="currentColor" />
								<path d="M3.42857 12H0V15.4286H3.42857V12Z" fill="currentColor" />
								<path d="M18 12.8574H6V14.5717H18V12.8574Z" fill="currentColor" />
							</g>
							<defs>
								<clipPath id="clip0_1379_355">
									<rect width="18" height="15.4286" fill="currentColor" />
								</clipPath>
							</defs>
						</svg>
					</a>
				</li>

				<li>
					<a class="btn kivicare-view-grid <?php echo esc_attr($is_view_grid['3']) ?>" data-grid="2">
						<svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17">
							<path d="M8.57143 0H0V8.57143H8.57143V0Z" fill="currentcolor"></path>
							<path d="M17.9999 0H9.42847V8.57143H17.9999V0Z" fill="currentcolor"></path>
							<path d="M8.57143 9.42871H0V18.0001H8.57143V9.42871Z" fill="currentcolor"></path>
							<path d="M17.9999 9.42871H9.42847V18.0001H17.9999V9.42871Z" fill="currentcolor"></path>
						</svg>
					</a>
				</li>
				
				<li>
					<a class="btn kivicare-view-grid <?php echo esc_attr($is_view_grid['4']) ?>" data-grid="3">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.90909 0H0V4.90909H4.90909V0Z" fill="currentColor" />
							<path d="M11.4545 0H6.54541V4.90909H11.4545V0Z" fill="currentColor" />
							<path d="M17.9999 0H13.0908V4.90909H17.9999V0Z" fill="currentColor" />
							<path d="M4.90909 6.5459H0V11.455H4.90909V6.5459Z" fill="currentColor" />
							<path d="M11.4545 6.5459H6.54541V11.455H11.4545V6.5459Z" fill="currentColor" />
							<path d="M17.9999 6.5459H13.0908V11.455H17.9999V6.5459Z" fill="currentColor" />
							<path d="M4.90909 13.0908H0V17.9999H4.90909V13.0908Z" fill="currentColor" />
							<path d="M11.4545 13.0908H6.54541V17.9999H11.4545V13.0908Z" fill="currentColor" />
							<path d="M17.9999 13.0908H13.0908V17.9999H17.9999V13.0908Z" fill="currentColor" />
						</svg>
					</a>
				</li>

				<li>
					<a class="btn kivicare-view-grid <?php echo esc_attr($is_view_grid['5']) ?>" data-grid="4">
						<svg width="18" height="18" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3.85714 0H0V3.85714H3.85714V0Z" fill="currentColor" />
							<path d="M8.5715 0H4.71436V3.85714H8.5715V0Z" fill="currentColor" />
							<path d="M13.2856 0H9.42847V3.85714H13.2856V0Z" fill="currentColor" />
							<path d="M18 0H14.1428V3.85714H18V0Z" fill="currentColor" />
							<path d="M3.85714 4.71387H0V8.57101H3.85714V4.71387Z" fill="currentColor" />
							<path d="M8.5715 4.71387H4.71436V8.57101H8.5715V4.71387Z" fill="currentColor" />
							<path d="M13.2856 4.71387H9.42847V8.57101H13.2856V4.71387Z" fill="currentColor" />
							<path d="M18 4.71387H14.1428V8.57101H18V4.71387Z" fill="currentColor" />
							<path d="M3.85714 9.42871H0V13.2859H3.85714V9.42871Z" fill="currentColor" />
							<path d="M8.5715 9.42871H4.71436V13.2859H8.5715V9.42871Z" fill="currentColor" />
							<path d="M13.2856 9.42871H9.42847V13.2859H13.2856V9.42871Z" fill="currentColor" />
							<path d="M18 9.42871H14.1428V13.2859H18V9.42871Z" fill="currentColor" />
							<path d="M3.85714 14.1426H0V17.9997H3.85714V14.1426Z" fill="currentColor" />
							<path d="M8.5715 14.1426H4.71436V17.9997H8.5715V14.1426Z" fill="currentColor" />
							<path d="M13.2856 14.1426H9.42847V17.9997H13.2856V14.1426Z" fill="currentColor" />
							<path d="M18 14.1426H14.1428V17.9997H18V14.1426Z" fill="currentColor" />
						</svg>
					</a>
				</li>
			</ul>
		</div> <?php
	} ?>
	<form class="woocommerce-ordering" method="get">
		<select name="orderby" class="orderby" aria-label="<?php esc_attr_e('Shop order', 'kivicare'); ?>">
			<?php foreach ($catalog_orderby_options as $id => $name) : ?>
				<option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
	</form>

	</div>
</div>