<?php

/**
 * Kivicare\Utility\Dynamic_Style\Styles\Maintenance class
 *
 * @package kivicare
 */

namespace Kivicare\Utility\Dynamic_Style\Styles;   

use Kivicare\Utility\Dynamic_Style\Component;
use function add_action;

class Maintenance extends Component
{

    public function __construct()
    {
        $this->kivicare_maintenance_mode();   
        
    }

    public function kivicare_maintenance_mode()
    {
        $kivicare_options = get_option('kivi_options');
            global $pagenow;
            if (isset($kivicare_options['mainte_mode']) && $kivicare_options['mainte_mode'] == "yes") {
                if ($pagenow !== 'wp-login.php' && !current_user_can('manage_options') && !is_admin()) {
                    require_once get_template_directory() . '/template-parts/maintenance/maintenance.php';
                    exit;
                }
            }
    }
}
