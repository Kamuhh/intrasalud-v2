<?php

global $product;
global $post;
global $kivicare_options;

$product = isset($args['id']) ? wc_get_product($args['id']) :  wc_get_product($post->ID); // condition fro Load Template from Plugin 
if (!$product) {
	return '';
}

$is_quickview = isset($kivicare_options['kivicare_display_product_quickview_icon']) ? $kivicare_options['kivicare_display_product_quickview_icon'] : "yes";
$is_wishlist = isset($kivicare_options['kivicare_display_product_wishlist_icon']) ? $kivicare_options['kivicare_display_product_wishlist_icon'] : "yes";
$is_addtocart = isset($kivicare_options['kivicare_display_product_addtocart_icon']) ? $kivicare_options['kivicare_display_product_addtocart_icon'] : "yes";
$default_title = isset($kivicare_options['kivicare_display_product_name']) ? $kivicare_options['kivicare_display_product_name'] : "yes";
$default_rating = isset($kivicare_options['kivicare_display_product_rating']) ? $kivicare_options['kivicare_display_product_rating'] : "yes";
$default_price = isset($kivicare_options['kivicare_display_price']) ? $kivicare_options['kivicare_display_price'] : "yes";
$display_category = isset($kivicare_options['kivicare_display_product_category']) ? $kivicare_options['kivicare_display_product_category'] : "yes";

?>

<div <?php wc_product_class('kivicare-sub-product ', $product->get_id()); ?>>
	<div class="kivicare-inner-box ">
		<a href="<?php the_permalink(); ?>"></a>
		<div class="kivicare-product-block">
			<?php
			$newness_days = 30;
			$created = strtotime($product->get_date_created());
			if (!$product->is_in_stock()) {
			?>
				<span class="onsale kivicare-sold-out"><?php echo esc_html__('Sold!', 'kivicare') ?></span>
			<?php } else if ($product->is_on_sale()) { ?>
				<span class="onsale kivicare-on-sale"><?php echo esc_html__('Sale!', 'kivicare') ?></span>
			<?php } else if ((time() - (60 * 60 * 24 * $newness_days)) < $created) { ?>
				<span class="onsale kivicare-new"><?php echo esc_html__('New!', 'kivicare'); ?></span>
			<?php } ?>


			<div class="kivicare-image-wrapper">
				<?php
				if ($product->get_image_id()) {
					$product->get_image('shop_catalog');
					$image = wp_get_attachment_image_src($product->get_image_id(), 'kivicare-product'); ?>
					<?php echo '<div class="kivicare-product-image">' . woocommerce_get_product_thumbnail() . '</div>'; ?>
				<?php
				} else { ?>
					<?php
					echo sprintf('<div class="kivicare-product-image"><img src="%s" alt="%s" class="wp-post-image" /></div>', esc_url(wc_placeholder_img_src()), esc_html__('Awaiting product image', 'kivicare')); ?>
				<?php
				}

				if ($is_quickview == "yes" || $is_wishlist == "yes" || $is_addtocart == "yes") { ?>
					<div class="kivicare-woo-buttons-holder">
						<ul>
							<?php if ($is_quickview == "yes") { ?>
								<?php if (class_exists('WPCleverWoosq')) { ?>
									<li><?php echo do_shortcode('[woosq id="' . $product->get_id() . '"]') ?></li>
								<?php
								}
							}
							if ($is_wishlist == "yes") {
								if (class_exists('YITH_WCWL')) {
								?>
									<li>
										<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
									</li>
								<?php }
							}

							if ($is_addtocart == "yes" && $product->is_in_stock()) { ?>
								<li>
									<?php if ($product->get_id() && !$product->is_type('grouped')) { ?>
										<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class=" ajax_add_to_cart add_to_cart_button button kivicare-box-shadow kivicare-morden-btn" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M4.27385 4.95616L4.77635 10.9328C4.81302 11.3928 5.18885 11.7378 5.64802 11.7378H5.65135H14.7439H14.7455C15.1797 11.7378 15.5505 11.4145 15.6122 10.9853L16.4039 5.51949C16.4222 5.38949 16.3897 5.25949 16.3105 5.15449C16.2322 5.04866 16.1172 4.98033 15.9872 4.96199C15.813 4.96866 8.58552 4.95866 4.27385 4.95616ZM5.64631 12.9878C4.54881 12.9878 3.61964 12.1311 3.53047 11.0353L2.76714 1.95695L1.51131 1.74028C1.17048 1.68028 0.942975 1.35778 1.00131 1.01695C1.06131 0.676117 1.39047 0.45445 1.72381 0.507784L3.45714 0.807784C3.73631 0.85695 3.94881 1.08862 3.97297 1.37195L4.16881 3.70612C16.0655 3.71112 16.1038 3.71695 16.1613 3.72362C16.6255 3.79112 17.0338 4.03362 17.3121 4.40695C17.5905 4.77945 17.7071 5.23862 17.6405 5.69862L16.8496 11.1636C16.7005 12.2036 15.7971 12.9878 14.7471 12.9878H14.743H5.65297H5.64631Z" fill="#130F26" />
												<path fill-rule="evenodd" clip-rule="evenodd" d="M13.4077 8.03638H11.0977C10.7518 8.03638 10.4727 7.75638 10.4727 7.41138C10.4727 7.06638 10.7518 6.78638 11.0977 6.78638H13.4077C13.7527 6.78638 14.0327 7.06638 14.0327 7.41138C14.0327 7.75638 13.7527 8.03638 13.4077 8.03638Z" fill="#130F26" />
												<path fill-rule="evenodd" clip-rule="evenodd" d="M5.28815 15.2516C5.53898 15.2516 5.74148 15.4541 5.74148 15.7049C5.74148 15.9558 5.53898 16.1591 5.28815 16.1591C5.03648 16.1591 4.83398 15.9558 4.83398 15.7049C4.83398 15.4541 5.03648 15.2516 5.28815 15.2516Z" fill="#130F26" />
												<path fill-rule="evenodd" clip-rule="evenodd" d="M5.28732 16.784C4.69232 16.784 4.20898 16.2998 4.20898 15.7048C4.20898 15.1098 4.69232 14.6265 5.28732 14.6265C5.88232 14.6265 6.36648 15.1098 6.36648 15.7048C6.36648 16.2998 5.88232 16.784 5.28732 16.784" fill="#130F26" />
												<path fill-rule="evenodd" clip-rule="evenodd" d="M14.6877 16.784C14.0927 16.784 13.6094 16.2998 13.6094 15.7048C13.6094 15.1098 14.0927 14.6265 14.6877 14.6265C15.2835 14.6265 15.7677 15.1098 15.7677 15.7048C15.7677 16.2998 15.2835 16.784 14.6877 16.784" fill="#130F26" />
											</svg>
										</a>
									<?php } else { ?>
										<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="added_to_cart d-flex align-items-center button iq-product-cart-button" title="<?php echo esc_attr__('View cart', 'kivicare'); ?>">
											<i class="fa fa-arrow-right" aria-hidden="true"></i>
										</a>
									<?php } ?>
								</li>
							<?php } ?>
						</ul>
					</div> <?php
						} ?>
			</div>
		</div>

		<div class="product-caption"> <?php
										if ($display_category == "yes") { ?>
				<?php if (!empty(wc_get_product_term_ids($product->get_id(), 'product_cat'))) { ?>
					<div class="iq-product-category"> <?php
														global $post;
														global $product;
														$product_cats_ids = wc_get_product_term_ids($product->get_id(), 'product_cat');
														foreach ($product_cats_ids as $cat_id) {
															$term = get_term_by('id', $cat_id, 'product_cat');
															$iq_category[] = '<span class="iq-category">' . $term->name . '</span>';
														}
														echo "" . implode(',', $iq_category) . "";  ?>
					</div> <?php
											}
										} ?>

			<div class="product-content-wrapper">
				<?php if ($default_title == "yes") { ?>
					<h5 class="woocommerce-loop-product__title th13">
						<a href="<?php echo the_permalink($product->get_id()); ?>" class="kivicare-product-title-link ">
							<?php echo esc_html($product->get_name()); ?>
						</a>
					</h5> <?php
						} ?>


				<?php if ($default_price == "yes") { ?>
					<div class="price-detail">
						<span class="price">
							<?php if ($product->get_tax_status() == 'taxable' && !$product->is_type('grouped')) { ?>
								<?php echo get_woocommerce_currency() ?><?php echo wc_get_price_including_tax($product);
																		echo '<br>';
																		echo $product->get_price_suffix(); ?>
							<?php } else { ?>
								<?php echo wp_kses($product->get_price_html(), 'kivicare'); ?>
							<?php } ?>
						</span>
					</div> <?php
						}

						if ($default_rating == "yes") { ?>
					<div class="container-rating">
						<?php
							$rating_count = $product->get_rating_count();
							if ($rating_count >= 0) {
								$average      = $product->get_average_rating();
						?>
							<div class="star-rating">
								<?php echo wc_get_rating_html($average, $rating_count); ?>
							</div>
						<?php }
						?>
					</div> <?php
						} ?>
			</div>
		</div>
	</div>
</div>