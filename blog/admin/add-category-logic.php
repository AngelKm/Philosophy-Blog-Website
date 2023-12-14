<?php
require 'config/database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

// get add-category form data if submit button was clicked
if(isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // check if there are values for title ans description
    if (!$title) {
        $_SESSION['add-category'] = "Enter title";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Enter description";
    }

    // redirect back to add category page with form data if there was invalid input
    if(isset($_SESSION['add-category'])) {
        // pass form data back to add-category page
        $_SESSION['add-category-data'] = $_POST; // send all invalid details back
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        // insert category into table
        $query = "INSERT INTO categories (title, description) VALUES 
        ('$title', '$description')";

        $result = mysqli_query($connection, $query);
        // check if there was any error when adding the category
        if(mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Failed to add category.";
            header('location: ' . ROOT_URL . 'admin/add-category.php'); // go to add category page
            die(); 
        } else { 
            $_SESSION['add-category-success'] = "Category $title added succesfully.";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php'); // go to manage users page
            die(); 
        }
    }
}
        
?>