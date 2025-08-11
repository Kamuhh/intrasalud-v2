<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$align = '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {
	$align .= ' iq-box-shadow';
}

$image_html = '';

if ($settings['counter_style'] == 'image') {
	if (!empty($settings['image']['url'])) {
		$this->add_render_attribute('image', 'src', $settings['image']['url']);
		$this->add_render_attribute('image', 'srcset', $settings['image']['url']);
		$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
		$this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
		$image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
	}
}

if ($settings['counter_style'] == 'icon') {
	$image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['selected_icon']['value']));
}

if ($settings['design_style'] == '1') {
	$align .= ' iq-counter-style-1';
}

if ($settings['design_style'] == '2') {
	$align .= ' iq-counter-style-2';
}

if ($settings['design_style'] == '1') {
    ?>
	<div class="iq-counter <?php echo esc_attr($align); ?>">
		<?php
		if ($settings['counter_style'] != 'none') {
		    ?>
			<div class="iq-counter-icon">
				<?php echo $image_html; ?>
			</div>
		    <?php
		}
		?>
		<div class="counter-content">
			<p class="iq-counter-info">
				<span class="timer" data-to="<?php echo  sprintf('%1$s', esc_attr($settings['content'])); ?>" data-speed="5000">
					<?php echo sprintf('%1$s', esc_html($settings['content'])); ?>
				</span>
				<span class="counter-after-content">
					<?php echo sprintf('%1$s', esc_html($settings['content_after_text'])); ?>
				</span>
				<span class="counter-symbol">
					<?php echo sprintf('%1$s', esc_html($settings['content_symbol'])); ?>
				</span>
			</p>
			<?php if (!empty($settings['section_title'])) { ?>
				<<?php echo esc_attr($settings['title_tag']); ?> class="counter-title-text iq-heading-title">
					<?php echo sprintf('%1$s', esc_html($settings['section_title'])); ?>
				</<?php echo esc_attr($settings['title_tag']); ?>>
			<?php } if ((!empty($settings['description']))) { ?>
				<p class="counter-content-text"><?php echo esc_html($settings['description']); ?></p>
			<?php  } ?>
		</div>
	</div>
    <?php
}

if ($settings['design_style'] == '2') {
    ?>
	<div class="iq-counter <?php echo esc_attr($align); ?>">

		<?php if($settings['counter_style'] != 'none') { ?>
			<div class="iq-counter-icon">
				<?php echo $image_html; ?>
			</div>
		<?php } ?>

		<div class="counter-content">
			<p class="iq-counter-info">
				<span class="timer" data-to="<?php echo  sprintf('%1$s', esc_attr($settings['content'])); ?>" data-speed="5000">
					<?php echo sprintf('%1$s', esc_html($settings['content'])); ?>
				</span>
				<span class="counter-after-content">
					<?php echo sprintf('%1$s', esc_html($settings['content_after_text'])); ?>
				</span>
				<span class="counter-symbol">
					<?php echo sprintf('%1$s', esc_html($settings['content_symbol'])); ?>
				</span>
			</p>
			<?php
			if (!empty($settings['section_title'])) {
			?>
				<<?php echo esc_attr($settings['title_tag']); ?> class="counter-title-text iq-heading-title">
					<?php echo sprintf('%1$s', esc_html($settings['section_title'])); ?>
				</<?php echo esc_attr($settings['title_tag']); ?>>

			<?php }
			if ((!empty($settings['description']))) {
			?>
				<p class="counter-content-text"><?php echo esc_html($settings['description']); ?></p>
			<?php  } ?>
		</div>
	</div>
<?php }
