<?php

/**
 * Template part for displaying a post's summary
 *
 * @package kivicare
 */

namespace Kivicare\Utility;
?>

<div class="blog-content">
	<?php
	if (!empty(get_the_excerpt()) && ord(get_the_excerpt()) !== 38) {
		the_excerpt();
	}
	?>
</div><!-- .blog-content -->