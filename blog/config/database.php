<?php 
// file will be included in the head of partial
require 'config/constants.php';

// connect to the database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// check if there's any errors
if(mysqli_errno($connection)) {
    die(mysqli_error($connection));
}

?> 