<?php

namespace ProApp\baseClasses ;
use App\baseClasses\KCBase;

class KCProFilterHandler extends KCBase {

    /**
     * require all filters class files
     * @return void
     */
    public function init() {
        $api_folder_path = plugin_dir_path( dirname( __FILE__, 2 ) ) . 'proApp/filters/';
        $dir = scandir($api_folder_path);
        if (count($dir)) {
            foreach ($dir as $controller_name) {
                if ($controller_name !== "." && $controller_name !== ".." && $controller_name !== ".controllers.php" && $controller_name !== ".filters.php") {
                    $controller_name = explode( ".", $controller_name)[0];
                    $this->call($controller_name);
                }
            }
        }
    }

    /**
     * initiate class
     * @param $controllerName
     * @return void
     */
    public function call($controllerName) {
        $controller = 'ProApp\\filters\\' . $controllerName;
        (new $controller);
    }

}


