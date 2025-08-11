<?php

namespace ProApp\baseClasses;

use Automatic_Upgrader_Skin;
use Plugin_Upgrader;

class KCProGetDependency {

    protected $pluginName;

    protected $textDomain;

    /**
     * @param $pluginName
     * @param $textDomain
     */
    public function __construct($pluginName, $textDomain) {
        $this->pluginName = $pluginName;
        $this->textDomain = $textDomain;
    }

    /**
     * get all required plugins
     * @return bool
     */
    public function getPlugin()
    {
        $basename = '';
        $plugins = get_plugins();

        foreach ($plugins as $key => $data) {
            if ($data['TextDomain'] === $this->textDomain) {
                $basename = $key;
            }
        }

        //check if required plugin installed
        if ($this->isPluginInstalled($basename)) {
            //check if required plugin not active
            if (!is_plugin_active($basename)) {
                //activated required plugin
                activate_plugin($this->callPluginPath(WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $basename), '', false, false);
                return true;
            }
        } else {
            //get required plugin data
            $plugin_data = $this->getPluginData($this->pluginName);
            //check if plugin data have download link
            if (isset($plugin_data->download_link)) {
                //install required plugin
                $this->installPlugin($plugin_data->download_link);
                return true;
            }
        }
        return false;

    }

    /**
     * function to get plugin data
     * @param $slug
     * @return false|mixed
     */
    public function getPluginData($slug = '') {
        $args = array(
            'slug' => $slug,
            'fields' => array(
                'version' => false,
            ),
        );

        //call wordpress api to get data
        $response = wp_remote_post(
            'http://api.wordpress.org/plugins/info/1.0/',
            array(
                'body' => array(
                    'action' => 'plugin_information',
                    'request' => serialize((object) $args),
                ),
            )
        );

        //check if response not have error
        if (is_wp_error($response)) {
            return false;
        } else {
            // get body from response
            $response = unserialize(wp_remote_retrieve_body($response));

            if ($response) {
                return $response;
            } else {
                return false;
            }
        }
    }

    /**
     * check if basename plugin is installed
     * @param $basename
     * @return bool
     */
    public function isPluginInstalled($basename) {
        if (!function_exists('get_plugins')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $plugins = get_plugins();

        return isset($plugins[$basename]);
    }

    /**
     * install required plugin
     * @param $plugin_url
     * @return bool|string|\WP_Error
     */
    public function installPlugin($plugin_url) {
        include_once ABSPATH . 'wp-admin/includes/file.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

        $skin = new Automatic_Upgrader_Skin;
        $upgrade = new Plugin_Upgrader($skin);
        $upgrade->install($plugin_url);

        // activate plugin
        activate_plugin($upgrade->plugin_info(), '', false, false);

        return $skin->result;
    }

    /**
     * @param $path
     * @return array|string|string[]
     */
    public function callPluginPath($path) {
        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

}


