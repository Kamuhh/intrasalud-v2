<?php
/**
 * Kivicare\Utility\Redux_Framework\Options\SocialMedia class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Redux_Framework\Options;
use Redux;
use Kivicare\Utility\Redux_Framework\Component;

class SocialMedia extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {

		Redux::set_section( $this->opt_name, array(
			'title'            => esc_html__( 'Social Media', 'kivicare' ),
			'id'               => 'social_link',
			'icon'             => 'el-icon-share',  
			'fields'           => array(
						
				array(
					'id'       => 'social-media-iq',
					'type'     => 'sortable',
					'title'    => esc_html__('Social Media Option', 'kivicare'),
					'subtitle' => esc_html__('Enter social media url.', 'kivicare'),
					'mode'     => 'text',
					'label'    => true,
					'options'  => array(
						'facebook-f'     => '#',
						'x-twitter'      => '#',
						'github'      	 => '',
						'tiktok' 		 => '',
						'instagram'      => '#',
						'linkedin'       => '',
						'tumblr'         => '',
						'pinterest'      => '',
						'dribbble'       => '',
						'reddit'         => '',
						'flickr'         => '',
						'skype'          => '',
						'youtube'        => '',
						'vimeo'          => '',
						'soundcloud'     => '',
						'wechat'         => '',
						'renren'         => '',
						'weibo'          => '',
						'xing'           => '',
						'qq'             => '',
						'rss'            => '',
						'vk'             => '',
						'behance'        => '',
						'snapchat'       => '',
					),
				),
				
			),
		) );
		
	
	}
}
