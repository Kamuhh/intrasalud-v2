<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     15.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login" method="post"  <?php echo esc_attr( $hidden ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo esc_html( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<div class="row">
		<div class="col-lg-6">
			<p class="form-row form-row-first">
				<label for="username"><?php esc_html_e( 'Username or email', 'kivicare' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" autocomplete="username" />
			</p>
		</div>

		<div class="col-lg-6">
			<p class="form-row form-row-last">
				<label for="password"><?php esc_html_e( 'Password', 'kivicare' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>
		</div>
	</div>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="form-row mt-3">
		<div class="kivicare-check">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><span><span class="text-check"><?php esc_html_e( 'Remember me', 'kivicare' ); ?></span><span class="checkmark"></span>
			</label>
		</div>
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />

		<button type="submit" class="woocommerce-button button iq-new-btn-style iq-button-style-2 woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> " name="login" value="<?php esc_attr_e( 'Login', 'kivicare' ); ?>">
			<span class="iq-btn-text-holder"><?php esc_html_e( 'Login', 'kivicare' ); ?></span>
			<span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
	    </button>
</div>

	<p class="lost_password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'kivicare' ); ?></a>
	</p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
