<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Online Store') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-brand: <?= sanitize($storeSettings['primary_color'] ?? '#059669') ?>;
            --accent-brand: <?= sanitize($storeSettings['secondary_color'] ?? '#eab308') ?>;
        }
        body { background-color: #0f172a; color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .card-custom { background: #1e293b; border: 1px solid #334155; border-radius: 0.75rem; }
        .btn-brand { background-color: var(--primary-brand); color: #ffffff; border: none; font-weight: 600; }
        .btn-brand:hover { filter: brightness(0.9); color: #ffffff; }
        .text-accent { color: var(--accent-brand)!important; }
    </style>
</head>
<body>
    <!-- Storefront Dynamic Theme Header -->
    <?php 
        $themeFolder = $themeConfig['theme_folder'] ?? 'minimal';
        $headerPath = __DIR__ . '/../../themes/' . $themeFolder . '/header.php';
        if (file_exists($headerPath)) {
            require $headerPath;
        }
    ?>

    <!-- Main Storefront View Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Storefront Dynamic Theme Footer -->
    <?php 
        $footerPath = __DIR__ . '/../../themes/' . $themeFolder . '/footer.php';
        if (file_exists($footerPath)) {
            require $footerPath;
        }
    ?>

    <script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateCartBadge() {
            fetch('/store/<?= sanitize($store['slug']) ?>/cart/count')
                .then(res => res.json())
                .then(data => {
                    if (data.count !== undefined) {
                        const el = document.getElementById('cartCount');
                        if (el) el.innerText = data.count;
                    }
                }).catch(() => {});
        }
        function addToCart(productId, qty = 1) {
            fetch('/store/<?= sanitize($store['slug']) ?>/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    alert('Product added to cart!');
                    updateCartBadge();
                } else {
                    alert(data.message || 'Error adding to cart');
                }
            });
        }
        document.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>
</body>
</html>
