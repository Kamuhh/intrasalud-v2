<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$align .= ' iq-box-shadow';
}
$args = array(
	'post_type'         => 'testimonial',
	'post_status'       => 'publish',
	'suppress_filters'  => 0,
	'posts_per_page'    => -1,
);

$wp_query = new \WP_Query($args);

$out = '';

global $post;

$desk = $settings['desk_number'];
$lap = $settings['lap_number'];
$tab = $settings['tab_number'];
$mob = $settings['mob_number'];

$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
$this->add_render_attribute('slider', 'data-doteach', $settings['dot_each']);

if ($settings['design_style'] == 1  || $settings['design_style'] == 2) {
	$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
	$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
	$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
	$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
	$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
} elseif($settings['design_style'] == 3 || $settings['design_style'] == 4) {
	$this->add_render_attribute('slider', 'data-items', '1');
	$this->add_render_attribute('slider', 'data-items-laptop', '1');
	$this->add_render_attribute('slider', 'data-items-tab', '1');
	$this->add_render_attribute('slider', 'data-items-mobile', '1');
	$this->add_render_attribute('slider', 'data-items-mobile-sm', '1');
}

$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
$this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
$this->add_render_attribute('slider', 'data-centermode', $settings['centermode']);

if ($settings['design_style'] == 1) {
	$align .= ' iq-testimonial-1';
}
if ($settings['design_style'] == 2) {
	$align .= ' iq-testimonial-2';
}
if ($settings['design_style'] == 3) {
	$align .= ' iq-testimonial-3';
}
if ($settings['design_style'] == 4) {
	$align .= ' iq-testimonial-4 ';
}

if($settings['design_style'] == 4 && $settings['use_seprator'] == 'yes'){
	$align .= 'has-seprator';
}

remove_filter('the_content', 'wpautop');

$image_html = '';

if ($settings['media_style'] == 'image') {
	if (!empty($settings['image']['url'])) {
		$this->add_render_attribute('image', 'src', $settings['image']['url']);
		$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
		$this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
		$image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
	}
}

?>
<div class="iq-testimonial kivicare-testimonial-style-1 <?php echo esc_attr($align); ?>">

    <?php if ($settings['display_quote'] == 'yes' && $settings['design_style'] == 3) { ?>
		<div class="iq-testimonial-quote">
			<?php if(!empty($image_html)){ echo $image_html; } ?>
			<?php
			if ($settings['media_style'] == 'icon') {
				\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
			} ?>
		</div>
	<?php	} ?>

	<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
		<?php
		if ($wp_query->have_posts()) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				if (function_exists('get_field')) {
					$key =  get_field('key_pjros12', get_the_ID());
					$designation  = $key['iqonic_testimonial_designation'];
					$company  = $key['iqonic_testimonial_company'];
					$star  = $key['star_select'];
				}

				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");

				if ($settings['design_style'] == 1) {
		            ?>
					<div class="iq-testimonial-info">
						<div class="iq-testimonial-content">

							<p><?php the_content($wp_query->ID); ?></p>
							<?php if ($settings['display_quote'] == 'yes') { ?>
								<div class="iq-testimonial-quote">
								<?php if(!empty($image_html)){ echo $image_html; } ?>
									<?php
									if ($settings['media_style'] == 'icon') {
										\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
									} ?>
								</div>
							<?php	} ?>
						</div>

						<div class="iq-testimonial-member">

							<div class="iq-testimonial-avtar">
								<img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
							</div>

							<div class="avtar-name">
								<div class="iq-lead">
									<?php the_title($wp_query->ID); ?>
								</div>
								<?php if (function_exists('get_field')) { ?>
								<span class="iq-post-meta">
									<?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?>
								</span>
								<?php } ?>
							</div>

						</div>
					</div>
				      <?php
				}
				if ($settings['design_style'] == 2) {
				      ?>
					<div class="iq-testimonial-info">
						<div class="iq-testimonial-avtar">
							<img alt="#" class="img-fluid rounded-circle" src="<?php echo esc_url($full_image[0]); ?>">
						</div>
						<div class="iq-testimonial-member">
							<?php if ($settings['display_quote'] == 'yes') { ?>
								<div class="iq-testimonial-quote">
								<?php if(!empty($image_html)){ echo $image_html; } ?>
									<?php
									if ($settings['media_style'] == 'icon') {
										\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
									} ?>
								</div>
							<?php	} ?>
							<h5 class="content"><?php the_title($wp_query->ID); ?></h5>
							<span class="sub-title"><span class="content-sub me-2 ms-2">-</span>
							<?php if (function_exists('get_field')) { ?>
								<?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?>
								<?php } ?>
							</span>
						</div>

						<p><?php the_content($wp_query->ID);  ?></p>
					</div>
		              <?php
				}

				if ($settings['design_style'] == 3 || $settings['design_style'] == 4) { 
					 ?>
                    
					<div class="kivicare-slider slider__item">
						<div class="kivicare-main-slider">

						   <?php if($settings['design_style'] == 3){ ?>
								<div class="kivicare-slider_top">
									<?php echo sprintf('<div class="testimonial-slider-img"><img src="%1$s"  alt="iqonic-user"/></div>', esc_url($full_image[0], 'iqonic')); ?>
								</div>
							<?php } ?>
						
							<div class="kivicare-slider_content">

							<?php if ($settings['display_quote'] == 'yes') { ?>
								<div class="iq-testimonial-quote">
								<?php if(!empty($image_html)){ echo $image_html; } ?>
									<?php
									if ($settings['media_style'] == 'icon') {
										\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
									} ?>
								</div>
							<?php	} ?>
							
								<div class="text-dec">
									<p><?php echo sprintf("%s", get_the_content($wp_query->ID)); ?></p> 
								</div>

								<?php if (function_exists('get_field')) { ?>
								<div class="kivicare-post-ratings">
									<?php
									for ($i = 1; $i < 6; $i++) {
										if ($i > $star) {
										?>
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.71938 5.89299L9.83364 6.19117L10.1522 6.21292L14.7699 6.5283L11.209 9.66486L10.9817 9.86504L11.0539 10.1592L12.2126 14.8841L8.27125 12.2961L7.99681 12.1159L7.72237 12.2961L3.78105 14.8841L4.9398 10.1592L5.01187 9.86527L4.78494 9.6651L1.22878 6.5283L5.84145 6.21292L6.16 6.19114L6.27424 5.89299L7.99681 1.39742L9.71938 5.89299Z" stroke="#F9A620"/>
											</svg>
											<?php
										} else {
											?>
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 6.11115L10.1863 5.71409L7.99681 0L5.80734 5.71409L0 6.11115L4.45419 10.0401L2.99256 16L7.99681 12.714L13.0011 16L11.5395 10.0401L16 6.11115Z" fill="#F9A620"/></svg>
											<?php
										}
									}
									?>
								</div>
								<?php } ?>

								<div class="kivicare-lead">
									<?php if($settings['iqonic_avatar_image'] == 'yes') { ?>
								        <div class="iq-testimonial-avtar">
								 			 <img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
							  			</div>
							 		 <?php } ?>
									<div class="kivicare-user-info">
										<h4>
											<?php the_title($wp_query->ID); ?>
										</h4>
										<p class="kivicare-testimonial-user">
											<?php if (function_exists('get_field')) { ?>
											<span class="kivicare-designation">
												<?php echo  sprintf("%s", esc_html($designation, 'iqonic')); ?>
											</span>
											<?php } ?>
										</p>
									</div>
								</div>
							</div>

						</div>
					</div>
					 <?php

				}
			}
			wp_reset_postdata();
		}
		   ?>
	</div>
</div>