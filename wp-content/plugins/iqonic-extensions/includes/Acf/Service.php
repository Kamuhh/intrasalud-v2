<?php

namespace Iqonic\Acf;

class Service
{
    public function __construct()
    {
        $this->set_services_options();
    }

    public function set_services_options()
    {
        if (function_exists('acf_add_local_field_group')) {
            // Page Options
            acf_add_local_field_group(array(
                'key'    => 'group_servicer8t1781',
                'title'  => 'Service Details',
                'fields' => array(
                    array(
                        'key' => 'field_service_icon_one',
                        'label' => 'Service Icon',
                        'name' => 'service_icon_one',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'wrapper' => array(
                            'width' => '50%',
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
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'service',
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
        }
    }
}
