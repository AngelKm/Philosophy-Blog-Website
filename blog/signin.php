<?php
require 'config/constants.php';
include 'partials/header.php';
// get the data back, if no then set to null
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

        <section class="form__section">
            <div class="container form__section-container">
                <h2>Sign In</h2>
                <?php if (isset($_SESSION['signup-success'])) : //if the sign up was successfull, show message ?>     
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['signup-success']; // message
                        unset($_SESSION['signup-success']); ?>
                    </p>
                </div>
                <?php elseif (isset($_SESSION['signin'])) : // check if the session sign in has an error ?>
                    <div class="alert__message error">
                        <p>
                        <?= $_SESSION['signin']; // message
                        unset($_SESSION['signin']); ?>
                        </p>
                    </div>
                <?php  endif ?>
                <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                    <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email">
                    <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
                    <button type="submit" name="submit" class="btn">Sign in</button>
                    <small>Don't have an account? <a href="signup.php">Sign up here</a></small>
                </form>
            </div>
        </section>

<?php 
include 'partials/footer.php';
?>