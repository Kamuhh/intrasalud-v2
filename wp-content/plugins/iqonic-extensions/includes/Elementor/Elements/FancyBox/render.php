<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$align .= ' iq-box-shadow';
}

$active = $settings['active_onoff'];
if ($active === "yes") {
	$align .= ' active';
}
$image_html = '';

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

$image_html1 = '';

if ($settings['design_style'] == '4') {
?>
	<div class="iq-fancy-box iq-fancy-box-style-4 <?php echo esc_attr($align); ?>">

		<div class="iq-fancy-box-content">
			<div class="iq-img-area">
				<?php echo $image_html; ?>
			</div>
			<?php
			if ($settings['section_title']) {
			?>

				<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-fancy-title iq-heading-title">
					<?php echo sprintf('%1$s', esc_html($settings['section_title'])); ?>
				</<?php echo esc_attr($settings['title_tag']);  ?>>
			<?php } ?>
			<?php
			if ($settings['description']) {
			?>
				<p class="fancy-box-content"> <?php echo sprintf('%1$s', esc_html($settings['description'])); ?> </p>
			<?php } ?>
			<?php if (!empty($settings['button_text'])) {
				require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			} ?>
		</div>
	</div>
<?php
}
else {
?>
	<div class="iq-fancy-box iq-fancy-box-style-7 <?php echo esc_attr($align); ?>">
		<div class="iq-img-area">
			<?php echo $image_html; ?>
		</div>
		<div class="iq-fancy-box-content">
			<?php
			if ($settings['section_title']) {
			?>
				<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-fancy-title iq-heading-title"> 
				<?php echo sprintf('%1$s', esc_html($settings['section_title'])); ?>
				</<?php echo esc_attr($settings['title_tag']);  ?>>

			<?php } ?>
			<?php
			if ($settings['description']) {
			?>
				<p class="fancy-box-content"> <?php echo sprintf('%1$s', esc_html($settings['description'])); ?> </p>
			<?php } ?>

			<?php if (!empty($settings['button_text'])) {
					require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			}  ?>

		</div>
	</div>
<?php
}
