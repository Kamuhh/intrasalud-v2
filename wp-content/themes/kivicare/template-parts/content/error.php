<?php

/**
 * Template part for displaying the page content when an error has occurred
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

?>
<section class="error text-center kivicare-error">
	<?php get_template_part('template-parts/content/page_header'); ?>
	<div class="page-content">
		<?php if (is_home() && current_user_can('publish_posts')) { ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						esc_html__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kivicare'),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url(admin_url('post-new.php'))
				);
				?>
			</p>
		<?php } elseif (is_search()) { ?>
			<p>
				<?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kivicare'); ?>
			</p>
			<form method="get" class="search-form search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="form-search">
					<input type="search" class="search-field search__input" name="s" value="<?php echo get_search_query(); ?>" placeholder=<?php esc_attr_e("Search website","kivicare") ?> />
					<button type="submit" class="search-submit" ><i class="ion-ios-search" aria-hidden="true"></i><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'kivicare' ); ?></span></button> 
				</div>
			</form>
			<div class="d-block">
				<?php
					$btn_text  = 'Back to Home';
				?>
				<?php kivicare()->kivicare_get_blog_readmore(home_url(), $btn_text); ?>
			</div>
		<?php } else { ?>
			<p>
				<?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kivicare'); ?>
			</p>
		<?php
		}
		get_search_form('');
		?>
	</div><!-- .page-content -->
</section><!-- .error -->