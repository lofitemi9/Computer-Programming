<?php
/* shop page
   keep top-aligned (body class)
*/
$base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
$bodyClass = 'shop-page';
include __DIR__ . '/../inc/header.php';
?>

<!-- this is the search function -->
<section class="container" style="padding-top:1rem;">
    <form class="filters" role="search" style="display:flex; gap:1rem; flex-wrap:wrap;">
        <input type="search" placeholder="Search products" aria-label="Search products" style="flex:1; min-width:220px;">
        <select aria-label="Category">
            <option>All Categories</option>
            <option>Best Sellers</option>
        </select>
        <select aria-label="Sort by">
            <option>Sort: Featured</option>
            <option>Sort: Price (Low → High)</option>
            <option>Sort: Price (High → Low)</option>
        </select>
    </form>
</section>

<!-- product grid (static placeholders) -->
<section class="grid grid-3 container">
    <?php for ($i = 1; $i <= 9; $i++): ?>
        <article class="card">
            <img src="<?= $base ?>/img/placeholder-<?= ($i % 3) + 1 ?>.jpg" alt="Product placeholder <?= $i ?>">
            <h3>Product Title <?= $i ?></h3>
            <p>$00.00</p>
            <button class="btn">Add to Cart</button>
        </article>
    <?php endfor; ?>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>