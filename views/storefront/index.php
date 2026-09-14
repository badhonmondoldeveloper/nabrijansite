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

<!-- Category Pills Navigation -->
<?php if (!empty($categories)): ?>
    <div class="container my-4">
        <div class="d-flex align-items-center gap-2 overflow-auto py-2">
            <a href="/store/<?= sanitize($store['slug']) ?>" class="btn btn-sm <?= empty($selectedCategory) ? 'btn-warning fw-bold' : 'btn-outline-secondary' ?>">
                All Categories
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="/store/<?= sanitize($store['slug']) ?>/category/<?= sanitize($cat['slug']) ?>" class="btn btn-sm <?= (!empty($selectedCategory) && $selectedCategory['id'] == $cat['id']) ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">
                    <?= sanitize($cat['name']) ?>
                </a>
            <?php endforeach; ?>
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
