<?php
include 'partials/header.php';

// get back form data if there was a registration error
// if no data is coming back, then null
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confrimpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

// delete add user data session
unset($_SESSION['add-user-data']);
?>

        <section class="form__section">
            <div class="container form__section-container">
                <h2>Add User</h2>
                <?php if(isset($_SESSION['add-user'])) : //if there's an error, show error message ?>     
                    <div class="alert__message error">  
                        <p>
                            <?= $_SESSION['add-user']; // echo the error message
                            unset($_SESSION['add-user']); // unset the session?>
                        </p>    
                    </div>
                <?php endif?>
                <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                    <input type="text" name="lastname" value="<?= $lastname ?>"  placeholder="Last Name">
                    <input type="text" name="username" value="<?= $username ?>"  placeholder="Username">
                    <input type="email" name="email" value="<?= $email ?>"  placeholder="Email">
                    <input type="password" name="createpassword" value="<?= $createpassword ?>"  placeholder="Create Password">
                    <input type="password" name="confirmpassword" value="<?= $confrimpassword ?>"  placeholder="Confirm Password">
                    <select name="userrole">
                        <option value="0">Author</option>
                        <option value="1">Admin</option>
                    </select>
                    <div class="form__control">
                        <label for="avatar">User Avatar</label>
                        <input type="file" name="avatar" id="avatar">
                    </div>
                    <button type="submit" name="submit" class="btn">Add User</button>
                    
                </form>
            </div>
        </section>

<?php 
include '../partials/footer.php';
?>