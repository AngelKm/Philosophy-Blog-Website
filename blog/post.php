<?php
include 'partials/header.php';

// fetch post from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

        <section class="singlepost">
            <div class="container singlepost__container">
                <h2><?= $post['title'] ?></h2>
                <div class="post__author">
                    <?php
                    // fetch author from users table using author_id
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM user WHERE id = $author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                    ?>
                    <div class="post__author-avatar">
                        <?php
                        if ($author && $author['avatar']) {
                            // Determine MIME type dynamically based on image type
                            $image_info = getimagesizefromstring($author['avatar']);
                            $mime_type = $image_info['mime'];

                            // Display the avatar using base64 encoding
                            $avatar_data = base64_encode($author['avatar']);
                            echo '<img src="data:' . $mime_type . ';base64,' . $avatar_data . '"/>';
                        } else {
                            // Display a default avatar or placeholder if the user doesn't have one
                            echo '<img src="http://localhost/blog/images/default.png" alt="Default Avatar"/>';
                        }
                        ?>
                        </div>
                    <div class="post__author-info">
                        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small>
                            <?= date("M d, Y - H:i", strtotime($post['date_time'])) // show the time when it was posted ?>
                        </small>
                    </div>
                </div>
                <div class="singlepost__thumbnail">
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
                <p><?= nl2br($post['body']) ?></p>
            </div>
        </section>
        <!-- END OF POST -->

<?php 
include 'partials/footer.php';
?>