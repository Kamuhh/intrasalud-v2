<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

global $kivicare_options;
?>
<div class="container-fluid">
	<div class="row align-items-center">
		<div class="col-sm-12">
			<nav class="kivicare-menu-wrapper mobile-menu">
				<div class="navbar">

					<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
						<?php
						if (function_exists('get_field') || class_exists('ReduxFramework')) {
							$key = function_exists('get_field') ? get_field('key_header') : '';
							if (!empty($key['header_logo']['url'])) {
								$options = $key['header_logo']['url'];
							} else if (isset($kivicare_options['header_radio'])) {
								if ($kivicare_options['header_radio'] == 1) {
									$logo_text = $kivicare_options['header_text'];
									echo esc_html($logo_text);
								}
							}
							if (isset($options) && !empty($options)) {
								echo '<img class="img-fluid logo" src="' . esc_url($options) . '" alt="'.esc_attr('image','kivicare').'">';
							}
						} elseif (has_header_image()) {
							$image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
							if (has_custom_logo()) {
								echo '<img class="img-fluid logo" src="' . esc_url($image) . '" alt="'.esc_attr('image','kivicare').'">';
							} else {
								bloginfo('name');
							}
						} else {
							$logo_url = get_template_directory_uri() . '/assets/images/logo.png';
							echo '<img class="img-fluid logo" src="' . esc_url($logo_url) . '" alt="'.esc_attr('image','kivicare').'">';
						}
						?>
					</a>

					<button class="navbar-toggler custom-toggler ham-toggle" type="button">
						<span class="menu-btn d-inline-block">
							<span class="line one"></span>
							<span class="line two"></span>
							<span class="line three"></span>
						</span>
					</button>
				</div>

				<div class="c-collapse">
					<div class="menu-new-wrapper row align-items-center">
						<div class="menu-scrollbar verticle-mn yScroller col-lg-12">
							<div id="kivicare-menu-main" class="kivicare-full-menu">
								<?php
								if (kivicare()->is_primary_nav_menu_active()) {
									kivicare()->display_primary_nav_menu(array('menu_class' => 'navbar-nav top-menu'));
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</nav><!-- #site-navigation -->
		</div>
	</div>
</div>