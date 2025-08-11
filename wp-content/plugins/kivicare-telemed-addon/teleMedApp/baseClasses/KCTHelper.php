<?php

namespace TeleMedApp\baseClasses;

class KCTHelper extends KCTBaseClass {

    public function __construct() {
        
    }

    public function getOption ( $name ) {
      return  get_option( KIVI_CARE_TELEMED_PREFIX . $name );
    }

    public function updateOption ( $name, $value, $autoload = 'no' ) {
      return update_option( KIVI_CARE_TELEMED_PREFIX . $name, $value, $autoload );
    }

}