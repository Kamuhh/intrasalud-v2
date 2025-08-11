<?php

/**
 * Template part for displaying the Breadcrumb 
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

if (is_front_page()) {
        if (is_home()) { ?>
            <div class="iq-breadcrumb text-center green-bg">
                <div class="container">
                    <div class="row flex-row-reverse">
                        <div class="col-sm-12">
                            <div class="heading-title white iq-breadcrumb-title">
                                <h1 class="title mt-0"><?php esc_html_e('Home', 'kivicare'); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }
}
kivicare()->kivicare_inner_breadcrumb();
?>