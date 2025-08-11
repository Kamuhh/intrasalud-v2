<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$chart = $this->get_settings_for_display('chart');;
$settings = $this->get_settings();

$this->add_render_attribute('progress_attr', 'data-value', $settings['chart_percentage_data']);
$this->add_render_attribute('progress_attr', 'data-background', $settings['empty_color']);
$this->add_render_attribute('progress_attr', 'data-color', $settings['progress_color']);
$this->add_render_attribute('progress_attr', 'data-speed', $settings['speed']);

$this->add_render_attribute('progress_attr', 'data-size', $settings['size']);
$this->add_render_attribute('progress_attr', 'data-ratio', $settings['widthRatio']);
$this->add_render_attribute('progress_attr', 'data-angle', $settings['start_angle']);
$this->add_render_attribute('progress_attr', 'data-linecap', $settings['linecap']);
$this->add_render_attribute('progress_attr', 'data-direction', $settings['direction']);

?>
<div class="iq-circle-chart">
	<div class="circleChart" <?php echo $this->get_render_attribute_string('progress_attr') ?>></div>

	<?php if($settings['show_section_title'] == "yes") { ?>
		<div class="kivicare-section-title">
			<span class="sub-title">
				<?php echo esc_html($settings['circle_subtitle']); ?>
			</span>
			<h2 class="title">
				<?php echo esc_html($settings['circle_title']); ?>
			</h2>
		</div>
	<?php } ?>
</div>
