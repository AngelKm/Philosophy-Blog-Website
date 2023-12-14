<?php
require 'config/database.php';
// INCOMPLETE DOES NOT RESPOND AS INTENDED
// get contact form data if submit button was clicked
if(isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate input values
    // check if any of the form fields are empty
    if (!$name) {
        $_SESSION['contact'] = "Please enter your Name";
    } elseif (!$email) {
        $_SESSION['contact'] = "Please enter a valid email";
    } elseif (!$message) {
        $_SESSION['contact'] = "Please enter a message";
    } else {
        // compose the email
        $to = "masanoangel@gmail.com"; //Business email address
        $subject = "New Contact Form Submission";
        $headers = "From: $email";

        // Compose the email body
        $email_body = "Name: $name\n\n";
        $email_body .= "Email: $email\n\n";
        $email_body .= "Message:\n$message";

        // Send the email
        mail($to, $subject, $email_body, $headers);

        // Check if the mail function was successful
        if (mail($to, $subject, $email_body, $headers)) {
            $_SESSION['contact-success'] = "Message sent successfully.";
        } else {
            $_SESSION['contact'] = "Failed to send message. Please try again.";
        }
    }

    // redirect back to contact page if there was any problem
    if (isset($_SESSION['contact'])) {
        // pass form data back to contact page
        $_SESSION['contact-data'] = $_POST; // send all invalid details back
        header('location: ' . ROOT_URL . '/contact.php');
        die();
    } else {
        // redirect to contact page with success message
        $_SESSION['contact-success'] = "Message sent successfully.";
        header('location: ' . ROOT_URL . '/contact.php');
        die();
    }
} else {
    // if button wasn't clicked, go back to contact page
    header('location: ' . ROOT_URL . '/contact.php');
    die();
}

?>