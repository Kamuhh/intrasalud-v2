<?php

namespace Iqonic\Acf;

class Team
{
    public function __construct()
    {
        $this->set_team_options();
    }

    public function set_team_options()
    {
        if (function_exists('acf_add_local_field_group')) {
            // Page Options
            acf_add_local_field_group(array(
                'key' => 'group_46Cg7N74r8t81',
                'title' => 'Social Details',
                'fields' => array(
                    array(
                        'key' => 'field_7a2p3jBTfCbZ17',
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
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),
                    array(
                        'key' => 'key_pjros1245',
                        'label' => '',
                        'name' => 'member_detail_group',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,

                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'table',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_WGCt5cd3bf79k',
                                'label' => 'Facebook',
                                'name' => 'iqonic_team_facebook',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,

                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => '',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),

                            array(
                                'key' => 'field_WGCt53f759k',
                                'label' => 'Twitter',
                                'name' => 'iqonic_team_twitter',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,

                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => '',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),

                            array(
                                'key' => 'field_WGCt5cd3bf59k',
                                'label' => 'Google',
                                'name' => 'iqonic_team_google',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,

                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => '',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
                            array(
                                'key' => 'field_WGCt5c3f759k',
                                'label' => 'Github',
                                'name' => 'iqonic_team_github',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,

                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => '',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
                            array(
                                'key' => 'field_WGCt5cd3f759k',
                                'label' => 'Instagram',
                                'name' => 'iqonic_team_insta',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,

                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => '',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
                            array(
                                'key' => 'field_whatsapp',
                                'label' => 'WhatsApp',
                                'name' => 'iqonic_team_whatsapp',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => '',
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
                        ),
                    ),
                ),
                'location' => array(


                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'team',
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
