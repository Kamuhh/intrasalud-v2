<?php

namespace Iqonic\Acf;

class General
{
    public function __construct()
    {
        $this->set_general_options();
    }

    public function get_hf_layout($type = 'header')
    {
        $args = array(
            'post_type'         => 'iqonic_hf_layout',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_key'          => '_layout_meta_key',
            'meta_value'        => $type,
        );
        global $post;
        $wp_query = get_posts($args);
        $iqonic_header_list = [];

        if ($wp_query) {
            foreach ($wp_query as $header) {
                $iqonic_header_list[$header->post_name] = $header->post_title;
            }
        }
        return $iqonic_header_list;
    }

    public function set_general_options()
    {
        if (function_exists('acf_add_local_field_group')) :

            // Page Options
            acf_add_local_field_group(array(
                'key' => 'group_46Cg7N74r8t811VLFfR6',
                'title' => 'Page Options',
                'fields' => array(
        
                    // Banner Settings
                    array(
                        'key' => 'field_7a2p3jBTfCbZ17c4cciu',
                        'label' => 'Banner Settings',
                        'name' => 'banner',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'placement' => 'left',
                        'endpoint' => 0,
                    ) ,
        
                    array(
                        'key' => 'field_QnF1',
                        'label' => 'Display Banner',
                        'name' => 'display_banner',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'choices' => array(
                            'default' => 'Default',
                            'yes' => 'yes',
                            'no' => 'no',
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,
                    array(
                        'key' => 'key_pjros',
                        'label' => 'Breadcrumbs Layout',
                        'name' => 'breadcumb_layout',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_QnF1Ebcc8OXfqaebPj7H',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ) ,
                            ) ,
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'layout' => 'table',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_WGCt5cd3bf759qMh8gRk',
                                'label' => 'Display Title',
                                'name' => 'display_title',
                                'type' => 'button_group',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'choices' => array(
                                    'default' => 'Default',
                                    'yes' => 'yes',
                                    'no' => 'no',
                                ) ,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'message' => '',
                                'default_value' => 'default',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ) ,
        
                            array(
                                'key' => 'field_3PnJp21d93eM5Nrs8422',
                                'label' => 'Display Breadcrumbs',
                                'name' => 'display_breadcumb',
                                'type' => 'button_group',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'message' => '',
                                'choices' => array(
                                    'default' => 'Default',
                                    'yes' => 'yes',
                                    'no' => 'no',
                                ) ,
                                'default_value' => 'default',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ) ,
        
                        ) ,
                    ) ,
                    array(
                        'key' => 'key_banner_back',
                        'label' => 'Banner Background',
                        'name' => 'banner_back_option',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_QnF1',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ) ,
                            ) ,
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'layout' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_ybmis',
                                'label' => 'Background',
                                'name' => 'banner_background_type',
                                'type' => 'button_group',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'choices' => array(
                                    'default' => 'Default',
                                    'color' => 'Color',
                                    'image' => 'Image'
                                ) ,
                                'allow_null' => 0,
                                'default_value' => 'default',
                                'layout' => 'horizontal',
                                'return_format' => 'value',
                            ) ,
                            array(
                                'key' => 'field_egeo',
                                'label' => 'Background Color',
                                'name' => 'banner_background_color',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_ybmis',
                                            'operator' => '==',
                                            'value' => 'color',
                                        ) ,
                                    ) ,
                                ) ,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'default_value' => '',
                            ) ,
        
                            array(
                                'key' => 'field_5d6d06b7dca4c',
                                'label' => 'Background Image',
                                'name' => 'banner_background_image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_ybmis',
                                            'operator' => '==',
                                            'value' => 'image',
                                        ) ,
                                    ) ,
                                ) ,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'return_format' => 'array',
                                'preview_size' => 'medium',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ) ,
        
                            array(
                                'key' => 'field_ybmisxy',
                                'label' => 'Background Size',
                                'name' => 'banner_background_size',
                                'type' => 'select',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_ybmis',
                                            'operator' => '==',
                                            'value' => 'image',
                                        ) ,
                                    ) ,
                                ) ,
                                'wrapper' => array(
                                    'width' => '100',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'choices' => array(
                                    'auto' => 'auto',
                                    'cover' => 'cover',
                                    'contain' => 'contain'
                                ) ,
                                'allow_null' => 0,
                                'default_value' => '',
                                'layout' => 'horizontal',
                                'return_format' => 'value',
                            ) ,
        
                            array(
                                'key' => 'field_ybmiskr',
                                'label' => 'Background Repeat',
                                'name' => 'banner_background_repeat',
                                'type' => 'select',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_ybmis',
                                            'operator' => '==',
                                            'value' => 'image',
                                        ) ,
                                    ) ,
                                ) ,
                                'wrapper' => array(
                                    'width' => '100',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'choices' => array(
                                    'no-repeat' => 'no-repeat',
                                    'repeat' => 'repeat',
                                    'repeat-y' => 'repeat-y',
                                    'repeat-x' => 'repeat-x',
                                    'initial' => 'initial',
                                    'inherit' => 'inherit'
                                ) ,
                                'allow_null' => 0,
                                'default_value' => '',
                                'layout' => 'horizontal',
                                'return_format' => 'value',
                            ) ,
        
                        ) ,
                    ) ,
        
                    // Header Option
                   
                     array(
                        'key' => 'field_TfCbZ17c4cciu',
                        'label' => 'Header Settings',
                        'name' => 'header',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'placement' => 'left',
                        'endpoint' => 0,
                    ) ,
                    array(
                        'key' => 'key_header',
                        'label' => 'Header Layout',
                        'name' => 'header_layout',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'layout' => 'table',
                        'sub_fields' => array(

                            array(
                                'key' => 'acf_key_header_switch',
                                'label' => 'Display Header',
                                'name' => 'display_header',
                                'type' => 'button_group',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'choices' => array(
                                    'default' => 'Default',
                                    'yes' => 'yes',
                                    'no' => 'no',
                                ),
                                'wrapper' => array(
                                    'width' => '25%',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => 'default',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),

                            array(
                                'key' => 'header_layout_switch',
                                'label' => 'Header Layout',
                                'name' => 'header_layout_type',
                                'type' => 'button_group',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'acf_key_header_switch',
                                            'operator' => '==',
                                            'value' => 'yes',
                                        ),
                                    ),
                                ),
                                'choices' => array(
                                    'default' => 'Default',
                                    'custom' => 'Custom',
                                ),
                                'wrapper' => array(
                                    'width' => '25%',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => 'default',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
        
                            array(
                                'key' => 'header_layout_key',
                                'label' => 'Select Header',
                                'name' => 'header_layout_name',
                                'type' => 'select',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'header_layout_switch',
                                            'operator' => '==',
                                            'value' => 'custom',
                                        ),
                                    ),
                                ),
                                'wrapper' => [
                                    'width' => '25%',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'choices' => $this->get_hf_layout(),
                                'default_value' => [],
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 1,
                                'ajax' => 0,
                                'return_format' => 'value',
                                'placeholder' => '',
                            ),
                           
                            array(
                                'key' => 'field_logo',
                                'label' => 'Logo',
                                'name' => 'header_logo',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'acf_key_header_switch',
                                            'operator' => '==',
                                            'value' => 'default',
                                        ),
                                    ),
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'array',
                                'preview_size' => 'medium',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ),                      
                        ) ,
                    ) ,
        
        
        
                    // Footer Options
                    array(
                        'key' => 'field_1gY7e',
                        'label' => 'Footer Settings',
                        'name' => 'footer',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'placement' => 'left',
                        'endpoint' => 0,
                    ) ,
        
                    array(
                        'key' => 'acf_key_footer_switch',
                        'label' => 'Display Footer',
                        'name' => 'display_footer',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'choices' => array(
                            'default' => 'Default',
                            'yes' => 'yes',
                            'no' => 'no',
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,

                    array(
                        'key' => 'footer_layout_switch',
                        'label' => 'Footer Layout',
                        'name' => 'footer_layout_type',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'acf_key_footer_switch',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ),
                            ),
                        ),
                        'choices' => array(
                            'default' => 'Default',
                            'custom' => 'Custom',
                        ),
                        'wrapper' => array(
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),

                    array(
                        'key' => 'footer_layout_key',
                        'label' => 'Select Footer',
                        'name' => 'footer_layout_name',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'footer_layout_switch',
                                    'operator' => '==',
                                    'value' => 'custom',
                                ),
                            ),
                        ),
                        'wrapper' => [
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ],
                        'choices' => $this->get_hf_layout('footer'),
                        'default_value' => [],
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => '',
                    ),
        
                    array(
                        'key' => 'acf_key_footer',
                        'label' => 'Customize Footer',
                        'name' => 'acf_footer_options',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'footer_layout_switch',
                                    'operator' => '==',
                                    'value' => 'default',
                                ),
                            ),
                        ),
                        'choices' => array(
                            'default' => 'Default',
                            '1' => 'One Column',
                            '2' => 'Two Column',
                            '3' => 'Three Column',
                            '4' => 'Four Column',
                            '5' => 'Five Column',
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,
        
            
                    array(
                        'key' => 'field_footer_logo',
                        'label' => 'Footer Logo',
                        'name' => 'footer_logo',
                        'type' => 'image',
                        'instructions' => '',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'footer_layout_switch',
                                    'operator' => '==',
                                    'value' => 'default',
                                ),
                            ),
                        ),
                        'required' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
        
                    array(
                        'key' => 'field_footer_bg_color',
                        'label' => 'Background color',
                        'name' => 'footer_background_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'footer_layout_switch',
                                    'operator' => '==',
                                    'value' => 'default',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ) ,
        
                    // Color Options
                    array(
                        'key' => 'field_1ge',
                        'label' => 'Color Palette',
                        'name' => 'color_pallete',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'placement' => 'left',
                        'endpoint' => 0,
                    ) ,
                    array(
                        'key' => 'key_color_switch',
                        'label' => 'Use Color Palette?',
                        'name' => 'name_color_switch',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'choices' => array(
                            'default' => 'Default',
                            'yes' => 'yes',
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,
                    array(
                        'key' => 'key_color_pallete',
                        'label' => 'Color Options',
                        'name' => 'color_pallete',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'key_color_switch',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ) ,
                            ) ,
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'layout' => 'table',
                        'sub_fields' => array(
        
                            array(
                                'key' => 'field_primary_color',
                                'label' => 'Primary Color',
                                'name' => 'primary_color',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'default_value' => '',
                            ) ,
        
                            array(
                                'key' => 'field_secondary_color',
                                'label' => 'Secondary Color',
                                'name' => 'secondary_color',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'default_value' => '',
                            ) ,
        
                            array(
                                'key' => 'field_tertiary_color',
                                'label' => 'Tertiary Color',
                                'name' => 'text_color',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'default_value' => '',
                            ) ,
        
                            array(
                                'key' => 'field_title_color',
                                'label' => 'Title Color',
                                'name' => 'title_color',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'default_value' => '',
                            ) ,
        
                            array(
                                'key' => 'field_sub_title_color',
                                'label' => 'Sub Title Color',
                                'name' => 'sub_title_color',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'default_value' => '',
                            ) ,
                        ),
                    ),

                    array(
                        'key' => 'section_enable_rtl',
                        'label' => 'RTL Settings',
                        'name' => 'banner',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),

                    array(
                        'key' => 'key_enable_rtl',
                        'label' => 'Enable RTL?',
                        'name' => 'enable_rtl',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'choices' => array(
                            'default' => 'Default',
                            'yes' => 'Yes',
                            'no' => 'No',
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                ),

                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'page',
                        ) ,
        
                    ) ,
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'post',
                        ) ,
                    ) ,
        
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'team',
                        ) ,
        
                    ) ,
        
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'testimonial',
                        ) ,
                    ) ,
                ) ,
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        endif;
    }
}
