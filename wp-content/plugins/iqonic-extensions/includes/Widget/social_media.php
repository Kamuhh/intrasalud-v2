<?php

function iqonic_social_media_widgets()
{
	register_widget('iq_socail_media');
}
add_action('widgets_init', 'iqonic_social_media_widgets');

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_socail_media extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'iq_socail_media',

			// Widget name will appear in UI
			esc_html('Iqonic Social Media', 'iqonic'),

			// Widget description
			array('description' => esc_html('Iqonic social media. ', 'iqonic'),)
		);
	}

	// Creating widget front-end

	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? $instance['title'] : false;
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		/* here add extra display item  */

		global  $kivicare_options;
		if (isset($kivicare_options['social-media-iq'])) {
			$top_social = $kivicare_options['social-media-iq'];
            ?>
			<ul class="info-share">
				<?php
				if (!empty($title)) { ?>
					<li>
						<?php
						if ($title) {
							echo ('<span>' .  $title . '</span>');
						}
						?>
					</li>
				<?php
				} ?>
				<?php
				foreach ($top_social as $key => $value) {
					if ($value) { ?>
						<li>
							<a target="_blank" href="<?php echo $value; ?>">
								<i class="fab fa-'<?php echo $key; ?>"></i>
						    </a>
						</li> <?php
					}
				}
				?>
			</ul>
		<?php
		}
	}
	// Widget Backend 
	public function form($instance)
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : ''; ?>
		<p>
			<label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>">
			    <?php esc_html_e('Title:', 'iqonic'); ?>
			</label>
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
