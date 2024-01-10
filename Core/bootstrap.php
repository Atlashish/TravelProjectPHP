<?php 
// The provided code use the App class to bind instances of the Database class and a configuration array.

use Core\Database;
use Core\App;

App::bind('config', require 'config.php');
App::bind('database', new Database(App::get('config')['database']));

?>