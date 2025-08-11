<?php
abstract class Layout_Meta_Box
{
    /**
     * Set up and add the meta box.
     */
    public static function add()
    {
        $screens = ['iqonic_hf_layout', 'layout_cpt'];
        foreach ($screens as $screen) {
            add_meta_box(
                'layout_box_id',          // Unique ID
                __('Select Layout', 'iqonic-layouts'), // Box title
                [self::class, 'view'],   // Content callback, must be of type callable
                $screen,                 // Post type
                'side'
            );
        }
    }


    /**
     * Save the meta box selections.
     *
     * @param int $post_id  The post ID.
     */
    public static function save(int $post_id)
    {
        if (array_key_exists('layout_field', $_POST)) {
            update_post_meta(
                $post_id,
                '_layout_meta_key',
                $_POST['layout_field']
            );
        }
    }


    /**
     * Display the meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function view($post)
    {
        $value = get_post_meta($post->ID, '_layout_meta_key', true);
?>
        <select name="layout_field" id="layout_field" class="postbox">
            <option value="header" <?php selected($value, 'header'); ?>><?php _e('Header', 'iqonic-layouts') ?></option>
            <option value="mega_menu" <?php selected($value, 'mega_menu'); ?>><?php _e('Mega Menu', 'iqonic-layouts') ?></option>
            <option value="footer" <?php selected($value, 'footer'); ?>><?php _e('Footer', 'iqonic-layouts') ?></option>
            <option value="custom" <?php selected($value, 'custom'); ?>><?php _e('Custom', 'iqonic-layouts') ?></option>
            <option value="four_zero_four" <?php selected($value, 'four_zero_four'); ?>><?php _e('404', 'iqonic-layouts') ?></option>
            <option value=""><?php _e('Select', 'iqonic-layouts') ?></option>
        </select>
<?php
    }
}

add_action('add_meta_boxes', ['Layout_Meta_Box', 'add']);
add_action('save_post', ['Layout_Meta_Box', 'save']);
