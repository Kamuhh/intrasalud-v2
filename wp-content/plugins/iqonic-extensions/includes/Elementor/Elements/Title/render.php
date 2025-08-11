<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$image_html = '';

$align = isset($settings['align']) ? $settings['align'] : '';


if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

$responsive = '';

if (empty($settings['align'])) {
	$responsive = ' normal-view';
} elseif (empty($settings['align_laptop'])) {
	$responsive = ' laptop-view';
} elseif (empty($settings['align_tablet'])) {
	$responsive = ' tablet-view';
} elseif (empty($settings['align_mobile'])) {
	$responsive = ' tablet-mobile';
}

$this->add_render_attribute('iq-section', 'class', 'iq-title-box');

if ($settings['media_style'] == 'image') {
	if (!empty($settings['image']['url'])) {
		$this->add_render_attribute('image', 'src', $settings['image']['url']);
		$this->add_render_attribute('image', 'srcset', $settings['image']['url']);
		$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
		$this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
		$image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
	}
}

if ($settings['media_style'] == 'icon') {
	$image_html = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['selected_icon']['value']));
}

if ($settings['design_style'] == 1) {
	$this->add_render_attribute('iq-section', 'class', 'iq-title-box-1');
}

if ($settings['titlebox_has_befor'] == 'yes') {
	$this->add_render_attribute('iq-section', 'class', 'iq-befor-line');
}


if ($settings['design_style'] == "1") {
?>
	<div <?php echo $this->get_render_attribute_string('iq-section'); ?>>
		<div class="iq-title-icon">
			<?php echo $image_html; ?>
		</div>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'before') {
			echo sprintf('<span class="iq-subtitle">%1$s</span>', esc_html($settings['sub_title']));
		}
		?>

		<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-title iq-heading-title">
			<?php echo wp_kses($settings['section_title'], array('br' => true)); ?>
		</<?php echo esc_attr($settings['title_tag']); ?>>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'after') {
			echo sprintf('<span class="iq-subtitle">%1$s</span>', esc_html($settings['sub_title']));
		}

		if (!empty($settings['description']) && $settings['has_description'] == 'yes') {
			echo sprintf('<p class="iq-title-desc">%1$s</p>', $this->parse_text_editor($settings['description']));
		}
		?>
	</div>
<?php
}
if ($settings['design_style'] == "3") {
?>
	<div <?php echo $this->get_render_attribute_string('iq-section'); ?>>
		<div class="iq-title-icon">
			<?php echo $image_html; ?>
		</div>

		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'before') {
			echo sprintf('<span class="iq-subtitle">%1$s</span>', esc_html($settings['sub_title']));
		}
		?>
		<<?php echo $settings['title_tag'];  ?> class="iq-title iq-heading-title">
			<span class="right-text"><?php echo wp_kses($settings['section_title'], array('br' => true)); ?></span>
			<span class="left-text"><?php echo wp_kses($settings['section_title_2'], array('br' => true)); ?></span>
		</<?php echo $settings['title_tag']; ?>>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'after') {
			echo sprintf('<span class="iq-subtitle">%1$s</span>', esc_html($settings['sub_title']));
		}

		if (!empty($settings['description']) && $settings['has_description'] == 'yes') {
			echo sprintf('<p class="iq-title-desc">%1$s</p>', $this->parse_text_editor($settings['description']));
		}
		?>
	</div>
   <?php 
}
