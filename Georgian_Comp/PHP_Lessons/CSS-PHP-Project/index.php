<?php
/* index page
   this is the homepage layout
   includes header and footer
*/
$base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
include __DIR__ . '/inc/header.php';
?>

<!-- hero section -->
<section class="hero">
    <div class="hero-content">
        <h1>Shop Quality Teddy Bears</h1>
        <p>Quality goods, fair prices, fast shipping. Browse our latest arrivals.</p>
        <a class="btn" href="<?= $base ?>/templates/shop.php">Shop New Arrivals</a>
    </div>
</section>

<!-- product grid-->
<section class="grid grid-3 product-grid">
    <article class="card">
        <img src="<?= $base ?>/img/placeholder-1.jpg" alt="Featured product 1">
        <h3>Featured Product</h3>
        <p>product desc</p>
        <a class="btn-outline" href="<?= $base ?>/templates/shop.php">View</a>
    </article>

    <article class="card">
        <img src="<?= $base ?>/img/placeholder-2.jpg" alt="Featured product 2">
        <h3>Editor’s Pick</h3>
        <p>product desc</p>
        <a class="btn-outline" href="<?= $base ?>/templates/shop.php">View</a>
    </article>

    <article class="card">
        <img src="<?= $base ?>/img/placeholder-3.jpg" alt="Featured product 3">
        <h3>Bestseller</h3>
        <p>product desc</p>
        <a class="btn-outline" href="<?= $base ?>/templates/shop.php">View</a>
    </article>
</section>

<?php include __DIR__ . '/inc/footer.php'; ?>

