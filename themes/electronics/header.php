<!-- Electronics Theme Header -->
<?php if (!empty($themeConfig['header']['announcement_bar'])): ?>
    <div class="store-announcement-bar">
        <span class="pulse-dot"></span> <?= sanitize($themeConfig['header']['announcement_bar']) ?>
    </div>
<?php endif; ?>

<nav class="store-navbar">
    <div class="container d-flex align-items-center justify-content-between gap-3">
        <a class="store-brand-logo" href="/store/<?= sanitize($store['slug']) ?>">
            <i class="bi bi-cpu text-primary"></i> <?= sanitize($store['name']) ?>
        </a>

        <form action="/store/<?= sanitize($store['slug']) ?>" method="GET" class="store-search-form d-none d-md-block">
            <input type="text" name="q" class="store-search-input" placeholder="Search gadgets & electronics..." value="<?= sanitize($_GET['q'] ?? '') ?>">
            <button type="submit" class="store-search-btn"><i class="bi bi-search"></i></button>
        </form>

        <div class="d-flex align-items-center gap-2">
            <button type="button" onclick="toggleCartDrawer(true)" class="store-cart-trigger">
                <i class="bi bi-cart3 fs-5"></i>
                <span class="d-none d-sm-inline">Cart</span>
                <span class="store-cart-badge cart-count-badge">0</span>
            </button>
        </div>
    </div>
</nav>
