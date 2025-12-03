<?php
// admin/product-edit.php
// Edit an existing product (update text, price, optional new image).

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'admin-page';

require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../conf/database.php';

$pdo = db();

// grab the id from the query string and make sure it looks valid
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . $base . '/admin/products.php');
    exit;
}

// Load product from DB so we can pre-fill the form
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    // if product is missing just send the admin back to the list
    header('Location: ' . $base . '/admin/products.php');
    exit;
}

// set initial values from existing product
$errors      = [];
$title       = $product['title'];
$description = $product['description'];
$price       = $product['price'];
$imageName   = $product['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = trim($_POST['price'] ?? '');

    // basic validation – not perfect but enough for this assignment
    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }
    if ($price === '' || !is_numeric($price)) {
        $errors[] = 'Valid price is required.';
    }

    // Optional new image – only process this if a new file was actually uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp  = $_FILES['image']['tmp_name'];
        $imageOrig = $_FILES['image']['name'];
        $ext       = strtolower(pathinfo($imageOrig, PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed, true)) {
            $errors[] = 'Image must be JPG, PNG, or WEBP.';
        } else {
            $newName   = 'product-' . time() . '-' . mt_rand(1000, 9999) . '.' . $ext;
            $targetDir = __DIR__ . '/../img/products';

            // if the folder doesn't exist yet, make it (first time uploading)
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetPath = $targetDir . '/' . $newName;

            // I always mess up file paths with uploads so I'm being extra careful here
            if (!move_uploaded_file($imageTmp, $targetPath)) {
                $errors[] = 'Failed to move uploaded image.';
            } else {
                // delete old image file if it still exists, so we don't fill the server with junk
                $oldPath = $targetDir . '/' . $imageName;
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
                $imageName = $newName;
            }
        }
    }

    if (!$errors) {
        $update = $pdo->prepare(
            'UPDATE products
             SET title = :title, description = :description, price = :price, image = :image
             WHERE id = :id'
        );
        $update->execute([
            'title'       => $title,
            'description' => $description,
            'price'       => $price,
            'image'       => $imageName,
            'id'          => $id,
        ]);

        // go back to the list after a successful update
        header('Location: ' . $base . '/admin/products.php');
        exit;
    }
}

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main">
    <section class="container admin-section">
        <h1 class="page-title">Edit Product #<?= $id ?></h1>

        <?php if ($errors): ?>
            <div class="form-errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- simple form to edit the product details -->
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
                    name="price"
                    step="0.01"
                    min="0"
                    value="<?= htmlspecialchars($price) ?>"
                    required
                >
            </label>

            <label>
                Current Image
                <div class="mt-sm">
                    <?php if (!empty($imageName)): ?>
                        <img
                            src="<?= $base ?>/img/products/<?= htmlspecialchars($imageName) ?>"
                            alt="Current product image"
                            style="max-width: 180px; border-radius: 8px;"
                        >
                    <?php else: ?>
                        <p class="text-muted">No image saved for this product yet.</p>
                    <?php endif; ?>
                </div>
            </label>

            <label>
                New Image (optional)
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
                <span class="form-note">If you upload a new image, it will replace the current one.</span>
            </label>

            <button class="button" type="submit">Save Changes</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
