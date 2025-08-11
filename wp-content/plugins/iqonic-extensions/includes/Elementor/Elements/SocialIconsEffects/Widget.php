<?php

namespace Iqonic\Elementor\Elements\SocialIconsEffects;

use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
	public function get_name()
	{
		return 'iqonic_social_icons_effects';
	}

	public function get_title()
	{
		return __('Iqonic Social Icons Effects', 'iqonic');
	}
	public function get_categories()
	{
		return ['iqonic-extension'];
	}

	public function get_icon()
	{
		return 'eicon-social-icons';
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => __('Social Icons', 'iqonic'),
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings();
		require 'render.php';
	}
}
