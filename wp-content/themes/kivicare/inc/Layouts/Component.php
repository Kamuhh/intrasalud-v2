<?php

/**
 * Kivicare\Utility\Actions\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Layouts;

use Elementor\Plugin;
use Kivicare\Utility\Component_Interface;
use Kivicare\Utility\Templating_Component_Interface;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `kivicare()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'layouts';
	}
	
	public function initialize()
	{
		add_action('manage_posts_extra_tablenav', array($this, 'add_layout_navigation'));
		add_filter('iqonic_hf_metakey_display', array($this, 'kivicare_edit_layouts_filters'));
		add_filter('iqonic_hf_metakey_type', array($this, 'kivicare_edit_layouts_filters'));
		add_filter('iqonic_hf_metakey_name', array($this, 'kivicare_edit_layouts_filters'));
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `kivicare()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'kivicare_get_layout_content' => array($this, 'kivicare_get_layout_content'),
		);
	}

	public function kivicare_get_layout_content($id)
	{
		$content = Plugin::instance()->frontend->get_builder_content_for_display($id);
		if (!isset($_REQUEST['elementor-preview']))
			return $content;
		ob_start();

		?>
		<div class="layout-editor-wrapper">
			<?php echo $content;
			do_action('iqonic_hf_layout/editor/layout_content_after', $id);
			?>
		</div>
		<?php return ob_get_clean();
	}
	//layout admin navigation
	function add_layout_navigation($where)
	{
		global $post_type_object;
		global $post;
		if ($post_type_object->name === 'iqonic_hf_layout' && $where == "top" && $post) {
		?>
			<div class="alignleft action">
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_kivicare_options&tab=9")); ?> " class="button">
					<?php echo esc_html__("Setup header layout", "kivicare"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_kivicare_options&tab=27")); ?> " class="button">
					<?php echo esc_html__("Setup footer layout", "kivicare"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>'" class="button">
					<?php echo esc_html__("Setup menu layout", "kivicare"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_kivicare_options&tab=24")); ?> " class="button">
					<?php echo esc_html__("Setup 404 page layout", "kivicare"); ?>
				</a>
			</div>
<?php
		}
	}

	function kivicare_edit_layouts_filters($string) {
		$layout_type = "header";
		if($string == 'dispaly_' . $layout_type) {
			return "header_layout_display_header";
		} elseif($string == $layout_type . '_layout_type') {
			return "header_layout_header_layout_type";
		} elseif($string == $layout_type . '_layout_name') {
			return "header_layout_header_layout_name";
		}
		return $string;
	}
}
