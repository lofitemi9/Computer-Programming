<?php
// templates/shop.php
// Public product listing page – shows every bear currently in the DB.

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'shop-page';

require_once __DIR__ . '/../conf/database.php';
$pdo = db();

// grab all products newest-first so the latest stuff shows up at the top
$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $stmt->fetchAll();

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main">
    <section class="container">
        <header class="page-header">
            <h1 class="page-title">Shop Teddy Bears</h1>

            <p class="page-subtitle">
                Browse all available bears. I update this whenever I add new ones :)
            </p>
        </header>

        <!-- grid of products coming straight from the database -->
        <section class="product-list">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <img
                            src="<?= $base ?>/img/products/<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['title']) ?>"
                        >
                        <div class="product-card-body">
                            <h2><?= htmlspecialchars($product['title']) ?></h2>

                            <p class="product-price">
                                $<?= number_format($product['price'], 2) ?>
                            </p>

                            <a
                                class="button button-outline"
                                href="<?= $base ?>/templates/product.php?id=<?= $product['id'] ?>"
                            >
                                View Details
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-state">
                    No products are live yet. Check back soon or bug the admin to add some bears :)
                </p>
            <?php endif; ?>
        </section>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
