<?php

/**
 * Template part for displaying the footer info
 *
 * @package kivicare
 */

namespace Kivicare\Utility;

$year = date('Y');

?>
<div class="copyright-footer">
	<div class="row">
		<?php
		if (class_exists('ReduxFramework')) {
			global $kivicare_options;
		?>
			<?php if ($kivicare_options['display_copyright'] == 'yes') {
				if ($kivicare_options['footer_copyright_align'] == "1") {
					$footer_copyright_align = 'text-lg-left';
				}
				if ($kivicare_options['footer_copyright_align'] == "2") {
					$footer_copyright_align = 'text-lg-right';
				}
				if ($kivicare_options['footer_copyright_align'] == "3") {
					$footer_copyright_align = 'text-lg-center';
				}    ?>
				<div class="col-lg-12 col-md-12 <?php echo esc_attr($footer_copyright_align); ?> text-md-center text-center">
					<div class="pt-3 pb-3">
						<?php if (isset($kivicare_options['footer_copyright'])) {  ?>
							<span class="copyright">
								<?php
								$copyright = str_replace("{{year}}", $year, $kivicare_options['footer_copyright']);
								echo html_entity_decode($copyright);
								?>
							</span>
						<?php } else {	?>
							<span class="copyright">
								<a target="_blank" href="<?php echo esc_url('https://themeforest.net/user/iqonicthemes/portfolio/'); ?>">
									<?php echo esc_html__("© $year", 'kivicare'); ?>
									<strong><?php esc_html_e(' KiviCare ', 'kivicare'); ?></strong>
									<?php esc_html_e('. All Rights Reserved.', 'kivicare'); ?>
								</a>
							</span>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="col-sm-12">
				<div class="pt-3 pb-3 text-center">
					<span class="copyright">
						<a target="_blank" href="<?php echo esc_url(__('https://themeforest.net/user/iqonicthemes/portfolio/', 'kivicare')); ?>">
							<?php echo esc_html__("© $year", 'kivicare'); ?>
							<strong><?php esc_html_e(' KiviCare ', 'kivicare'); ?></strong>
							<?php esc_html_e('. All Rights Reserved.', 'kivicare'); ?>
						</a>
					</span>
				</div>
			</div>
		<?php } ?>
	</div>
</div><!-- .site-info -->