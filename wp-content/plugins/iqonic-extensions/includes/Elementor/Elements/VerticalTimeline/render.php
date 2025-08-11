<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$nav_content = '';
$time_content = '';

$tabs = $this->get_settings_for_display('tabs');
$id_int = rand(10, 100);

$align = isset($settings['align']) ? $settings['align'] : '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {

  $align .= ' kivicare-box-shadow';
}

if ($settings['design_style'] == '2') {
   ?>
  <div class="kivicare-timeline kivicare-timeline-vertical-2 <?php echo esc_attr($align); ?>">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-timeline-section ">
          <div class="conference-center-line"></div>
          <div class="conference-timeline-content">
              <?php
            foreach ($tabs as $index => $item) {
                ?>
                <div class="timeline-article timeline__content">
                  <div class="meta-date">
                      <div class="kivicare-button kivicare-blog-link">
                        <span class="kivicare-main-btn">
                          <span></span>
                          <span class="main one"></span>
                          <span class="main two"></span>
                          <span class="main three"></span>
                        </span>
                      </div>
                  </div>
                  <div class="content-box">
                  <div class="yeardate">
                      <div class="timeline-year"><?php echo esc_html($item['tab_year']); ?></div>
                          <<?php echo $settings['title_tag'] ?> class="timeline-title"><?php echo esc_html($item['tab_title']); ?> </<?php echo $settings['title_tag'] ?>>
                      <p class="timeline-content"><?php echo esc_html($item['tab_content']); ?></p>
                  </div>
                </div>
              </div>
               <?php 
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php

} else { ?>

  <div class="kivicare-timeline kivicare-timeline-vertical-1 <?php echo esc_attr($align); ?>">
    <div class="timeline" id="kivicare-timeline-vertical-1">
      <div class="timeline__wrap">
        <div class="timeline__items">
            <?php
          foreach ($tabs as $index => $item) {
            ?>
            <div class="timeline__item">
              <div class="timeline__content">
                <div class="mediaicon">
                  <div class="media">
                    <?php if ($settings['has_icon'] == 'yes') { ?>
                      <div class="kivicare-button kivicare-blog-link">
                        <span class="kivicare-main-btn">
                          <span></span>
                          <span class="main one"></span>
                          <span class="main two"></span>
                          <span class="main three"></span>
                        </span>
                      </div>
                    <?php } ?>
                    <div class="media-body">
                      <div class="timeline-year"><?php echo esc_html($item['tab_year']); ?></div>
                      <<?php echo $settings['title_tag'] ?> class="timeline-title"><?php echo esc_html($item['tab_title']); ?> </<?php echo $settings['title_tag'] ?>>
                      <p class="timeline-content"><?php echo esc_html($item['tab_content']); ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php 
}
