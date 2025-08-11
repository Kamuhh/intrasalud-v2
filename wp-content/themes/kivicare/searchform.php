<?php

/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

$unique_id = esc_html(uniqid('search-form-')); ?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<label for="<?php echo esc_attr($unique_id); ?>">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'kivicare' ); ?></span>
	</label>

	<input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'kivicare' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><i class="ion-ios-search"></i><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'kivicare' ); ?></span></button>

</form>