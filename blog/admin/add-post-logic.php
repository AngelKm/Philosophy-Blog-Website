<?php
require 'config/database.php';

// get add post form data if submit button was clicked
if(isset($_POST['submit'])) {
    // get form inputs and sanitize them
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // validate form inputs
    if (!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    }  elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    }  elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose a post thumbnail";
    } else {
        // work on thumbnail
        $thumbnail_tmp_name = $thumbnail['tmp_name']; // get the temporary name

        // check to make sure the file is an image
        $allowed_files = ['png', 'jpg', 'jpeg']; // allowable extensions
        $extention = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);

        if(in_array($extention, $allowed_files)) {
            // make sure image is not too large (5mb+)
            if($thumbnail['size'] < 50000000) {
                // Read the image file content
                $thumbnail_data = file_get_contents($thumbnail_tmp_name);

                // Check for errors
                $file_get_contents_error = error_get_last();

                if ($file_get_contents_error !== null) {
                    echo "Error reading file: " . $file_get_contents_error['message'];
                    // Handle the error as needed
                } else {
                    // Continue with the rest of your code...
                    echo "File read successfully";
                }
                        
            } else {
                $_SESSION['add-post'] = 'File size too big. Should be less than 2mb';
            }
        } else { // file not an image
            $_SESSION['add-post'] = "File should be png, jpg, or jpeg";
        }
    }
    //redirect back to add post page with form data if there is any problem
    if(isset($_SESSION['add-post'])) {
        // pass form data back to add post page
        $_SESSION['add_post-data'] = $_POST; // send all invalid details back
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        // set is featured for all posts to 0 if this post is featured is 1
        if ($is_featured == 1) {
            $zero_all_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_featured_result = mysqli_query($connection, $zero_all_featured_query);
        }

        // insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) 
        VALUES ('$title', '$body', ?, $category_id, $author_id, $is_featured)";

        // Create a prepared statement using the provided connection and SQL query
        $stmt = mysqli_prepare($connection, $query);

        // Check for a valid prepared statement
        if (!$stmt) {
            echo "Error creating prepared statement: " . mysqli_error($connection);
            die();
        }

        // Bind the parameter to the prepared statement
        // In this case, "s" indicates that $avatar_data is a string
        mysqli_stmt_bind_param($stmt, "s", $thumbnail_data);

        // Execute the prepared statement, which includes the bound parameter
        $result = mysqli_stmt_execute($stmt);

        // Close the prepared statement to free up resources
        mysqli_stmt_close($stmt);

        // check if there was any error
        if(!mysqli_errno($connection)) {
            // redirect to sign gin page with success message
            $_SESSION['add-post-success'] = "New post added succesfully.";
            header('location: ' . ROOT_URL . 'admin/'); // go to admin page
            die(); 
        }
    }
}
header('location: ' . ROOT_URL . 'admin/add-post.php'); // go to admin page
die(); 
?>