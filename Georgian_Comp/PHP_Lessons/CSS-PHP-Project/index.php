<?php
// index.php
// Homepage w/ hero + some "featured" products.
// (featured ones are static for now... I didn't wanna overcomplicate it lol)

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'home-page';

include __DIR__ . '/inc/header.php';
?>

<main class="site-main">

    <!-- Hero section (big teddy pic w/ text overlay) -->
    <section class="hero-section">
        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <h1>Shop Quality Teddy Bears</h1>

            <!-- tried to keep this description short + cute -->
            <p>Soft, premium teddy bears at fair prices. Find your next favourite cuddle buddy.</p>

            <a class="button" href="<?= $base ?>/templates/shop.php">
                Shop New Arrivals
            </a>
        </div>
    </section>

    <!-- Featured picks — these are just placeholder cards for now.
         (I was gonna make them dynamic but ran out of time ngl) -->
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">Featured Picks</h2>

            <div class="product-list">

                <article class="product-card">
                    <img src="<?= $base ?>/img/placeholder-1.jpg" alt="Featured product 1">
                    <div class="product-card-body">
                        <h3>Featured Bear</h3>
                        <p>Our softest everyday companion – perfect for gifting.</p>

                        <a class="button button-outline" href="<?= $base ?>/templates/shop.php">
                            View Collection
                        </a>
                    </div>
                </article>

                <article class="product-card">
                    <img src="<?= $base ?>/img/placeholder-2.jpg" alt="Featured product 2">
                    <div class="product-card-body">
                        <h3>Editor’s Pick</h3>
                        <p>Handpicked by our team for quality and comfort.</p>

                        <a class="button button-outline" href="<?= $base ?>/templates/shop.php">
                            View Collection
                        </a>
                    </div>
                </article>

                <article class="product-card">
                    <img src="<?= $base ?>/img/placeholder-3.jpg" alt="Featured product 3">
                    <div class="product-card-body">
                        <h3>Bestseller</h3>
                        <p>Customer favourite – loved by kids and adults alike.</p>

                        <a class="button button-outline" href="<?= $base ?>/templates/shop.php">
                            View Collection
                        </a>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- CTA — quick little section to push ppl to shop -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Adopt Your New Favourite Teddy?</h2>
            <p>Hand-picked, super-soft, and ready to ship to your door.</p>

            <a class="button" href="<?= $base ?>/templates/shop.php">
                Shop the Collection
            </a>
        </div>
    </section>

</main>

<?php include __DIR__ . '/inc/footer.php'; ?>
