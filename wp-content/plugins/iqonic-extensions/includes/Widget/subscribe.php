<?php

function iqonic_subscribe_widgets()
{
	register_widget('iq_contact_info');
}
add_action('widgets_init', 'iqonic_subscribe_widgets');

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_contact_info extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'iq_contact_info',

			// Widget name will appear in UI
			esc_html('Iqonic Subscribe', 'iqonic'),

			// Widget description
			array('description' => esc_html('Iqonic subscribe. ', 'iqonic'),)
		);
	}

	// Creating widget front-end

	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? esc_html($instance['title']) : esc_html('', 'iqonic');
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
		if (!$number) {
			$number = 5;
		}
?>

		<div class="widget">
			<?php
			if ($title) {
				echo ($args['before_title'] . $title . $args['after_title']);
			}
			$posts = get_posts(array('post_type'   => 'mc4wp-form'));
			echo do_shortcode('[mc4wp_form id=' . $posts[0]->ID . ']');
			?>
		</div>
	<?php

	}

	// Widget Backend 
	public function form($instance)
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
	?>
		<p>
			<label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>"><?php esc_html_e('Title:', 'iqonic'); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('title', 'iqonic')); ?>" type="text" value="<?php echo esc_html($title, 'iqonic'); ?>" />
		</p>
<?php

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
