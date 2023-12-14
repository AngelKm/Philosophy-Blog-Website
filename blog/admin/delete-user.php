<?php
require 'config/database.php';

// delete user using the id
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // get curent user from the database table
    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    // delete user from database table
    $delete_user_query = "DELETE FROM user WHERE id = $id";
    // pass the query to the database
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    // check for errors
    if (mysqli_errno($connection)) {
        $_SESSION['delete-user'] = "Failed to delete '{$user['firstname']} {$user['lastname']}' ";
    } else {
        $_SESSION['delete-user-success'] = "Successfully deleted '{$user['firstname']} {$user['lastname']}' ";
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();
?>