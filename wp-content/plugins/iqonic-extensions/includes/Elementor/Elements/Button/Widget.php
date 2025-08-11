<?php

namespace Iqonic\Elementor\Elements\Button;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iq_button';
    }

    public function get_title()
    {
        return __('Iqonic Button', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-button';
    }
    protected function register_controls()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
    }
}
