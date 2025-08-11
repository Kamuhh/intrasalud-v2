<?php

namespace Iqonic\Elementor\Elements\ScrollingText;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'Iq_scrolling_text';
    }

    public function get_title()
    {
        return __('Scrolling Text', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-site-title';
    }
    protected function register_controls()
    {
       
		$this->start_controls_section(
			'section_st',
			[
				'label' => __( 'Scrolling Text', 'iqonic' ),
			]
		);

        $this->add_control(
			'stext_title',
			[
				'label' => __( 'Scrolling Title', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                'default' => __( 'Scrolling Title', 'iqonic' ),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Scrolling position', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'right',
				'options'    => [
					'right'          => __('Style-1', 'iqonic'),
					'left'          => __('Style-2', 'iqonic'),
				],
			]
		);
		
        $this->end_controls_section();
        
		// Container Style Section End
		
		// Title Style Section
        $this->start_controls_section(
			'section_scroll_text',
			[
				'label' => __( 'Title', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_typography',
				'label' => __( 'Typography', 'iqonic' ),
				'selector' => '{{WRAPPER}} .scrolling-text',
			]
		);

		$this->add_control(
			'sub_title_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .scrolling-text' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->end_controls_section();
        // Title Style Section End

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/ScrollingText/render.php';
		if (Plugin::$instance->editor->is_edit_mode()) { 
			?>
		   <script>
			   (function(jQuery) {
				    callSkrollr();
			   })(jQuery);
		   </script> 
			   <?php
	   }
    }
}
