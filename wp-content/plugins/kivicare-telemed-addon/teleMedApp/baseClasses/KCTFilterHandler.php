<?php

namespace TeleMedApp\baseClasses;


use App\baseClasses\KCBase;

class KCTFilterHandler extends KCBase {

	public function init() {

		$api_folder_path = plugin_dir_path( dirname( __FILE__, 2 ) ) . 'teleMedApp/filters/';
		$dir = scandir($api_folder_path);

		if (count($dir)) {
			foreach ($dir as $controller_name) {
				if (strpos($controller_name, '.') !== 0 && $controller_name !== "." && $controller_name !== ".." && $controller_name !== ".controllers.php" && $controller_name !== ".filters.php" && $controller_name !== ".baseClasses.php") {
					$controller_name = explode( ".", $controller_name)[0];
					$this->call($controller_name);
				}
			}
		}
	}

	public function call($controllerName) {
		
		$controller = 'TeleMedApp\\filters\\' . $controllerName;
		(new $controller);
	}

}