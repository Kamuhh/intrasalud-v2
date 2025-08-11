<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$tabs = $this->get_settings_for_display('tabs');
$align = $settings['align'];

if($align == "text-left") {
    $align = "text-start";
} elseif($align == "text-right") {
    $align = "text-end";
}

$align .= ' iq-' . $settings['list_column'] . '-column';

if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

if ($settings['list_style'] == 'unorder') {
?>
    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ul class="iq-unoreder-list">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li class="kivicare-list-all">
                    <?php echo esc_html($item['tab_title']); ?>
                </li>

            <?php  }
            ?>
        </ul>
    </div>

<?php }
if ($settings['list_style'] == 'order') {
?>
    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ol class="iq-order-list">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li class="kivicare-list-all">
                    <?php echo esc_html($item['tab_title']); ?>
                </li>
            <?php  }
            ?>
        </ol>
    </div>

<?php }
if ($settings['list_style'] == 'icon') {
?>
    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ul class="iq-list-with-icon">
            <?php

            foreach ($tabs as $index => $item) {
            ?>
                <li class="kivicare-list-all">
               <?php  if (isset($settings['selected_icon'])) {
                        Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                    } ?>
                    <?php echo esc_html($item['tab_title']); ?>
                </li>

            <?php  }
            ?>
        </ul>
    </div>

<?php }
if ($settings['list_style'] == 'image') {
?>
    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ul class="iq-list-with-img">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li class="kivicare-list-all">
                    <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="lists-img">
                    <?php echo esc_html($item['tab_title']); ?>
                </li>

            <?php  }
            ?>
        </ul>
    </div>

<?php } ?>