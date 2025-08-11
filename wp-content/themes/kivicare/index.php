<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

global $kivicare_options;

$is_sidebar = kivicare()->is_primary_sidebar_active();
$post_section = kivicare()->post_style();
get_header();
$kivicare_layout = '';
if (isset($kivicare_options['kivi_blog'])) {
	$kivicare_layout = $kivicare_options['kivi_blog'];
}
?>
<div class="site-content-contain">
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
					<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
						<?php
						if ($is_sidebar) {
							echo '<div class="col-xl-8 col-sm-12">';
						} else if ($kivicare_layout != '2' && $kivicare_layout != '3') {
							echo '<div class="col-lg-12 col-sm-12">';
						} 
						if ($kivicare_layout != '2' && $kivicare_layout != '3') {  ?>
                          <div class="kivicare-blog-main-list">
						   <?php
						} 

						if (have_posts()) {
							while (have_posts()) {
								the_post();
								get_template_part('template-parts/content/entry', get_post_type(), $post_section['post']);
							}

							if (!is_singular()) {
								if (isset($kivicare_options['kivi_display_pagination'])) {
									$options = $kivicare_options['kivi_display_pagination'];
									if ($options == "yes") {
										get_template_part('template-parts/content/pagination');
									}
								} else {
									get_template_part('template-parts/content/pagination');
								}
							}
						} else {
							get_template_part('template-parts/content/error');
						}
					
						if ($is_sidebar || $kivicare_layout != '2' && $kivicare_layout != '3') {
							echo '</div></div>';
						}
						get_sidebar();
						?>
					</div>
				</div>
			</main><!-- #primary -->
		</div>
	</div>
</div>
<?php
get_footer();
