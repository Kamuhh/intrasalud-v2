<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$cat = '';
if (isset($settings['blog_cat']) && !empty($settings['blog_cat'])) {
	$cat = implode(',', $settings['blog_cat']);
}

$args = array(
	'post_type'         => 'post',
	'post_status'       => 'publish',
	'paged'             => $paged,
	'category_name'		=> $cat,
	'order'           	=> $settings['order'],
	'suppress_filters'  => 0,
	'posts_per_page' => $settings['posts_per_page']['size']
);

$align = $settings['align'];

if ($align == "text-left") {
	$align = "text-start";
} elseif ($align == "text-right") {
	$align = "text-end";
}

$align .= ' kivicare-post-' . $settings['post_layout'];

// blog layouts	
$blog_layout = '';
$blog_art = '';
if (isset($settings['post_layout']) && $settings['post_layout'] === 'style2') {
	$blog_layout = ' iq-default-blog-style-2';
	$blog_art = ' iq-blog-article-style';
	if (isset($settings['blog_style']) && $settings['blog_style'] > 2) {
		$blog_layout = ' iq-default-blog-style-2-grid';
	} else if (isset($settings['blog_style']) && $settings['blog_style'] === '1') {
		if (isset($settings['desk_number']) && $settings['desk_number'] > 1) {
			$blog_layout = ' iq-default-blog-style-2-grid';
		}
	}
	$align .= $blog_layout;
}
if (isset($settings['post_layout']) && $settings['post_layout'] === 'style5') {
	$blog_layout = 'css_prefic-blog-style5';
}
global $post;

$wp_query = new \WP_Query($args);
?>
<div class="<?php echo esc_attr($align) ?>">
	<?php
	if ($settings['blog_style'] === '1') {
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
		$this->add_render_attribute('slider', 'data-centermode', $settings['centermode']); ?>

		<div class="blog-carousel owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
			<?php
			if ($wp_query->have_posts()) {
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
					$term_list = wp_get_post_terms(get_the_ID(), 'category');
					$slugs = array();
					foreach ($term_list as $term) {
						$slugs[] = $term->slug;
					}

					if ($settings['post_layout'] == 'styel1') { ?>
						<div class="iq-blog-box">
							<div class="iq-blog-image">
								<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
							</div>
							<div class="iq-blog-detail">

							    <?php if ($settings['show_category'] == 'yes') { ?>
									<div class="iq-blog-cat">
										<?php
										$cat = get_term_by('slug', $slugs[0], 'category');
										?>
										<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
											<?php echo esc_html($cat->name); ?>
										</a>
									</div>
								<?php } ?>

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<li class="list-inline-item">
											    <i class="fa fa-calendar me-2" aria-hidden="true"></i>
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
											<li class="list-inline-item">
												<a href="<?php echo  sprintf("%s", get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'iqonic'); ?>" class="iq-user">
													<i class="fas fa-user me-2" aria-hidden="true"></i>
													<?php echo  sprintf("%s ", get_the_author(), 'iqonic'); ?>
												</a>
											</li>
										</ul>
									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>
					<?php
					}

					if ($settings['post_layout'] == 'style2') {	 ?>
					<div class="iq-blog-box">
							<div class="iq-blog-image">
								<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
							</div>
							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<li class="list-inline-item">
												<?php if ($settings['show_category'] == 'yes') { ?>
													<div class="iq-blog-cat">
														<?php
														$cat = get_term_by('slug', $slugs[0], 'category');
														?>
														<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
															<?php echo esc_html($cat->name); ?>
														</a>
													</div>
												<?php } ?>
											</li>
											<li class="list-inline-item">
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
										</ul>
									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>
					<?php
					}

					if ($settings['post_layout'] == 'style3') {	 ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
								</div> <?php
									} ?>
							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<div class="list-inline-item">
											<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
										</div>

										<?php if ($settings['show_category'] == 'yes') { ?>
											<div class="iq-blog-cat">
												<?php
												$cat = get_term_by('slug', $slugs[0], 'category');
												?>
												<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
													<?php echo esc_html($cat->name); ?>
												</a>
											</div>
										<?php } ?>

									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>
					<?php
					}

					if ($settings['post_layout'] == 'style4') { ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
								</div> <?php
									} ?>
							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">

										<?php if ($settings['show_category'] == 'yes') { ?>
											<div class="iq-blog-cat">
												<?php
												$cat = get_term_by('slug', $slugs[0], 'category');
												?>
												<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
													<?php echo esc_html($cat->name); ?>
												</a>
											</div>
										<?php } ?>

										<div class="list-inline-item">
											<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
										</div>
									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>

								<ul class="list-inline blog-author-info mb-0">
									<li class="list-inline-item blog-author"> <?php
																				$get_author_id = get_the_author_meta('ID');
																				$get_author_gravatar = get_avatar_url($get_author_id); ?>
										<?php echo '<img src="' . $get_author_gravatar . '" class="author-image" alt="' . esc_attr__("image", "iqonic") . '" />' ?>
										<div class="auth-info">
											<span><?php echo esc_html__('Written By', 'iqonic'); ?></span>
											<?php echo '<span class="author"> <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . esc_html(get_the_author()) . '</a> </span>';  ?>
										</div>
									</li>
								</ul>

								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>
					<?php
					}
					if ($settings['post_layout'] == 'style5') { ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>

									<?php if ($settings['show_category']) { ?>
										<div class="iq-blog-cat">
											<?php
											if (isset($slugs[0])) {
												$cat = get_term_by('slug', $slugs[0], 'category');
											?>
												<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
													<?php echo esc_html($cat->name); ?>
												</a>
											<?php } ?>
										</div>
									<?php } ?>

								</div> <?php
									} ?>

							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<li class="list-inline-item">
												<i class="far fa-calendar-alt me-2"></i>
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
											<li class="list-inline-item">
												<a href="<?php echo  sprintf("%s", get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'iqonic'); ?>" class="iq-user">
													<i class="far fa-user me-2"></i>
													<?php echo  sprintf("%s ", get_the_author(), 'iqonic'); ?>
												</a>
											</li>
										</ul>
									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div> <?php
							}
						}
						wp_reset_postdata();
					}
								?>
		</div>

		<?php
	} else {

		echo '<div class="row">';
		if ($settings['blog_style'] === "2") {
			$col = 'col-lg-12' . $blog_art;
		}
		if ($settings['blog_style'] === "3") {
			$col = 'col-lg-6 col-md-6 ';
		}
		if ($settings['blog_style'] === "4") {
			$col = 'col-lg-4 col-md-6';
		}
		if ($settings['blog_style'] === "5") {
			$col = 'col-xl-3 col-lg-4 col-md-6';
		}
		if ($wp_query->have_posts()) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
				$term_list = wp_get_post_terms(get_the_ID(), 'category');
				$slugs = array();
				foreach ($term_list as $term) {
					$slugs[] = $term->slug;
				}
		?>
				<div class="<?php echo esc_attr($col); ?>">

					<?php if ($settings['post_layout'] == 'styel1') { ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
								</div> <?php
									} ?>

							<div class="iq-blog-detail">

								<?php if ($settings['show_category'] == 'yes') { ?>
									<div class="iq-blog-cat">
										<?php
										if (isset($slugs[0])) {
											$cat = get_term_by('slug', $slugs[0], 'category');
										?>
											<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
												<?php echo esc_html($cat->name); ?>
											</a>
										<?php } ?>
									</div>
								<?php } ?>

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<li class="list-inline-item">
												<i class="fa fa-calendar me-2" aria-hidden="true"></i>
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
											<li class="list-inline-item">
												<a href="<?php echo  sprintf("%s", get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'iqonic'); ?>" class="iq-user">
													<i class="fas fa-user me-2" aria-hidden="true"></i>
													<?php echo  sprintf("%s ", get_the_author(), 'iqonic'); ?>
												</a>
											</li>
										</ul>
									</div>
								<?php } ?>

								<div class="blog-title	">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>
					<?php }

					if ($settings['post_layout'] == 'style2') {
					?>

						<div class="iq-blog-box">
							<div class="iq-blog-image">
								<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
							</div>
							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<li class="list-inline-item">
												<?php if ($settings['show_category'] == 'yes') { ?>
													<div class="iq-blog-cat">
														<?php
														$cat = get_term_by('slug', $slugs[0], 'category');
														?>
														<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
															<?php echo esc_html($cat->name); ?>
														</a>
													</div>
												<?php } ?>
											</li>
											<li class="list-inline-item">
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
										</ul>
									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>

					<?php

					}

					if ($settings['post_layout'] == 'style3') { ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
								</div> <?php
									} ?>
							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<div class="list-inline-item">
											<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
										</div>

										<?php if ($settings['show_category'] == 'yes') { ?>
											<div class="iq-blog-cat">
												<?php
												$cat = get_term_by('slug', $slugs[0], 'category');
												?>
												<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
													<?php echo esc_html($cat->name); ?>
												</a>
											</div>
										<?php } ?>

									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								}
								?>
							</div>
						</div>
					<?php
					}

					if ($settings['post_layout'] == 'style4') { ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>
								</div> <?php
									} ?>
							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<div class="list-inline-item">
											<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
										</div>

										<?php if ($settings['show_category'] == 'yes') {  ?>
											<div class="iq-blog-cat">
												<?php
												$cat = get_term_by('slug', $slugs[0], 'category');
												?>
												<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
													<?php echo esc_html($cat->name); ?>
												</a>
											</div>
										<?php } ?>

									</div>
								<?php } ?>

								<div class="blog-title">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>

								<ul class="list-inline">
									<li class="list-inline-item blog-author"> <?php
																				$get_author_id = get_the_author_meta('ID');
																				$get_author_gravatar = get_avatar_url($get_author_id); ?>
										<?php echo '<img src="' . $get_author_gravatar . '" class="author-image" alt="' . esc_attr__("image", "iqonic") . '" />' ?>
										<?php echo esc_html__('Written By', 'iqonic'); ?>
										<?php echo '<span class="author"> <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . esc_html(get_the_author()) . '</a> </span>';  ?>
									</li>
								</ul>

								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div>
					<?php
					}
					if ($settings['post_layout'] == 'style5') { ?>
						<div class="iq-blog-box">
							<?php if (!empty($full_image[0])) { ?>
								<div class="iq-blog-image">
									<?php echo sprintf('<img src="%1$s" alt="' . esc_attr__("iqonic-blog", "talkie") . '"/>', esc_url($full_image[0], 'iqonic')); ?>

									<?php if ($settings['show_category'] == 'yes') { ?>
										<div class="iq-blog-cat">
											<?php
											if (isset($slugs[0])) {
												$cat = get_term_by('slug', $slugs[0], 'category');
											?>
												<a class="iq-cat-name" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
													<?php echo esc_html($cat->name); ?>
												</a>
											<?php } ?>
										</div>
									<?php } ?>

								</div> <?php
									} ?>

							<div class="iq-blog-detail">

								<?php if ($settings['show_meta'] == 'yes') { ?>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<li class="list-inline-item">
												<i class="far fa-calendar-alt me-2"></i>
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
											<li class="list-inline-item">
												<a href="<?php echo  sprintf("%s", get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'iqonic'); ?>" class="iq-user">
													<i class="far fa-user me-2"></i>
													<?php echo  sprintf("%s ", get_the_author(), 'iqonic'); ?>
												</a>
											</li>
										</ul>
									</div>
								<?php } ?>

								<div class="blog-title	">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']); ?> class="blog-text iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo esc_attr($settings['title_tag']); ?>>
									</a>
								</div>
								<p><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<?php if ($settings['has_button'] == "yes") {
									require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
								} ?>
							</div>
						</div> <?php
							} ?>
				</div>
	<?php
			}
			wp_reset_postdata();
		}
		echo '</div>';
	} ?>
</div>
<?php
$tot = $wp_query->found_posts;

if ($settings['blog_style'] != '1' && $settings['pagination'] == 'yes') {
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
