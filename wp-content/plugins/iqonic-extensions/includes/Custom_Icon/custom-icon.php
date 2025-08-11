<?php 

add_filter( 'elementor/icons_manager/additional_tabs', function(){
	return [
		'ion-ionicons' => [
			'name' => 'ion-ionicons',
			'label' => __( 'Ionic Custom', 'iqonic' ),
			'url' => '',
			'enqueue' => '',
			'prefix' => 'ion-',
			'displayPrefix' => 'ion',
			'labelIcon' => 'ion ion-android-add',
			'ver' => '1.0',
			'fetchJson' => IQONIC_EXTENSION_PLUGIN_URL.'includes/Custom_Icon/assest/js/ionicons.js',
			'native' => true,
        ],
        'typ-typicons' => [
			'name' => 'typ-typicons',
			'label' => __( 'Typicons', 'iqonic' ),
			'url' => '',
			'enqueue' => '',
			'prefix' => 'typcn-',
			'displayPrefix' => 'typcn',
			'labelIcon' => 'typcn typcn-anchor',
			'ver' => '1.0',
			'fetchJson' => IQONIC_EXTENSION_PLUGIN_URL.'includes/Custom_Icon/assest/js/typicons.js',
			'native' => true,
		],
		'typ-flaticon' => [
			'name' => 'typ-flaticon',
			'label' => __( 'Flaticon', 'iqonic' ),
			'url' => '',
			'enqueue' => '',
			'prefix' => 'flaticon-',
			'displayPrefix' => 'flaticon',
			'labelIcon' => 'flaticon flaticon-accounting',
			'ver' => '1.0',
			'fetchJson' => IQONIC_EXTENSION_PLUGIN_URL.'includes/Custom_Icon/assest/js/flaticon.js',
			'native' => true,
		],
	];
}
);


add_action('elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style('ionicons', IQONIC_EXTENSION_PLUGIN_URL.'/includes/Custom_Icon/assest/css/ionicons.min.css',array(), '2.0.0', 'all');
	wp_enqueue_style('typicon', IQONIC_EXTENSION_PLUGIN_URL.'/includes/Custom_Icon/assest/css/typicon.min.css',array(), '2.0.9', 'all');
	wp_enqueue_style('flaticon', IQONIC_EXTENSION_PLUGIN_URL.'/includes/Custom_Icon/assest/css/flaticon.css',array(), '1.0.0', 'all');
});

/*---------------------------------------
		iqonic admin enque
---------------------------------------*/

function iqonic_font_plugin_script(){
	
	wp_enqueue_style('ionicons', IQONIC_EXTENSION_PLUGIN_URL.'/includes/Custom_Icon/assest/css/ionicons.min.css',array(), '2.0.0', 'all');
	wp_enqueue_style('typicon', IQONIC_EXTENSION_PLUGIN_URL.'/includes/Custom_Icon/assest/css/typicon.min.css',array(), '2.0.9', 'all');
	wp_enqueue_style('flaticon', IQONIC_EXTENSION_PLUGIN_URL.'/includes/Custom_Icon/assest/css/flaticon.css',array(), '1.0.0', 'all');
	
}

add_action( 'wp_enqueue_scripts', 'iqonic_font_plugin_script'  );
