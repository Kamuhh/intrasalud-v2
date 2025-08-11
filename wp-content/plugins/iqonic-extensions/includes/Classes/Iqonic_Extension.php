<?php

namespace Iqonic\Classes;

use Iqonic\Acf;
use Iqonic\Controls;
use Iqonic\Elementor;

class Iqonic_Extension
{

    protected $loader;

    protected $plugin_name;

    protected $version;

    public function __construct()
    {
        if (defined('IQONIC_EXTENSION_VERSION')) {
            $this->version = IQONIC_EXTENSION_VERSION;
        } else {
            $this->version = '1.1.0';
        }
        $this->plugin_name = 'iqonic-extension';

        $this->register_custom_post();
        $this->load_dependencies();
        $this->load_acf_dependencies();
        $this->set_locale();
        $this->define_register_controls();
        $this->define_elementor_hooks();
        $this->register_custom_helper();
        $this->define_redux_hooks();
        $this->load_widget();
        $this->custom_icon();
    }

    public function load_dependencies()
    {
        $this->loader = new Iqonic_Extension_Loader();
    }

    public function load_acf_dependencies()
    {
        if (function_exists('get_field')) {
            new Acf\Team();
            new Acf\General();
            new Acf\Testimonial();
            new Acf\Service();
        }
    }

    public function set_locale()
    {
        $plugin_i18n = new Iqonic_Extension_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    public function define_register_controls()
    {
        $this->loader->add_action('elementor/controls/controls_registered', $this, 'register_controls');
    }

    public function register_controls()
    {
        if (class_exists('\Elementor\Base_Data_Control')) {
            $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        }
    }

    public function define_elementor_hooks()
    {
        $plugin_elementor = new Elementor\Iqonic_Extension_Elementor($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('elementor/init', $plugin_elementor, 'elementor_init');
        $this->loader->add_action('elementor/widgets/register', $plugin_elementor, 'include_widgets');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_elementor, 'editor_enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_elementor, 'editor_enqueue_scripts');
        $this->loader->add_filter('elementor/frontend/builder_content_data', $plugin_elementor, 'load_used_items', 10, 2);
    }

    public function define_redux_hooks()
    {
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/ReduxCore/framework.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/departments-menu.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/footer-contact.php';
         require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/footer-logo.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/recent-post.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/social_media.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/subscribe.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Widget/working-days.php';
    }
    public function register_custom_post()
    {
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Custom_Post/Testimonial.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Custom_Post/Team.php';
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Custom_Post/Service.php';
    }

    public function custom_icon()
    {
        require_once IQONIC_EXTENSION_PLUGIN_PATH . '/includes/Custom_Icon/custom-icon.php';
    }

    public function load_widget()
    {
    }

    public function register_custom_helper()
    {
        require_once IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Utils/woo_helper.php';
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
