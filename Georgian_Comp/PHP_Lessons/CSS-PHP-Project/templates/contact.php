<?php
// templates/contact.php
// Contact form layout. This doesn't actually send an email, it's just here for the UI + marks tbh.

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'contact-page';

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main">
    <section class="container contact-section">
        <h1 class="page-title">Contact Us</h1>
        <p class="page-subtitle">
            Got a question about a bear, an order, or something random? Drop a quick message below.
        </p>

        <!-- simple front-end only form, no backend email hooked up -->
        <form method="post" action="#" class="contact-form" novalidate>
            <label>
                Name
                <input type="text" name="name" required placeholder="Your name">
            </label>

            <label>
                Email
                <input type="email" name="email" required placeholder="email@example.com">
            </label>

            <label>
                Message
                <textarea name="message" rows="5" placeholder="How can we help?"></textarea>
            </label>

            <button type="submit" class="button">Send Message</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
