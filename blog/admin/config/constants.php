<?php 
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 


// root url of the project
define('ROOT_URL', 'http://localhost/blog/');
// defining he host, user, password and database
// try to user = angel, pass = admin1
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog');
?> 