<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
?>

<div class="kivicare-working-hours">

<?php if(!empty($settings['working_title'])){ ?>
	<h3 class="contact-info iq-heading-title"><?php echo esc_html($settings['working_title']); ?></h3>
<?php } ?>
	<div class="row">
		<div class="col-sm-12">
			<ul class="iq-contact">

			    <?php if( !empty($settings['label_weekdays']) || !empty($settings['time_weekdays']) ) {  ?>
					<li class="iq-week weekdays">
						<?php if(!empty($settings['label_weekdays'])){ ?>
						    <span class="iq-week-day"><?php echo esc_html($settings['label_weekdays']); ?></span>
					    <?php } ?>
						<?php if(!empty($settings['time_weekdays'])){ ?>
						    <span class="iq-time"><?php echo esc_html($settings['time_weekdays']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_monday']) || !empty($settings['time_monday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_monday'])){ ?>
						    <span class="iq-week-day"><?php echo esc_html($settings['label_monday']); ?></span>
					    <?php } ?>
						<?php if(!empty($settings['time_monday'])){ ?>
						    <span class="iq-time"><?php echo esc_html($settings['time_monday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_tuesday']) || !empty($settings['time_tuesday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_tuesday'])){ ?>
							<span class="iq-week-day"><?php echo esc_html($settings['label_tuesday']); ?></span>
						<?php } ?>
						<?php if(!empty($settings['time_tuesday'])){ ?>
							<span class="iq-time"><?php echo esc_html($settings['time_tuesday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_wednesday']) || !empty($settings['time_wednesday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_wednesday'])){ ?>
							<span class="iq-week-day"><?php echo esc_html($settings['label_wednesday']); ?></span>
						<?php } ?>
						<?php if(!empty($settings['time_wednesday'])){ ?>
							<span class="iq-time"><?php echo esc_html($settings['time_wednesday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_thursday']) || !empty($settings['time_thursday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_thursday'])){ ?>
							<span class="iq-week-day"><?php echo esc_html($settings['label_thursday']); ?></span>
						<?php } ?>
						<?php if(!empty($settings['time_thursday'])){ ?>
							<span class="iq-time"><?php echo esc_html($settings['time_thursday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_friday']) || !empty($settings['time_friday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_friday'])){ ?>
							<span class="iq-week-day"><?php echo esc_html($settings['label_friday']); ?></span>
						<?php } ?>
						<?php if(!empty($settings['time_friday'])){ ?>
							<span class="iq-time"><?php echo esc_html($settings['time_friday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_saturday']) || !empty($settings['time_saturday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_saturday'])){ ?>
							<span class="iq-week-day"><?php echo esc_html($settings['label_saturday']); ?></span>
						<?php } ?>
						<?php if(!empty($settings['time_saturday'])){ ?>
							<span class="iq-time"><?php echo esc_html($settings['time_saturday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>

				<?php if( !empty($settings['label_sunday']) || !empty($settings['time_sunday']) ) {  ?>
					<li class="iq-week monday">
						<?php if(!empty($settings['label_sunday'])){ ?>
							<span class="iq-week-day"><?php echo esc_html($settings['label_sunday']); ?></span>
						<?php } ?>
						<?php if(!empty($settings['time_sunday'])){ ?>
							<span class="iq-time"><?php echo esc_html($settings['time_sunday']); ?></span>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
			<?php 
			require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			?>
		</div>
	</div>
</div>