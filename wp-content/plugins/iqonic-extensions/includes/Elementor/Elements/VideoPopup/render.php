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
$video_url = '';

$icon = '';
if ($settings['video_type'] == 'hosted') {
	$video_url = $settings['hosted_url']['url'];
}
if ($settings['video_type'] == 'video_link') {
	$video_url = $settings['link_url'];
}

if ($settings['media_style'] == 'image') {
	$icon = '<img class="hover-img" src="' . esc_url($settings['image_icon']['url']) . '" alt="fancybox">';
}
if ($settings['media_style'] == 'icon') {
	$icon = sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($settings['selected_icon']['value']));
}
?>

<div class="iq-popup-video">
	<div class="iq-video-img position-relative">
		<div class="iq-video-icon wow FadeIn">
			<a href="<?php echo esc_url($video_url); ?>" class="iq-video popup-youtube">
				<?php echo $icon; ?>
			</a>
			<div class="iq-waves">
				<div class="waves wave-1"></div>
				<div class="waves wave-2"></div>
				<div class="waves wave-3"></div>
			</div>
		</div>
	</div>
</div>