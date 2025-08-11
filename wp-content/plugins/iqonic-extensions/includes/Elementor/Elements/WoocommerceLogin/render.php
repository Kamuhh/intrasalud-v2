<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
global $kivicare_options;

?>
<div class="kivicare-woocommerce-custom-form">
    <?php if (isset($kivicare_options['header_radio']) && $kivicare_options['header_radio'] == 1) { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            if (!empty($kivicare_options['header_text'])) { ?>
                <h1 class="logo-text"><?php echo esc_html($kivicare_options['header_text']); ?></h1>
            <?php
            } ?>
        </a> <?php
            } else if ($settings['kivicare_has_logo'] == "yes") { ?>

        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
            <?php
                if (function_exists('get_field') && class_exists('ReduxFramework')) {
                    $key = get_field('key_header');

                    if (!empty($key['header_logo']['url'])) {
                        $logo = $key['header_logo']['url']; ?>
                    <img class="img-fluid logo" src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr_e('kivicare', 'kivicare'); ?>">
                <?php
                    } else if (isset($kivicare_options['kivi_logo']['url']) && !empty($kivicare_options['kivi_logo']['url'])) {
                        $logo = $kivicare_options['kivi_logo']['url']; ?>
                    <img class="img-fluid logo" src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr_e('kivicare', 'kivicare'); ?>">
                <?php
                    } else { ?>
                    <img class="img-fluid logo test" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('kivicare', 'kivicare'); ?>">
                <?php
                    }
                } else { ?>
                <img class="img-fluid logo test1" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('kivicare', 'kivicare'); ?>">
            <?php
                } ?>
        </a>
        <?php
            }

            if ($settings['woocommerce_login_form'] == 'signup-form') { /* signup form */

                if ($settings['signin_link_type'] == 'dynamic') {
                    $url = get_permalink(get_page_by_path($settings['signin_dynamic_link']));
                    $this->add_render_attribute('kivicare_class', 'href', esc_url($url));
                } else {
                    if ($settings['signin_link']['url']) {
                        $url = $settings['signin_link']['url'];
                        $this->add_render_attribute('kivicare_class', 'href', esc_url($url));

                        if ($settings['signin_link']['is_external']) {
                            $this->add_render_attribute('kivicare_class', 'target', '_blank');
                        }

                        if ($settings['signin_link']['nofollow']) {
                            $this->add_render_attribute('kivicare_class', 'rel', 'nofollow');
                        }
                    }
                }

                $text_string = $settings['signin_text_string'];
                $button_text = $settings['signin_button_text'];

                if (!is_user_logged_in()) {
                    echo do_shortcode('[iqonic-signup-form btn_text_string="' . $text_string . '" button_text="' . $button_text . '" url="' . $url . '" ]');
                } else { ?>

            <p class="logged-in"> <?php esc_html_e('Note: You are already logged in to your account', 'iqonic'); ?> </p>
        <?php
                }
            } elseif ($settings['woocommerce_login_form'] == 'login-form') { /* login form */

                if ($settings['link_type'] == 'dynamic') {
                    $url = get_permalink(get_page_by_path($settings['dynamic_link']));
                    $this->add_render_attribute('kivicare_class', 'href', esc_url($url));
                } else {
                    if ($settings['link']['url']) {
                        $url = $settings['link']['url'];
                        $this->add_render_attribute('kivicare_class', 'href', esc_url($url));

                        if ($settings['link']['is_external']) {
                            $this->add_render_attribute('kivicare_class', 'target', '_blank');
                        }

                        if ($settings['link']['nofollow']) {
                            $this->add_render_attribute('kivicare_class', 'rel', 'nofollow');
                        }
                    }
                }

                $text_string = $settings['button_text_string'];
                $button_text = $settings['button_text'];

                $forgot_password_string = $settings['forgot_password_text'];

                if ($settings['forgot_password_link_type'] == 'dynamic') {
                    $forgot_password_url = get_permalink(get_page_by_path($settings['forgot_password_dynamic_link']));
                    $this->add_render_attribute('kivicare_class', 'href', esc_url($forgot_password_url));
                } else {
                    if ($settings['forgot_password_link']['url']) {
                        $forgot_password_url = $settings['forgot_password_link']['url'];
                        $this->add_render_attribute('kivicare_class', 'href', esc_url($forgot_password_url));

                        if ($settings['forgot_password_link']['is_external']) {
                            $this->add_render_attribute('kivicare_class', 'target', '_blank');
                        }

                        if ($settings['forgot_password_link']['nofollow']) {
                            $this->add_render_attribute('kivicare_class', 'rel', 'nofollow');
                        }
                    }
                }
                if (!is_user_logged_in()) {
                    echo do_shortcode('[iqonic-login-form btn_text_string="' . $text_string . '" button_text="' . $button_text . '" url="' . $url . '" lost_password_string="' . $forgot_password_string . '" lost_password_url="' . $forgot_password_url . '" ]');
                } else { ?>

            <p class="logged-in"> <?php esc_html_e('Note: You are already logged in to your account', 'iqonic'); ?> </p>
    <?php
                }
            } elseif ($settings['woocommerce_login_form'] == 'track-order') { /* order tracking */

                if (is_user_logged_in()) {
                    echo do_shortcode('[woocommerce_order_tracking]');
                } else {
                    echo '<span class="d-block">' . esc_html__('Note: Please sign in to your account.', 'iqonic') . '</span>';
                }
            } elseif ($settings['woocommerce_login_form'] == 'lost-password') { /* order tracking */

                if (!is_user_logged_in()) {

                    echo do_shortcode('[iqonic-lost-password-form]');
                } else {

                    esc_html_e('Note: You are already logged in to your account', 'iqonic');
                }
            }
    ?>
</div>