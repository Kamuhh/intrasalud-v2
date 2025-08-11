<?php

/**
 * Kivicare\Utility\Helper\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Helper;

use Exception;
use Kivicare\Utility\Component_Interface;
use function add_action;
use function Patchwork\Utils\args;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `kivicare()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */

	public $kivicare_options;

	public function get_slug(): string
	{
		return 'helper';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		$this->kivicare_options = get_option('kivicare-options');

		// live ajax search
		add_action('wp_ajax_data_fetch', array($this, 'data_fetch'));
		add_action('wp_ajax_nopriv_data_fetch', array($this, 'data_fetch'));
		add_action('wp_footer', array($this, 'ajax_fetch'), 9999);

		// ** search load more *//
		if (!function_exists('kivicare_loadmore_ajax_handler')) {
			add_action('wp_ajax_loadmore', array($this, 'kivicare_loadmore_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore', array($this, 'kivicare_loadmore_ajax_handler'));
		}

		//** blog load more *//
		if (!function_exists('kivicare_loadmore_blog_ajax_handler')) {
			add_action('wp_ajax_loadmore_blog', array($this, 'kivicare_loadmore_blog_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore_blog', array($this, 'kivicare_loadmore_blog_ajax_handler'));
		}
		
		// Archive Page -> Genres ,Tag, Category
		if (!function_exists('kivicare_loadmore_archive_ajax_handle')) {
			add_action('wp_ajax_loadmore_archive', array($this, 'kivicare_loadmore_archive_ajax_handle'), 10, 2);
			add_action('wp_ajax_nopriv_loadmore_archive', array($this, 'kivicare_loadmore_archive_ajax_handle'));
		}

		// ** Product load more *//
		if (!function_exists('kivicare_loadmore_product_ajax_handler')) {
			add_action('wp_ajax_loadmore_product', array($this, 'kivicare_loadmore_product_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore_product', array($this, 'kivicare_loadmore_product_ajax_handler'));
		}

		add_action('wp_ajax_load_skeleton', array($this, 'kivicare_load_skeleton_ajax_handler'));
		add_action('wp_ajax_nopriv_load_skeleton', array($this, 'kivicare_load_skeleton_ajax_handler'));

		// Get Woof Ajax Filter Product Query 
		if (!function_exists('kivicare_fetch_woof_filter_ajax_query')) {
			add_action('wp_ajax_fetch_woof_filter_ajax_query', array($this, 'kivicare_fetch_woof_filter_ajax_query'));
			add_action('wp_ajax_nopriv_fetch_woof_filter_ajax_query', array($this, 'kivicare_fetch_woof_filter_ajax_query'));
		}

		if (!function_exists('ajax_qty_cart')) {
			add_action('wp_ajax_qty_cart', array($this,'ajax_qty_cart'));
			add_action('wp_ajax_nopriv_qty_cart', array($this,'ajax_qty_cart'));
		}

		add_filter('pms_edit_profile_form_submit_text',function($btn_text){
			return esc_html__('Save Profile','kivicare');
		});
		add_filter('pms_member_account_subscriptions_view_row',function($subscription_row){
			return '<div class="table-responsive">'. $subscription_row. '</div>';
		});
	}

	public function kivicare_load_skeleton_ajax_handler()
	{
		global $wp_filesystem;
		if(!isset($wp_filesystem)) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}
		
		$skeleton_path = get_template_directory() . '/template-parts/skeleton/';
		try {
			$data = array(
				'skeleton-grid' => $wp_filesystem->get_contents( $skeleton_path . 'skeleton-grid.php' ),
				'skeleton-list' => $wp_filesystem->get_contents( $skeleton_path . 'skeleton-list.php' )
			);
			if($data['skeleton-grid']==false || $data['skeleton-list']==false){  throw new Exception("File not Found");}
			wp_send_json_success( $data );
		} catch (Exception $e) {
			wp_send_json_error( $e->getMessage(),404 );
		}
	}

	public function kivicare_fetch_woof_filter_ajax_query()
	{
		session_start();
		if(isset($_SESSION['kivicare_woof_query_ajax'])) {
			$query = new \WP_Query($_SESSION['kivicare_woof_query_ajax']);
			echo json_encode(array('query' => json_encode($_SESSION['kivicare_woof_query_ajax']), 'max_page' => $query->max_num_pages));
			wp_reset_postdata();
			session_unset();
			die;
		}
	}

	// live ajax search
	public function data_fetch()
	{
		$args = array('posts_per_page' => 5, 's' => esc_attr($_POST['keyword']), 'post_type' => array('product'));
		if (isset($_POST['is_include']) && $_POST['is_include'] == 'posts') {
			array_push($args['post_type'], 'post');
			array_push($args['post_status'], 'publish');
		}

		$wp_query = new \WP_Query($args); ?>
		<div class="widget kivicare-widget-menu mb-0 ">
			<div class="list-inline iq-widget-menu">
				<ul class="kivicare-post">
					<?php
					$genre = '';
					if ($wp_query->have_posts()) :
						while ($wp_query->have_posts()) : $wp_query->the_post();
							
							$wp_object = wp_get_post_terms(get_the_ID(), 'category');
							if (!empty($wp_object)) {
								$k = 1;
								foreach ($wp_object as $val) {

									if ($k == 1)
										$genre = $val->name;
									else
										$genre .= ', ' . $val->name;
									$k++;
								}
							}
							$img_url = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()), "medium"); ?>
							<li class="mr-0 mb-2 pb-0 d-block">
								<div class="post-img">
									<div class="post-img-holder">
										<a class="img-height" href="<?php echo esc_url(get_permalink()); ?>">
											<img src='<?php echo esc_url($img_url, 'kivicare'); ?>' alt=<?php esc_attr_e("image",'kivicare') ?>/>
										</a>
									</div>
									<div class="post-blog pt-2 pb-2 pr-2">
										<div class="blog-box">
											<a class="new-link" href="<?php echo esc_url(get_permalink()); ?>">
												<h6><?php the_title(); ?></h6>
											</a>

											<ul class="list-inline kivicare-category-list">
												<li class="list-inline-item">
													<span><?php echo esc_html(rtrim($genre, ",")); ?></span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>

						<?php endwhile;
						wp_reset_postdata();
					else :
						echo '<p class="no-result">' . esc_html__('No Results Found', 'kivicare') . '</p>';
					endif; ?>
				</ul>
			</div>
		</div>
		<?php
		// $tot = $wp_query->found_posts;
		$total_pages = $wp_query->max_num_pages;
		if ($total_pages > 1) { ?>
			<button type="submit" class="hover-buttons btn w-100"><?php esc_html_e('More Results', 'kivicare'); ?></button>
		<?php }
		die();
	}

	public function ajax_fetch()
	{ ?>
		<script type="text/javascript">
			var debounce_fn = _.debounce(fetchResults, 500, false);

			function fetchResults(input) {
				let keyword = input.value;
				if (jQuery(input).parents('header').length == 0) {
					return false
				}
				if (keyword == "") {
					jQuery(input).siblings('.datafetch').html('');
				} else {
					jQuery.ajax({
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						type: 'post',
						data: {
							action: 'data_fetch',
							keyword: keyword,
							is_include: 'posts',
						},
						success: function(data) {
							jQuery(input).siblings('.datafetch').html(data);
						}
					});
				}
			}
		</script>
		<?php
	}

	// ** search load more *//
	public function kivicare_loadmore_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';

		query_posts($args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				get_template_part('template-parts/content/entry_search', get_post_type());
			endwhile;

		endif;
		die;
	}

	//** blog load more *//
	public function kivicare_loadmore_blog_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';

		query_posts($args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				get_template_part('template-parts/content/entry', get_post_type());
			endwhile;

		endif;
		die;
	}

	public function  kivicare_loadmore_archive_ajax_handle()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['posts_per_page'] = $_POST['availablepost'];
		$args['paged'] = $_POST['page'] + 1;

		if (have_posts()) {
			while (have_posts()) {
				the_post(); ?>
				<article id="post-<?php the_ID(); ?>" class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 wl-child archive-media">
					<div class="block-images position-relative watchlist-img">
						<?php
						$kivicare_options = get_option('kivicare-options'); ?>
						
						<div class="block-description">
							<h6 class="kivicare-title">
								<a href="<?php echo esc_url(get_the_permalink()); ?>">
									<?php the_title(); ?>
								</a>
							</h6>
							<div class="movie-time d-flex align-items-center my-2">
								<span class="text-white"><?php echo get_the_date(); ?></span>
							</div>
							<div class="hover-buttons">
								<a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-hover kivicare-button">
									<i class="fas fa-play mr-1" aria-hidden="true"></i>
									<?php esc_html_e('Play Now', 'kivicare') ?>
								</a>
							</div>
						</div>
						<div class="block-social-info">
							<ul class="list-inline p-0 m-0 music-play-lists">
								<?php if (isset($kivicare_options['kivicare_display_social_icons'])) {
									if ($kivicare_options['kivicare_display_social_icons'] == 'yes') {
								?>
										<li class="share">
											<span><i class="ri-share-fill"></i></span>
											<div class="share-box">
												<svg width="15" height="40" viewBox="0 0 15 40" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M14.8842 40C6.82983 37.2868 1 29.3582 1 20C1 10.6418 6.82983 2.71323 14.8842 0H0V40H14.8842Z" fill="#191919" />
												</svg>
												<div class="d-flex align-items-center">
													<a href="https://www.facebook.com/sharer?u=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ri-facebook-fill"></i></a>
													<a href="http://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php echo get_the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ri-twitter-fill"></i></a>
													<a href="#" data-link='<?php get_permalink(get_the_ID()); ?>' class="share-ico kivicare-copy-link"><i class="ri-links-fill"></i></a>
												</div>
											</div>
										</li>
								<?php }
								} ?>
							</ul>
						</div>
					</div>
				</article>
				<?php
			}
		}
		wp_die();
	}

	public function kivicare_loadmore_product_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';
		$is_grid = $_POST['is_grid'] != 'true' ? 'listing' : 'grid';
		$is_switch = isset($_POST['is_switch']) && $_POST['is_switch'] == 'true' ? true : false;

		if ($is_switch) {
			for ($args['paged'] = 1; $args['paged'] <= $_POST['page']; $args['paged']++) {
				query_posts($args);
				if (have_posts()) :
					while (have_posts()) : the_post();

						get_template_part('template-parts/wocommerce/entry', $is_grid);

					endwhile;

				endif;
			}
		} else {
			query_posts($args);
			if (have_posts()) :
				while (have_posts()) : the_post();
					get_template_part('template-parts/wocommerce/entry', $is_grid);
				endwhile;
			endif;
		}
		die;
	}
	/**
	 * Returns the related Product 
	 * @param int $post_id
	 * @param bool $show_related_product
	 * arg for show the related product or 
	 * @param string $title
	 * @param array $post_type_to_show_related_product
	 * array of perticular post type to show related product
	 * @return string|null return all related product with html rendered.
	 */
	public static function kivicare_related_prodcuct($post_id, $post_type_to_show_related_product ,  $title = "Related Product" ,$show_related_product = false)
	{
		$products = get_post_meta($post_id, 'related_product', true);
		if (empty($products) ||   $show_related_product != 'yes' || !in_array(get_post_type(), $post_type_to_show_related_product)) {
			return;
		}

		$array = array();

		foreach ($products as $item) {
			$array[] = wc_get_product($item);
		}
		$args['related_products'] = $array;
		$args['name'] = $title;

		?>
		<div class="woocommerce kivicare-related-product">
			<?php
			wc_set_loop_prop('columns', 4);
			wc_get_template('single-product/related.php', $args);
			?>
		</div> <?php
	}

	function ajax_qty_cart()
	{
		// Set item key as the hash found in input.qty's name
		$cart_item_key = $_POST['hash'];

		// Get the array of values owned by the product we're updating
		$threeball_product_values = WC()->cart->get_cart_item($cart_item_key);

		// Get the quantity of the item in the cart
		$threeball_product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

		// Update cart validation
		$passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity);

		// Update the quantity of the item in the cart
		if ($passed_validation) {
			WC()->cart->set_quantity($cart_item_key, $threeball_product_quantity, true);

			wp_send_json_success(array('quantity' => WC()->cart->get_cart_contents_count()));
		}

		// Refresh the page
		wp_send_json_error();
	}
}
