<!-- Fashion Theme Header -->
<?php if (!empty($themeConfig['header']['announcement_bar'])): ?>
    <div class="store-announcement-bar bg-dark text-light border-0">
        <span class="pulse-dot bg-warning"></span> <?= sanitize($themeConfig['header']['announcement_bar']) ?>
    </div>
<?php endif; ?>

<nav class="store-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="store-menu-trigger" onclick="toggleNavDrawer(true)">
                    <i class="bi bi-list"></i>
                </button>
                <a class="store-brand-logo text-uppercase" href="/store/<?= sanitize($store['slug']) ?>">
                    <?= sanitize($store['name']) ?>
                </a>
            </div>

            <form action="/store/<?= sanitize($store['slug']) ?>" method="GET" class="store-search-form d-none d-md-block" style="max-width: 480px;">
                <input type="text" name="q" class="store-search-input" placeholder="Search fashion collection..." value="<?= sanitize($_GET['q'] ?? '') ?>">
                <button type="submit" class="store-search-btn"><i class="bi bi-search"></i></button>
            </form>

            <div class="d-flex align-items-center gap-2">
                <button type="button" onclick="toggleCartDrawer(true)" class="store-cart-trigger">
                    <i class="bi bi-bag-heart fs-5"></i>
                    <span class="d-none d-sm-inline">Bag</span>
                    <span class="store-cart-badge cart-count-badge">0</span>
                </button>
            </div>
        </div>

        <div class="store-search-container-mobile d-md-none">
            <form action="/store/<?= sanitize($store['slug']) ?>" method="GET" class="store-search-form">
                <input type="text" name="q" class="store-search-input" placeholder="Search fashion collection..." value="<?= sanitize($_GET['q'] ?? '') ?>">
                <button type="submit" class="store-search-btn"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</nav>
