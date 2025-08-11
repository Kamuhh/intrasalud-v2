<?php
// Add standard elements option in the existing controls Columns
if (!function_exists('iqonic_addons_layouts_elementor_added_elements')) {
    add_action('elementor/element/before_section_end', 'iqonic_addons_layouts_elementor_added_elements', 10, 3);
    function iqonic_addons_layouts_elementor_added_elements($element, $section_id)
    {
        if (!is_object($element)) return;

        if (in_array($element->get_name(), array('section')) && $section_id == 'section_layout') {

            $element->add_control(
                'is_blur',
                [
                    'label' => esc_html__('Background Blur ', 'iqonic'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'yes' => esc_html__('Yes', 'iqonic'),
                    'no' => esc_html__('no', 'iqonic'),
                    'default' => 'no',
                ]
            );

            $element->add_control(
                'blur_val',
                [
                    'label' => esc_html__('Blur', 'iqonic'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 30,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'condition' => [
                        'is_blur' => 'yes'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} ' => 'backdrop-filter:blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}})',
                    ],
                ]
            );

            $element->add_control(
                'has_sticky_row',
                [
                    'label'         => __("Fix Row", 'iqonic-layouts'),
                    'label_block'   => false,
                    'type'          => \Elementor\Controls_Manager::SELECT,
                    'options'       => [
                        'no'            => __('No', 'iqonic-layouts'),
                        'yes'           => __('Yes', 'iqonic-layouts'),
                    ],
                    'default' => 'no',
                ]
            );
            $element->add_control(
                'default_hidden',
                [
                    'label'         => esc_html__('Default Hidden ?', 'iqonic-layouts'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__('yes', 'iqonic-layouts'),
                    'label_off'     => esc_html__('no', 'iqonic-layouts'),
                    'return_value'  => 'yes',
                    'condition'     => ['has_sticky_row' => 'yes'],
                    'default'       => 'no',
                ]
            );
        }
        if (in_array($element->get_name(), array('column')) && $section_id == 'layout') {

            $element->add_responsive_control('column_align', array(
                'label'         => __("Alignment", 'iqonic-layouts'),
                'label_block'   => false,
                'type'          => \Elementor\Controls_Manager::SELECT,
                'options'       => [
                    'inherit'       => __('Inherit', 'iqonic-layouts'),
                    'left'          => __('Left', 'iqonic-layouts'),
                    'right'         => __('Right', 'iqonic-layouts'),
                    'center'        => __('Center', 'iqonic-layouts'),
                    'between'       => __('Space Between', 'iqonic-layouts'),
                ],
                'default'       => 'inherit',
                'prefix_class'  => 'layouts-column%s-align-'
            ));

            $element->add_control('section_position', array(
                'label'         => __("Position", 'iqonic-layouts'),
                'label_block'   => false,
                'type'          => \Elementor\Controls_Manager::SELECT,
                'options'       => [
                    'none'       => __('None', 'iqonic-layouts'),
                    'static'     => __('Static', 'iqonic-layouts'),
                ],
                'default'       => 'none',
                'prefix_class'  => 'layouts-section-position-'
            ));
        }

        if (in_array($element->get_name(), array('section', 'column')) && in_array($section_id, array('_section_responsive', '_responsive'))) {
            $element->add_control(
                'show_in_laptop',
                [
                    'label'         => __('Visiblity on laptop', 'iqonic-layouts'),
                    'type'          => \Elementor\Controls_Manager::SELECT,
                    'description'   => 'From 1199px width',
                    'options'       => [
                        'select'        => __('Select', 'iqonic-layouts'),
                        'show'          => __('Show', 'iqonic-layouts'),
                        'hide'          => __('Hide', 'iqonic-layouts'),
                    ],
                    'default'       => 'select',
                ]
            );
        }
    }
}
// Add class to the wrapper of the row
if (!function_exists('iqonic_addons_elementor_add_layout_class')) {
    add_action('elementor/frontend/widget/before_render',  'iqonic_addons_elementor_add_layout_class', 11, 1);

    function iqonic_addons_elementor_add_layout_class($element)
    {
        if (!is_object($element)) return;
        $element->add_render_attribute('_wrapper', 'class', 'hf-elementor-layout');
    }
}

if (!function_exists('iqonic_addons_elementor_add_responsive_class')) {
    add_action('elementor/frontend/before_render',  'iqonic_addons_elementor_add_responsive_class', 10, 1);

    function iqonic_addons_elementor_add_responsive_class($element)
    {
        if (!is_object($element)) return;

        if (in_array($element->get_name(), array('section', 'column'))) {
            $settings = $element->get_settings();
            if (isset($settings['has_sticky_row']) && $settings['has_sticky_row'] === 'yes') {
                $element->add_render_attribute('_wrapper', 'class', 'has-sticky');
                if (isset($settings['default_hidden']) && $settings['default_hidden'] === 'yes') {
                    $element->add_render_attribute('_wrapper', 'class', 'header-default-hidden default-hidden-enable');
                }
            }
            if (isset($settings['show_in_laptop']) && $settings['show_in_laptop'] === 'hide') {
                $element->add_render_attribute('_wrapper', 'class', 'hf-hide-on-laptop');
            }
            if (isset($settings['show_in_laptop']) && $settings['show_in_laptop'] === 'show') {
                $element->add_render_attribute('_wrapper', 'class', 'hf-show-on-laptop');
            }
        }
    }
}

// cleare cache on save while additional breakpoints enabled.
$has_additional_breakpoints = get_option("elementor_experiment-additional_custom_breakpoints");
if ($has_additional_breakpoints != "inactive") {
    add_action('elementor/document/after_save',  'clear_cache_when_updating_elementor');
    function clear_cache_when_updating_elementor()
    {
        \Elementor\Plugin::instance()->files_manager->clear_cache();
    }
}
