<!-- Minimal Theme Hero Banner -->
<div class="container my-4">
    <div class="store-hero-card">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-success px-3 py-1.5 rounded-pill mb-3 fw-semibold">
                    <i class="bi bi-star-fill text-warning me-1"></i> Quality Guaranteed
                </span>
                <h1 class="store-hero-title"><?= sanitize($themeConfig['hero']['title'] ?? 'Quality Products Delivered Fast') ?></h1>
                <p class="store-hero-subtitle"><?= sanitize($themeConfig['hero']['subtitle'] ?? 'Browse our curated collection with best price guarantee across Bangladesh.') ?></p>
                <a href="<?= sanitize($themeConfig['hero']['button_link'] ?? '#products') ?>" class="btn btn-light text-success btn-lg fw-bold rounded-pill px-4 shadow-sm">
                    <?= sanitize($themeConfig['hero']['button_text'] ?? 'Shop Now') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
