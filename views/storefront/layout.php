<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Online Store') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/storefront-redesign.css">
    <style>
        :root {
            --store-primary: <?= sanitize($storeSettings['primary_color'] ?? '#087A4B') ?>;
            --store-accent: <?= sanitize($storeSettings['secondary_color'] ?? '#D8F34A') ?>;
        }
    </style>
</head>
<body class="storefront-body">
    <!-- Storefront Dynamic Theme Header -->
    <?php 
        $themeFolder = $themeConfig['theme_folder'] ?? 'minimal';
        $headerPath = __DIR__ . '/../../themes/' . $themeFolder . '/header.php';
        if (file_exists($headerPath)) {
            require $headerPath;
        }
    ?>

    <!-- Main Storefront View Content -->
    <main class="py-4">
        <?= $content ?>
    </main>

    <!-- Storefront Dynamic Theme Footer -->
    <?php 
        $footerPath = __DIR__ . '/../../themes/' . $themeFolder . '/footer.php';
        if (file_exists($footerPath)) {
            require $footerPath;
        }
    ?>

    <!-- Sliding Cart Drawer -->
    <div class="store-cart-backdrop" id="cartBackdrop" onclick="toggleCartDrawer(false)"></div>
    <div class="store-cart-drawer" id="cartDrawer">
        <div class="store-drawer-header">
            <h5 class="fw-bold mb-0"><i class="bi bi-bag me-2 text-success"></i> Your Cart</h5>
            <button class="btn-close" onclick="toggleCartDrawer(false)"></button>
        </div>
        <div class="store-drawer-body" id="cartDrawerBody">
            <div class="text-center py-5 text-muted">
                <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                <p>Loading cart items...</p>
            </div>
        </div>
        <div class="store-drawer-footer">
            <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                <span>Subtotal</span>
                <span class="text-success" id="cartDrawerSubtotal">৳0.00</span>
            </div>
            <a href="/store/<?= sanitize($store['slug']) ?>/checkout" class="btn btn-success w-100 py-2.5 fw-bold rounded-pill">Proceed To Checkout</a>
        </div>
    </div>

    <!-- Floating Mobile Bottom Nav Bar -->
    <nav class="store-mobile-nav">
        <a href="/store/<?= sanitize($store['slug']) ?>" class="store-mobile-nav-item active">
            <i class="bi bi-house"></i>
            <span>Home</span>
        </a>
        <a href="/store/<?= sanitize($store['slug']) ?>#categories" class="store-mobile-nav-item">
            <i class="bi bi-grid"></i>
            <span>Categories</span>
        </a>
        <a href="javascript:void(0)" onclick="toggleCartDrawer(true)" class="store-mobile-nav-item position-relative">
            <i class="bi bi-bag"></i>
            <span>Cart</span>
        </a>
        <a href="/store/<?= sanitize($store['slug']) ?>/checkout" class="store-mobile-nav-item">
            <i class="bi bi-credit-card"></i>
            <span>Checkout</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleCartDrawer(open) {
            const drawer = document.getElementById('cartDrawer');
            const backdrop = document.getElementById('cartBackdrop');
            if (open) {
                drawer.classList.add('open');
                backdrop.classList.add('open');
                fetchCartDrawerItems();
            } else {
                drawer.classList.remove('open');
                backdrop.classList.remove('open');
            }
        }

        function updateCartBadge() {
            fetch('/store/<?= sanitize($store['slug']) ?>/cart/count')
                .then(res => res.json())
                .then(data => {
                    if (data.count !== undefined) {
                        const badges = document.querySelectorAll('.cart-count-badge');
                        badges.forEach(b => b.innerText = data.count);
                    }
                }).catch(() => {});
        }

        function fetchCartDrawerItems() {
            const body = document.getElementById('cartDrawerBody');
            fetch('/store/<?= sanitize($store['slug']) ?>/cart')
                .then(res => res.text())
                .then(html => {
                    // Extract cart items preview or render quick drawer snippet
                    updateCartBadge();
                }).catch(() => {});
        }

        function addToCart(productId, qty = 1) {
            fetch('/store/<?= sanitize($store['slug']) ?>/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    updateCartBadge();
                    toggleCartDrawer(true);
                } else {
                    alert(data.message || 'Error adding to cart');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>
</body>
</html>
