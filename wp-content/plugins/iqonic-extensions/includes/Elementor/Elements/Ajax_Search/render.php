<?php

namespace Elementor;

$html = '';
if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
?>

<div class="iq-ajax-search ">
    <a href="javascript:void(0);" class="search-toggle device-search active ">
        <?php \Elementor\Icons_Manager::render_icon($settings['search_icon'], ['aria-hidden' => 'true']); ?>
    </a>
    <div class="search-box iq-search-bar d-search active">
        <form method="get" class="search-form search__form" action="<?php echo esc_url(home_url()) ?>" autocomplete="off">
            <input type="search" class="search-field search__input" placeholder="<?php echo  esc_attr__('Search', 'iqonic') ?>" value="" name="s">
            <input type="hidden" name="ajax_search" value="true">
            <button type="submit" class="search-submit">
                <i class="fa fa-search" aria-hidden="true"></i>
                <span class="screen-reader-text">
                    <?php echo esc_html__('Search', 'iqonic') ?>
                </span>
            </button>
            <div class="datafetch"></div>
        </form>
    </div>
</div>