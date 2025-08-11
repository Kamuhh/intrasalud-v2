<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();
$align = $vertical_menu =  '';

$id_int = rand(10, 100);
$menu = 'primary';

if (!empty($settings['menu'])) {
    $menu = $settings['menu'];
}
if ($settings['direction'] === 'vertical') {
    $vertical_menu = ' vertical-menu-layout';
}
if ($settings['has_icon'] == 'yes') {
    $align .= ' iqonic-footer-menu-icon';
}
if (!empty($settings['ft_nav_style'])) {
    $align .= ' ' . $settings['ft_nav_style'];
}
$align = !empty($align) ? trim($align) : '';
?>
<div class="widget-nav-menu <?php echo esc_attr($align); ?>">
    <nav class="navbar deafult-header nav-widget navbar-light p-0 footer-default-menu  <?php echo esc_attr($vertical_menu); ?>">
        <div class="navbar-collapse new-collapse footer-collapse">
            <div class="menu-all-pages-container widget-menu-container">
                <?php
                wp_nav_menu(array(
                    'menu' => $menu,
                    'menu_class' => 'layout-footer-widget footer-menu',
                ));
                ?>
            </div>
        </div>
    </nav>
</div>
<?php
