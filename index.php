<?php

use Core\Request;
use Core\Router;

require 'vendor/autoload.php';
require 'Core/bootstrap.php';

Router::build('App/routes.php')->route(Request::uri(), Request::method());
?>

