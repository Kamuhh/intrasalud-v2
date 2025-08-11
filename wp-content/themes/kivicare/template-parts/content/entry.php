<?php

/**
 * Template part for displaying a post
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

global $kivicare_options;

$kivicare_layout = '';
if (isset($kivicare_options['kivi_blog'])) {
	$kivicare_layout = $kivicare_options['kivi_blog'];
}
if ($kivicare_layout == '2' || $kivicare_layout == '3') {
?>
	<div class="<?php echo esc_attr($args); ?>">
	<?php } ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
		<div class="iq-blog-box">
			<?php
			get_template_part('template-parts/content/entry_header', get_post_type());
			if (is_single()) {
				get_template_part('template-parts/content/entry_content', get_post_type());
			} else {
				get_template_part('template-parts/content/entry_summary', get_post_type());
			}
			wp_link_pages(array(
				'before'      => '<div class="page-links">' . esc_html__('Pages:', 'kivicare'),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			));
			get_template_part('template-parts/content/entry_footer', get_post_type());
			?>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
	if (is_singular(get_post_type())) {
		if (class_exists('ReduxFramework')) {
			global $kivicare_options;
			if ($kivicare_options['kivi_display_comment'] == 'yes') {
				// Show comments only when the post type supports it and when comments are open or at least one comment exists.
				if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
					comments_template();
				}
			}
		} else {
			// Show comments only when the post type supports it and when comments are open or at least one comment exists.
			if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
				comments_template();
			}
		}
	}
	if ($kivicare_layout == '2' || $kivicare_layout == '3') { ?>
	</div>
<?php
	}