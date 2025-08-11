<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$progress_bar = $this->get_settings_for_display('progress_bar');
$align = '';

$settings = $this->get_settings();
if ($settings['iqonic_has_box_shadow'] == 'yes') {

  $align .= ' iq-box-shadow';
}

if ($settings['design_style'] == 1) {
?>
  <div class="iq-progressbar-box iq-progressbar-style-1 <?php echo esc_attr($align); ?>">
    <?php foreach ($progress_bar as $index => $item) {
    ?>
      <div class="iq-progressbar-content">
        <span class="progress-title">
          <?php echo sprintf('%1$s', esc_html($item['section_title'])); ?>
        </span>
        <span class="progress-value">
          <?php
          echo esc_html($item['tab_score']['size']);
          echo esc_html($item['tab_score']['unit']);
          ?>
        </span>
        <div class="iq-progress-bar">
          <span data-percent="<?php echo esc_attr($item['tab_score']['size']); ?>" class="show-progress"></span>
        </div>

      </div>
    <?php } ?>
  </div>
<?php }
if ($settings['design_style'] == 2) {
?>

  <div class="iq-progressbar-box iq-progressbar-style-2 <?php echo esc_attr($align); ?>">
    <?php foreach ($progress_bar as $index => $item) {
    ?>
      <div class="iq-progressbar-content">
        <div class="iq-progress-bar">
          <span class="show-progress progress-bar-striped" data-percent="<?php echo esc_attr($item['tab_score']['size']); ?>">
            <span class="progress-title"><?php echo sprintf('%1$s', esc_html($item['section_title'])); ?></span>
            <span class="progress-value"><?php echo esc_html($item['tab_score']['size']) . '%'; ?> </span>
          </span>

        </div>

      </div>
    <?php } ?>
  </div>
<?php }

if ($settings['design_style'] == 3) {
?>

  <div class="iq-progressbar-box iq-progressbar-style-3 <?php echo esc_attr($align); ?>">
    <?php foreach ($progress_bar as $index => $item) {
    ?>
      <div class="iq-progressbar-content">

        <span class="progress-title"><?php echo sprintf('%1$s', esc_html($item['section_title'])); ?></span>


        <div class="iq-progress-bar">
          <span class="show-progress" data-percent="<?php echo esc_attr($item['tab_score']['size']); ?>">
            <span class="progress-value"><?php echo esc_html($item['tab_score']['size']) . '%'; ?> </span>
          </span>

        </div>

      </div>
    <?php } ?>
  </div>
<?php } ?>