<?php

namespace Iqonic_Layouts\Admin\Classes;


class Iqonic_Layouts_Admin
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'iqonic_enqueue_admin_script'));

        //layout post columns
        add_filter('manage_iqonic_hf_layout_posts_columns', array($this, 'iqonic_hf_layout_posts_columns'), 10, 1);
        add_action('manage_iqonic_hf_layout_posts_custom_column', array($this, 'iqonic_hf_layout_posts_custom_column'), 10, 2);

        //menu meta
        add_action('wp_nav_menu_item_custom_fields', array($this, 'iqonic_menu_item_options'), 10, 2);
        add_action('wp_update_nav_menu_item', array($this, 'iqonic_save_menu_item_options'), 10, 2);
        add_filter('wp_nav_menu_objects', array($this, 'custom_nav_menu_badge'), 10, 1);
    }
    public function iqonic_enqueue_admin_script($hook)
    {
        if ('nav-menus.php' == $hook) {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('iqonic-menu', plugin_dir_url(__DIR__) . 'assets/js/menu.js', array(), '1.0');
        }
    }
    // Layout admin Column Header
    public function iqonic_hf_layout_posts_columns($columns)
    {
        $columns = array(
            'cb'        => $columns['cb'],
            'title'     => 'Title',
            'type'      => 'Type',
            'shortcode' => 'Shortcode',
            'date'      => 'Date'
        );
        return $columns;
    }

    //Layout admin Column Content
    function iqonic_hf_layout_posts_custom_column($column, $post_id)
    {

        if (sanitize_title('type') === $column) {
            echo ucfirst(get_post_meta($post_id, '_layout_meta_key', true));
        }
        if (sanitize_title('shortcode') === $column) {
            echo '<code>[iqonic_layout id="' . $post_id . '"]</code>';
        }
    }
    function iqonic_menu_item_options($item_id, $item)
    {
        $is_megamenu = get_post_meta($item_id, '_is_megamenu', true);
        $is_selected_megamenu = get_post_meta($item_id, '_is_selected_megamenu', true);
        $is_megamenu = !empty($is_megamenu) ? 'checked=checked' : '';
        $menu_item_badge = get_post_meta($item_id, '_menu_item_badge', true);
        $badge_color = get_post_meta($item_id, '_item_badge_color', true);
        $badge_text_color = get_post_meta($item_id, '_badge_text_color', true);

        // Varibale For Menu Height
        $menu_item_height = get_post_meta($item_id, '_menu_item_height', true);
        $default_selected_height = ($menu_item_height === 'default') ? 'checked=checked' : '';
        $custom_selected_height = ($menu_item_height === 'custom') ? 'checked=checked' : '';
        $menu_height= get_post_meta($item_id, '_menu_custom_height', true);

        // Variable For Menu item Padding And Bg Color
        $menu_padding = get_post_meta($item_id, 'menu_item_padding_input', true);
        $menu_bg_color = get_post_meta($item_id, 'mega_menu_color_bg', true);

        $menu_item_width = get_post_meta($item_id, '_menu_item_width', true);
        $default_selected = ($menu_item_width === 'default') ? 'checked=checked' : '';
        $full_width_selected = ($menu_item_width === 'full-width') ? 'checked=checked' : '';
        $custom_selected = ($menu_item_width === 'custom') ? 'checked=checked' : '';
        $menu_width = get_post_meta($item_id, '_menu_custom_width', true);
        $megamenu_list = iqonic_addons_get_list_layouts(false, 'mega_menu');
?>
        <div style="clear: both;margin: 10px 0;display: block;float: left;">
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id; ?>" />
            <div class="megamenu-holder" style="border-top:1px solid #aaa;">
                <div class="megamenu-check" style="margin: 15px 0;width: 100%;">
                    <input type="checkbox" name="enable_megamenu[<?php echo $item_id; ?>]" id="enable-megamenu-<?php echo $item_id; ?>" class="enable-megamenu" value="1" <?php echo esc_attr($is_megamenu); ?> /><?php esc_html_e("Enable Megamenu", "iqonic-layouts"); ?>
                </div>
                <div class="megamenu-select" style="margin: 10px 0;<?php echo empty($is_megamenu) ? 'display:none' : ''; ?>">
                    <select name="selected_megamenu[<?php echo $item_id; ?>]" style="width: 100%;">
                        <?php
                        if ($megamenu_list) :
                            echo '<option value="">' . esc_html__('select', 'iqonic-layouts') . '</option>';
                            foreach ($megamenu_list as $value => $label) :
                                $selected = ($value == $is_selected_megamenu) ? 'selected="selected"' : '';
                        ?>
                                <option value="<?php echo $value; ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                        <?php
                            endforeach;
                        else :
                            echo '<option value="">' . esc_html__('No record found', 'iqonic-layouts') . '</option>';
                        endif;
                        ?>
                    </select>
                    <?php echo esc_html__("Create", 'iqonic-layouts') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'iqonic-layouts') . "</a>" ?>
                </div>
                <div class="megamenu-width-container" style="margin: 10px 0;<?php echo empty($is_megamenu) ? 'display:none' : ''; ?>">
                    <div class="width-wrap">
                        <span class="label"><?php esc_html_e("Megamenu Width", 'iqonic'); ?></span>
                        <div class="width-container" style="display: flex;align-items: center;margin: 5px 0;">
                            <div class="default-width" style="margin-right: 10px;">
                                <input type="radio" name="menu_item_width[<?php echo $item_id; ?>]" id="menu-item-width-<?php echo $item_id; ?>" class="default-width-radio" value="default" <?php echo esc_attr($default_selected); ?> /><?php esc_html_e("Default", "iqonic-layouts"); ?>
                            </div>
                            <div class="full-width" style="margin-right: 10px;">
                                <input type="radio" name="menu_item_width[<?php echo $item_id; ?>]" id="menu-item-full-width-<?php echo $item_id; ?>" class="default-width-radio" value="full-width" <?php echo esc_attr($full_width_selected); ?> /><?php esc_html_e("Full Width", "iqonic-layouts"); ?>
                            </div>
                            <div class="custom-width">
                                <input type="radio" name="menu_item_width[<?php echo $item_id; ?>]" id="menu-item-custom-width-<?php echo $item_id; ?>" class="custom-width-radio" value="custom" <?php echo esc_attr($custom_selected); ?> /><?php esc_html_e("Custom", "iqonic-layouts"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="custom-width-input-holder" style="margin: 5px 0;">
                        <span class="label" style="width: 100%;display: block;margin: 5px 0;"><?php esc_html_e("Menu Width", 'iqonic'); ?></span>
                        <input type="text" style="width: 30%;" name="menu_item_width_input[<?php echo $item_id; ?>]" id="menu-item-width-input<?php echo $item_id; ?>" class="custom-width-input" placeholder="768px" value="<?php echo esc_attr($menu_width); ?>" />
                    </div>
                </div>
                <!-- Mega Menu Height Options -->
                <div class="megamenu-height-container" style="margin: 10px 0;<?php echo empty($is_megamenu) ? 'display:none' : ''; ?>">
                    <div class="height-wrap">
                        <span class="label"><?php esc_html_e("Megamenu Height", 'iqonic'); ?></span>
                        <div class="height-container" style="display: flex;align-items: center;margin: 5px 0;">
                            <div class="default-height" style="margin-right: 10px;">
                                <input type="radio" name="menu_item_height[<?php echo $item_id; ?>]" id="menu-item-height-<?php echo $item_id; ?>" class="default-height-radio" value="default" <?php echo esc_attr($default_selected_height); ?> /><?php esc_html_e("Default", "iqonic-layouts"); ?>
                            </div>
                            <div class="custom-height">
                                <input type="radio" name="menu_item_height[<?php echo $item_id; ?>]" id="menu-item-custom-height-<?php echo $item_id; ?>" class="custom-height-radio" value="custom" <?php echo esc_attr($custom_selected_height); ?> /><?php esc_html_e("Custom", "iqonic-layouts"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="custom-height-input-holder" style="margin: 5px 0;">
                        <span class="label" style="height: 100%;display: block;margin: 5px 0;"><?php esc_html_e("Menu height", 'iqonic'); ?></span>
                        <input type="text" style="height: 30%;" name="menu_item_height_input[<?php echo $item_id; ?>]" id="menu-item-height-input<?php echo $item_id; ?>" class="custom-height-input" placeholder="768px" value="<?php echo esc_attr($menu_height); ?>" />
                    </div>
                </div>
                <!-- Mega Menu Padding And Background Color -->
                <div class="megamenu-padding-container" style="margin: 10px 0;border-top:1px solid #aaa;<?php echo empty($is_megamenu) ? 'display:none' : ''; ?>">
                    <div class="custom-padding-input-holder" style="margin: 5px 0;display:inline-block">
                        <span class="label" style="height: 100%;display: block;margin: 5px 0;"><?php esc_html_e("Mega Menu padding", 'iqonic'); ?></span>
                        <input type="text" style="height: 30%;" name="menu_item_padding_input[<?php echo $item_id; ?>]" id="menu-item-padding-input<?php echo $item_id; ?>" class="custom-height-input" placeholder="768px" value="<?php echo esc_attr($menu_padding); ?>" />
                    </div>
                    <div class="badge-text-color" style="margin : 0 10px;display:inline-block">
                        <span class="badge-label" style="margin-bottom: 5px;display:block;"><?php esc_html_e("Mega Menu Bg Color", 'iqonic'); ?></span>
                        <input type="text" class="widefat iqonic-color-picker" name="mega_menu_color_bg[<?php echo $item_id; ?>]" id="item-badge-text-color-<?php echo $item_id; ?>" value="<?php echo esc_attr($menu_bg_color); ?>" />
                    </div>
                </div>
            </div>
            <div class="logged-input-holder" style="display: flex;border-top:1px solid #aaa;">
                <div class="badge-text" style="margin: 10px 0;">
                    <span class="badge-label" style="margin-bottom: 5px;display:inline-block;"><?php esc_html_e("Badge Text", 'iqonic'); ?></span>
                    <input type="text" style="width: 92%;" name="menu_item_badge[<?php echo $item_id; ?>]" id="menu-item-badge-<?php echo $item_id; ?>" value="<?php echo esc_attr($menu_item_badge); ?>" />
                </div>
                <div class="badge-text-color" style="margin: 10px 0;">
                    <span class="badge-label" style="margin-bottom: 5px;display:inline-block;"><?php esc_html_e("Badge Text Color", 'iqonic'); ?></span>
                    <input type="text" class="widefat iqonic-color-picker" name="badge_text_color[<?php echo $item_id; ?>]" id="item-badge-text-color-<?php echo $item_id; ?>" value="<?php echo esc_attr($badge_text_color); ?>" />
                </div>
                <div class="badge-color" style="margin: 10px 0;">
                    <span class="badge-label" style="margin-bottom: 5px;display:inline-block;"><?php esc_html_e("Badge Background", 'iqonic'); ?></span>
                    <input type="text" class="widefat iqonic-color-picker" name="badge_color[<?php echo $item_id; ?>]" id="item-badge-color-<?php echo $item_id; ?>" value="<?php echo esc_attr($badge_color); ?>" />
                </div>
            </div>
        </div>
<?php
    }
    public function iqonic_save_menu_item_options($menu_id, $menu_item_db_id)
    {
        if (isset($_POST['menu_item_badge'][$menu_item_db_id])) {
            $sanitized_data = sanitize_text_field($_POST['menu_item_badge'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_menu_item_badge', $sanitized_data);
            //badge-text-color
            $sanitized_badge_text = ($_POST['badge_text_color'][$menu_item_db_id] && !empty($_POST['badge_text_color'][$menu_item_db_id])) ? sanitize_text_field($_POST['badge_text_color'][$menu_item_db_id]) : '';
            update_post_meta($menu_item_db_id, '_badge_text_color', $sanitized_badge_text);
            //badge-background-color
            $sanitized_badge_color = ($_POST['badge_color'][$menu_item_db_id] && !empty($_POST['badge_color'][$menu_item_db_id])) ? sanitize_text_field($_POST['badge_color'][$menu_item_db_id]) : '';
            update_post_meta($menu_item_db_id, '_item_badge_color', $sanitized_badge_color);
        } else {
            update_post_meta($menu_item_db_id, '_menu_item_badge', '');
        }
        if (isset($_POST['enable_megamenu'][$menu_item_db_id])) {
            $sanitized_megamenu_checkbox = sanitize_text_field($_POST['enable_megamenu'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_is_megamenu', $sanitized_megamenu_checkbox);
            $sanitized_selected_megamenu = sanitize_text_field($_POST['selected_megamenu'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_is_selected_megamenu', $sanitized_selected_megamenu);
            if (isset($_POST['menu_item_width'][$menu_item_db_id])) {
                $sanitized_width_option = sanitize_text_field($_POST['menu_item_width'][$menu_item_db_id]);
                update_post_meta($menu_item_db_id, '_menu_item_width', $sanitized_width_option);
                if ('custom' === $sanitized_width_option && isset($_POST['menu_item_width_input'][$menu_item_db_id])) {
                    $sanitized_width = !empty($_POST['menu_item_width_input'][$menu_item_db_id]) ? sanitize_text_field($_POST['menu_item_width_input'][$menu_item_db_id]) : '';
                    update_post_meta($menu_item_db_id, '_menu_custom_width', $sanitized_width);
                }
            } else {
                update_post_meta($menu_item_db_id, '_menu_item_width', 'default');
            }
            // Mega Menu height Options
            if (isset($_POST['menu_item_height'][$menu_item_db_id])) {
                $sanitized_height_option = sanitize_text_field($_POST['menu_item_height'][$menu_item_db_id]);
                update_post_meta($menu_item_db_id, '_menu_item_height', $sanitized_height_option);
                if ('custom' === $sanitized_height_option && isset($_POST['menu_item_height_input'][$menu_item_db_id])) {
                    $sanitized_height = !empty($_POST['menu_item_height_input'][$menu_item_db_id]) ? sanitize_text_field($_POST['menu_item_height_input'][$menu_item_db_id]) : '';
                    update_post_meta($menu_item_db_id, '_menu_custom_height', $sanitized_height);
                }
            } else {
                update_post_meta($menu_item_db_id, '_menu_item_height', 'default');
            }


            // Mega Menu  Padding Condition
            if (isset($_POST['menu_item_padding_input'][$menu_item_db_id])) {
                $sanitized_height_option = sanitize_text_field($_POST['menu_item_padding_input'][$menu_item_db_id]);
                update_post_meta($menu_item_db_id, 'menu_item_padding_input', $sanitized_height_option);
            } else {
                update_post_meta($menu_item_db_id, 'menu_item_padding_input', '');
            }
            // Mega Menu  Background Color Condition
            if (isset($_POST['mega_menu_color_bg'][$menu_item_db_id])) {
                $sanitized_height_option = sanitize_text_field($_POST['mega_menu_color_bg'][$menu_item_db_id]);
                update_post_meta($menu_item_db_id, 'mega_menu_color_bg', $sanitized_height_option);
            } else {
                update_post_meta($menu_item_db_id, 'mega_menu_color_bg', '');
            }
        } else {
            update_post_meta($menu_item_db_id, '_is_megamenu', '');
        }
    }
    public function custom_nav_menu_badge($items)
    {
        foreach ($items as $item) {
            $menu_item_badge = get_post_meta($item->ID, '_menu_item_badge', true);
            if (!empty($menu_item_badge)) {
                $badge_color = get_post_meta($item->ID, '_item_badge_color', true);
                $badge_color = !empty($badge_color) ? "background:" . $badge_color : '';
                $badge_text_color = get_post_meta($item->ID, '_badge_text_color', true);
                $badge_text_color = !empty($badge_text_color) ? "color:" . $badge_text_color : '';
                $item->title = '<span class="menu-line"><span class="link-title">' . $item->title . '</span><span class="link-badge" style="' . $badge_color . ';' . $badge_text_color . '">' . $menu_item_badge . '</span></span>';
            }
        }
        return $items;
    }
}
