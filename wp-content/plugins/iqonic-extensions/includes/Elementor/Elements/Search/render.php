<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
$unique_id = esc_html(uniqid('search-form-'));
?>

<div class="search_wrap <?php if ($settings['layout'] == 'default') { esc_attr_e('search-form-default'); } ?> search_style_<?php echo esc_attr($settings['style']); ?>">
    <div class="search_form_wrap">
        <?php if (  $settings['layout'] == 'modern' ) { ?>
            <div class="search_count">
                <a href="javascript:void(0);" class="btn-search ">
                    <?php
                    if ($settings['use_search_Text'] == 'yes' && $settings['use_search_position'] == 'before' && !empty($settings['search_text'])) {
                        echo '<span class="search-text">' . esc_html($settings['search_text']) . '</span>';
                    }
                    if ($settings['show_search_icon'] == "yes") {
                        Icons_Manager::render_icon($settings['search_icon'], ['aria-hidden' => 'true']);
                    }
                    if ($settings['use_search_Text'] == 'yes' && $settings['use_search_position'] == 'after' && !empty($settings['search_text'])) {
                        echo '<span class="search-text">' . esc_html($settings['search_text']) . '</span>';
                    }
                    ?>
                </a>
                <div class="kivicare-search">
                    <button class="btn btn-search-close btn--search-close" aria-label="Close search form">
                        <i class="fa fa-times"></i>
                    </button>
                    <form method="get" class="search-form search__form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="form-search">
                            <input type="hidden" value="<?php if (!empty($settings['post_types'])) { echo esc_attr(is_array($settings['post_types']) ? join(',', $settings['post_types']) : $settings['post_types']); } ?>" name="post_types">
                            <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field search__input" name="s" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>" />
                            <button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <form method="get" class="search-form search__form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="form-search">
                    <input type="hidden" value="<?php
                        if (!empty($settings['post_types'])) {
                            echo esc_attr(is_array($settings['post_types']) ? join(',', $settings['post_types']) : $settings['post_types']);
                        }
                        ?>" name="post_types">
                    <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field search__input" name="s" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>" />
                    <button type="submit" class="search-submit">
                        <?php if ($settings['show_search_icon'] == "yes") { ?>
                            <i class="fa fa-search" aria-hidden="true"></i>
                        <?php } ?>
                    </button>
                </div>
            </form>
        <?php } ?>
    </div>
</div>