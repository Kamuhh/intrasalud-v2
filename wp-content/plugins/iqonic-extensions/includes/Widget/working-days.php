<?php
function iqonic_working_days()
{
	register_widget('iq_working');
}
add_action('widgets_init', 'iqonic_working_days');

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_working extends WP_Widget
{
	public $days;

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'iq_working',

			// Widget name will appear in UI
			esc_html('Iqonic Working Days', 'iqonic'),

			// Widget description
			array('description' => esc_html('Iqonic Working Days', 'iqonic'),)
		);
		$this->days = array(
			"weekdays",
			"monday",
			"tuesday",
			"wednesday",
			"thursday",
			"Friday",
			"saturday",
			"sunday"
		);
	}

	// Creating widget front-end

	public function widget($args, $instance)
	{

		global $wp_registered_sidebars;

		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? $instance['title'] : false;
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		/* here add extra display item  */  ?>
		<div class="widget">
			<?php
			if ($title && !empty($title)) {
			?>
				<h4 class="footer-title contact-info iq-heading-title"><?php echo esc_html($title); ?></h4>
			<?php
			} ?>
			<div class="row">
				<div class="col-sm-12">
					<ul class="iq-contact">
						<?php
						foreach ($this->days as $val) {
							$value = isset($instance[$val]) ? $instance[$val] : false;
							if ($value) {
						?>
								<li class="iq-week">
									<span class="iq-week-day"><?php echo esc_html(ucfirst($val)); ?></span>
									<span class="iq-time"><?php echo esc_html($value); ?></span>
								</li>
						<?php
							}
						} ?>
					</ul>
				</div>
			</div>
		</div>
	<?php
	}
	// Widget Backend 
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : ''; ?>

		<p>
			<label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>"><?php esc_html_e('Title:', 'iqonic'); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('title', 'iqonic')); ?>" type="text" value="<?php echo esc_html($title, 'iqonic'); ?>" />
		</p>
		<?php
		foreach ($this->days as $val) {
			$value    = isset($instance[$val]) ? $instance[$val] : false; ?>
			<p>
				<label for="<?php echo esc_html($this->get_field_id($val, 'iqonic')); ?>">
					<?php esc_html_e($val . ':', 'iqonic'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_html($this->get_field_id($val, 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name($val, 'iqonic')); ?>" type="text" value="<?php echo esc_html($value, 'iqonic'); ?>" />
			</p>
<?php
		}
	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = sanitize_text_field($new_instance['title']);
		foreach ($this->days as $val) {
			$instance[$val] = isset($new_instance[$val]) ?  $new_instance[$val] : false;
		}
		return $instance;
	}
}
