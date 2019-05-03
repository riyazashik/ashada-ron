<?php
define("DEBUG_MODE", true);
if(DEBUG_MODE){
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}else {
    ini_set('display_errors', 0);
    // error_reporting(1);
    error_reporting(E_ALL);
}

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", 'demo');
define("DB_NAME", "ashada");
?>
