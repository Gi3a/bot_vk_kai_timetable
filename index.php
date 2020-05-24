<?php

require 'application/lib/Dev.php';

use application\core\Router;

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});
<<<<<<< HEAD

session_start();

=======
session_start();
>>>>>>> 47dcd6f92d43d368c2ce76dffacfcb9d0f5f655d
$router = new Router;
$router->run();