<?php
include 'partials/header.php';
// INCOMPLETE DOES NOT RESPOND AS INTENDED
// get back form data if there was an error
// if no data is coming back, then null
$name = $_SESSION['contact-data']['name'] ?? null;
$email = $_SESSION['contact-data']['email'] ?? null;
$message = $_SESSION['contact-data']['message'] ?? null;

unset($_SESSION['contact-data']);
?>

        <section class="form__section">
        <div class="container form__section-container">
            <h2>Get in Touch</h2>
            <?php if(isset($_SESSION['contact'])) : //if there's an error, show error message ?>     
                    <div class="alert__message error">  
                        <p>
                            <?= $_SESSION['contact']; // echo the error message
                            unset($_SESSION['contact']); // unset the session?>
                        </p>    
                    </div>
            <?php endif?>
            <form action="<?= ROOT_URL ?>contact-logic.php" method="POST">
                <input type="text" id="name" name="name" value="<?= $name ?>" placeholder="Your name">
                <input type="email" id="email" name="email" value="<?= $email ?>" placeholder="Your email">
                <textarea id="message" name="message" value="<?= $message ?>" rows="4" placeholder="Your message"></textarea>

                <button type="submit" name="submit" class="btn">Send Message</button>
            </form>
        </div>
        </section>

<?php 
include 'partials/footer.php';
?>