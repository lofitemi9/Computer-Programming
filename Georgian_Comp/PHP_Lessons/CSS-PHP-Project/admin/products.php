<?php
// admin/products.php
// Admin product list page – shows all products in a table so I can edit/delete them.

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'admin-page';

require_once __DIR__ . '/../inc/auth.php';
require_admin();

require_once __DIR__ . '/../conf/database.php';

$pdo = db();

// not paginated or anything fancy, but enough for this project size
$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $stmt->fetchAll();

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main">
    <section class="container admin-section">
        <header class="page-header">
            <h1 class="page-title">Admin – Products</h1>
            <p class="page-subtitle">
                Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?>.
            </p>
        </header>

        <div class="admin-actions">
            <a class="button" href="<?= $base ?>/admin/product-create.php">Add New Product</a>
            <a class="button button-outline" href="<?= $base ?>/templates/shop.php">View Shop</a>
        </div>

        <!-- main products table in the admin area -->
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['title']) ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= htmlspecialchars($product['image']) ?></td>
                            <td><?= htmlspecialchars($product['created_at']) ?></td>

                            <!-- quick links for editing / deleting a specific product -->
                            <td class="admin-table-actions">
                                <a href="<?= $base ?>/admin/product-edit.php?id=<?= $product['id'] ?>">Edit</a>
                                <span>•</span>
                                <a
                                    href="<?= $base ?>/admin/product-delete.php?id=<?= $product['id'] ?>"
                                    onclick="return confirm('Delete this product?');"
                                >
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="admin-table-empty">
                            No products yet. Add one to kick things off :)
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
