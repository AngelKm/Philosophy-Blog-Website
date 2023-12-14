<?php
require 'config/database.php';

// get signup form data if signup button was clicked
if(isset($_POST['submit'])) {
    // get form inputs and sanitize them
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword= filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // validate input values
    // check if any of the form fields are empty
    if(!$firstname) { // use session to access this in the signup page
        $_SESSION['signup'] = "Please enter your First Name";
    } elseif(!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name"; 
    } elseif(!$username) {
        $_SESSION['signup'] = "Please enter your Username"; 
    } elseif(!$email) {
        $_SESSION['signup'] = "Please enter a valid email"; 
    // check the password length for strength
    } elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Password should be more than 7 characters"; 
    // check for the name of the avatar, if no name then there's no avatar
    } elseif(!$avatar['name']) {
        $_SESSION['signup'] = "Please add an avatar"; 
    } else {
        // check if passwords don't match
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match";
        } else {
            // hash the password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exists in the database
            $user_check_query = "SELECT * from user WHERE 
            username = '$username' OR email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            // check if we got any rows from the database
            if(mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exists";
            } else {
                // work on avatar
                $avatar_tmp_name = $avatar['tmp_name']; // get the temporary name

                // check to make sure the file is an image
                $allowed_files = ['png', 'jpg', 'jpeg']; // allowable extensions
                $extention = pathinfo($avatar['name'], PATHINFO_EXTENSION);

                if(in_array($extention, $allowed_files)) {
                    // make sure image is not too large (1mb+)
                    if($avatar['size'] < 10000000) {
                        // Read the image file content
                        $avatar_data = file_get_contents($avatar_tmp_name);

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
                        $_SESSION['add-user'] = 'File size too big. Should be less than 1mb';
                    }
                } else { // file not an image
                    $_SESSION['add-user'] = "File should be png, jpg, or jpeg";
                }
            }
        }
    }
    // redirect back to signup page if there was any problem
    if(isset($_SESSION['signup'])) {
        // pass form data back to signup page
        $_SESSION['signup-data'] = $_POST; // send all invalid details back
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert new user into user table
        $insert_user_query = "INSERT INTO user (`firstname`, `lastname`, `username`, 
        `email`, `password`, `avatar`, `is_admin`) VALUES ('$firstname', '$lastname', 
        '$username','$email', '$hashed_password', ?, 0)";

        // insert into the databse
        // Create a prepared statement using the provided connection and SQL query
        $stmt = mysqli_prepare($connection, $insert_user_query);

        // Bind the parameter to the prepared statement
        // In this case, "s" indicates that $avatar_data is a string
        mysqli_stmt_bind_param($stmt, "s", $avatar_data);

        // Execute the prepared statement, which includes the bound parameter
        $insert_user_result = mysqli_stmt_execute($stmt);

        // Close the prepared statement to free up resources
        mysqli_stmt_close($stmt);

        // check if there was any error
        if(!mysqli_errno($connection)) {
            // redirect to sign gin page with success message
            $_SESSION['signup-success'] = "Registration succesful. Please sign in.";
            header(('location: ' . ROOT_URL . 'signin.php')); // go to sign in page
            die(); 
        }
    }

} else {
    // if button wasn't clicked, go back to sign up page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
?>