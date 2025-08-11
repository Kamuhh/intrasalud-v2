<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage kivicare
 * @since 1.0
 * @version 1.0
 */
get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php
					while (have_posts()) : the_post();
						get_template_part('template-parts/content/entry_page', get_post_type());
					endwhile; // End of the loop.
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div><!-- #primary -->
	</main><!-- #main -->
</div><!-- .container -->
<?php get_footer();
