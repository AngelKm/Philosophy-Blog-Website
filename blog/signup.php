<?php
require 'config/constants.php';
include 'partials/header.php';
// get back form data if there was a registration error
// if no data is coming back, then null
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confrimpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
$avatar = $_SESSION['signup-data']['avatar'] ?? null;
// delete sign up data session
unset($_SESSION['signup-data']);
?>


        <section class="form__section">
            <div class="container form__section-container">
                <h2>Sign Up</h2>
                <?php if(isset($_SESSION['signup'])) : //if there's an error, show error message ?>     
                    <div class="alert__message error">  
                        <p>
                            <?= $_SESSION['signup']; // echo the error message
                            unset($_SESSION['signup']); // unset the session?>
                        </p>    
                    </div>
                <?php endif?>
                <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
                    <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                    <input type="text" name="lastname" value="<?= $lastname ?>"  placeholder="Last Name">
                    <input type="text" name="username" value="<?= $username ?>"  placeholder="Username">
                    <input type="email" name="email" value="<?= $email ?>"  placeholder="Email">
                    <input type="password" name="createpassword" value="<?= $createpassword ?>"  placeholder="Create Password">
                    <input type="password" name="confirmpassword" value="<?= $confrimpassword ?>"  placeholder="Confirm Password">
                    <div class="form__control">
                        <label for="avatar">User Avatar</label>
                        <input type="file" name="avatar" id="avatar">
                    </div>
                    <button type="submit" name="submit" class="btn">Sing up</button>
                    <small>Already have an account? <a href="signin.php">Sign in here</a></small>
                </form>
            </div>
        </section>

<?php 
include 'partials/footer.php';
?>