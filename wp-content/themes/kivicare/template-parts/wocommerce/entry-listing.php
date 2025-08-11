<?php

namespace Kivicare\Utility;

global $product;
global $post;
global $kivicare_options;

$product = wc_get_product($post->ID);
if (!$product) {
	return '';
}
$default_quickview = isset($kivicare_options['kivicare_display_product_quickview_icon']) ? $kivicare_options['kivicare_display_product_quickview_icon'] : "yes";
?>
<div <?php wc_product_class('kivicare-sub-product', get_the_ID()); ?>>
	<div class="kivicare-inner-box ">
		<a href="<?php the_permalink(); ?>"></a>
		<div class="row">
			<div class="col-md-4">
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
							$image = wp_get_attachment_image_src($product->get_image_id(), 'kivicare-product');
						?>
							<a href="<?php echo the_permalink($product->get_id()); ?>" class="kivicare-product-title-link ">
								<?php echo '<div class="kivicare-product-image"> <img src="' . $image['0'] . '" alt="' . esc_attr__('product-image', 'kivicare') . '" class="wp-post-image" /> </div>'; ?>
							</a><?php

							} else {
								?>
							<a href="<?php echo the_permalink($product->get_id()); ?>" class="kivicare-product-title-link ">
								<?php
								echo sprintf('<div class="kivicare-product-image"><img src="%s" alt="%s" class="wp-post-image" /></div>', esc_url(wc_placeholder_img_src()), esc_html__('Awaiting product image', 'kivicare')); ?>
							</a><?php
							} ?>

						<?php
						if ($default_quickview == "yes") { ?>
							<div class="kivicare-woo-buttons-holder">
								<ul>
									<?php
									if (class_exists('WPCleverWoosq')) { ?>
										<li class="quick-view-icon"><?php echo do_shortcode('[woosq id="' . $product->get_id() . '"]') ?></li>
									<?php
									}
									?>
								</ul>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="product-caption">
					<h4 class="woocommerce-loop-product__title th13">
						<a href="<?php echo the_permalink(); ?>" class="kivicare-product-title-link ">
							<?php echo esc_html($product->get_name()); ?>
						</a>
					</h4>

					<div class="price-detail">
						<span class="price">
							<?php echo $product->get_price_html(); ?>
						</span>
					</div>

					<div class="container-rating">
						<?php
						$rating_count = $product->get_rating_count();
						if ($rating_count >= 0) {
							$average      = $product->get_average_rating();
						?>
							<div class="star-rating">
								<?php echo wc_get_rating_html($average, $rating_count); ?>
							</div>
						<?php } ?>
					</div>
					<div class="kivicare-woo-buttons-holder">
						<ul>
							<li>
								<?php
								if ($product->get_id()) {
									if ($product->is_type('variable')) { ?>
										<a href="<?php echo esc_url($product->get_permalink()); ?>" class="iq-new-btn-style iq-button-style-2 btn kivicare-add-to-cart btn  btn_small" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<span class="iq-btn-text-holder">
												<?php echo esc_html__('Select Options', 'kivicare'); ?>
											</span>
											<span class="iq-btn-icon-holder">
												<i aria-hidden="true" class="ion ion-plus"></i>
											</span>
										</a>
									<?php } elseif ($product->is_type('grouped')) { ?>
										<a href="<?php echo esc_url($product->get_permalink()); ?>" class="iq-new-btn-style iq-button-style-2 btn kivicare-add-to-cart btn  btn_small" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<span class="iq-btn-text-holder">
												<?php echo esc_html__('View products', 'kivicare'); ?>
											</span>
											<span class="iq-btn-icon-holder">
												<i aria-hidden="true" class="ion ion-plus"></i>
											</span>
										</a>
									<?php } elseif ($product->is_type('external')) { ?>
										<a rel="nofollow" href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="iq-new-btn-style iq-button-style-2 btn kivicare-add-to-cart btn  btn_small" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>'" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" target="_blank">
											<span class="iq-btn-text-holder">
												<?php echo esc_html__('Our Product', 'kivicare'); ?>
											</span>
											<span class="iq-btn-icon-holder">
												<i aria-hidden="true" class="ion ion-plus"></i>
											</span>
										</a>
									<?php } else {	?>
										<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="ajax_add_to_cart iq-new-btn-style iq-button-style-2 add_to_cart_button btn kivicare-add-to-cart btn  btn_small" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<span class="iq-btn-text-holder">
												<?php echo esc_html__('Add to Cart', 'kivicare'); ?></span>
											<span class="iq-btn-icon-holder">
												<i aria-hidden="true" class="ion ion-plus"></i>
											</span>
										</a>
									<?php }
								} else { ?>
									<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="added_to_cart iq-new-btn-style iq-button-style-2 wc-forward kivicare-add-to-cart btn  btn_small" title="<?php esc_attr_e('View Cart', 'kivicare') ?>">
										<?php echo esc_html__('View cart', 'kivicare'); ?>
									</a>
								<?php
								}
								?>
							</li>

							<?php if (class_exists('YITH_WCWL')) { ?>
								<li>
									<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
								</li>
							<?php } ?>
						</ul>
					</div>
					<?php if (!empty(get_the_excerpt())) { ?>
						<div class="kivicare-product-description">
							<?php the_excerpt(); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>