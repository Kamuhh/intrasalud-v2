<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
?>

<div class="iq-widget-menu widget">
	<?php if (!empty($settings['iqonic-title'])) { ?>
		<h5> <?php echo esc_html($settings['iqonic-title']); ?> </h5>
	<?php } ?>

	<div class="list-inline iq-widget-menu">
		<ul class="iq-post">
			<?php
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'order' => 'DESC',
				'suppress_filters' => 0,
				'posts_per_page' => $settings['posts_per_page']
			);

			$loop = new \WP_Query($args);
			if($loop->have_posts()) :
				while ($loop->have_posts()) : $loop->the_post();
					$year = get_post_time('Y');
					$month = get_post_time('m');
					$day = get_post_time('j'); ?>

					<li>
						<div class="post-img">
							<?php if($settings['show_image'] == 'yes') { ?>
								<div class="post-img-holder">
									<a href="<?php echo esc_url(get_permalink()); ?>" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')"></a>
								</div>
							<?php } ?>

							<div class="post-blog">
								<div class="blog-box">
									<?php if($settings['show_meta'] == 'yes') { ?>
										<ul class="list-inline">
											<li class="list-inline-item me-3">
												<a href="<?php echo esc_url(get_day_link($year, $month, $day)); ?>">
													<i class="far fa-calendar-alt me-2" aria-hidden="true"></i><?php echo get_the_date();  ?>
												</a>
											</li>

											<li class="list-inline-item me-3">
												<a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>">
													<i class="far fa-user me-2" aria-hidden="true"></i><?php the_author();  ?>
												</a>
											</li>
										</ul>
									<?php } ?>	
									<a class="new-link" href="<?php echo esc_url(get_permalink()); ?>">
										<<?php echo esc_attr($settings['title_tag']) ?> class="post-title"><?php the_title(); ?></<?php echo esc_attr($settings['title_tag']) ?>>
									</a>
								</div>
							</div>
						</div>
					</li> <?php
				endwhile;
				wp_reset_postdata();
			endif; wp_reset_query(); ?>
		</ul>
	</div>
</div>