<?php
// admin/product-create.php
// Create a new product (title, price, description, image).
// I use this to seed the shop with new bears.

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'admin-page';

require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../conf/database.php';

$pdo = db();

// keeping track of form values so if something fails I don't wipe out everything the user typed
$errors      = [];
$title       = '';
$description = '';
$price       = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = trim($_POST['price'] ?? '');

    // basic validation – not bulletproof but enough for this project
    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }
    if ($price === '' || !is_numeric($price)) {
        $errors[] = 'Valid price is required.';
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Product image is required.';
    }

    $imageName = null;

    if (!$errors) {
        $imageTmp  = $_FILES['image']['tmp_name'];
        $imageOrig = $_FILES['image']['name'];
        $ext       = strtolower(pathinfo($imageOrig, PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed, true)) {
            $errors[] = 'Image must be JPG, PNG, or WEBP.';
        } else {
            $imageName = 'product-' . time() . '-' . mt_rand(1000, 9999) . '.' . $ext;
            $targetDir = __DIR__ . '/../img/products';

            // if the folder doesn't exist yet, make it (first time uploading)
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetPath = $targetDir . '/' . $imageName;

            // I always mess up file paths with uploads so I'm being extra careful here
            if (!move_uploaded_file($imageTmp, $targetPath)) {
                $errors[] = 'Failed to move uploaded image.';
            }
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO products (title, description, price, image)
             VALUES (:title, :description, :price, :image)'
        );
        $stmt->execute([
            'title'       => $title,
            'description' => $description,
            'price'       => $price,
            'image'       => $imageName,
        ]);

        // after creating, send the admin back to the product list
        header('Location: ' . $base . '/admin/products.php');
        exit;
    }
}

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main">
    <section class="container admin-section">
        <h1 class="page-title">Add Product</h1>

        <?php if ($errors): ?>
            <div class="form-errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- form to add a brand new product to the shop -->
        <form class="form admin-form" method="post" enctype="multipart/form-data">
            <label>
                Title
                <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>
            </label>

            <label>
                Description
                <textarea name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
            </label>

            <label>
                Price
                <input
                    type="number"
                    step="0.01"
                    name="price"
                    value="<?= htmlspecialchars($price) ?>"
                    required
                >
            </label>

            <label>
                Image
                <input type="file" name="image" accept="image/*" required>
            </label>

            <button class="button" type="submit">Create Product</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
