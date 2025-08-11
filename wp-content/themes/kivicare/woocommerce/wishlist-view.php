<?php

/**
 * Wishlist page template - Standard Layout
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\Wishlist\View
 * @version 15.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $pagination                    string yes/no
 * @var $per_page                      int Items per page
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $no_interactions               bool
 */

namespace Kivicare\Utility;

if (!defined('YITH_WCWL')) {
	exit;
} // Exit if accessed directly

 
?>

<!-- WISHLIST TABLE -->
<table class="shop_table cart wishlist_table wishlist_view traditional responsive <?php $no_interactions ?  esc_attr_e('no-interactions','kivicare') : ''; ?> <?php $enable_drag_n_drop ? esc_attr_e('sortable','kivicare') : ''; ?> " data-pagination="<?php echo esc_attr($pagination); ?>" data-per-page="<?php echo esc_attr($per_page); ?>" data-page="<?php echo esc_attr($current_page); ?>" data-id="<?php echo esc_attr($wishlist_id); ?>" data-token="<?php echo esc_attr($wishlist_token); ?>">

	<?php $column_count = 2; ?>

	<thead>
		<tr>
			<?php if ($show_cb) : ?>
				<?php $column_count++; ?>
				<th class="product-checkbox">
					<input type="checkbox" value="" name="" id="bulk_add_to_cart" />
				</th>
			<?php endif; ?>

			<?php if ($show_remove_product) : ?>
				<?php $column_count++; ?>
				<th class="product-remove">
					<span class="nobr">
						<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_remove_heading', '', $wishlist)); ?>
					</span>
				</th>
			<?php endif; ?>

			<th class="product-thumbnail"></th>

		

			<th class="product-name">
				<span class="nobr">
					<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_name_heading', esc_html__('Product name', 'kivicare'), $wishlist)); ?>
				</span>
			</th>

			<?php if ($show_price || $show_price_variations) : ?>
				<?php $column_count++; ?>
				<th class="product-price">
					<span class="nobr">
						<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_price_heading', esc_html__('Unit price', 'kivicare'), $wishlist)); ?>
					</span>
				</th>
			<?php endif; ?>

			<?php if ($show_quantity) : ?>
				<?php $column_count++; ?>
				<th class="product-quantity">
					<span class="nobr">
						<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_quantity_heading', esc_html__('Quantity', 'kivicare'), $wishlist)); ?>
					</span>
				</th>
			<?php endif; ?>

			<?php if ($show_stock_status) : ?>
				<?php $column_count++; ?>
				<th class="product-stock-status">
					<span class="nobr">
						<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_stock_heading', esc_html__('Stock status', 'kivicare'), $wishlist)); ?>
					</span>
				</th>
			<?php endif; ?>

			<?php if ($show_last_column) : ?>
				<?php $column_count++; ?>
				<th class="product-add-to-cart">
					<span class="nobr">
						<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_cart_heading', '', $wishlist)); ?>
					</span>
				</th>
			<?php endif; ?>

			<?php if ($enable_drag_n_drop) : ?>
				<?php $column_count++; ?>
				<th class="product-arrange">
					<span class="nobr">
						<?php echo esc_html(apply_filters('yith_wcwl_wishlist_view_arrange_heading', esc_html__('Arrange', 'kivicare'), $wishlist)); ?>
					</span>
				</th>
			<?php endif; ?>

		</tr>
	</thead>

	<tbody class="wishlist-items-wrapper">
		<?php
		if ($wishlist && $wishlist->has_items()) :
			foreach ($wishlist_items as $item) :
				/**
				 * Each of the wishlist items
				 *
				 * @var $item \YITH_WCWL_Wishlist_Item
				 */
				global $product;

				$product      = $item->get_product();
				$availability = $product->get_availability();
				$stock_status = isset($availability['class']) ? $availability['class'] : false;

				if ($product && $product->exists()) :
		?>
					<tr id="yith-wcwl-row-<?php echo esc_attr($item->get_product_id()); ?>" data-row-id="<?php echo esc_attr($item->get_product_id()); ?>">
						<?php if ($show_cb) : ?>
							<td class="product-checkbox">
								<input type="checkbox" value="yes" name="items[<?php echo esc_attr($item->get_product_id()); ?>][cb]" />
							</td>
						<?php endif ?>

						<?php if ($show_remove_product) : ?>
							<td class="product-remove">
								<div>
									<a href="<?php echo esc_url($item->get_remove_url()); ?>" class="remove remove_from_wishlist" title="<?php echo esc_html(apply_filters('yith_wcwl_remove_product_wishlist_message_title', esc_html__('Remove this product', 'kivicare'))); ?>"><i class="far fa-trash-alt"></i></a>
								</div>
							</td>
						<?php endif; ?>

					
							<td class="product-thumbnail">
								<a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $item->get_product_id()))); ?>">
								<?php echo wp_kses($product->get_image() ,'post'); ?>
							</a>
							</td>
						<td class="product-name">
							<?php do_action('yith_wcwl_table_before_product_thumbnail', $item, $wishlist); ?>


							<?php do_action('yith_wcwl_table_after_product_thumbnail', $item, $wishlist); ?>
							<?php do_action('yith_wcwl_table_before_product_name', $item, $wishlist); ?>

							<a class="kivicare-product-title" href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $item->get_product_id()))); ?>">
								<?php echo wp_kses(apply_filters('woocommerce_in_cartproduct_obj_title', $product->get_title(), $product) , 'post'); ?>
							</a>

							<?php
							if ($show_variation && $product->is_type('variation')) {
								/**
								 * Product is a Variation
								 *
								 * @var $product \WC_Product_Variation
								 */
								echo wp_kses(wc_get_formatted_variation($product) , 'post');
							}
							?>

							<?php do_action('yith_wcwl_table_after_product_name', $item, $wishlist); ?>
						</td>

						<?php if ($show_price || $show_price_variations) : ?>
							<td class="product-price">
								<?php do_action('yith_wcwl_table_before_product_price', $item, $wishlist); ?>

								<?php
								if ($show_price) {
									echo wp_kses($item->get_formatted_product_price() , 'post');
								}

								if ($show_price_variations) {
									echo wp_kses($item->get_price_variation() , 'post');
								}
								?>

								<?php do_action('yith_wcwl_table_after_product_price', $item, $wishlist); ?>
							</td>
						<?php endif ?>

						<?php if ($show_quantity) : ?>
							<td class="product-quantity">
								<?php do_action('yith_wcwl_table_before_product_quantity', $item, $wishlist); ?>

								<?php if (!$no_interactions && $wishlist->current_user_can('update_quantity')) : ?>
									<input type="number" min="1" step="1" name="items[<?php echo esc_attr($item->get_product_id()); ?>][quantity]" value="<?php echo esc_attr($item->get_quantity()); ?>" />
								<?php else : ?>
									<?php echo esc_html($item->get_quantity()); ?>
								<?php endif; ?>

								<?php do_action('yith_wcwl_table_after_product_quantity', $item, $wishlist); ?>
							</td>
						<?php endif; ?>

						<?php if ($show_stock_status) : ?>
							<td class="product-stock-status">
								<?php do_action('yith_wcwl_table_before_product_stock', $item, $wishlist); ?>

								<?php echo 'out-of-stock' === $stock_status ? '<span class="wishlist-out-of-stock">' . esc_html(apply_filters('yith_wcwl_out_of_stock_label', esc_html__('Out of stock', 'kivicare'))) . '</span>' : '<span class="wishlist-in-stock">' . esc_html(apply_filters('yith_wcwl_in_stock_label', esc_html__('In Stock', 'kivicare'))) . '</span>'; ?>

								<?php do_action('yith_wcwl_table_after_product_stock', $item, $wishlist); ?>
							</td>
						<?php endif ?>

						<?php if ($show_last_column) : ?>
							<td class="product-add-to-cart">
								<?php do_action('yith_wcwl_table_before_product_cart', $item, $wishlist); ?>

								<!-- Date added -->
								<?php
								if ($show_dateadded && $item->get_date_added()) :
									// translators: date added label: 1 date added.
									echo '<span class="dateadded">' . esc_html(sprintf(__('Added on: %s', 'kivicare'), $item->get_date_added_formatted())) . '</span>';
								endif;
								?>

								<?php do_action('yith_wcwl_table_product_before_add_to_cart', $item, $wishlist); ?>

								<!-- Add to cart button -->
								<?php $show_add_to_cart = apply_filters('yith_wcwl_table_product_show_add_to_cart', $show_add_to_cart, $item, $wishlist); ?>
								<?php if ($show_add_to_cart && isset($stock_status) && 'out-of-stock' !== $stock_status) : ?>
									<a href="<?php echo esc_url($product->get_permalink()); ?>" class="kivicare-product-cart-button d-flex align-items-center button iq-product-cart-button" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
									    <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M4.27385 4.95616L4.77635 10.9328C4.81302 11.3928 5.18885 11.7378 5.64802 11.7378H5.65135H14.7439H14.7455C15.1797 11.7378 15.5505 11.4145 15.6122 10.9853L16.4039 5.51949C16.4222 5.38949 16.3897 5.25949 16.3105 5.15449C16.2322 5.04866 16.1172 4.98033 15.9872 4.96199C15.813 4.96866 8.58552 4.95866 4.27385 4.95616ZM5.64631 12.9878C4.54881 12.9878 3.61964 12.1311 3.53047 11.0353L2.76714 1.95695L1.51131 1.74028C1.17048 1.68028 0.942975 1.35778 1.00131 1.01695C1.06131 0.676117 1.39047 0.45445 1.72381 0.507784L3.45714 0.807784C3.73631 0.85695 3.94881 1.08862 3.97297 1.37195L4.16881 3.70612C16.0655 3.71112 16.1038 3.71695 16.1613 3.72362C16.6255 3.79112 17.0338 4.03362 17.3121 4.40695C17.5905 4.77945 17.7071 5.23862 17.6405 5.69862L16.8496 11.1636C16.7005 12.2036 15.7971 12.9878 14.7471 12.9878H14.743H5.65297H5.64631Z" fill="#130F26"></path>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M13.4077 8.03638H11.0977C10.7518 8.03638 10.4727 7.75638 10.4727 7.41138C10.4727 7.06638 10.7518 6.78638 11.0977 6.78638H13.4077C13.7527 6.78638 14.0327 7.06638 14.0327 7.41138C14.0327 7.75638 13.7527 8.03638 13.4077 8.03638Z" fill="#130F26"></path>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M5.28815 15.2516C5.53898 15.2516 5.74148 15.4541 5.74148 15.7049C5.74148 15.9558 5.53898 16.1591 5.28815 16.1591C5.03648 16.1591 4.83398 15.9558 4.83398 15.7049C4.83398 15.4541 5.03648 15.2516 5.28815 15.2516Z" fill="#130F26"></path>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M5.28732 16.784C4.69232 16.784 4.20898 16.2998 4.20898 15.7048C4.20898 15.1098 4.69232 14.6265 5.28732 14.6265C5.88232 14.6265 6.36648 15.1098 6.36648 15.7048C6.36648 16.2998 5.88232 16.784 5.28732 16.784" fill="#130F26"></path>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M14.6877 16.784C14.0927 16.784 13.6094 16.2998 13.6094 15.7048C13.6094 15.1098 14.0927 14.6265 14.6877 14.6265C15.2835 14.6265 15.7677 15.1098 15.7677 15.7048C15.7677 16.2998 15.2835 16.784 14.6877 16.784" fill="#130F26"></path>
										</svg>
								    </a>
								<?php endif ?>

								<?php do_action('yith_wcwl_table_product_after_add_to_cart', $item, $wishlist); ?>

								<!-- Change wishlist -->
								<?php $move_to_another_wishlist = apply_filters('yith_wcwl_table_product_move_to_another_wishlist', $move_to_another_wishlist, $item, $wishlist); ?>
								<?php if ($move_to_another_wishlist && $available_multi_wishlist && count($users_wishlists) > 1) : ?>
									<?php if ('select' === $move_to_another_wishlist_type) : ?>
										<select class="change-wishlist selectBox">
											<option value=""><?php esc_html_e('Move', 'kivicare'); ?></option>
											<?php
											foreach ($users_wishlists as $wl) :
												/**
												 * Each of customer's wishlists
												 *
												 * @var $wl \YITH_WCWL_Wishlist
												 */
												if ($wl->get_token() === $wishlist_token) {
													continue;
												}
											?>
												<option value="<?php echo esc_attr($wl->get_token()); ?>">
													<?php echo sprintf('%s - %s', esc_html($wl->get_formatted_name()), esc_html($wl->get_formatted_privacy())); ?>
												</option>
											<?php
											endforeach;
											?>
										</select>
									<?php else : ?>
										<a href="#move_to_another_wishlist" class="move-to-another-wishlist-button" data-rel="prettyPhoto[move_to_another_wishlist]">
											<?php echo esc_html(apply_filters('yith_wcwl_move_to_another_list_label', esc_html__('Move to another list &rsaquo;', 'kivicare'))); ?>
										</a>
									<?php endif; ?>

									<?php do_action('yith_wcwl_table_product_after_move_to_another_wishlist', $item, $wishlist); ?>

								<?php endif; ?>

								<!-- Remove from wishlist -->
								<?php if ($repeat_remove_button) : ?>
									<a href="<?php echo esc_url($item->get_remove_url()); ?>" class="remove_from_wishlist button" title="<?php echo esc_html(apply_filters('yith_wcwl_remove_product_wishlist_message_title', esc_html__('Remove this product', 'kivicare'))); ?>"><?php esc_html_e('Remove', 'kivicare'); ?></a>
								<?php endif; ?>

								<?php do_action('yith_wcwl_table_after_product_cart', $item, $wishlist); ?>
							</td>
						<?php endif; ?>

						<?php if ($enable_drag_n_drop) : ?>
							<td class="product-arrange ">
								<i class="fa fa-arrows"></i>
								<input type="hidden" name="items[<?php echo esc_attr($item->get_product_id()); ?>][position]" value="<?php echo esc_attr($item->get_position()); ?>" />
							</td>
						<?php endif; ?>

					</tr>
			<?php
				endif;
			endforeach;
		else :
			?>
			<tr>
				<td colspan="<?php echo esc_attr($column_count); ?>" class="wishlist-empty"><?php echo esc_html(apply_filters('yith_wcwl_no_product_to_remove_message', esc_html__('No products added to the wishlist', 'kivicare'), $wishlist)); ?></td>
			</tr>
		<?php
		endif;

		if (!empty($page_links)) :
		?>
			<tr class="pagination-row wishlist-pagination">
				<td colspan="<?php echo esc_attr($column_count); ?>">
					<?php echo wp_kses($page_links , 'post'); ?>
				</td>
			</tr>
		<?php endif ?>
	</tbody>

</table>

<?php

?>