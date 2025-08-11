<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$tabs2 = $this->get_settings_for_display('tabs2');

$image_html = '';

$align = $settings['alignment'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$align .= ' iq-box-shadow';
}

$this->add_render_attribute('iq-section', 'class', $align);
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

if ($settings['st_design_style'] == '1') {		?>

	<div class="iq-title-box-slider owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
		<?php
		foreach ($tabs as $index => $item) {

			if (!empty($item['st_link']['url'])) {
				$url = $item['st_link']['url'];
				$this->add_render_attribute('iq_class', 'href', esc_url($url));

				if ($item['st_link']['is_external']) {
					$this->add_render_attribute('iq_class', 'target', '_blank');
				}

				if ($item['st_link']['nofollow']) {
					$this->add_render_attribute('iq_class', 'rel', 'nofollow');
				}
				$url = '';
			}

			if ($item['media_style'] == 'image') {
				if (!empty($item['image']['url'])) {
					$this->add_render_attribute('image', 'src', $item['image']['url']);
					$this->add_render_attribute('image', 'srcset', $item['image']['url']);
					$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($item['image']));
					$this->add_render_attribute('image', 'title', Control_Media::get_image_title($item['image']));
					$image_html = Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'image');
				}
			}

			if ($item['media_style'] == 'icon') {
				$image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($item['selected_icon']['value']));
			}
		?>
			<div class="text-slider-content  <?php echo esc_attr($align); ?>">
				<?php echo $image_html;  ?>
				<<?php echo esc_attr($item['title_tag']);  ?> class="iq-title iq-heading-title">
					<?php echo wp_kses($item['section_title'], array('br' => true)); ?>
				</<?php echo esc_attr($item['title_tag']); ?>>

				<?php
				if (!empty($item['description']) && $item['has_description'] == 'yes') {
					echo sprintf('<p class="iq-title-desc">%1$s</p>', $this->parse_text_editor($item['description']));
				}
				?>
			</div>
		<?php $image_html = '';
		}
		?>
	</div> <?php

		}

		if ($settings['st_design_style'] == '2') { ?>

	<div class="iq-title-box-slider-two owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
		<?php
			foreach ($tabs2 as $index => $item) { ?>
			<div class="iq-service-slider">
				<?php
				if ($item['st_media_style2'] === 'image') {

					if (!empty($item['st_image2']['url'])) { ?>

						<div class="slider-img">
							<img src="<?php echo esc_attr($item['st_image2']['url']); ?>" alt="markethon-image" />
						</div>
					<?php
					}
				}

				if ($item['st_media_style2'] == 'icon') { ?>
					<div class="slider-img">
						<?php
						$image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($item['st_icon2']['value']));
						echo $image_html;
						?>
					</div>
				<?php
				} ?>

				<div class="slider-text">
					<div class="slider-info">
						<<?php echo esc_attr($item['title_tag2']);  ?> class="iq-title iq-heading-title">
							<?php echo wp_kses($item['st_title_2'], array('br' => true)); ?>
						</<?php echo esc_attr($item['title_tag2']); ?>>
						<?php

						if (!empty($item['st_subtitle_2'])) {
							echo sprintf('<p class="slider-desc mb-0">%1$s</p>', $this->parse_text_editor($item['st_subtitle_2']));
						} ?>

					</div>

					<a <?php echo $this->get_render_attribute_string('iq_class') ?>>
						<?php
						if (!empty($item['st_button_text'])) {
							echo esc_html($item['st_button_text']);
						}   ?>
						<?php
						Icons_Manager::render_icon($item['st_button_icon'], ['aria-hidden' => 'true', 'class' => 'feature-icon']);  ?>
					</a>

				</div>
			</div>
		<?php
				$image_html = '';
			}  ?>
	</div>
<?php

}
