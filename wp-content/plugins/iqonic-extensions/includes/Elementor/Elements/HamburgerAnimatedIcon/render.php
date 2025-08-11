<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$class = '';
if($settings['Hamburger_style'] == 'style1'){
    $class = 'burger-one';
} elseif($settings['Hamburger_style'] == 'style2'){
    $class = 'burger-two';
} elseif($settings['Hamburger_style'] == 'style3'){
    $class = 'burger-three';
}


if ($settings['link']['url']) {
	$url = $settings['link']['url'];
	$this->add_render_attribute('kivicare_class', 'href', esc_url($url));

	if ($settings['link']['is_external']) {
		$this->add_render_attribute('kivicare_class', 'target', '_blank');
	}

	if ($settings['link']['nofollow']) {
		$this->add_render_attribute('kivicare_class', 'rel', 'nofollow');
	}
}

$url = '';

?>

<div class="hamburger-icon possion">
	<a class="kivicare-hamburger-icon" <?php echo $this->get_render_attribute_string('kivicare_class') ?>>
		<div class="burger-menu-style <?php echo esc_attr($class); ?>">
			<div></div>
		</div>
	</a>
</div>

