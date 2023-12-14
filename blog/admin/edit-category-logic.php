<?php
require 'config/database.php';

// get edit-user form data if submit button was clicked
if(isset($_POST['submit'])) {
    // get form inputs and sanitize them
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate input
    if (!$title || !$description) { // if fields are empty
        $_SESSION['edit-category'] = "Invalid form input on edit category page.";
    } else {
        $query = "UPDATE categories SET 
        `title` = '$title', 
        `description` = '$description'
        WHERE id = $id LIMIT 1";

        // pass the query to the database
        $result = mysqli_query($connection, $query);

        // check for errors
        if (mysqli_errno($connection)) {
            $_SESSION['edit-category'] = "Failed to update category.";
        } else { // user was edited
            $_SESSION['edit-category-success'] = "Category  $title updated successfully.";
        }

    }
}
// go to manage categories page
header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
?>