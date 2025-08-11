<?php

/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @package kivicare
 */

namespace Kivicare\Utility;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="sf-content">
        <div class="row">
            
            <div class="col-lg-12">
                <?php
                    the_content();
                ?>
            </div>
        </div>
	
	</div><!-- .sf-content -->
</article><!-- #post-## -->