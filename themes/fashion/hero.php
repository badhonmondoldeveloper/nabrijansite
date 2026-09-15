<!-- Fashion Theme Hero Banner -->
<div class="container my-4">
    <div class="store-hero-card" style="background: linear-gradient(135deg, #18181b 0%, #3f3f46 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill mb-3 fw-bold text-uppercase">
                    New Season Arrivals
                </span>
                <h1 class="store-hero-title"><?= sanitize($themeConfig['hero']['title'] ?? 'Discover Trending Styles') ?></h1>
                <p class="store-hero-subtitle"><?= sanitize($themeConfig['hero']['subtitle'] ?? 'Upgrade your wardrobe with premium apparel & lifestyle products.') ?></p>
                <a href="<?= sanitize($themeConfig['hero']['button_link'] ?? '#products') ?>" class="btn btn-warning text-dark btn-lg fw-bold rounded-pill px-4">
                    <?= sanitize($themeConfig['hero']['button_text'] ?? 'Explore Collection') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
