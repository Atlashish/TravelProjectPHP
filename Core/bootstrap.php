<?php

use Core\Database;
use Core\App;

App::bind('config', require 'config.php');
App::bind('database', new Database(App::resolver('config')['database']));

?>