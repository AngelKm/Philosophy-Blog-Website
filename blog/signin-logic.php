<?php
require 'config/database.php';
// check to see if the button was clicked
if (isset($_POST['submit'])) {
    // get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password= filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // if user name/ email is empty
    if( !$username_email) {
        $_SESSION['signin'] = "Username or Email is required";
    } elseif (!$password) { // no password
        $_SESSION['signin'] = "Password is required";
    } else {
        // fecth user from database
        $fetch_user_query = "SELECT * FROM user WHERE username = '$username_email'
        OR email = '$username_email'";

        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        // check if we found a user match
        if (mysqli_num_rows($fetch_user_result) == 1) {
            // convert the record data into associated array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            // get the hashed password from the database
            $db_password = $user_record['password'];
            // compare form password with database password
            if (password_verify($password, $db_password)) {
                // set session for access control
                // if the user is logged in they should have access to the dashboard
                $_SESSION['user-id'] = $user_record['id']; // get id from user record
                // check if the user ia an admin or not. is_admin= 0, user isn't an admin
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                // if the passwords match, sign in the user tot he admin section
                header('location: ' . ROOT_URL . 'admin/');
            } else { // when the passwords don't match
                $_SESSION['signin'] = "Please check your input";
            }
        } else { // no valid user found
            $_SESSION['signin'] = "User not found";
        }
    }
    // if there's any problem, redirect back to signin page with sign in data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else { // go back to the sign in page
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

?>