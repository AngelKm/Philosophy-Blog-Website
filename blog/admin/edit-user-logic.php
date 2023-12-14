<?php
require 'config/database.php';

// get edit-user form data if submit button was clicked
if(isset($_POST['submit'])) {
    // get form inputs and sanitize them
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // check for valid input
    if (!$firstname || !$lastname) { // if first and last name are empty
        $_SESSION['edit-user'] = "Invalid form input on edit user page.";
    } else {
        // update user
        $query = "UPDATE user SET 
        `firstname` = '$firstname', 
        `lastname` = '$lastname',     
        `is_admin` = $is_admin 
        WHERE id = $id LIMIT 1"; // LIMIT to make sure we only update 1 user

        // pass the query to the database
        $result = mysqli_query($connection, $query);

        // check for errors
        if (mysqli_errno($connection)) {
            $_SESSION['edit-user'] = "Failed to update user.";
        } else { // user was edited
            $_SESSION['edit-user-success'] = "User  $firstname $lastname updated successfully.";
        }
    }
}
// go to manage users page
header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();
?>