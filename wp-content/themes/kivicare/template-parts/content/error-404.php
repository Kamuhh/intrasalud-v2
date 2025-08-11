<?php

/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

global $kivicare_options;

$is_default_404 = true;
if (isset($kivicare_options['four_zero_four_layout']) && $kivicare_options['four_zero_four_layout'] == 'custom') {
	if (!empty($kivicare_options['404_layout'])) {
		$is_default_404 = false;
		$layout_404 = $kivicare_options['404_layout'];
		$has_sticky = '';
		$my_layout = get_page_by_path($layout_404, '', 'iqonic_hf_layout');
		$f04_response =  kivicare()->kivicare_get_layout_content($my_layout->ID);
	}
}
?>
<?php if (!$is_default_404) : ?>
	<?php echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($f04_response) : $f04_response; ?>
<?php else : ?>

	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="error-404 not-found">
					<div class="page-content">
						<div class="row">
							<div class="col-sm-12 text-center">
								<?php  
									if(!empty($kivicare_options['kivi_404_banner_image']['url'])) { ?>
									<div class="fourzero-image mb-5">
										<img src ="<?php echo esc_url($kivicare_options['kivi_404_banner_image']['url']); ?>" alt="<?php  esc_attr_e( '404', 'kivicare' ); ?>"/>
									</div>	

								<?php } else { 
									$bgurl = get_template_directory_uri() . '/assets/images/redux/404.png'; ?>
									<img src="<?php echo esc_url($bgurl); ?>" alt="<?php esc_attr_e('404', 'kivicare'); ?>" />
								<?php }
								
								if(!empty($kivicare_options['kivi_fourzerofour_title'])) { ?>
									<h4> <?php 
										$four_title = $kivicare_options['kivi_fourzerofour_title']; 
										echo esc_html($four_title); ?>
									</h4> <?php
								} else { ?> 
									<h4><?php echo __('Oops! This Page is Not Found.', 'kivicare');?></h4>									
								<?php }
								
								if(!empty($kivicare_options['kivi_four_description'])) { ?>
									<p class="mb-5">
										<?php $four_des = $kivicare_options['kivi_four_description']; echo esc_html($four_des); ?>
									</p> <?php
								} else { ?>	
									<p class="mb-5"><?php echo __('The requested page does not exist.', 'kivicare'); ?></p>
								<?php } ?>
								<div class="d-block">
									<a class="iq-new-btn-style iq-button-style-2 has-icon btn-icon-right" href="<?php echo esc_url(home_url()); ?>">
										<span class="iq-btn-text-holder"><?php esc_html_e('Back to Home', 'kivicare'); ?></span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
									</a>
								</div>
							</div>
						</div>
					</div><!-- .page-content -->
				</div><!-- .error-404 -->
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .container -->
<?php endif; ?>