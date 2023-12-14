<?php
include 'partials/header.php';

// get the user id
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // get cuurent user from the database table
    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);


} else { // if no user id go back to manage users page
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>

        <section class="form__section">
            <div class="container form__section-container">
                <h2>Edit User</h2>
                <!-- submit form to edit user logic page -->
                <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
                    <input type="hidden" value="<?= $user['id'] ?>" name="id">
                    <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="First Name">
                    <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Last Name">
                    <select name="userrole">
                        <option value="0">Author</option>
                        <option value="1">Admin</option>
                    </select>
                    <button type="submit" name="submit" class="btn">Update User</button>
                    
                </form>
            </div>
        </section>

<?php 
include '../partials/footer.php';
?>