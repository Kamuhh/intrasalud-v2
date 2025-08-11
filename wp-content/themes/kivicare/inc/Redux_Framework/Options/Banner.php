<?php

/**
 * Kivicare\Utility\Redux_Framework\Options\Banner class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;

use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class Banner extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {

        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Page Banner Setting','kivicare'),
            'id'    => 'breadcrumbs-fevicon',
            'icon'  => 'el el-cog',
            'desc'  => esc_html__('This section contains options for Page Breadcrumbs Area.','kivicare'),
            'fields'=> array(
        
                array(
                    'id'       => 'kivi_page_banner_image',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Default Banner Image','kivicare'),
                    'read-only'=> false,
                    'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/bg.png' ),
                    'subtitle' => esc_html__( 'Upload default banner image for your Website.','kivicare'),
                ),
        
                array(
                    'id'      => 'bg_image',
                    'type'    => 'image_select',
                    'title'   => esc_html__( 'Select Banner Style', 'kivicare' ),
                    'subtitle' => esc_html__( 'Select the style that best fits your needs.', 'kivicare' ),
                    'options' => array(
                        '1'      => array(
                            'alt' => 'Style1',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-1.jpg',
                        ),
                        '2'      => array(
                            'alt' => 'Style2',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-2.jpg',
                        ),
                        '3'      => array(
                            'alt' => 'Style3',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-3.jpg',
                        ),
                        '4'      => array(
                            'alt' => 'Style4',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-4.jpg',
                        ),
                        '5'      => array(
                            'alt' => 'Style5',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-5.jpg',
                        ),
                    ),
                    'default' => '1'
                ),
        
                array(
                    'id' => 'display_banner',
                    'type' => 'button_set',
                    'title' => esc_html__('Display Banner on inner Pages', 'kivicare') ,
                    'options' => array(
                        'yes' => esc_html__('Yes', 'kivicare') ,
                        'no' => esc_html__('No', 'kivicare')
                    ) ,
                    'default' => esc_html__('yes', 'kivicare')
                ) ,
        
                array(
                    'id' => 'display_breadcrumbs',
                    'type' => 'button_set',
                    'title' => esc_html__('Display Breadcrumbs on Banner', 'kivicare') ,
                    'options' => array(
                        'yes' => esc_html__('Yes', 'kivicare') ,
                        'no' => esc_html__('No', 'kivicare')
                    ) ,
                    'required' => array(
                        'display_banner',
                        '=',
                        'yes'
                    ) ,
                    'default' => esc_html__('yes', 'kivicare')
                ) ,
        
                array(
                    'id' => 'display_title',
                    'type' => 'button_set',
                    'title' => esc_html__('Display Breadcrumbs on Title', 'kivicare') ,
                    'options' => array(
                        'yes' => esc_html__('Yes', 'kivicare') ,
                        'no' => esc_html__('No', 'kivicare')
                    ) ,
                    'required' => array(
                        'display_banner',
                        '=',
                        'yes'
                    ) ,
                    'default' => esc_html__('yes', 'kivicare')
                ) ,
        
                array(
                    'id' => 'breadcum_title_tag',
                    'type' => 'select',
                    'title' => esc_html__('Select Breadcrumbs Title Tag', 'kivicare') ,
                    'options' => array(
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h5' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6'
                    ) ,
                    'required' => array(
                        'display_title',
                        '=',
                        'yes'
                    ) ,
                    'default' => 'h2'
                ) ,
        
                array(
                    'id' => 'bg_title_color',
                    'type' => 'color',
                    'title' => esc_html__('Set Title Color', 'kivicare') ,
                    'default'       =>'',
                    'mode' => 'background',
                    'required' => array(
                        'display_title',
                        '=',
                        'yes'
                    ) ,
                    'transparent' => false
                ) ,
        
                array(
                    'id'       => 'bg_type',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Banner Background Type', 'kivicare' ),
                    'options'  => array(
                        '1' => 'Color',
                        '2' => 'Image'
                    ),
                    'default'  => '1'
                ),
        
                array(
                    'id'       => 'banner_image',
                    'type'     => 'media',
                    'url'      => false,
                    'title'    => esc_html__( 'Set Banner Body Image','kivicare'),
                    'read-only'=> false,
                    'required'  => array( 'bg_type', '=', '2' ),
                    'subtitle' => esc_html__( 'Upload Image for your body.','kivicare'),
                    'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/bg.jpg' ),
                ),
        
                array(
                    'id'            => 'bg_color',
                    'type'          => 'color',
                    'title'         => esc_html__( 'Set Background Color', 'kivicare' ),
                    'required'  => array( 'bg_type', '=', '1' ),
                    'default'       =>'#eff1fe',
                    'mode'          => 'background',
                    'transparent'   => false
                ),

            )
        ));


    }
}
