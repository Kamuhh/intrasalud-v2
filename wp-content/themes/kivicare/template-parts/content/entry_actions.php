<?php

/**
 * Template part for displaying a post's comment and edit links
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

$btn_txt = esc_html__('Read More', 'kivicare');
kivicare()->kivicare_get_blog_readmore_link(get_the_permalink(), $btn_txt);
?>