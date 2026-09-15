<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
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
    <main class="py-3 py-md-4">
        <?= $content ?>
    </main>

    <!-- Storefront Dynamic Theme Footer -->
    <?php 
        $footerPath = __DIR__ . '/../../themes/' . $themeFolder . '/footer.php';
        if (file_exists($footerPath)) {
            require $footerPath;
        }
    ?>

    <!-- Sliding Mobile Navigation Drawer -->
    <div class="store-nav-backdrop" id="navBackdrop" onclick="toggleNavDrawer(false)"></div>
    <div class="store-nav-drawer" id="navDrawer">
        <div class="store-nav-drawer-header">
            <h6 class="fw-bold mb-0 text-success"><i class="bi bi-shop me-2"></i> <?= sanitize($store['name']) ?></h6>
            <button class="btn-close" onclick="toggleNavDrawer(false)"></button>
        </div>
        <div class="store-nav-drawer-body">
            <a href="/store/<?= sanitize($store['slug']) ?>" class="store-nav-item-link active">
                <i class="bi bi-house"></i> Home
            </a>
            <a href="/store/<?= sanitize($store['slug']) ?>#categories" class="store-nav-item-link">
                <i class="bi bi-grid"></i> Categories
            </a>
            <a href="/store/<?= sanitize($store['slug']) ?>#products" class="store-nav-item-link">
                <i class="bi bi-box-seam"></i> All Products
            </a>
            <a href="/store/<?= sanitize($store['slug']) ?>/cart" class="store-nav-item-link">
                <i class="bi bi-bag"></i> Cart Page
            </a>
            <a href="/store/<?= sanitize($store['slug']) ?>/checkout" class="store-nav-item-link">
                <i class="bi bi-credit-card"></i> Checkout
            </a>
            <?php if (!empty($storeSettings['phone'])): ?>
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted d-block mb-2">Customer Care</small>
                    <a href="tel:<?= sanitize($storeSettings['phone']) ?>" class="store-nav-item-link text-success">
                        <i class="bi bi-telephone"></i> <?= sanitize($storeSettings['phone']) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

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
        <a href="javascript:void(0)" onclick="toggleNavDrawer(true)" class="store-mobile-nav-item">
            <i class="bi bi-grid"></i>
            <span>Menu</span>
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
        function toggleNavDrawer(open) {
            const drawer = document.getElementById('navDrawer');
            const backdrop = document.getElementById('navBackdrop');
            if (open) {
                drawer.classList.add('open');
                backdrop.classList.add('open');
            } else {
                drawer.classList.remove('open');
                backdrop.classList.remove('open');
            }
        }

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
            const subtotalEl = document.getElementById('cartDrawerSubtotal');
            fetch('/store/<?= sanitize($store['slug']) ?>/cart/data')
                .then(res => res.json())
                .then(data => {
                    updateCartBadge();
                    if (data.success && data.cart && data.cart.items && data.cart.items.length > 0) {
                        subtotalEl.innerText = '৳' + parseFloat(data.cart.subtotal).toFixed(2);
                        let html = '<div class="d-flex flex-column gap-2">';
                        data.cart.items.forEach(item => {
                            html += `
                                <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
                                    <div class="d-flex align-items-center gap-2">
                                        ${item.image ? `<img src="${item.image}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">` : '<div class="bg-secondary bg-opacity-20 rounded" style="width:48px;height:48px;"></div>'}
                                        <div>
                                            <div class="fw-bold small text-dark">${item.name}</div>
                                            <div class="small text-muted">Qty: ${item.quantity} × ৳${item.price}</div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-success">৳${(item.quantity * item.price).toFixed(2)}</div>
                                </div>
                            `;
                        });
                        html += '</div>';
                        body.innerHTML = html;
                    } else {
                        subtotalEl.innerText = '৳0.00';
                        body.innerHTML = '<div class="text-center py-5 text-muted"><i class="bi bi-cart-x fs-1 d-block mb-2"></i><p class="mb-0">Your shopping cart is empty.</p></div>';
                    }
                }).catch(() => {
                    body.innerHTML = '<div class="text-center py-4 text-muted">Unable to load cart.</div>';
                });
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
