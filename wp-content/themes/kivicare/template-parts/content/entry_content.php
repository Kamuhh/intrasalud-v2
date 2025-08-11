<?php

/**
 * Template part for displaying a post's content
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

if (is_single()) {
	?>
	<div class="blog-content">
	    <?php the_content(); ?>
	</div>
	<?php is_single()  && get_template_part('template-parts/content/entry_taxonomies', get_post_type()); ?>
	</div>
	<?php
} else {
	the_excerpt();
}
?>
