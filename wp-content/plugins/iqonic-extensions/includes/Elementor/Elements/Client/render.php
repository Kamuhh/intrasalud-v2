<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$tabs = $this->get_settings_for_display('tabs');
$col = 'iq-client-col-3';

$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

if ($settings['iq_client_list_hover_shadow'] == 'yes') {
	$align .= " iq-has-shadow";
}
if ($settings['iq_client_list_hover_grascale'] == 'yes') {
	$align .= " iq-has-grascale";
}
if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$align .= ' iq-box-shadow';
}  ?>

<div class="iq-client iq-client-style-2 <?php echo esc_attr($align) ?>">

	<?php
	if ($settings['client_style'] === "slider") {
		$desk = $settings['desk_number'];
		$lap = $settings['lap_number'];
		$tab = $settings['tab_number'];
		$mob = $settings['mob_number'];

		$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
		$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
		$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
		$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
		$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
		$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
		$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
		$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
		$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
		$this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
		$this->add_render_attribute('slider', 'data-centermode', $settings['centermode']);
	?>

		<div id="my-carousel" class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
			<?php
			foreach ($tabs as $index => $item) {
			?>
				<div class="item iq-client-box">
					<div class="iq-client-img">
						<img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php esc_attr_e('client-image', 'iqonic'); ?>" />
					</div>
					<div class="iq-client-info">
						<?php
						if (!empty($item['clinet_name'])) {
						?>
							<h5 class="iq-heading-title"><?php echo esc_html($item['clinet_name']); ?></h5>
						<?php } ?>
						<p><?php echo esc_html($item['description']) ?></p>
					</div>
				</div>
			<?php
			}
			?>
		</div>

		<?php } else {

		if ($settings['client_style'] === "2") {
			$col = 'iq-client-col-2';
		}
		if ($settings['client_style'] === "3") {
			$col = 'iq-client-col-3';
		}
		if ($settings['client_style'] === "4") {
			$col = 'iq-client-col-4';
		}
		if ($settings['client_style'] === "5") {
			$col = 'iq-client-col-5';
		}
		if ($settings['client_style'] === "6") {
			$col = 'iq-client-col-6';
		}
		echo '<ul class="' . esc_attr($col) . ' iq-client-grid">';
		foreach ($tabs as $index => $item) {
		?>
			<li class="<?php echo esc_attr($align); ?>">

				<img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php esc_attr_e('client-image', 'iqonic'); ?>" />

				<?php
				if (!empty($item['clinet_name'])) {
				?>
					<h5 class="iq-heading-title"><?php echo esc_html($item['clinet_name']); ?></h5>
				<?php } ?>
				<p><?php echo esc_html($item['description']); ?></p>

			</li>
	<?php
		}
		echo '</ul>';
	} ?>
</div>