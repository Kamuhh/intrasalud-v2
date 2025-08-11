<?php

return [
    'Elements' => [
        'general' => [
            'dependency' => [
                'js' => [
                    [
                        'name' => 'layout-general',
                        'src' => 'assets/js/general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'layout-general',
                        'src' => 'assets/css/general.css'
                    ],
                ],

            ]
        ],
        'iqonic_layouts' => [
            'class' => 'Iqonic_Layouts\Elementor\Elements\Layout\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'custom-layout',
                        'src' => 'assets/js/custom-layouts.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'custom-layout',
                        'src' => 'assets/css/custom-layouts.css'
                    ]
                ],
            ]
        ],
        'iqonic_logo' => [
            'class' => 'Iqonic_Layouts\Elementor\Elements\Logo\Widget',
        ],
    ]
];
