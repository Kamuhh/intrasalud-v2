<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\AdditionalCode class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class AdditionalCode extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'kivicare_inline_css'), 20);
        add_action('wp_enqueue_scripts', array($this, 'kivicare_inline_js'), 20);
    }

    public function kivicare_inline_css()
    {
          global $kivicare_options;

        $custom_style = "";

        if (!empty($kivicare_options['kivi_css_code'])) {
            $kivicare_css_code = $kivicare_options['kivi_css_code'];
            $custom_style = $kivicare_css_code;
            wp_add_inline_style('kivicare-global', $custom_style);
        }
    }

    public function kivicare_inline_js()
    {
		global $kivicare_options;
        
        $custom_js = "";

        if (!empty($kivicare_options['kivi_js_code'])) {
            $kivicare_js_code = $kivicare_options['kivi_js_code'];

            $custom_js = $kivicare_js_code;
            wp_register_script('kivicare-custom-js', '', [], '', true);
            wp_enqueue_script('kivicare-custom-js');
            wp_add_inline_script('kivicare-custom-js', wp_specialchars_decode($custom_js));
        }
    }
}
