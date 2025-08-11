<?php

/**
 * Kivicare\Utility\Redux_Framework\Options\User class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Woocommerce extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('WooCommerce ', 'kivicare'),
			'icon'  => 'el el-shopping-cart',
			'customizer_width' => '500px',
		));


		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Shop Page', 'kivicare'),
			'id'    => 'Woocommerce',
			'subsection' => true,
			'fields' => array(
				array(
					'id'        => 'woocommerce_shop',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop page Setting', 'kivicare'),
					'subtitle'  => wp_kses(__('Choose among these structures (Product Listing, Product Grid) for your shop section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.', 'kivicare'), array('br' => array())),
					'options'   => array(
						'1' => array('title' => esc_html__('Product Listing', 'kivicare'), 
						'img' => get_template_directory_uri() . '/assets/images/redux/single-column.jpg'),
						'2' => array('title' => esc_html__('Product Grid ', 'kivicare'), 
						'img' => get_template_directory_uri() . '/assets/images/redux/three-column.jpg'),
					),
					'default'   => '2',
				),

				array(
					'id'        => 'woocommerce_shop_grid',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop Page Sidebar Setting', 'kivicare'),
					'options'   => array(
						'1' => array('title' => esc_html__('Full Width', 'kivicare'), 'img' => get_template_directory_uri() . '/assets/images/redux/single-column.jpg'),
						'4' => array('title' => esc_html__('Left Sidebar', 'kivicare'), 'img' => get_template_directory_uri() . '/assets/images/redux/left-side.jpg'),
						'5' => array('title' => esc_html__('Right Sidebar', 'kivicare'), 'img' => get_template_directory_uri() . '/assets/images/redux/right-side.jpg'),
					),
					'default'   => '5',
				),

				array(
					'id' => 'woocommerce_product_per_page',
					'type' => 'slider',
					'title' => esc_html__('Set Product Per Page', 'kivicare'),
					'desc' => esc_html__('Here This option provide set post per paged item', 'kivicare'),
					'min' => 1,
					'step' => 1,
					'max' => 99,
					'default' => 12
				),
			)
		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Product Page', 'kivicare'),
			'id'    => 'product_page',
			'subsection' => true,
			'fields' => array(

				array(
					'id' => 'product_display_banner',
					'type' => 'button_set',
					'title' => esc_html__('Display Banner on Product Page', 'kivicare'),
					'subtitle' => esc_html__('This Option Display The Banner Of The Product', 'kivicare'),
					'options' => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default' => esc_html__('yes', 'kivicare')
				),
				array(
					'id' => 'kivicare_show_related_product',
					'type' => 'button_set',
					'title' => esc_html__('Display Related Product On Single Page', 'kivicare'),
					'subtitle' => esc_html__('This Option Display RElated Product On Single Page', 'kivicare'),
					'options' => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default' => esc_html__('yes', 'kivicare')
				),

			)
		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Shop Page Products Setting', 'kivicare'),
			'id'    => 'single_page',
			'subsection' => true,
			'fields' => array(
				array(
					'id'        => 'kivicare_display_product_category',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Category', 'kivicare'),
					'subtitle' => esc_html__('Here This option provide Category Of The Product', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'kivicare_display_product_name',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Name', 'kivicare'),
					'subtitle' => esc_html__('Here This option provide Name Of The Product', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'kivicare_display_price',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Price', 'kivicare'),
					'subtitle' => esc_html__('Here This option Display The Price', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'kivicare_display_product_rating',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Rating', 'kivicare'),
					'subtitle' => esc_html__('Display The Ratings', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),


				array(
					'id'        => 'kivicare_display_product_addtocart_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display AddToCart Icon', 'kivicare'),
					'subtitle' => esc_html__('Display AddToCart Icon', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'kivicare_display_product_wishlist_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Wishlist Icon', 'kivicare'),
					'subtitle' => esc_html__('Display The Wishlist Icon', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),


				array(
					'id'        => 'kivicare_display_product_quickview_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display QuickView Icon', 'kivicare'),
					'subtitle' => esc_html__('Display QuickView Icon', 'kivicare'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'kivicare'),
						'no' => esc_html__('No', 'kivicare')
					),
					'default'   => 'yes'
				),
			

				array(
					'id'            => 'kivicare_display_sale_badge_color',
					'type'          => 'color',
					'title'         => esc_html__(' Sale Badge Color', 'kivicare'),
					'subtitle'		=> esc_html__('Color Of The Sale Badge', 'kivicare'),
					'mode'          => 'background',
					'transparent'   => false,
				),

				array(
					'id'            => 'kivicare_display_new_badge_color',
					'type'          => 'color',
					'title'         => esc_html__(' New Badge Color', 'kivicare'),
					'subtitle' 		=> esc_html__('Color Of The New Badge', 'kivicare'),
					'mode'          => 'background',
					'transparent'   => false,
				),


				array(
					'id'            => 'kivicare_display_sold_badge_color',
					'type'          => 'color',
					'title'         => esc_html__(' Sold Badge Color', 'kivicare'),
					'subtitle'      => esc_html__('Color Of The Sold BAdge', 'kivicare'),
					'mode'          => 'background',
					'transparent'   => false,
				),
				'default' => 'yes'
			),
		));
	}
}
