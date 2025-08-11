<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$posts = get_posts(
	array(
		'post_type'   		=> 'mc4wp-form',
		'post_status'       => 'publish',
	)
);
?>
<div class="kivicare-mailchimp-<?php echo esc_attr($settings['mailchimp_style']); ?>">
	<?php
	foreach ($posts as $res) {
		if (!empty($res)) {
			echo do_shortcode('[mc4wp_form id=' . $res->ID . ']');
		}
	}
	?>
</div>