<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';
$settings = $this->get_settings_for_display();
$settings = $this->get_settings();
$tab_nav = '';
$tab_nav1 = '';
$tab_content = '';
$image_html = '';

$tabs = $this->get_settings_for_display('tabs');
$id_int = rand(10, 100);
$align = '';
$align = isset($settings['align']) ? $settings['align'] : 'default_value';

$this->add_render_attribute('kivicare_container', 'class', 'kivicare-btn-container');

$icon = '';
$i = 0;
?>


<div class="kivicare-tabs kivicare-tab-horizontal <?php echo esc_attr($align); ?>">
    <div class="row">
        <div class="col-xl-12">
           
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <?php
            foreach ($tabs as $index => $item) {

                if ($i == 0) {
                    $class = "active";
                    $i++;
                } else {
                    $class = "";
                }

                echo  '<li class="nav-item">

                <a class="nav-link ' . esc_attr($class) . '" data-bs-toggle="pill" href="#tabs-' . $index . $id_int . '" role="tab">';

                if (!empty($item['tab_title'])) {
                    echo '
                        <' .  $settings['title_tag']   . ' class="tab-title">' . wp_kses($item['tab_title'], array('br' => true)) . '</' .  $settings['title_tag'] . '>';
                }

                echo '</a></li>';
            }
            ?>
            </ul>
        </div>
    </div>    
    
  
    <div class="tab-content kivicare-inner-box">


        <?php
        $j = 0;
        foreach ($tabs as $index => $items) {

            if ($j == 0) {
                $class = "active";
                $j++;
            } else {
                $class = "";
            }
            
            echo '<div class="tab-pane animated fadeIn ' . esc_attr($class) . '" id="tabs-' . $index . $id_int . '" role="tabpanel">';
                      ?>

                    <div class="row align-items-center">

                           <?php
                        if(!empty($items['contentimage']['url'])){
                           ?>
                            <div class="col-lg-6 pe-lg-5">
                                <div class=" tab-image">
                                    <img src="<?php echo esc_url($items['contentimage']['url']) ?>" alt="tab-img" />
                                </div>
                            </div> 
                            <div class="col-lg-6 ps-lg-5">
                           <?php
                        } else {
                            ?>
                            <div class="col-lg-12">
                                <?php
                        }
                            ?>

                            <div class="tab-details">
                                <?php
                                echo '<h4 class="tab-title-desc">' . esc_html__($items['tab_title_desc']) . '</h4>';
                                if (!empty($items['tab_content'])) { ?> <p class="tab-detail-desc"> <?php
                                    echo $this->parse_text_editor($items['tab_content']);?> </p> <?php 
                                }

                                if (!empty($items['link']['url'])) {
                                    $url = $items['link']['url'];

                                    if ($items['link']['nofollow']) {
                                        $this->add_render_attribute('kivicare_class', 'rel', 'nofollow');
                                    }
                                    if ($items['link']['is_external']) {
                                        $this->add_render_attribute('kivicare_class', 'target', '_blank');
                                    }
                                }

                                $target = '';
                                $rel = '';

                                if ($items['link_type'] == 'dynamic') {

                                    $url =  get_permalink(get_page_by_path($items['dynamic_link']));

                                } else {
                                    
                                    if (!empty($items['link']['url'])) {

                                        $url = $items['link']['url'];
                                        
                                        if ($items['link']['is_external']) {
                                            $target =  'target = "_blank"';
                                        }

                                        if ($items['link']['nofollow']) {
                                            $rel =  'rel = "nofollow"';
                                        }
                                    }
                                }
                                
                                if( !empty($items['button_text']) ){ ?>

                                    <div class="iq-btn-container">
                                        <a class="iq-button iq-btn-link yes btn-icon-right" href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($rel); ?>>
                                            <?php echo esc_html($items['button_text']) ?> <i aria-hidden="true" class="ion ion-plus"></i>
                                        </a>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>

                </div>
            <?php
            echo '</div>';
        } ?>

    </div>
</div>