<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version      15.1.1
 */

namespace Kivicare\Utility;

if (!defined('ABSPATH')) {
	exit;
}

if ($related_products) : 
	global $kivicare_options;
	if (isset($kivicare_options['kivicare_show_related_product']) && $kivicare_options['kivicare_show_related_product'] == 'no' && is_product()) {
		return false;
	} ?>

	<section class="related products product-grid-style">
		<?php
		$heading = apply_filters('woocommerce_product_related_products_heading', esc_html__('Related Products', 'kivicare'));
		if ($heading) :
		?>

			<div class=" kivicare-title-box kivicare-title-box-1 text-animation">
				<h2 class="kivicare-title kivicare-heading-title">
					<?php
					$kivicare_words = explode(" ", $heading);
					$kivicare_split = explode(' ', $heading);
					$kivicare_lastword = array_pop($kivicare_split);
					array_splice($kivicare_words, -1);
					$kivicare_string = implode(" ", $kivicare_words);
					echo esc_html($kivicare_string) . ' <span class="highlighted-text-wrap wow">' . $kivicare_lastword . '</span>';
					?>
				</h2>
			</div>

		<?php endif; ?>

		<?php

		$related_count = count($related_products);
		if (class_exists('ReduxFramework') && $related_count > 4) {
			kivicare()->get_single_product_dependent_script();
		?>
			<div class="swiper product-single-slider related-slider products kivicare-main-product">
				<div class="swiper-wrapper kivicare-related-product kivicare-product-slider">
				<?php
			} else { ?>
					<div class="columns-4 products kivicare-main-product">
						<?php
					}

					foreach ($related_products as $related_product) :
						$post_object = get_post($related_product->get_id());
						setup_postdata($GLOBALS['post'] = &$post_object);
						if (class_exists('ReduxFramework') && $related_count > 4) {
						?>
							<div class="swiper-slide">
								<?php wc_get_template_part('content', 'product'); ?>
							</div>
						<?php
						} else {
							wc_get_template_part('content', 'product');
						}
					endforeach;

					if (class_exists('ReduxFramework') && $related_count > 4) {
						?>
					</div>
				</div>
				<div class="iqonic-navigation">
					<div class="swiper-button-prev">
						<span class="text-btn">
							<span class="text-btn-line-holder">
								<span class="text-btn-line-top"></span>
								<span class="text-btn-line"></span>
								<span class="text-btn-line-bottom"></span>
							</span>
						</span>
					</div>
					<div class="swiper-button-next">
						<span class="text-btn">
							<span class="text-btn-line-holder">
								<span class="text-btn-line-top"></span>
								<span class="text-btn-line"></span>
								<span class="text-btn-line-bottom"></span>
							</span>
						</span>
					</div>
				</div>
			<?php } else { ?>
			</div>
		<?php } ?>
	</section>
<?php
endif;

wp_reset_postdata();
