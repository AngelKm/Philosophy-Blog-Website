<?php 
require '../partials/header.php'; // get all header code from partials header

// makes sure user can't access admin if not signed in
// check sign in status
if (!isset($_SESSION['user-id'])) {
    // go back to the sign in page
    header('location: ' . ROOT_URL . 'signin.php');
    die();    
}
 
