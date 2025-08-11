<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
$lists = $this->get_settings_for_display('list');
$i = 1;
$j = 1;
?>

<div class="service-container iq-price-container">
    <div class="row kivicare-service-list align-items-start">
        <div class="col-lg-12 col-md-12">
            <div class="process-step-wrapper">
                <div class="media-body">
                    <div class="switch">
                        <div class="switch-content"> <?php
                            foreach ($lists as $item) { ?>
                                <?php if (!empty($item['list_title'])) { ?>
                                    <h5 class="service-name" data-price="price-<?php echo esc_attr($j) ?>">
                                        <?php echo esc_html($item['list_title']) ?>
                                    </h5> <?php
                                    $j++;
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">               
            <div class="price-wrapper"> <?php
                foreach ($lists as $item) { ?>
                    <div class="price-content price-<?php echo esc_attr($i) ?>"> <?php
                            $iq_shortcode = do_shortcode(shortcode_unautop($item['list_shortcode']));
                            echo $iq_shortcode; ?>
                    </div> <?php
                    $i++;
                } ?>
            </div>
        </div>
    </div>
</div>