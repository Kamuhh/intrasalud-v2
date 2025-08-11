<?php

/**
 * Template part for displaying a post's header
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

global $kivicare_options;

if (!is_search()) {
	if (isset($kivicare_options['kivi_display_image'])) {
		$options = $kivicare_options['kivi_display_image'];
		if ($options == "yes") {
			get_template_part('template-parts/content/entry_thumbnail', get_post_type());
		}
	} else {
		get_template_part('template-parts/content/entry_thumbnail', get_post_type());
	}
}
?>
<div class="iq-blog-detail">
	<?php
	$postcat = get_the_category();
	if ( $postcat && !is_single() ) {
	?>
		<div class="iq-blog-cat">
			<?php foreach ( $postcat as $cat ) { ?>
				<a class="iq-cat-name" href="<?php echo get_category_link($cat->cat_ID) ?>">
			 	    <?php echo esc_html( $cat->name ); ?>
			    </a>
			<?php } ?>
		</div>
	<?php
	}

	if ( !is_single() ) {
	    ?>
		<div class="blog-title">
			<?php get_template_part( 'template-parts/content/entry_title', get_post_type() ); ?>
		</div>
	    <?php
	}
	get_template_part( 'template-parts/content/entry_meta', get_post_type() );

	?>

	<!-- .entry-header -->