<?php

namespace Iqonic\Acf;

class Testimonial
{
    public function __construct()
    {
        $this->set_testimonial_options();
    }

    public function set_testimonial_options()
    {
        if (function_exists('acf_add_local_field_group')) {

            // Page Options
            acf_add_local_field_group(array(
                'key' => 'group_46Cg7N74r8t811fR6',
                'title' => 'Testimonial Member Details',
                'fields' => array(
                    array(
                        'key' => 'field_7a2p3jBTfCbZ17c4c',
                        'label' => 'Member',
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
                        'key' => 'key_pjros12',
                        'label' => '',
                        'name' => 'member_detail_group',
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
                                'key' => 'field_WGCt5cd3bf759k',
                                'label' => 'Designation',
                                'name' => 'iqonic_testimonial_designation',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                               
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'message' => '',
                                'default_value' => 'designation',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ) ,
        
                            array(
                                'key' => 'field_WGCt5cbf75k',
                                'label' => 'Company',
                                'name' => 'iqonic_testimonial_company',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                               
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'message' => '',
                                'default_value' => 'company',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ) ,
        
                            array(
                                'key' => 'field_ybmisxy565',
                                'label' => 'Star',
                                'name' => 'star_select',
                                'type' => 'select',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ) ,
                                'choices' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5'
                                    
                                ) ,
                                'allow_null' => 0,
                                'default_value' => '',
                                'layout' => 'horizontal',
                                'return_format' => 'value',
                            ) ,
        
                            
        
                        ) ,
                    ) ,
                ) ,
                'location' => array(
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
        }
    }
}
