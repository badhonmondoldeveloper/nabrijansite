<!-- Grocery Theme Header -->
<?php if (!empty($themeConfig['header']['announcement_bar'])): ?>
    <div class="store-announcement-bar bg-success text-white">
        <span class="pulse-dot bg-light"></span> <?= sanitize($themeConfig['header']['announcement_bar']) ?>
    </div>
<?php endif; ?>

<nav class="store-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="store-menu-trigger" onclick="toggleNavDrawer(true)">
                    <i class="bi bi-list"></i>
                </button>
                <a class="store-brand-logo text-success" href="/store/<?= sanitize($store['slug']) ?>">
                    <i class="bi bi-basket3 text-success"></i> <?= sanitize($store['name']) ?>
                </a>
            </div>

            <form action="/store/<?= sanitize($store['slug']) ?>" method="GET" class="store-search-form d-none d-md-block" style="max-width: 480px;">
                <input type="text" name="q" class="store-search-input" placeholder="Search fresh groceries & everyday items..." value="<?= sanitize($_GET['q'] ?? '') ?>">
                <button type="submit" class="store-search-btn"><i class="bi bi-search"></i></button>
            </form>

            <div class="d-flex align-items-center gap-2">
                <button type="button" onclick="toggleCartDrawer(true)" class="store-cart-trigger">
                    <i class="bi bi-basket fs-5"></i>
                    <span class="d-none d-sm-inline">Basket</span>
                    <span class="store-cart-badge cart-count-badge">0</span>
                </button>
            </div>
        </div>

        <div class="store-search-container-mobile d-md-none">
            <form action="/store/<?= sanitize($store['slug']) ?>" method="GET" class="store-search-form">
                <input type="text" name="q" class="store-search-input" placeholder="Search fresh groceries..." value="<?= sanitize($_GET['q'] ?? '') ?>">
                <button type="submit" class="store-search-btn"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</nav>
