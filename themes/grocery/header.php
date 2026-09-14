<!-- Minimal Theme Header -->
<?php if (!empty($themeConfig['header']['announcement_bar'])): ?>
    <div class="py-2 text-center text-dark font-weight-bold" style="background: <?= sanitize($storeSettings['secondary_color'] ?? '#eab308') ?>;">
        <small><?= sanitize($themeConfig['header']['announcement_bar']) ?></small>
    </div>
<?php endif; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 text-light" href="/store/<?= sanitize($store['slug']) ?>">
            <?= sanitize($store['name']) ?>
        </a>
        <div class="d-flex align-items-center gap-3">
            <form action="/store/<?= sanitize($store['slug']) ?>" method="GET" class="d-none d-md-flex">
                <input type="text" name="q" class="form-control form-control-sm bg-dark text-light border-secondary" placeholder="Search products..." value="<?= sanitize($_GET['q'] ?? '') ?>">
            </form>
            <a href="/store/<?= sanitize($store['slug']) ?>/cart" class="btn btn-outline-warning btn-sm position-relative">
                <i class="bi bi-cart3"></i> Cart
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">0</span>
            </a>
        </div>
    </div>
</nav>
