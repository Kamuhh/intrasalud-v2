<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Logo class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class Logo extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'kivicare_logo_options'), 20);
    }

    public function kivicare_logo_options()
    {
        global $kivicare_options;
        $logo_var = "";
        
        if ($kivicare_options['header_radio'] == 1) {
            if (!empty($kivicare_options['header_color'])) {
                $logo = $kivicare_options['header_color'];
                $logo_var = ".navbar-light .navbar-brand,.navbar-light .logo-text  {
                    color : $logo !important;
                }";
            }
        }

        if (!empty($kivicare_options["logo-dimensions"]["width"]) && $kivicare_options["logo-dimensions"]["width"] != "px") {
            $logo_width = $kivicare_options["logo-dimensions"]["width"];
            $logo_var .= 'header.site-header a.navbar-brand img, .vertical-navbar-brand img { width: ' . $logo_width . ' !important; }';
        }

        if (!empty($kivicare_options["logo-dimensions"]["height"]) && $kivicare_options["logo-dimensions"]["height"] != "px") {
            $logo_height = $kivicare_options["logo-dimensions"]["height"];
            $logo_var .= 'header.site-header a.navbar-brand img, .vertical-navbar-brand img { height: ' . $logo_height . ' !important; }';
        }
        if (!empty($logo_var)) {
            wp_add_inline_style('kivicare-global', $logo_var);
        }
    }
}
