<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

use Elementor\Plugin;
use Kivicare\Utility\Dynamic_Style\Styles\Footer;

global $kivicare_options;

$is_default = $is_footer = true;

if (function_exists("get_field")) {
	$breadcrumb = new Footer();
	$is_footer = $breadcrumb->is_kivicare_footer();
}

$back_to_top = isset($kivicare_options['kivi_back_to_top']) ? $kivicare_options['kivi_back_to_top'] : "yes";

if ($is_footer) {
	if (function_exists('get_field') || class_exists('ReduxFramework') && class_exists("Elementor\Plugin")) {

		$id = (get_queried_object_id()) ? get_queried_object_id() : '';
		$footer_display = !empty($id) ? get_post_meta($id, 'display_footer', true) : '';
		$footer_layout = !empty($id) ? get_post_meta($id, 'footer_layout_type', true) : '';
		$footer_name = !empty($id) ? get_post_meta($id, 'footer_layout_name', true) : '';

		$year = date('Y');

		if (function_exists('get_field') && $footer_display === 'yes' && $footer_layout !== 'default' && !empty($footer_name)) {
			$is_default = false;
			$footer = $footer_name;
			$my_layout = get_page_by_path($footer, '', 'iqonic_hf_layout');
			$footer_response =  kivicare()->kivicare_get_layout_content($my_layout->ID);
			$footer_response = str_replace("{{year}}", $year, $footer_response);
			echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($footer_response) : $footer_response;
		} else if (isset($kivicare_options['footer_layout']) && $kivicare_options['footer_layout'] == 'custom') {
			$is_default = false;
			$footer = $kivicare_options['footer_style'];
			$my_layout = get_page_by_path($footer, '', 'iqonic_hf_layout');
			$footer_response =  kivicare()->kivicare_get_layout_content($my_layout->ID);
			$footer_response = str_replace("{{year}}", $year, $footer_response);
			echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($footer_response) : $footer_response;
		}
	}

	if ($is_default) {
		global $kivicare_options;
		if (isset($kivicare_options['display_footer'])) {
			$options = $kivicare_options['display_footer'];
			if ($options == "yes") {
				if (isset($kivicare_options['footer_image']['url'])) {
					$bgurl = $kivicare_options['footer_image']['url'];
				}
			}
		} ?>

		<footer id="contact" class="footer-one default iq-bg-dark iq-over-dark-90" <?php if (!empty($bgurl)) { ?> style="background: url(<?php echo esc_url($bgurl); ?> );" <?php } ?>>
			<div class="container">
				<?php
				get_template_part('template-parts/footer/widget');
				get_template_part('template-parts/footer/info');
				?>
			</div>
		</footer><!-- #colophon -->
	<?php }
}

if ($back_to_top == "yes") { ?>
	<div id="back-to-top">
		<a class="top" id="top" href="#top"><i class="ion-ios-arrow-up"></i> </a>
	</div> <?php
} ?>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>

</html>