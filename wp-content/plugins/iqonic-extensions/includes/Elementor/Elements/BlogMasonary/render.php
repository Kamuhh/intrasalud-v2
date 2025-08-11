<?php
namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH'))
	exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$i = 0;
$class_hidden = '';
$class_with_loadmore = '';
$data_loadmore_item = '';
$loadmore_btn = '';
$display_loadmore_btn = 'display:none';
if (isset($settings['loadmore_button']) && $settings['loadmore_button'] === 'yes') {
	$class_hidden = ' loadmore-hidden-items';
	$class_with_loadmore = ' iq-with-loadmore';
	$data_loadmore_item = $settings['posts_per_loadmore']['size'];
	$display_loadmore_btn = 'display:block';
}
$kivi_class = '';
?>
<div class="iq-masonry-block iq-blog-masonary<?php echo esc_attr($class_with_loadmore); ?>"
	data-loadmore-item='<?php echo esc_attr($data_loadmore_item); ?>'>

	<?php
	if ($settings['dis_tabs'] == 'yes') {
		?>
		<div class="isotope-filters isotope-tooltip">
			<?php
			$terms = get_terms(array('taxonomy' => 'category'));
			?>
			<button data-filter="" class="active"><?php echo esc_html__('All', 'iqonic'); ?></button>
			<?php foreach ($terms as $term) { ?>
				<button data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="iq-portfolio-2 iq-masonry iq-columns-2 <?php echo esc_attr($kivi_class); ?>">
		<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $settings['posts_per_page']['size'],
			'order' => $settings['order']
		);
		$wp_query = new \WP_Query($args);

		while ($wp_query->have_posts()) {

			$wp_query->the_post();
			$term_list = wp_get_post_terms(get_the_ID(), 'category');
			$slugs = array();
			foreach ($term_list as $term) {
				$slugs[] = $term->slug;
			} ?>

			<div class="iq-masonry-item <?php echo implode(' ', $slugs); ?><?php echo esc_attr($class_hidden); ?>">
				<div class="iq-portfolio">
					<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>" class="iq-portfolio-img">
						<?php echo get_the_post_thumbnail(); ?>
					</a>
					<div class="iq-post-details">
						<div class="iq-portfolio-content">
							<div class="details-box clearfix">
								<div class="consult-details">
									<div class="iq-blog-cat">
										<?php
										if (isset($slugs[0])) {
											$cat = get_term_by('slug', $slugs[0], 'category'); ?>
											<a class="iq-cat-name"
												href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
												<?php echo esc_html($cat->name); ?>
											</a>
											<?php
										} ?>
									</div>
									<div class="iq-blog-meta">
										<ul class="list-inline">
											<?php
											//post date
											$archive_year = get_the_time('Y', $wp_query->ID);
											$archive_month = get_the_time('m', $wp_query->ID);
											$archive_day = get_the_time('d', $wp_query->ID);
											if (!empty($wp_query->post_date)) {
												$date = date_create($wp_query->post_date);
											} ?>
											<li class="list-inline-item">
												<i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
												<?php echo sprintf("%s", iqonic_blog_time_link()); ?>
											</li>
											<li class="list-inline-item">
												<a href="<?php echo sprintf("%s", get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'iqonic'); ?>"
													class="iq-user">
													<i class="far fa-user me-2" aria-hidden="true"></i>
													<?php echo sprintf("%s ", get_the_author(), 'iqonic'); ?>
												</a>
											</li>
										</ul>
									</div>
									<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo sprintf('%1$s', esc_attr($settings['title_size'])); ?> class="post-title
											text-hover iq-heading-title">
											<?php echo sprintf("%s", esc_html(get_the_title($wp_query->ID))); ?>
										</<?php echo sprintf('%1$s', esc_attr($settings['title_size'])); ?>>
									</a>

									<?php if ($settings['has_button'] == "yes") {
										require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_blog_button.php';
									} ?>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
		}
		wp_reset_postdata();
		?>
	</div>

	<div id="load-more-pf" style="<?php echo esc_attr($display_loadmore_btn); ?>">
		<a class="iq-button-style-2 has-icon btn-icon-right" href="#">
			<span class="iq-btn-text-holder"><?php echo esc_html__('Load More', 'iqonic'); ?></span><span
				class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span>
		</a>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function () {
		if (jQuery('.iq-with-loadmore').length >= 1) {
			var $container = jQuery('.iq-with-loadmore .iq-masonry');

			$container.isotope({
				itemSelector: '.iq-masonry-item',
				animationOptions: {
					duration: 750,
					easing: 'linear',
					queue: false
				}
			});

			var initShow = jQuery('.iq-with-loadmore').data('loadmore-item');
			var counter = initShow;
			var iso = $container.data('isotope');

			loadMore(initShow);

			function loadMore(toShow) {

				$container.find(".loadmore-hidden-items").removeClass("loadmore-hidden-items");
				var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function (item) {
					return item.element;
				});
				jQuery(hiddenElems).addClass('loadmore-hidden-items');
				$container.isotope('layout');
				//when no more to load, hide show more button
				if (hiddenElems.length == 0) {
					jQuery("#load-more-pf").hide();
				} else {
					jQuery("#load-more-pf").show();
				};
			}
			jQuery(document).on("click", "#load-more-pf", function (e) {
				e.preventDefault();
				counter = counter + initShow;
				loadMore(counter);
			});
		}

	});
</script>