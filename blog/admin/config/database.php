<?php 
require 'constants.php';


// connect to the database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// check if there's any errors
if(mysqli_errno($connection)) {
    die(mysqli_error($connection));
}

?> 