<?php
require 'config/database.php';

// make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = $_POST['is_featured'] ?? 0;
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if it was unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // Initialize thumbnail data
    $thumbnail_data = '';

    // check and validate input values
    if (!$title) {
        $_SESSION['edit-post'] = "Failed to update post. Invalid form data on edit post page.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Failed to update post. Invalid form data on edit post page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Failed to update post. Invalid form data on edit post page.";
    } else {
        // delete existing thumbnail if new thumbail is available
        if ($thumbnail['name']) {      
            // WORK ON NEW THUMBNAIL
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
                        $_SESSION['edit-post-success'] = "File read successfully";
                        echo "File read successfully";
                    }
                } else {
                    $_SESSION['edit-post'] = "File should be png, jpg, or jpeg";
                }
            }
        }


    if ($_SESSION['edit-post']) {
        // redirect to manage form page if form was invalid
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // set thumbnail name if a new one was uploaded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? null;

        $query = "UPDATE posts SET title='$title', body='$body', thumbnail= ?, category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        // Create a prepared statement using the provided connection and SQL query
        $stmt = mysqli_prepare($connection, $query);

        // Bind the parameter to the prepared statement
        // In this case, "s" indicates that $avatar_data is a string
        mysqli_stmt_bind_param($stmt, "s", $thumbnail_data);

        // Execute the prepared statement, which includes the bound parameter
        $result = mysqli_stmt_execute($stmt);

        // Close the prepared statement to free up resources
        mysqli_stmt_close($stmt);
    }
    
    if (!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
        
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();