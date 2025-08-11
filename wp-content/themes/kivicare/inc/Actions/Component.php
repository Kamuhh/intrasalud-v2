<?php

/**
 * Kivicare\Utility\Actions\Component class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Actions;

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
		return 'actions';
	}
	public function initialize()
	{
		add_action('manage_posts_extra_tablenav', array($this, 'add_layout_navigation'));
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
			'kivicare_get_blog_readmore_link' => array($this, 'kivicare_get_blog_readmore_link'),
			'kivicare_get_blog_readmore' => array($this, 'kivicare_get_blog_readmore'),
			'kivicare_get_comment_btn' => array($this, 'kivicare_get_comment_btn'),
			'kivicare_get_woo_comment_btn' => array($this, 'kivicare_get_woo_comment_btn'),
		);
	}

	//** Blog Read More Button Link **//
	public function kivicare_get_blog_readmore_link($link, $label = "Read More")
	{
		echo '<div class="iq-btn-container">		
				<a class="iq-button iq-btn-link yes btn-icon-right" href="' . esc_url($link) . '">' . esc_html($label) . ' 
				   <span class="btn-link-icon"><i aria-hidden="true" class="ion ion-plus"></i></span>
				</a>
			</div>';

	}

	//** Blog Read More Button **//
	public function kivicare_get_blog_readmore($link, $label)
	{
		echo '<div class="iq-btn-container">
		        <a class="iq-button-style-2   iq-new-btn-style has-icon btn-icon-right" href="' . esc_url($link) . '"><span class="iq-btn-text-holder">' . esc_html($label) . '</span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span></a>
			</div>';
	}

	//layout navigation
	function add_layout_navigation($where)
	{
		global $post_type_object;
		global $post;
		if ($post_type_object->name === 'iqonic_hf_layout' && $where == "top" && $post) {
?>
			<div class="alignleft action">
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_kivicare_options&tab=6")); ?> " class="button">
					<?php echo esc_html__("Setup header layout", "kivicare"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_kivicare_options&tab=17")); ?> " class="button">
					<?php echo esc_html__("Setup footer layout", "kivicare"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>'" class="button">
					<?php echo esc_html__("Setup menu layout", "kivicare"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_kivicare_options&tab=15")); ?> " class="button">
					<?php echo esc_html__("Setup 404 page layout", "kivicare"); ?>
				</a>
			</div>
<?php
		}
	}
	//** Comment Submit Button **//
	public function kivicare_get_comment_btn()
	{
		return '<span  id="cmnt-btn"><button name="submit" type="submit" id="submit" class="submit iq-comment-btn iq-new-btn-style" value="' . esc_html__('Post Comment' . 'kivicare') . '"><span class="iq-btn-text-holder">' . esc_html__('Post Comment', 'kivicare') . '</span><span class="iq-btn-icon-holder"><i aria-hidden="true" class="ion ion-plus"></i></span></button></span>';
	}

	public function kivicare_get_woo_comment_btn($tag = 'a',  $label = 'Post Comment', $show_icon = true, $attr = array())
	{

		$icon = $show_icon ? '<i class="" aria-hidden="true"></i>' : '';
		$classes = isset($attr['class']) ? $attr['class'] : '';
		$attr_render = '';

		foreach ($attr as $key => $value) {
			if ($key != 'class') {
				$attr_render .= $key . '=' . $value . ' ';
			}
		}

		return '<' . tag_escape($tag) . '  class="kivicare-button btn btn_small ' . esc_attr($classes) . '  " ' . esc_attr($attr_render) . '  >
				' . esc_html($label) .
			$icon .
			' </' . tag_escape($tag) . '>';
	}
}
