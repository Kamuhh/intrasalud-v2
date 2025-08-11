<?php

/**
 * Template part for displaying a post's taxonomy terms
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

$taxonomies = wp_list_filter(
	get_object_taxonomies($post, 'objects'),
	array(
		'public' => true,
	)
);
$post_tag = get_the_tags();
if ($post_tag) {
?>
	<ul class="kivicare-blogtag list-inline">
		<li class="kivicare-label"><?php esc_html_e("Tags:", "kivicare") ?></li>
		<?php foreach ($post_tag as $tag) { ?>
			<li>
				<a href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo esc_html($tag->name); ?></a>
			</li>
		<?php } ?>
	</ul>
<?php } ?>