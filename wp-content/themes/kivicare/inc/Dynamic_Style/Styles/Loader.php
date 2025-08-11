<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Loader class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class Loader extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'kivicare_loader_options'), 20);
    }

    public function kivicare_loader_options()
    {
        global $kivicare_options;
        $loader_var = "";
        if (isset($kivicare_options['loader_color'])) {
            $loader_var = $kivicare_options['loader_color'];
            if (!empty($loader_var)) {
                $loader_css = "
                    #loading {
                        background : $loader_var !important;
                    }";
            }
        }
        if (!empty($kivicare_options["loader-dimensions"]["width"]) && $kivicare_options["loader-dimensions"]["width"] != "px") {
            $loader_width = $kivicare_options["loader-dimensions"]["width"];
            $loader_css .= '#loading img { width: ' . $loader_width . ' !important; }';
        }

        if (!empty($kivicare_options["loader-dimensions"]["height"]) && $kivicare_options["loader-dimensions"]["height"] != "px") {
            $loader_height = $kivicare_options["loader-dimensions"]["height"];
            $loader_css .= '#loading img { height: ' . $loader_height . ' !important; }';
        }
        if (!empty($loader_css)) {
            wp_add_inline_style('kivicare-global', $loader_css);
        }
    }
}
