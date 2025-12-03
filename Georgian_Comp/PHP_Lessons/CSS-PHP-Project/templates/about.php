<?php

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'about-page';

include __DIR__ . '/../inc/header.php';
?>

<!-- about section -->
<section class="about-section">
    <h1>About Cozy Cub Bears</h1>

    <p>
        This whole teddy bear shop actually started as my school project for learning PHP and SQL.
        I wanted something that felt friendly and not super “techy,” so teddy bears just kinda made sense.
        Plus, they look way nicer on a page than random boxes or electronics lol.
    </p>

    <p>
        It's not a real business (yet), but I tried to design it like something a small shop could honestly use.
        The admin side lets you add/update/delete products, and the public side keeps everything clean
        and easy to scroll through without too much clutter.
    </p>

    <article class="about-values">
        <h2>Our Values</h2>
        <ul>
            <li>Soft, huggable bears (no weird scratchy fur pls)</li>
            <li>Fair pricing that doesn't break your wallet</li>
            <li>Simple layouts that feel comfy to browse</li>
        </ul>
    </article>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>
