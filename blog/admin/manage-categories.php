<?php
include 'partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);

?>

        <section class="dashboard">
            <?php if (isset($_SESSION['add-category-success'])) : //if the add category was successfull, show message ?>     
                <div class="alert__message success container" >
                    <p>
                        <?= $_SESSION['add-category-success']; // message
                        unset($_SESSION['add-category-success']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['add-category'])) : //if the add category was not successfull, show message ?>     
                <div class="alert__message error container" >
                    <p>
                        <?= $_SESSION['add-category']; // message
                        unset($_SESSION['add-category']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['edit-category-success'])) : //if the edit category was successfull, show message ?>     
                <div class="alert__message success container" >
                    <p>
                        <?= $_SESSION['edit-category-success']; // message
                        unset($_SESSION['edit-category-success']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['edit-category'])) : //if the edit category was not successfull, show message ?>     
                <div class="alert__message error container" >
                    <p>
                        <?= $_SESSION['edit-category']; // message
                        unset($_SESSION['edit-category']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['delete-category-success'])) : //if the delete category was successfull, show message ?>     
                <div class="alert__message success container" >
                    <p>
                        <?= $_SESSION['delete-category-success']; // message
                        unset($_SESSION['delete-category-success']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['delete-category'])) : //if the delete category was not successfull, show message ?>     
                <div class="alert__message error container" >
                    <p>
                        <?= $_SESSION['delete-category']; // message
                        unset($_SESSION['delete-category']); ?>
                    </p>
                </div>
            <?php endif ?>
            <div class="container dashboard__container">
                <button id="show__sidebar-btn" class="sidebar__toggle">
                    <i class="uil uil-angle-right-b"></i></button>
                <button id="hide__sidebar-btn" class="sidebar__toggle">
                    <i class="uil uil-angle-left-b"></i>
                </button>
                <aside>
                    <ul>
                        <li>
                            <a href="add-post.php"><i class="uil uil-pen"></i>
                            <h5>Add Post</h5>
                            </a>
                        </li>
                        <li>
                            <a href="index.php"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                            </a>
                        </li>
                        <?php if (isset($_SESSION['user_is_admin'])): //check if the current user is an admin to show the below or hide ?>
                            <li>
                                <a href="add-user.php"><i class="uil uil-user-plus"></i>
                                <h5>Add User</h5>
                                </a>
                            </li>
                            <li>
                                <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                                <h5>Manager Users</h5>
                                </a>
                            </li>
                            <li>
                                <a href="add-category.php"><i class="uil uil-edit"></i>
                                <h5>Add Category</h5>
                                </a>
                            </li>
                            <li>
                                <a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
                                <h5>Manage Categories</h5>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </aside>
                <main>
                    <h2>Manage Categories</h2>
                    <?php if (mysqli_num_rows($categories) > 0) : ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($category = mysqli_fetch_assoc($categories)) : // loop through the table to display the categories ?>
                                    <tr>
                                        <td><?= $category['title'] ?></td>
                                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=
                                        <?= $category['id'] ?>" class="btn sm">Edit</a></td>
                                        <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=
                                        <?= $category['id'] ?>"  class="btn sm danger">Delete</a></td>
                                    </tr>
                                <?php endwhile ?>
                            </tbody>
                        </table>
                    <?php else : ?> 
                        <div class="alert__message error"><?= "No categories found" ?></div>
                    <?php endif ?>
                </main>
            </div>
        </section>

<?php 
include '../partials/footer.php';
?>