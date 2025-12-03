<?php
// templates/product.php
// Single product detail page for one teddy.

// base path + body class used by the layout/header
$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'product-page';

require_once __DIR__ . '/../conf/database.php';
$pdo = db();

// get product id from query string and make sure it's at least somewhat valid
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(404);
    exit('Product not found (we probably got a weird id).');
}

// Fetch product from DB
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    exit('Product not found in the database.');
}

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main">
    <section class="container">
        <article class="product-detail">
            <div class="product-detail-image">
                <img
                    src="<?= $base ?>/img/products/<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['title']) ?>"
                >
            </div>

            <div class="product-detail-content">
                <h1 class="product-detail-title">
                    <?= htmlspecialchars($product['title']) ?>
                </h1>

                <p class="product-detail-price">
                    $<?= number_format($product['price'], 2) ?>
                </p>

                <!-- nl2br is just to keep line breaks that I type in the description -->
                <p class="product-detail-description">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </p>

                <div class="product-detail-actions">
                    <a href="<?= $base ?>/templates/shop.php" class="button button-outline">
                        ← Back to Shop
                    </a>
                </div>
            </div>
        </article>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
