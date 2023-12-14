<?php
include 'partials/header.php';

// fetch posts if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // sort by newest post first
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

        <header class="category__title">
            <h2>
                <?php
                // fetch category from categories table using category_id of post
                $category_id = $id;
                $category_query = "SELECT * FROM categories WHERE id=$id";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result);
                echo $category['title']
                ?>
            </h2>
        </header>
        <!-- END OF CATEGORY TITLE -->

    <?php if (mysqli_num_rows($posts) > 0) : ?>
        <section class="posts">
            <div class="container posts__container">
                <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                    <article class="post">
                        <div class="post__thumbnail">
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
                        <div class="post__info">
                            <h3 class="post__title">
                                <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                            </h3>
                            <p class="post__body"><?= substr($post['body'], 0, 150) ?>...</p>
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
                        </div>
                    </article>
                <?php endwhile ?>
            </div>
        </section>
    <?php else : ?>
        <div class="alert__message error lg">
            <p>No posts found in this category</p>
        </div>
    <?php endif ?>
        <!-- END OF ARTICLE POSTS -->

        <section class="category__buttons">
            <div class="container category__buttons-container">
                <?php
                $all_categories_query = "SELECT * FROM categories";
                $all_categories = mysqli_query($connection, $all_categories_query);
                ?>
                <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
                <?php endwhile ?>
            </div>
        </section>
        <!-- END OF CATEGORY BUTTONS -->

<?php 
include 'partials/footer.php';
?>        