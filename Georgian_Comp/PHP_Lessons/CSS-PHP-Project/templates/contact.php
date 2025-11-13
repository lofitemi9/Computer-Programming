<?php
$base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
$bodyClass = 'contact-page';
include __DIR__ . '/../inc/header.php';
?>

<!-- contact form (simple + centered) -->
<section class="contact-form">
    <h1>Contact Us</h1>
    <form method="post" action="#" novalidate>
        <label>Name
            <input type="text" name="name" required placeholder="your name">
        </label>

        <label>Email
            <input type="email" name="email" required placeholder="email@example.com">
        </label>

        <label>Message
            <textarea name="message" rows="5" placeholder="How can we help?"></textarea>
        </label>

        <button type="submit">Send</button>
    </form>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>