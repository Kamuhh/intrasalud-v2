<?php

return [
    'Elements' => [
        'general' => [
            'dependency' => [
                'js' => [
                    [
                        'name' => 'general',
                        'src' => 'assets/js/general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'general',
                        'src' => 'assets/css/general.css'
                    ]
                ],

            ]
        ],

           /* WorkingHours */
           'iqonic_working_hours' => [
            'class' => 'Iqonic\Elementor\Elements\WorkingHours\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'working-hours',
                        'src' => 'assets/css/working-hours.css'
                    ]
                ],
            ]
        ],

        /* Iconbox List*/
        'iqonic_icon_list' => [
            'class' => 'Iqonic\Elementor\Elements\IconBox_List\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'iconBox_List',
                        'src' => 'assets/css/iconBox_List.css'
                    ]
                ]
            ]
        ],
        /* Blog */
        'Iq_Blog' => [
            'class' => 'Iqonic\Elementor\Elements\Blog\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'Blog',
                        'src' => 'assets/css/blog.css'
                    ]
                ],
            ]
        ],
        /* Blog Masonary */
        'Iq_Blog_Masonary' => [
            'class' => 'Iqonic\Elementor\Elements\BlogMasonary\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'isotope-pkgd',
                        'src' => 'assets/js/isotope.pkgd.min.js'
                    ],
                    [
                        'name' => 'blog-masonary',
                        'src' => 'assets/js/blog-masonary.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'blog-masonary',
                        'src' => 'assets/css/blog-masonary.css'
                    ]
                ],
            ]
        ],
        /* Title */
        'section_title' => [
            'class' => 'Iqonic\Elementor\Elements\Title\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'Title',
                        'src' => 'assets/css/title.css'
                    ]
                ],
            ]
        ],

        /* Button */
        'iqonic-Button' => [
            'class' => 'Iqonic\Elementor\Elements\Button\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'button',
                        'src' => 'assets/css/button.css'
                    ]
                ],
            ]
        ],
        /* Scrolling Text */
        'Iq_scrolling_text' => [
            'class' => 'Iqonic\Elementor\Elements\ScrollingText\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'scrolling-text',
                        'src' => 'assets/js/scrolling-text.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'scrolling-text',
                        'src' => 'assets/css/scrolling-text.css'
                    ]
                ],
            ]
        ],
        /* circle chart */
        'circle_chart' => [
            'class' => 'Iqonic\Elementor\Elements\CircleChart\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'circleChart',
                        'src' => 'assets/js/circleChart.min.js'
                    ],
                    [
                        'name' => 'circle-chart',
                        'src' => 'assets/js/circle-chart.js'
                    ]
                ],
            ]
        ],
        /* doctor info */
        'Iq_Doc_Info' => [
            'class' => 'Iqonic\Elementor\Elements\DoctorInfo\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'doctor-info',
                        'src' => 'assets/css/doctor-info.css'
                    ]
                ],
            ]
        ],
        /* Accordion */
        'iqonic_accordion' => [
            'class' => 'Iqonic\Elementor\Elements\Accordion\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'accordion_faq',
                        'src' => 'assets/js/accordion_faq.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'accordion',
                        'src' => 'assets/css/accordion.css'
                    ]
                ],
            ]
        ],
        /* Client */
        'Client' => [
            'class' => 'Iqonic\Elementor\Elements\Client\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'client',
                        'src' => 'assets/css/client.css'
                    ]
                ],
            ]
        ],
        /* Count Downt */
        'iqonic_count_down' => [
            'class' => 'Iqonic\Elementor\Elements\CountDown\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'jQuery-countdownTimer-min',
                        'src' => 'assets/js/jQuery.countdownTimer.min.js'
                    ],
                    [
                        'name' => 'custom-countdown ',
                        'src' => 'assets/js/custom-countdown.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'countdown',
                        'src' => 'assets/css/countdown.css'
                    ]
                ],
            ]
        ],
        /* Counter */
        'iqonic_counter' => [
            'class' => 'Iqonic\Elementor\Elements\Counter\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'jquery-countTo',
                        'src' => 'assets/js/jquery.countTo.js'
                    ],
                    [
                        'name' => 'appear',
                        'src' => 'assets/js/appear.js'
                    ],
                    [
                        'name' => 'counter',
                        'src' => 'assets/js/counter.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'counter',
                        'src' => 'assets/css/counter.css'
                    ]
                ],
            ]
        ],
        /* Divider */
        'iq_divider' => [
            'class' => 'Iqonic\Elementor\Elements\Divider\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'divider',
                        'src' => 'assets/css/divider.css'
                    ]
                ],
            ]
        ],
        /* Fancy Box */
        'iqonic_fancybox' => [
            'class' => 'Iqonic\Elementor\Elements\FancyBox\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'fancybox',
                        'src' => 'assets/css/fancybox.css'
                    ]
                ],
            ]
        ],
        /* Flip Box */
        'iq_flip_box' => [
            'class' => 'Iqonic\Elementor\Elements\FlipBox\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'flipbox',
                        'src' => 'assets/css/flipbox.css'
                    ]
                ],
            ]
        ],
        /* Icon Box */
        'iqonic_icon_box' => [
            'class' => 'Iqonic\Elementor\Elements\IconBox\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'iconbox',
                        'src' => 'assets/css/iconbox.css'
                    ]
                ],
            ]
        ],
        /* Lists */
        'iqonic_lists' => [
            'class' => 'Iqonic\Elementor\Elements\Lists\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'list',
                        'src' => 'assets/css/list.css'
                    ]
                ],
            ]
        ],
        /* Progress */
        'iqonic_progressbar' => [
            'class' => 'Iqonic\Elementor\Elements\Progress\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'appear',
                        'src' => 'assets/js/appear.js'
                    ],
                    [
                        'name' => 'progress',
                        'src' => 'assets/js/progress.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'progress',
                        'src' => 'assets/css/progress.css'
                    ]
                ],
            ]
        ],
        /* Slider with Text */
        'Iq_Slider_With_Text' => [
            'class' => 'Iqonic\Elementor\Elements\SliderText\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'slick-min',
                        'src' => 'assets/js/slick.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ],
                    [
                        'name' => 'slick-general',
                        'src' => 'assets/js/slick-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'slider-text',
                        'src' => 'assets/css/slider-text.css'
                    ]
                ],
            ]
        ],
        /* Team */
        'team' => [
            'class' => 'Iqonic\Elementor\Elements\Team\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'team',
                        'src' => 'assets/css/team.css'
                    ]
                ],
            ]
        ],
       
       
        
       /* Project */
        'team_tab' => [
            'class' => 'Iqonic\Elementor\Elements\TeamTab\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'team',
                        'src' => 'assets/css/team.css'
                    ]
                ],
            ]
        ],
        
        /* Testimonial Slick */
        'Iq_Testimonial_slick' => [
            'class' => 'Iqonic\Elementor\Elements\TestimonialSwiper\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'slick-min',
                        'src' => 'assets/js/slick.min.js'
                    ],
                    [
                        'name' => 'swiper-bundle-min',
                        'src' => 'assets/js/swiper-bundle.min.js'
                    ],
                    [
                        'name' => 'swiper-general',
                        'src' => 'assets/js/swiper-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'swiper-bundle-min',
                        'src'  => 'assets/css/swiper-bundle.min.css'
                    ],
                    [
                        'name' => 'slick-testimonial',
                        'src' => 'assets/css/slick-testimonial.css'
                    ]
                ],
            ]
        ],

         /* Testimonial */
        'iq_testimonial' => [
            'class' => 'Iqonic\Elementor\Elements\Testimonial\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ],
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'testimonial',
                        'src' => 'assets/css/testimonial.css'
                    ],
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                  
                ],
            ]
        ],

        /* Title Slider */
        'section_title_slider' => [
            'class' => 'Iqonic\Elementor\Elements\TitleSlider\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ]
                ],
            ]
        ],
        /* Video Popup */
        'iqonic_popup_video' => [
            'class' => 'Iqonic\Elementor\Elements\VideoPopup\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'jquery-magnific-popup-min',
                        'src' => 'assets/js/jquery.magnific-popup.min.js'
                    ],
                    [
                        'name' => 'video-popup',
                        'src' => 'assets/js/video-popup.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'magnific-popup',
                        'src'  => 'assets/css/magnific-popup.css'
                    ],
                    [
                        'name' => 'video-popup',
                        'src' => 'assets/css/video-popup.css'
                    ]
                ],
            ]
        ],

        /* Vertcile Timeline */
        'iqonic-VerticalTimeline' => [
            'class' => 'Iqonic\Elementor\Elements\VerticalTimeline\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'VerticalTimeline',
                        'src' => 'assets/css/verticaltimeline.css'
                    ]
                ],
            ]
        ],

        /* Service Slider*/
        'iqonic_service_slider' => [
            'class' => 'Iqonic\Elementor\Elements\ServiceSlider\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'swiper-bundle-min',
                        'src' => 'assets/js/swiper-bundle.min.js'
                    ],
                    [
                        'name' => 'swiper-general',
                        'src' => 'assets/js/swiper-general.js'
                    ],
                    [
                        'name' => 'service-slider',
                        'src' => 'assets/js/service-slider.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'swiper-bundle-min',
                        'src'  => 'assets/css/swiper-bundle.min.css'
                    ],
                    [
                        'name' => 'service-slider',
                        'src' => 'assets/css/service-slider.css'
                    ]
                ],
            ]
        ],

        /* Service List*/
        'iqonic_service_grid' => [
            'class' => 'Iqonic\Elementor\Elements\ServiceGrid\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'servicelist',
                        'src' => 'assets/css/servicegrid.css'
                    ]
                ],
            ]
        ],

        /* Before After Image */
        'iqonic_before_after_image' => [
            'class' => 'Iqonic\Elementor\Elements\Before_After_Image\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'iqonic-event-move',
                        'src' => 'assets/js/jquery.event.move.js'
                    ],
                    [
                        'name' => 'jquery-twentytwenty.',
                        'src' => 'assets/js/jquery.twentytwenty.js'
                    ],
                    [
                        'name' => 'before-after-img',
                        'src' => 'assets/js/before-after-img.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'before-after',
                        'src' => 'assets/css/before-after.css'
                    ],
                ],
            ]
        ],

        /* gallery */
        'iqonic_gallery' => [
            'class' => 'Iqonic\Elementor\Elements\Gallery\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'jquery-magnific-popup-min',
                        'src' => 'assets/js/jquery.magnific-popup.min.js'
                    ],
                    [
                        'name' => 'imagesloaded-pkgd',
                        'src' => 'assets/js/imagesloaded.pkgd.min.js'
                    ],
                    [
                        'name' => 'masonry-pkgd',
                        'src' => 'assets/js/masonry.pkgd.min.js'
                    ],
                    [
                        'name' => 'gallery',
                        'src' => 'assets/js/gallery.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'magnific-popup',
                        'src'  => 'assets/css/magnific-popup.css'
                    ],
                    [
                        'name' => 'Gallery',
                        'src' => 'assets/css/gallery.css'
                    ],
                ],
            ]
        ],

        /* Image Box */

        'iqonic_imageBox' => [
            'class' => 'Iqonic\Elementor\Elements\ImageBox\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'ImageBox',
                        'src' => 'assets/css/imagebox.css'
                    ]
                ],
            ]
        ],


        // WooCoomerce products
        'Woo_Product_Grid' => [
            'class' => 'Iqonic\Elementor\Elements\Products\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'product-ajax',
                        'src' => 'assets/js/product-ajax.js'
                    ],
                ],
            ],
        ],

        // WooCoomerce User
        'iqonic_user_nav_menu' => [
            'class' => 'Iqonic\Elementor\Elements\UserNavMenu\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'woocommerce-user',
                        'src' => 'assets/js/woocommerce-user.js'
                    ],
                    [
                        'name' => 'cart',
                        'src' => 'assets/js/cart.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'woocommerce-user',
                        'src' => 'assets/css/woocommerce-user.css'
                    ]
                ],
            ]
        ],

         /* Pricing  */
        'iqonic-pricing-plan' => [
            'class' => 'Iqonic\Elementor\Elements\PricingPlan\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'pricing-plan',
                        'src' => 'assets/css/pricing-plan.css'
                    ]
                ],
            ]
        ],

         /* Pricing  */
         'iqonic_pricing_tab' => [
            'class' => 'Iqonic\Elementor\Elements\PricingTab\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'pricing-tab',
                        'src' => 'assets/js/pricing-tab.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'pricing-tab',
                        'src' => 'assets/css/pricing-tab.css'
                    ]
                ],
            ]
        ],

        /* hamburger animated icon */
        'iqonic_hamburger_animatedicon' => [
            'class' => 'Iqonic\Elementor\Elements\HamburgerAnimatedIcon\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'hamburger-animated-icon',
                        'src' => 'assets/js/hamburger-animated-icon.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'hamburger-animated-icon',
                        'src' => 'assets/css/hamburger-animated-icon.css'
                    ]
                ],
            ]
        ],

        /********** Iqonic layout Header **********/

        //Navigation
        'iqonic_navigation' => [
            'class' => 'Iqonic\Elementor\Elements\Navigation\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'menu',
                        'src' => 'assets/js/menu.js'
                    ],
                ],
                'css' => [
                    [
                        'name' => 'layout-menu',
                        'src' => 'assets/css/menu.css'
                    ],
                ],
            ]
        ],

        // Footer Navigation
        'iqonic_footer_navigation' => [
            'class' => 'Iqonic\Elementor\Elements\FooterNavigation\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'footer-menu',
                        'src' => 'assets/css/footer-menu.css'
                    ]
                ],
            ]
        ],

        /* Social Icons */
        'iqonic_social_icons' => [
            'class' => 'Iqonic\Elementor\Elements\Social_Icons\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'socials-icon',
                        'src' => 'assets/css/social-icons.css'
                    ]
                ],
            ]
        ],

        /* Recent Post */
        'iqonic_recent_post' => [
            'class' => 'Iqonic\Elementor\Elements\RecentPost\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'recen-tpost',
                        'src' => 'assets/css/recent-post.css'
                    ]
                ],
            ]
        ],
        
         /* Images effect */
        'iqonic_image' => [
            'class' => 'Iqonic\Elementor\Elements\Image\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'tilt',
                        'src' => 'assets/js/tilt.js'
                    ],
                ],
                'css' => [
                    [
                        'name' => 'iqonic-image',
                        'src' => 'assets/css/image.css'
                    ]
                ],
            ]
        ],
        /* Social icons effects */
        'iqonic_social_icons_effects' => [
            'class' => 'Iqonic\Elementor\Elements\SocialIconsEffects\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'social-icons-effects',
                        'src' => 'assets/css/social-icons-effects.css'
                    ]
                ],
            ]
        ],

        // Search
        'iqonic_search' => [
            'class' => 'Iqonic\Elementor\Elements\Search\Widget',
        ],
        // Cart
        'iqonic_cart' => [
            'class' => 'Iqonic\Elementor\Elements\Cart\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'cart',
                        'src' => 'assets/js/cart.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'cart',
                        'src' => 'assets/css/cart.css'
                    ]
                ],
            ]
        ],

         // Ajax Search
         'iqonic_ajaxsearch' => [
            'class' => 'Iqonic\Elementor\Elements\Ajax_Search\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'ajaxsearch',
                        'src' => 'assets/js/ajaxsearch.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'ajaxsearch',
                        'src' => 'assets/css/ajaxsearch.css'
                    ]
                ],
            ]
        ],

        // WooCoomerce login
        'iqonic_woocommerce_login' => [
            'class' => 'Iqonic\Elementor\Elements\WoocommerceLogin\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'woocommerce-login',
                        'src' => 'assets/css/woocommerce-login.css'
                    ]
                ],
            ]
        ],

        // Tab
        'iqonic_tabs' => [
            'class' => 'Iqonic\Elementor\Elements\Tab\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'iqonictab',
                        'src' => 'assets/css/tab.css'
                    ],
                ],
            ]
        ],

        /* Mailchimp */
        'iqonic_mailchimp' => [
            'class' => 'Iqonic\Elementor\Elements\Mailchimp\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'mailchimp',
                        'src' => 'assets/css/mailchimp.css'
                    ]
                ],  
            ]
        ],


    ]
];
