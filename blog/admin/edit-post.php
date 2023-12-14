<?php
include 'partials/header.php';

// fetch categories from database
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);

// fetch post data from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);

} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}


?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title">
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $category['id'] ?>" <?= ($post['category_id'] == $category['id']) ? 'selected' : '' ?>>
                        <?= $category['title'] ?>
                    </option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" id="editor" placeholder="Body"><?= $post['body'] ?></textarea>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= ($post['is_featured'] == 1) ? 'checked' : '' ?>>
                <label for="is_featured">Featured</label>
            </div>

            <div class="form__control">
                <label for="thumbnail">Current Thumbnail</label>
                <?php
                if ($post && $post['thumbnail']) {
                // Determine MIME type dynamically based on image type
                $image_info = getimagesizefromstring($post['thumbnail']);
                $mime_type = $image_info['mime'];

                // Display the avatar using base64 encoding
                $thumbnail_data = base64_encode($post['thumbnail']);
                echo '<img src="data:' . $mime_type . ';base64,' . $thumbnail_data . '"/>';
                } else {
                    // Display a default image or placeholder if the post doesn't have one
                    echo '<img src="http://localhost/blog/images/poster.png" alt="Default Image"/>';
                }
                ?>
            </div>

            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>

            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>


<?php include '../partials/footer.php'; ?>
