<?php
// admin/product-delete.php
// Delete a product and its image (if it exists).
// Slightly scary file... one wrong id and poof, product is gone.

$base = '/~Temiloluwa200632787/CSS-PHP-Project';

require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../conf/database.php';

$pdo = db();

// grab the id from the query string and make sure it looks at least somewhat valid
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . $base . '/admin/products.php');
    exit;
}

// Look up product image so we can also delete the file
$stmt = $pdo->prepare('SELECT image FROM products WHERE id = :id');
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

if ($product) {
    $targetDir = __DIR__ . '/../img/products';
    $path      = $targetDir . '/' . $product['image'];

    // try to delete the old image, but don't blow up the page if it's already gone
    if (is_file($path)) {
        @unlink($path);
    }

    // Delete product row from the DB
    $del = $pdo->prepare('DELETE FROM products WHERE id = :id');
    $del->execute(['id' => $id]);
}

// send admin back to the products list after delete
header('Location: ' . $base . '/admin/products.php');
exit;
