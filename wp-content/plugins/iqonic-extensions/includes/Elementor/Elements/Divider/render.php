<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$align .= ' iq-box-shadow';
}

if ($settings['design_style'] == "1") {
?>
	<div class="iq-divider iq-divider-style-1 <?php echo esc_attr($align); ?>">
		<div class="iq-divider-left">
		</div>
	</div>
<?php
}

if ($settings['design_style'] == "2") {
?>
	<div class="iq-divider iq-divider-style-2 <?php echo esc_attr($align); ?>">
		<div class="iq-divider-left"></div>
		<div class="iq-divider-center">
			<?php
			if (!empty($settings['selected_icon']['value'])) {
			?>
				<span class="iq-divider-icon">
					<i class="<?php echo esc_attr($settings['selected_icon']['value']); ?>"></i>
				</span>
			<?php
			}
			if (!empty($settings['section_title'])) {
			?>
				<h6 class="iq-divider-title">
					<?php echo esc_html($settings['section_title']); ?>
				</h6>
			<?php } ?>
		</div>
		<div class="iq-divider-right"></div>
	</div>
<?php
}
