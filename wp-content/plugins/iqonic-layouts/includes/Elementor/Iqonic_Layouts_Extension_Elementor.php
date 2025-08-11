<?php

namespace Iqonic_Layouts\Elementor;

use Elementor\Plugin;
class Iqonic_Layouts_Extension_Elementor
{
    private $plugin_name;

    private $version;

    protected $used_templates = [];

    protected $used_elements = [];

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('elementor/widget/render_content', array($this, 'widget_assets_on_render'), 11, 2);
    }

    public function elementor_init()
    {
        Plugin::$instance->elements_manager->add_category(
            'iqonic-layouts-extension',
            [
                'title' => esc_html__('Layout', 'iqonic-layouts'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    function widget_assets_on_render($content, $widget)
    {
        $widget_not_in = ['iqonic_navigation', 'iqonic_footer_navigation', 'iqonic_list_navigation', 'iqonic_social_icons', 'iqonic_search'];
        if ($widget->get_categories()[0] == 'iqonic-layouts-extension' && !in_array($widget->get_name(), $widget_not_in)) {
            $all_script_config = (function_exists('get_iqonic_layouts_config')) ? get_iqonic_layouts_config() : '';
            if (isset($all_script_config[$widget->get_name()]['dependency']) && count($all_script_config[$widget->get_name()]['dependency']) > 0) {
                $dir_path = plugin_dir_url(__DIR__) . 'Elementor/';
                $dependency = $all_script_config[$widget->get_name()]['dependency'];
                if (isset($dependency['js'])) {
                    foreach ($dependency['js'] as $js) {
                        wp_enqueue_script($js['name'], $dir_path . $js['src'], array('jquery'), $this->version, true);
                    }
                }
                if (isset($dependency['css'])) {
                    foreach ($dependency['css'] as $css) {
                        wp_enqueue_style($css['name'], $dir_path . $css['src'], array(), $this->version, 'all');
                    }
                }
            }
        }
        return $content;
    }

    public function include_widgets($widgets_manager)
    {
        if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
            $all_config = (function_exists('get_iqonic_layouts_config')) ? get_iqonic_layouts_config() : '';

            if (!empty($all_config)) {
                foreach ($all_config as $item) {
                    if (isset($item['class'])) {
                        $widgets_manager->register(new $item['class']);
                    }
                }
            }
        }
    }

    public function editor_enqueue_scripts()
    {
        $all_script_config = (function_exists('get_iqonic_layouts_config')) ? get_iqonic_layouts_config() : '';

        if (defined('ELEMENTOR_PATH') && !empty($all_script_config)) {
            foreach ($all_script_config as $key => $item) {
                if ('general' == $key || Plugin::$instance->preview->is_preview_mode()) {
                    if (isset($item['dependency']['js'])) {
                        foreach ($item['dependency']['js'] as $js) {
                            wp_enqueue_script($js['name'], plugin_dir_url(__FILE__) . $js['src'], array('jquery'), $this->version, true);
                        }
                    }
                }
            }
        }
    }

    public function editor_enqueue_styles()
    {
        $all_style_config = (function_exists('get_iqonic_layouts_config')) ? get_iqonic_layouts_config() : '';

        if (defined('ELEMENTOR_PATH') && !empty($all_style_config)) {
            foreach ($all_style_config as $key => $item) {
                if ('general' == $key || Plugin::$instance->preview->is_preview_mode()) {
                    if (isset($item['dependency']['css'])) {
                        foreach ($item['dependency']['css'] as $css) {
                            wp_enqueue_style($css['name'], plugin_dir_url(__FILE__) . $css['src'], array(), $this->version, 'all');
                        }
                    }
                }
            }
        }
    }

    public function load_used_items($data, $post_id)
    {
        if ($this->is_running_background()) {
            return $data;
        }
        if ($this->is_preview_mode()) {
            // used template stack
            $this->used_templates[] = $post_id;
            $this->used_elements[] = 'general';
            // used Elements stack
            $this->used_elements = array_merge($this->used_elements, $this->get_loaded_elements($data));

            $this->enqueue();
        }

        return $data;
    }

    public function enqueue()
    {
        $elements = $this->used_elements;

        if (!empty($elements)) {
            $config = (function_exists('get_iqonic_layouts_config')) ? get_iqonic_layouts_config() : '';
            foreach ($elements as $item) {
                if (isset($config[$item]['dependency']['js'])) {
                    foreach ($config[$item]['dependency']['js'] as $js) {
                        wp_enqueue_script($js['name'], plugin_dir_url(__FILE__) . $js['src'], array('jquery'), $this->version, true);
                    }
                }
                if (isset($config[$item]['dependency']['css'])) {
                    foreach ($config[$item]['dependency']['css'] as $css) {
                        wp_enqueue_style($css['name'], plugin_dir_url(__FILE__) . $css['src'], array(), $this->version, 'all');
                    }
                }
            }
        }
    }

    public function get_loaded_elements($elements): array
    {
        $collections = [];

        foreach ($elements as $element) {
            if (isset($element['elType']) && $element['elType'] == 'widget') {
                if ($element['widgetType'] === 'global') {
                    $document = Plugin::$instance->documents->get($element['templateID']);
                    if (is_object($document)) {
                        $collections = array_merge($collections, $this->get_loaded_elements($document->get_elements_data()));
                    }
                } else {
                    $collections[] = $element['widgetType'];
                }
            }

            if (!empty($element['Elements'])) {
                $collections = array_merge($collections, $this->get_loaded_elements($element['Elements']));
            }
        }

        return $collections;
    }

    public function is_running_background(): bool
    {
        if (wp_doing_cron()) {
            return true;
        }

        if (wp_doing_ajax()) {
            return true;
        }

        if (isset($_REQUEST['action'])) {
            return true;
        }

        return false;
    }

    public function is_preview_mode(): bool
    {
        if (isset($_REQUEST['elementor-preview'])) {
            return false;
        }

        if (isset($_REQUEST['action'])) {
            return false;
        }

        return true;
    }
}
