<?php

namespace Iqonic\Acf;

class Pricing
{
    public function __construct()
    {
        $this->set_general_options();
    }

    public function set_general_options()
    {
        if (function_exists('acf_add_local_field_group')) :
            $show_count = 0; // 1 for yes, 0 for no
            $pad_counts = 0; // 1 for yes, 0 for no
            $hierarchical = 1; // 1 for yes, 0 for no
            $new_cat_link = '<a href="' . admin_url("edit-tags.php?taxonomy=pricing_categories&post_type=pricing") . '" target="_blank"> >> Add New or Remove</a>';
            $args = [
                'taxonomy' => 'pricing_categories',
                'show_count' => $show_count,
                'pad_counts' => $pad_counts,
                'hierarchical' => $hierarchical,
                'hide_empty' => false,
                'parent' => 0
            ];
            $categories = new \WP_Term_Query($args);
            $cat_list = [];
            if ($categories->terms) {
                foreach ($categories->terms as $cat) {

                    $cat_data = array(
                        'key' => $cat->slug,
                        'label' => $cat->name,
                        'name' => $cat->slug,
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    );
                    $case = get_term_meta($cat->term_id, 'name_cat_type', true);
                    $case = !empty($case) ? $case : 'checkbox';
                    switch ($case) {
                        case 'checkbox':
                            $cat_list[] = array_merge(
                                $cat_data,
                                [
                                    'type' => 'radio',
                                    'message' => '',
                                    'default_value' => 0,
                                    'choices' => [
                                        'yes' => 'Yes',
                                        'no' => 'No'
                                    ],
                                    'allow_null' => 0,
                                    'other_choice' => 0,
                                    'save_other_choice' => 0,
                                    'layout' => 'horizontal',
                                    'return_format' => 'value',
                                ]
                            );
                            break;
                        case 'text':
                            $cat_list[] = array_merge(
                                $cat_data,
                                [
                                    'type' => 'text',
                                    'message' => '',
                                    'placeholder' => '',
                                    'default_value' => '',
                                ]
                            );
                            break;
                    }
                }
            }

            // Price Options
            acf_add_local_field_group(array(
                'key' => 'group_465Cg7N74r8t811VLFfR6',
                'title' => 'Pricing Data',
                'fields' => array(
                    array(
                        'key' => 'key_desc',
                        'label' => 'Description',
                        'name' => 'price_desc',
                        'type' => 'text',
                        'instructions' => '',
                        'placeholder' => 'e.g : Lorem Ipsum',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '100%',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),
                    array(
                        'key' => 'key_price',
                        'label' => 'Monthly Price',
                        'name' => 'name_price',
                        'type' => 'text',
                        'instructions' => '',
                        'placeholder' => 'e.g : $20',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),

                    array(
                        'key' => 'key_price_yearly',
                        'label' => 'Yearly Price',
                        'name' => 'name_price_yearly',
                        'type' => 'text',
                        'instructions' => '',
                        'placeholder' => 'e.g : $200',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),

                    array(
                        'key' => 'key_pricing_link',
                        'label' => 'Pricing Button Link',
                        'name' => 'name_pricing_link',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '100%',
                            'class' => '',
                            'id' => '',
                        ],
                        'post_type' => [
                            'page'
                        ],
                        'type' => 'radio',
                        'message' => '',
                        'default_value' => 'dynamic',
                        'choices' => [
                            'dynamic' => __('Dynamic', "iqonic"),
                            'custom' => __('Custom', "iqonic")
                        ],
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'taxonomy' => [],
                        'multiple' => 0,
                    ),
                    array(
                        'key' => 'key_pricing_redirect_link',
                        'label' => 'Pricing Button Redirect Link',
                        'name' => 'pricing_redirect_link',
                        'type' => 'page_link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'key_pricing_link',
                                    'operator' => '==',
                                    'value' => 'dynamic',
                                ),
                            ),
                        ),
                        'wrapper' => [
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ],
                        'post_type' => [
                            'page'
                        ],
                        'taxonomy' => [],
                        'allow_null' => 0,
                        'allow_archives' => 1,
                        'multiple' => 0,
                    ),
                   
                    array(
                        'key' => 'key_pricing_custom_link',
                        'label' => 'Pricing Button Redirect Link',
                        'name' => 'pricing_custom_link',
                        'type' => 'text',
                        'instructions' => '',
                        'placeholder' => 'https://your-link.com',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'key_pricing_link',
                                    'operator' => '==',
                                    'value' => 'custom',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '50%',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),

                    array(
                        'key' => 'key_pricing_custom_link_type',
                        'label' => 'Open in new window',
                        'name' => 'pricing_custom_link_type',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'key_pricing_link',
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
                        'type' => 'radio',
                        'message' => '',
                        'default_value' => 0,
                        'choices' => [
                            'yes' => __('Yes', "iqonic"),
                            'no' => __('No', "iqonic")
                        ],
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'taxonomy' => [],
                        'multiple' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'pricing',
                        ),
                    ),


                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));

            acf_add_local_field_group(array(
                'key' => 'group_465Cg7Ndjsfksdhflgdfl',
                'title' => 'Plan includes' . $new_cat_link,
                'fields' => $cat_list,
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'pricing',
                        ),
                    ),


                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
            acf_add_local_field_group(array(
                'key' => 'group_465Cg7Nksdhflgdfl',
                'title' => 'Category Data',
                'fields' => array(
                    [
                        'key' => 'key_cat_type',
                        'label' => 'Select type',
                        'name' => 'name_cat_type',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'choices' => [
                            'checkbox' => 'Yes/No',
                            'text' => 'Text'
                        ],
                        'default_value' => [],
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => '',
                    ],
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'pricing_categories',
                        ),
                    ),
                ),
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
