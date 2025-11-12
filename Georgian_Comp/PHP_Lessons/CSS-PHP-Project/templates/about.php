<?php
/* about page
   centered content (body class)
*/
$base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
$bodyClass = 'about-page';
include __DIR__ . '/../inc/header.php';
?>

<!-- about section -->
<section class="about-section">
    <h1>About Us</h1>
    <p>We’re a small team passionate about thoughtful design and sustainable sourcing. (this is placeholder text)</p>

    <article class="about-values">
        <h2>Our Values</h2>
        <ul>
            <li>Quality-first</li>
            <li>Fair pricing</li>
            <li>Responsible sourcing</li>
        </ul>
    </article>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>