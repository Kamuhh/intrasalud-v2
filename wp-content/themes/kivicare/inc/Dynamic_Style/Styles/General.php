<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\General class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;
use function Kivicare\Utility\kivicare;

class General extends Component
{
	public function __construct()
	{

		add_action('wp_enqueue_scripts', array($this, 'kivicare_create_general_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'kivicare_page_404'), 20);
		add_action('wp_enqueue_scripts', array($this, 'kivicare_layout_add_meta'), 20);
		$this->kivicare_maintenance_mode();
	}

	public function kivicare_create_general_style()
	{
		global $kivicare_options;
		$general_var = '';

		if (isset($kivicare_options['opt-slider-label']) && !empty($kivicare_options['opt-slider-label']['width'])) {

			$container_width = $kivicare_options['opt-slider-label']['width'];
			if ($container_width !== 'px' && $container_width !== 'em' && $container_width !== '%') {
				$general_var = "
					body.iq-container-width .container,
					body .elementor-section.elementor-section-boxed>.elementor-container {
						max-width: " . $container_width . ";
					} ";
			}
		}

		if (isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['layout_set'] == 1) {
			if (isset($kivicare_options['kivi_layout_color'])  && !empty($kivicare_options['kivi_layout_color'])) {
				$general = $kivicare_options['kivi_layout_color'];
				$general_var .= 'body { background : ' . $general . ' !important; }';
			}
		}
		
		if (isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['layout_set'] == 3) {
			if (isset($kivicare_options['kivi_layout_image']['url']) && !empty($kivicare_options['kivi_layout_image']['url'])) {
				$general = $kivicare_options['kivi_layout_image']['url'];
				$general_var .= 'body { background-image: url(' . $general . ') !important; }';
			}
		}

		if (isset($kivicare_options) && is_array($kivicare_options) && $kivicare_options['kivi_back_to_top'] == 'no') {
			if (isset($kivicare_options['kivi_back_to_top']) && !empty($kivicare_options['kivi_back_to_top'])) {
				$general_var .= '#back-to-top { display: none !important; }';
			}
		}
		
		if (!empty($general_var)) {
			wp_add_inline_style('kivicare-global', $general_var);
		}
	}

	// rtl switcher 

	function kivicare_layout_add_meta()
    {
        $version = kivicare()->get_version();
        $path = get_template_directory_uri() . '/assets/css/';
        echo "<meta name='setting_options' data-version='$version' data-path='$path'></meta>";
    }

	public function kivicare_maintenance_mode()
    {
        $kivicare_options = get_option("kivi_options");
        if (isset($kivicare_options['kivicare_enable_switcher']) && $kivicare_options['kivicare_enable_switcher'] == 1) {
            add_action('wp_footer', array($this, 'kivicare_style_switcher'));
            add_action('wp_enqueue_scripts', array($this, 'kivicare_style_switcher_styles'), 20);
        }
    }

	public function kivicare_style_switcher_styles()
    {
        wp_enqueue_script('iq-style-switcher', get_template_directory_uri() . '/assets/js/src/iq-style-switcher.js', array(), kivicare()->get_version(), true);
        wp_enqueue_style('iq-style-switcher', get_template_directory_uri() . '/assets/css/src/iq-style-switcher.css', array(), kivicare()->get_version());
    }

	function kivicare_style_switcher()
    {
        global $kivicare_options;
        $ltr_check = 'checked';
		$rtl_check = '';

		$page_id = (get_queried_object_id()) ? get_queried_object_id() : '';
		$is_rtl = !empty($page_id) ? get_post_meta($page_id, 'enable_rtl', true) : 'default';
		if ($is_rtl != 'default') {
			if ($is_rtl == "yes") {
				$rtl_check = 'checked';
			}
		} else {
			if(isset($kivicare_options['kivicare_direction_options']) &&  $kivicare_options['kivicare_direction_options'] == "yes"){
				$rtl_check = 'checked';
			} else
			if (isset($_COOKIE['theme_scheme_direction'])) {
				$rtl_check = ($_COOKIE['theme_scheme_direction'] == 'rtl') ? 'checked' : '';
				$ltr_check = ($_COOKIE['theme_scheme_direction'] == 'ltr') ? 'checked' : '';
			}
		}
?>
        <div class="iq-theme-feature hidden-xs hidden-sm hidden-md">
            <div class="iq-switchbuttontoggler"><i class="fas fa-cog"></i></div>
            <ul id="switch-mode" class="switch-mode">
                <li>
                    <input type="radio" value="ltr" class="btn-check" name="theme_scheme_direction" id="theme-scheme-direction-ltr" <?php echo esc_attr($ltr_check); ?>>
                    <label class="btn-box d-block" for="theme-scheme-direction-ltr">
                        <?php esc_html_e("LTR", "kivicare"); ?> </label>
                </li>
                <li>
                    <input type="radio" value="rtl" class="btn-check" name="theme_scheme_direction" id="theme-scheme-direction-rtl" <?php echo esc_attr($rtl_check); ?>>
                    <label class="btn-box d-block" for="theme-scheme-direction-rtl">
                        <?php esc_html_e("RTL", "kivicare"); ?></label>
                </li>
            </ul>
        </div>
<?php
    }

	/* 404 Page Options */
	public function kivicare_page_404()
	{
		if (is_404()) {
			global $kivicare_options;

			$header_footer_css = '';

			if (!$kivicare_options['header_on_404']) {
				$header_footer_css .= 'header { 
				display : none !important;
			}';
			}
			if (!$kivicare_options['footer_on_404']) {
				$header_footer_css .= 'footer { 
				display : none !important;
			}';
			}
			if (!empty($header_footer_css)) {
				wp_add_inline_style('kivicare-global', $header_footer_css);
			}
		}
	}
}
