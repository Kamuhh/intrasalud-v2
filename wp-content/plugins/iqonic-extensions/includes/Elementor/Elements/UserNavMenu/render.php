<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$user_login = false;

if (is_user_logged_in()) {
    $user_login = true;
}

// This Condition For User Preview
if (Plugin::$instance->editor->is_edit_mode()) {
    $user_login = $settings['user_login'];
}

if ($user_login) {
    $current_user = wp_get_current_user();
    $get_avatar = get_the_author_meta('kivicare_profile_image', $current_user->ID);
    if (empty($get_avatar)) {
        $get_avatar = get_avatar_url($current_user->ID);
    }
    $nav_title = !empty(trim($settings['title_after_login'])) ? esc_html($settings['title_after_login']) : '';
} else {
    $nav_title = !empty(trim($settings['title_before_login'])) ? esc_html($settings['title_before_login']) : '';
}
?>
<div class="kivicare-users-settings user-btn nav-item nav-icon header-user-rights kivicare-usermenu-dropdown">
    <div class="nav-item nav-icon dropdown-hover">
       
        <a href="javascript:void(0);" class=" nav-link dropdown-open dropdown-toggle p-0 align-items-center d-flex">
            <?php
            if (!$user_login || $settings['user_avatar_fix'] || $settings['avatar_type'] == 'none') {
                if ($settings['avatar_type'] == 'image') {
                    $this->add_render_attribute('avatar-image', 'src', $settings['avatar_image']['url']);
                    $this->add_render_attribute('avatar-image', 'alt', Control_Media::get_image_alt($settings['avatar_image']));
                    $this->add_render_attribute('avatar-image', 'title', Control_Media::get_image_title($settings['avatar_image']));
                    $this->add_render_attribute('avatar-image', 'class', "img-fluid kivicare-avatar-image");
                    echo "<img " . $this->get_render_attribute_string('avatar-image') . ">";
                }
                if ($settings['avatar_type'] == 'icon') {
                    echo '<span class="kivicare-avatar-icon">';
                    Icons_Manager::render_icon($settings['avatar_icon'], ['aria-hidden' => 'true']);
                    echo '</span>';
                }
            } else {
            ?>
                <img src="<?php echo esc_url($get_avatar) ?>" class="img-fluid kivicare-avatar-image" alt="user">
            <?php
            }
            if (!empty($nav_title)) {
                echo "<span class='user-nav-title'>$nav_title</span>";
            }
            ?>
        </a>
        <?php if (!$user_login) { ?>
            <div class="kivicare-sub-dropdown kivicare-user-dropdown dropdown-menu">             
                <div class="kivicare-card shadow-none m-0">
                    <div class="kivicare-card-body p-0 ps-3 pe-3">
                        <?php
                        if ($settings['list_user_non_login']) {
                            foreach ($settings['list_user_non_login'] as $item) {
                                $url = ($item['list_page_link']) ? get_the_permalink(get_page_by_path($item['list_page_link'])) : '#';
                        ?>
                                <a href="<?php echo  esc_url($url); ?>" class="kivicare-list-link kivicare-sub-card <?php echo esc_attr($settings['use_ajax'] == 'yes' ? 'ajax-effect-link' : '') ?>">

                                    <div class="media align-items-center">

                                        <?php if (!empty($item['list_icon']['value'])) { ?>
                                            <div class="right-icon">
                                                <?php Icons_Manager::render_icon($item['list_icon'], ['aria-hidden' => 'true', 'class' => 'kivicare-user-list-icon']); ?>
                                            </div>
                                        <?php } ?>

                                        <div class="media-body ms-3">
                                            <span class="m-0 ">
                                                <?php echo esc_html($item['list_title']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="kivicare-sub-dropdown kivicare-user-dropdown dropdown-menu">             
                <div class="kivicare-card shadow-none m-0">
                    <div class="kivicare-user-list-item kivicare-card-body p-0 ps-3 pe-3">
                        <?php
                        if ($settings['list_user']) {
                            foreach ($settings['list_user'] as $item) {
                                $url = ($item['list_page_link']) ? get_the_permalink(get_page_by_path($item['list_page_link'])) : '#';
                        ?>
                                <a href="<?php echo $item['is_logout'] != 'yes' ? esc_url($url) : wp_logout_url(home_url()) ?>" class="kivicare-list-link  kivicare-sub-card <?php echo esc_attr($settings['use_ajax'] == 'yes' ? 'ajax-effect-link' : '') ?>">

                                    <div class="media align-items-center">

                                        <?php if (!empty($item['list_icon']['value'])) { ?>
                                            <div class="right-icon">
                                                <?php Icons_Manager::render_icon($item['list_icon'], ['aria-hidden' => 'true', 'class' => 'kivicare-user-list-icon']); ?>
                                            </div>
                                        <?php } ?>

                                        <div class="media-body ms-3">
                                            <span class="m-0 ">
                                                <?php echo esc_html($item['list_title']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>