<?php 
require 'config/database.php';

// fetch current user from the database
// check if the user id is set 
if (isset($_SESSION['user-id'])) {
    // get the id, then santize it and palce in variable
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    // get user from database using the id
    $query = "SELECT avatar FROM user WHERE `id` = $id";
    $result = mysqli_query($connection, $query);
    //$avatar = mysqli_fetch_assoc($result); // place avatar in a variable
    if ($result) {
        $avatar = mysqli_fetch_assoc($result); // Place avatar in a variable
    }
}
?> 


<!DOCTYPE php>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Philosophy Blog Website</title>
        <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
        <!-- ICONSCOUT FOR ICONS -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Jost:wght@300;400&family=Nanum+Myeongjo&display=swap" rel="stylesheet">
    </head>
    <body>
        <nav>
            <div class="container nav__container">
                <a href="<?= ROOT_URL ?>" class="nav__logo">Philosophy Review</a>
                <ul class="nav__items">
                    <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                    <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                    <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                    <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                    <?php if (isset($_SESSION['user-id'])): // if user id is set then user signed in, show the below instead?>
                        <li class="nav__profile">
                            <div class="avatar">
                            <?php
                            if ($avatar && $avatar['avatar']) {
                                // Determine MIME type dynamically based on image type
                                $image_info = getimagesizefromstring($avatar['avatar']);
                                $mime_type = $image_info['mime'];

                                // Display the avatar using base64 encoding
                                $avatar_data = base64_encode($avatar['avatar']);
                                echo '<img src="data:' . $mime_type . ';base64,' . $avatar_data . '"/>';
                            } else {
                                // Display a default avatar or placeholder if the user doesn't have one
                                echo '<img src="http://localhost/blog/images/default.png" alt="Default Avatar"/>';
                            }
                            ?>
                            </div>
                            <ul>
                                <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                                <li><a href="<?= ROOT_URL ?>signout.php">Sign out</a></li>
                            </ul>
                        </li>
                    <?php else: // show this ?>
                        <li><a href="<?= ROOT_URL ?>signin.php">Sign in</a></li> 
                    <?php endif ?>    
                </ul>
                <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
                <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
            </div>
        </nav>
        <!-- END OF NAV -->