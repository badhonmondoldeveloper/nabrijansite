<?php
$themeFolder = $themeConfig['theme_folder'] ?? 'minimal';

// Render Theme Hero Section
if (empty($selectedCategory) && empty($search)) {
    $heroPath = __DIR__ . '/../../themes/' . $themeFolder . '/hero.php';
    if (file_exists($heroPath)) {
        require $heroPath;
    }
}
?>

<!-- Category Chips Bar -->
<?php if (!empty($categories)): ?>
    <div class="store-category-bar my-3">
        <div class="container">
            <div class="d-flex align-items-center gap-2 overflow-auto py-1">
                <a href="/store/<?= sanitize($store['slug']) ?>" class="store-category-chip <?= empty($selectedCategory) ? 'active' : '' ?>">
                    <i class="bi bi-grid-fill"></i> All Products
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="/store/<?= sanitize($store['slug']) ?>/category/<?= sanitize($cat['slug']) ?>" class="store-category-chip <?= (!empty($selectedCategory) && $selectedCategory['id'] == $cat['id']) ? 'active' : '' ?>">
                        <i class="bi bi-tag-fill opacity-75"></i> <?= sanitize($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Render Theme Product Grid -->
<?php
$gridPath = __DIR__ . '/../../themes/' . $themeFolder . '/product-grid.php';
if (file_exists($gridPath)) {
    require $gridPath;
}
?>
