<?php

namespace Iqonic\Elementor\Elements\Products;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{

	protected $product_query;
    protected $max_page;
	
    public function get_name()
    {
        return 'Woo_Product_Grid';
    }

    public function get_title()
    {
        return __('WooCommerce Product Grid', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_blog',
			[
				'label' => __('Product Grid', 'iqonic'),

			]
		);

		$this->add_control(
			'product_type',
			[
				'label'      => __('Select Product', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'products',
				'options'    => [

					'featured_products' => __('Feature Product', 'iqonic'),
					'recent_products' => __('Recent Product', 'iqonic'),
					'sale_products'   => __('Sale Product', 'iqonic'),
					'best_selling_products' => __('Best Selling Product', 'iqonic'),
					'top_rated_products'    => __('Top Rated Product', 'iqonic'),
					'products'          => __('All Products', 'iqonic'),
				],
			]
		);

		$this->add_control(
			'woo_column',
			[
				'label'      => __('Column', 'iqonic'),
				'type'       => Controls_Manager::SELECT,

				'options'    => [
					'1'          => __('1 Columns', 'iqonic'),
					'2'          => __('2 Columns', 'iqonic'),
					'3'          => __('3 Columns', 'iqonic'),
					'4'          => __('4 Columns', 'iqonic'),
					'5'          => __('5 Columns', 'iqonic'),
					'6'          => __('6 Columns', 'iqonic'),
				],
				'default'    => '1',
			]
		);



		$this->add_control(
			'woo_order',
			[
				'label'   => __('Order By', 'iqonic'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'DESC' => esc_html__('Descending', 'iqonic'),
					'ASC' => esc_html__('Ascending', 'iqonic')
				],

			]
		);

		$this->add_control(
			'woo_per_page',
			[
				'label' => __('Per Page', 'iqonic'),
				'type' => Controls_Manager::NUMBER,
				'min' => -1,

				'step' => 1,
				'default' => 10,
			]
		);
		$this->add_control(
			'show_pagination',
			[
				'label' => __('Show Pagination', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'iqonic'),
				'label_off' => __('Hide', 'iqonic'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'   => __('Show Pagintion/Loadmore/Infinite', 'iqonic'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'loadmore',
				'label_block' => true,
				'options' => [
					'yes' => esc_html__('Pagination', 'iqonic'),
					'loadmore' => esc_html__('Loadmore', 'iqonic'),
					'infinite' => esc_html__('Infinite Scroll', 'iqonic')
				],
			]
		);

		$this->add_control(
			'show_catalog',
			[
				'label' => __('Show Catalog ordering', 'iqonic'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'iqonic'),
				'label_off' => __('Hide', 'iqonic'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$array = [];
		$categories = iqonic_get_category();
		if (!empty($categories)) {
			foreach ($categories as $cat) {
				$array[$cat->slug] = $cat->slug;
			}
		}

		$this->add_control(
			'woo_category',
			[
				'label' => __('Display Product From Specific Category', 'iqonic'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $array,
			]
		);

		$this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Products/render.php';
    }
	public function kivicare_widget_loadmore () {
		if ($this->max_page <= 1 )
			return; ?>
		
		<input type="hidden" name="per_per_paged" class="per_per_paged" value='<?php echo  $this->get_settings()['woo_per_page'] ?>'>
		<input type="hidden" class="page_no" name="product_page_no" value='1'>
		<input type="hidden" class="max_no_page" name="max_no_page" value='<?php echo $this->max_page ?>'>
		<input type="hidden" class="product_ajax_query" name="product_query" value='<?php echo json_encode($this->product_query) ?>'>
		<input type="hidden" name="woocommerce_grid" class="woocommerce_grid" value='<?php echo  $this->get_settings()['woo_column'] ?>'>
	
		<?php
		if ($this->get_settings()['pagination'] == "loadmore") {
			echo '<a class="kivicare_loadmore_product iq-new-btn-style iq-button-style-2" tabindex="0" data-text="Load More" data-loading-text="Loading"><span> Load More </span></a>';
		} elseif ($this->get_settings()['pagination'] == "infinite") {
			echo '<div class="loader-wheel-container"></div>';
		} else {
			get_template_part('template-parts/wocommerce/pagination');
		}
	}
}
