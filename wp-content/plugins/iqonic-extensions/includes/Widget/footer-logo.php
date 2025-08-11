<?php
function iqonic_footer_logo_widgets()
{
	register_widget('iq_footer_logo');
}
add_action('widgets_init', 'iqonic_footer_logo_widgets');

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_footer_logo extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'iq_footer_logo',

			// Widget name will appear in UI
			esc_html('Iqonic Footer Logo', 'iqonic'),

			// Widget description
			array('description' => esc_html('Iqonic logo. ', 'iqonic'),)
		);
	}

	// Creating widget front-end

	public function widget($args, $instance)
	{

		if (! isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		global $wp_registered_sidebars;

		$key = get_field('footer_logo');

		global  $kivicare_options;
		$title = (! empty($instance['title'])) ? $instance['title'] : '';
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		if (get_field('acf_key_footer_switch') != 'default') { ?>
			<div class="footer-logo mb-4">
				<a href="<?php echo esc_url(home_url('/')); ?>"> 
					<?php if (!empty($key['url'])) {
						$iq_logo_img = $key['url'];
						}
						if (isset($iq_logo_img) && !empty($iq_logo_img)) {
						$footer_logo = $kivicare_options['logo_footer']['url'];  ?>
						<img class="img-fluid" src="<?php echo esc_url($iq_logo_img); ?>" alt="<?php esc_attr_e('logo', 'iqonic'); ?>"><?php
						} else { ?>
						<img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php esc_attr_e('iq-acf-logo', 'iqonic'); ?>"> <?php
						} ?>
				</a>
			</div> <?php
				} else { ?>
			<div class="footer-logo mb-4">
				<a href="<?php echo esc_url(home_url('/')); ?>"> <?php
						if (isset($kivicare_options['logo_footer']['url'])) {
						$footer_logo = $kivicare_options['logo_footer']['url'];  ?>
						<img class="img-fluid" src="<?php echo esc_url($footer_logo); ?>" alt="<?php esc_attr_e('logo', 'iqonic'); ?>"> <?php
					} else { ?>
					<img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php esc_attr_e('logo', 'iqonic'); ?>"> <?php
					} ?>
				</a>
			</div> <?php
				}
			}

			// Widget Backend 
			public function form($instance)
			{
				$title    = isset($instance['title']) ? esc_attr($instance['title']) : ''; ?>
		<p>
			<label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>"><?php esc_html_e('Title:', 'iqonic'); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('title', 'iqonic')); ?>" type="text" value="<?php echo esc_html($title, 'iqonic'); ?>" />
		</p> <?php
			}

			// Updating widget replacing old instances with new
			public function update($new_instance, $old_instance)
			{
				$instance = array();
				$instance['title'] = sanitize_text_field($new_instance['title']);
				return $instance;
			}
		} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/