<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$this->add_render_attribute('iq-class', 'class', 'scrolling-text');
$unique_id = uniqid (rand());  ?>

<div <?php echo $this->get_render_attribute_string('iq-class'); ?>  id="iq-text<?php echo $unique_id; ?>">

    <div class="iq-test">
        <?php echo esc_html($settings['stext_title']); ?>
    </div>

</div>
