<?php

namespace Iqonic_Layouts\Classes;

use Iqonic_Layouts\Admin\Classes\Iqonic_Layouts_Admin;
use Iqonic_Layouts\Controls;
use Iqonic_Layouts\Elementor;

class Iqonic_Layouts_Extension
{

    protected $loader;

    protected $plugin_name;

    protected $version;

    public function __construct()
    {
        if (defined('IQONIC_LAYOUT_EXTENSION_VERSION')) {
            $this->version = IQONIC_LAYOUT_EXTENSION_VERSION;
        } else {
            $this->version = '1.2.0';
        }
        $this->plugin_name = 'iqonic-layouts-extension';

        $this->register_layout_custom_post();
        $this->load_layout_dependencies();
        $this->set_layout_locale();
        $this->define_layout_elementor_hooks();
        $this->load_layout_widget();
        new Iqonic_Layouts_Admin();
    }

    public function load_layout_dependencies()
    {
        $this->loader = new Iqonic_Layouts_Extension_Loader();
    }

    public function set_layout_locale()
    {
        $plugin_i18n = new Iqonic_Layouts_Extension_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    public function define_layout_elementor_hooks()
    {

        $plugin_elementor = new Elementor\Iqonic_Layouts_Extension_Elementor($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('elementor/init', $plugin_elementor, 'elementor_init');
        $this->loader->add_action('elementor/widgets/register', $plugin_elementor, 'include_widgets');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_elementor, 'editor_enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_elementor, 'editor_enqueue_scripts');
        $this->loader->add_filter('elementor/frontend/builder_content_data', $plugin_elementor, 'load_used_items', 10, 2);
        require_once IQONIC_LAYOUTS_EXTENSION_PLUGIN_PATH . '/includes/Elementor/Utils/helpers.php';
    }

    public function register_layout_custom_post()
    {
        require_once IQONIC_LAYOUTS_EXTENSION_PLUGIN_PATH . '/includes/Custom_Post/HeaderFooterLayout.php';
        require_once IQONIC_LAYOUTS_EXTENSION_PLUGIN_PATH . '/includes/Layouts/LayoutMeta.php';
    }
    public function load_layout_widget()
    {
    }

    public function run()
    {
        $this->loader->run();
    }

    public function get_plugin_name(): string
    {
        return $this->plugin_name;
    }

    public function get_loader()
    {
        return $this->loader;
    }

    public function get_version(): string
    {
        return $this->version;
    }
}
