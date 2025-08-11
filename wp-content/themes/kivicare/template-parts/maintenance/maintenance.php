<?php
get_template_part('template-parts/maintenance/header');
$kivicare_options = get_option('kivi_options');

if ($kivicare_options['maintenance_radio'] == 1) {

	if (isset($kivicare_options['maintenance_bg_image']['url'])) {
		$m_bgurl = $kivicare_options['maintenance_bg_image']['url'];
	}
?>
	<div class="container-fluid">
		<div class="row">
			<div class="maintenance col-sm-12" <?php if (!empty($m_bgurl)) { ?> style="background: url(<?php echo esc_url($m_bgurl); ?> );" <?php } ?>>
				<h2 class="mb-3">
					<?php
					$maintenance_title = $kivicare_options['maintenance_title'];
					echo esc_html($maintenance_title);
					?>
				</h2>
				<p>
					<?php
					$mainten_desc = $kivicare_options['mainten_desc'];
					echo esc_html($mainten_desc);
					?>
				</p>
			</div>
		</div>
	</div>
<?php
}

if (isset($kivicare_options['maintenance_radio']) && $kivicare_options['maintenance_radio'] == 2) {
?>
	<div class="container-fluid">
		<div class="row">
			<?php
			if (isset($kivicare_options['coming_soon_bg_image']['url'])) {
				$coming_bgurl = $kivicare_options['coming_soon_bg_image']['url'];
			}
			?>
			<div class="iq-coming text-center col-sm-12" <?php if (!empty($coming_bgurl)) { ?> style="background: url(<?php echo esc_url($coming_bgurl); ?> );" <?php } ?>>
				<div class="iq-maintenance-text">
					<h1 class="mb-3">
						<?php
						$coming_title = $kivicare_options['coming_title'];
						echo esc_html($coming_title); ?>
					</h1>
					<p>
						<?php $coming_desc = $kivicare_options['coming_desc'];
						echo esc_html($coming_desc); ?>
					</p>
				</div>
				<?php
				if (!empty($kivicare_options['opt_date'])) {
					$date = $kivicare_options['opt_date'];
					$date = date_create_from_format('m/d/Y', $date);
					$date = $date->format('F d,Y');
				?>
				<div class="expire_date" id="<?php echo esc_attr($date); ?>"></div>
					<ul class="example mb-0 pl-0 countdown">
						<li><span class="days"><?php echo esc_html__('00', 'xamin'); ?></span>
							<p class="days_text"><?php esc_html_e("   ", 'xamin'); ?></p>
						</li>

						<li><span class="hours"><?php echo esc_html__('00', 'xamin'); ?></span>
							<p class="hours_text"><?php esc_html_e("Hours", 'xamin'); ?></p>
						</li>

						<li><span class="minutes"><?php echo esc_html__('00', 'xamin'); ?></span>
							<p class="minutes_text"><?php esc_html_e("Minutes", 'xamin'); ?></p>
						</li>

						<li><span class="seconds"><?php echo esc_html__('00', 'xamin'); ?></span>
							<p class="seconds_text"><?php esc_html_e("Seconds", 'xamin'); ?></p>
						</li>
					</ul>
			</div>
		<?php
				}
		?>
		</div>
	</div>
<?php
}
get_template_part('template-parts/maintenance/footer');
