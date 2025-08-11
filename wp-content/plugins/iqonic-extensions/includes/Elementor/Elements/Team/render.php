<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = '';
$col = 'grid';

$tax_query = array();
$tax_args = array();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if ($settings['iqonic_has_box_shadow'] == 'yes') {
	$align .= ' iq-box-shadow';
}

if ($settings['design_style'] == 'yes') {
	$align .= ' iq-box-shadow';
}

$iq_team = '';
if ($settings['design_style'] == '1') {
	$iq_team .= ' iq-team-style-1';
} elseif ($settings['design_style'] == '2') {
	$iq_team .= ' iq-team-style-2';
} elseif ($settings['design_style'] == '3') {
	$iq_team .= ' iq-team-style-3';
}

$args = array(
	'post_type'         => 'team',
	'post_status'       => 'publish',
	'paged'             => $paged,
	'posts_per_page'    => $settings['posts_per_page'],
);

if (!empty($settings['team_cat'])) {
	$tax_args['taxonomy'] = 'team-categories';
	$tax_args['field'] = 'term_id';
	$tax_args['terms'] = $settings['team_cat'];
	array_push($tax_query, $tax_args);
	$args['tax_query'] = $tax_query;
}

$wp_query = new \WP_Query($args);

global $post;

$style = $settings['team_style'];
$desk = $settings['desk_number'];
$lap = $settings['lap_number'];
$tab = $settings['tab_number'];
$mob = $settings['mob_number'];

$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
$this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
$this->add_render_attribute('slider', 'data-doteach', $settings['dot_each']);
$this->add_render_attribute('slider', 'data-centermode', $settings['centermode']);

if ($settings['team_style'] == 'slider') {
	if ($settings['design_style'] != '3') { ?>
		<div class="iq-team iq-team-slider <?php echo esc_attr($iq_team); ?> <?php echo esc_attr($align); ?>">
			<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
				<?php
				if ($wp_query->have_posts()) {
					while ($wp_query->have_posts()) {
						$wp_query->the_post();
						$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");

						$designation   = get_post_meta($post->ID, 'iqonic_team_designation', true);
						$contact   = get_post_meta($post->ID, 'iqonic_team_contact', true);
						$email   = get_post_meta($post->ID, 'iqonic_team_email', true);
						$li = '';

						if (function_exists('get_field')) {

							$key =  get_field('key_pjros1245', get_the_ID());
							$facebook   = $key['iqonic_team_facebook'];
							$twitter   = $key['iqonic_team_twitter'];
							$google   = $key['iqonic_team_google'];
							$github   = $key['iqonic_team_github'];
							$insta   = $key['iqonic_team_insta'];
							$whatsapp  = $key['iqonic_team_whatsapp'];

							if (!empty($facebook)) {
								$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-facebook-f"></i></a></li>', esc_url($facebook));
							}

							if (!empty($twitter)) {
								$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-x-twitter"></i></a></li>', esc_url($twitter));
							}

							if (!empty($google)) {
								$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-google"></i></a></li>', esc_url($google));
							}

							if (!empty($github)) {
								$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-github"></i></a></li>', esc_url($github));
							}

							if (!empty($insta)) {
								$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-instagram"></i></a></li>', esc_url($insta));
							}

							if (!empty($whatsapp)) {
								$li .= sprintf('<li><a href="%s"><i class="fab fa-whatsapp"></i></a></li>', esc_url($whatsapp));
							}
						} ?>

						<div class="item">
							<div class="iq-team-blog">
								<div class="iq-team-img">
									<?php echo sprintf('<img src="%1$s" alt="team-image"/>', esc_url($full_image[0])); ?>
								</div>

								<div class="share iq-team-social">
									<ul>
										<?php echo $li; ?>
									</ul>
								</div>

								<div class="iq-team-info">
									<div class="iq-team-main-detail">
										<a href="<?php the_permalink(); ?>">
											<h5 class="member-text iq-heading-title">
												<?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
											</h5>
										</a>
										<span class="iq-specialized">
											<?php echo iq_by_team_cat(get_the_ID()); ?>
										</span>
									</div>
								</div>
							</div>
						</div> <?php
							}
							wp_reset_postdata();
						}
								?>
			</div>
		</div> <?php
			} else if ($settings['design_style'] == 3) { ?>
		<div class="iq-team iq-team-slider <?php echo esc_attr($iq_team); ?> <?php echo esc_attr($align); ?>">
			<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
				<?php
				if ($wp_query->have_posts()) {
					while ($wp_query->have_posts()) :
						$wp_query->the_post();
						$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
						$designation   = get_post_meta($post->ID, 'iqonic_team_designation', true);
						$li = '';

						if (function_exists('get_field')) {

							$key =  get_field('key_pjros1245', get_the_ID());
							$facebook   = $key['iqonic_team_facebook'];
							$twitter   = $key['iqonic_team_twitter'];
							$google   = $key['iqonic_team_google'];
							$github   = $key['iqonic_team_github'];
							$insta   = $key['iqonic_team_insta'];
							$whatsapp  = $key['iqonic_team_whatsapp'];

							if (!empty($facebook)) {
								$li .= sprintf('<li class="list-inline-item"><a href="%s">' . '<svg class="base-circle animated" width="38" height="38" viewBox="0 0 50 50"><circle class="c1" cx="25" cy="25" r="23" stroke="currentColor" stroke-width="1" fill="none"></circle></svg>' . '<i class="fa-brands fa-facebook-f"></i></a></li>', esc_url($facebook));
							}

							if (!empty($twitter)) {
								$li .= sprintf('<li class="list-inline-item"><a href="%s">' . '<svg class="base-circle animated" width="38" height="38" viewBox="0 0 50 50"><circle class="c1" cx="25" cy="25" r="23" stroke="currentColor" stroke-width="1" fill="none"></circle></svg>' . '<i class="fa-brands fa-x-twitter"></i></a></li>', esc_url($twitter));
							}

							if (!empty($google)) {
								$li .= sprintf('<li class="list-inline-item"><a href="%s">' . '<svg class="base-circle animated" width="38" height="38" viewBox="0 0 50 50"><circle class="c1" cx="25" cy="25" r="23" stroke="currentColor" stroke-width="1" fill="none"></circle></svg>' . '<i class="fab fa-google"></i></a></li>', esc_url($google));
							}

							if (!empty($github)) {
								$li .= sprintf('<li class="list-inline-item"><a href="%s">' . '<svg class="base-circle animated" width="38" height="38" viewBox="0 0 50 50"><circle class="c1" cx="25" cy="25" r="23" stroke="currentColor" stroke-width="1" fill="none"></circle></svg>' . '<i class="fab fa-github"></i></a></li>', esc_url($github));
							}

							if (!empty($insta)) {
								$li .= sprintf('<li class="list-inline-item"><a href="%s">' . '<svg class="base-circle animated" width="38" height="38" viewBox="0 0 50 50"><circle class="c1" cx="25" cy="25" r="23" stroke="currentColor" stroke-width="1" fill="none"></circle></svg>' . '<i class="fab fa-instagram"></i></a></li>', esc_url($insta));
							}

							if (!empty($whatsapp)) {
								$li .= sprintf('<li class="list-inline-item"><a href="%s">' . '<svg class="base-circle animated" width="38" height="38" viewBox="0 0 50 50"><circle class="c1" cx="25" cy="25" r="23" stroke="currentColor" stroke-width="1" fill="none"></circle></svg>' . '<i class="fab fa-whatsapp"></i></a></li>', esc_url($whatsapp));
							}
						} ?>

						<div class="iq-item">
							<div class="iq-item-content-wrapper">
								<a href="<?php echo sprintf("%s", esc_url(get_permalink($post->ID))); ?>" class="iq-team-img">
									<?php echo sprintf('<img src="%1$s" alt="team"/>', esc_url($full_image[0], 'iqonic')); ?>
								</a>

								<div class="iq-team-content">
									<span class="iq-specialized">
										<?php echo iq_by_team_cat(get_the_ID()); ?>
									</span>
									<a href="<?php echo sprintf("%s", esc_url(get_permalink($post->ID))); ?>">
										<h4 class="link-color">
											<?php echo sprintf("%s", esc_html__(get_the_title($post->ID), 'iqonic')); ?>
										</h4>
									</a>
									<div class="kivicare-social">
										<h6 class="social-text"> <?php echo esc_html__('Follow Us:', 'iqonic') ?> </h6>
										<ul>
											<?php echo $li; ?>
										</ul>

									</div>
								</div>
							</div>
						</div>
				<?php
					endwhile;
					wp_reset_postdata();
				} ?>
			</div>
		</div>
	<?php } ?>
<?php
}
if ($settings['team_style'] == 'grid') { ?>
	<div class="iq-team iq-team-style-grid <?php echo esc_attr($iq_team); ?> <?php echo esc_attr($align); ?>">
		<div class="row">
			<?php
			if ($settings['team_grid_style'] == '1') {
				$col = 'col-lg-12';
			}
			if ($settings['team_grid_style'] == '2') {
				$col = 'col-lg-6';
			}
			if ($settings['team_grid_style'] == '3') {
				$col = 'col-lg-4';
			}
			if ($settings['team_grid_style'] == '4') {
				$col = 'col-lg-3';
			}

			if ($wp_query->have_posts()) {
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");

					$designation   = get_post_meta($post->ID, 'iqonic_team_designation', true);
					$contact   = get_post_meta($post->ID, 'iqonic_team_contact', true);
					$email   = get_post_meta($post->ID, 'iqonic_team_email', true);
					$li = '';

					if (function_exists('get_field')) {
						$key =  get_field('key_pjros1245', get_the_ID());
						$facebook   = $key['iqonic_team_facebook'];
						$twitter   = $key['iqonic_team_twitter'];
						$google   = $key['iqonic_team_google'];
						$github   = $key['iqonic_team_github'];
						$insta   = $key['iqonic_team_insta'];
						$whatsapp  = $key['iqonic_team_whatsapp'];

						if (!empty($facebook)) {
							$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-facebook-f"></i></a></li>', esc_url($facebook));
						}

						if (!empty($twitter)) {
							$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-x-twitter"></i></a></li>', esc_url($twitter));
						}

						if (!empty($google)) {
							$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-google"></i></a></li>', esc_url($google));
						}

						if (!empty($github)) {
							$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-github"></i></a></li>', esc_url($github));
						}

						if (!empty($insta)) {
							$li .= sprintf('<li><a href="%s">' . '<i class="fab fa-instagram"></i></a></li>', esc_url($insta));
						}

						if (!empty($whatsapp)) {
							$li .= sprintf('<li><a href="%s"><i class="fab fa-whatsapp"></i></a></li>', esc_url($whatsapp));
						}
					}  ?>

					<div class="<?php echo esc_attr($col); ?>">
						<div class="iq-team-blog">
							<div class="iq-team-img">
								<?php echo sprintf('<img src="%1$s" alt="team-image"/>', esc_url($full_image[0])); ?>
							</div>
							<div class=" ">
								<ul>
									<?php echo $li; ?>
								</ul>
							</div>
							<div class="iq-team-info">
								<div class="iq-team-main-detail">
									<a href="<?php the_permalink(); ?>">
										<h5 class="member-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
										</h5>
									</a>
									<span class="iq-specialized">
										<?php echo iq_by_team_cat(get_the_ID()); ?>
									</span>

								</div>
							</div>
						</div>
					</div>
		</div>
<?php
				}
				wp_reset_postdata();
			}
?>
	</div>
	</div>
<?php } ?>

<?php
$tot = $wp_query->found_posts;


if ($settings['team_style'] == 'grid' && $settings['pagination'] == 'yes') {
	$total_pages = $wp_query->max_num_pages;

	if ($total_pages > 1) {
		$current_page = max(1, get_query_var('paged'));
		echo paginate_links(array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => '/page/%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'type'            => 'list',
			'prev_text'       => wp_kses('<span aria-hidden="true">' . __('Previous page', 'iqonic') . '</span>', 'iqonic'),
			'next_text'       => wp_kses('<span aria-hidden="true">' . __('Next page', 'iqonic') . '</span>', 'iqonic'),
		));
	}
}
