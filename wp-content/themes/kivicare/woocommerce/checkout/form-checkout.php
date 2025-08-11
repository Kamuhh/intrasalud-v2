<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 15.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', esc_html__('You must be logged in to checkout.', 'kivicare')));
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

	<div class="row">
		<div class="col-md-12">
			<?php if ($checkout->get_checkout_fields()) : ?>
				<?php do_action('woocommerce_checkout_before_customer_details'); ?>
				<div class="col2-set" id="customer_details">
					<div class="iq_checkout_billing">
						<?php do_action('woocommerce_checkout_billing'); ?>
					</div>

					<div class="iq_checkout_shipping">
						<?php do_action('woocommerce_checkout_shipping'); ?>
					</div>
				</div>
				<?php do_action('woocommerce_checkout_after_customer_details'); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="row mt-5">
		<?php
		$has_order = false;
		$class = 'col-md-12';
		if (is_user_logged_in()) :
			$kivicare_user_id = get_current_user_id();
			$kivicare_customer = new WC_Customer($kivicare_user_id);

			if ($kivicare_customer->get_last_order()) {
				$has_order = true;
				$class = 'col-md-7';
			}
		endif;
		?>
		<div class="<?php echo esc_attr($class); ?>">
			<h3 id="order_review_heading"><?php esc_html_e('Your order', 'kivicare'); ?></h3>
			<?php do_action('woocommerce_checkout_before_order_review'); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action('woocommerce_checkout_order_review'); ?>
			</div>

			<?php do_action('woocommerce_checkout_after_order_review'); ?>
		</div>
		<?php if ($has_order) : ?>
			<div class="col-md-5">
				<div class="order-hisotry-wrapper">

					<h3 id="order_review_heading"><?php esc_html_e('Order History', 'kivicare'); ?></h3>
					<?php

					$kivicare_last_order = $kivicare_customer->get_last_order();
					$kivicare_order_id     = $kivicare_last_order->get_id();
					$kivicare_order_data   = $kivicare_last_order->get_data();
					$kivicare_status = $kivicare_last_order->get_status();
					$kivicare_order = wc_get_order($kivicare_order_id);
					$kivicare_count = count($kivicare_last_order->get_items());
					global $kivicare_options;
					$kivicare_product = '2';
					if (isset($kivicare_options['products_number'])) {
						$kivicare_product = $kivicare_options['products_number'];
					}
					$i = 1;
					?>

					<ul class="order-list">
						<?php foreach ($kivicare_last_order->get_items() as $item) : ?>
							<?php
							$product_id    = $item['product_id'];
							$product = wc_get_product($product_id);
							if ($i <= $kivicare_product) {
							?>
								<li>
									<?php echo '<div class="pro-image">' . $product->get_image() . '</div>'; ?>
									<div class="pro-details">
										<p class="my-0"><a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($item->get_name());  ?></a></p>
										<p class="my-0 dir-ltr">
											<span><?php echo get_woocommerce_currency_symbol(); ?> <?php echo esc_html($item['subtotal']); ?></span>
										</p>
									</div>
								</li>
						<?php $i++;
							}
						endforeach; ?>
					</ul>

					<?php ?>

					<div class="order-status-box">

						<a class="iq-new-btn-style iq-button-style-2" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . 'orders'); ?>">
							<span class="iq-btn-text-holder"><?php esc_html_e('View All Orders', 'kivicare'); ?></span>
							<span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
						</a>
					</div>


				</div>
			</div>
		<?php endif; ?>
	</div>

</form>