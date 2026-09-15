<!-- Grocery Theme Hero Banner -->
<div class="container my-4">
    <div class="store-hero-card" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-success px-3 py-1.5 rounded-pill mb-3 fw-bold">
                    <i class="bi bi-shield-check me-1"></i> 100% Organic & Fresh
                </span>
                <h1 class="store-hero-title"><?= sanitize($themeConfig['hero']['title'] ?? 'Fresh Groceries Delivered Daily') ?></h1>
                <p class="store-hero-subtitle"><?= sanitize($themeConfig['hero']['subtitle'] ?? 'Order everyday essentials and farm-fresh produce at your doorstep.') ?></p>
                <a href="<?= sanitize($themeConfig['hero']['button_link'] ?? '#products') ?>" class="btn btn-light text-success btn-lg fw-bold rounded-pill px-4">
                    <?= sanitize($themeConfig['hero']['button_text'] ?? 'Order Groceries') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
