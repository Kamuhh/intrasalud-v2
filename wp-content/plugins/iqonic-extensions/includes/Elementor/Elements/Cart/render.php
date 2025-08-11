<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
if (class_exists('WooCommerce')) {
    $cart_url = wc_get_cart_url();
    $cart_count = function_exists('get_cart_contents_count') ? WC()->cart->get_cart_contents_count() : '';
} else {
    $cart_count = "0";
}
?>
<div class="cart-btn">
    <div class="cart_count">
        <div class="kivicare-cart dropdown-hover">
            <a href="javascript:void(0);" class="dropdown-cart">
                <?php
                if (!empty($settings['selected_icon']['value'])) {
                    Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                } else {
                ?>
                    <i class="fas fa-shopping-cart"></i>
                <?php
                }
                 ?>
                <div class="basket-item-count">
                    <span class="cart-items-count count" id="mini-cart-count">
                    <?php echo (WC()->cart) ? WC()->cart->get_cart_contents_count() : ''; ?>
                    </span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-mini-cart">
                <a href="javascript:void(0);" class="dropdown-close"><i class="fas fa-times"></i></a>
                <div class="widget_shopping_cart_content">
                    <?php
                    if (function_exists("woocommerce_mini_cart") &&  WC()->cart) {
                        woocommerce_mini_cart();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>