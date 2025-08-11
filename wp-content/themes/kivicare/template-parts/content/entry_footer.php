<?php

/**
 * Template part for displaying a post's footer
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

if (!is_single()) {
    get_template_part('template-parts/content/entry_taxonomies', get_post_type());
    get_template_part('template-parts/content/entry_actions', get_post_type());
    echo "</div>";
}