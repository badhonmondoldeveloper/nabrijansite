<!-- Electronics Theme Hero Banner -->
<div class="container my-4">
    <div class="store-hero-card" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-left: 4px solid var(--store-accent);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill mb-3 fw-bold">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Tech Deals
                </span>
                <h1 class="store-hero-title"><?= sanitize($themeConfig['hero']['title'] ?? 'Next-Gen Tech & Gadgets') ?></h1>
                <p class="store-hero-subtitle"><?= sanitize($themeConfig['hero']['subtitle'] ?? 'Top brand electronics with official warranty and instant cash on delivery.') ?></p>
                <a href="<?= sanitize($themeConfig['hero']['button_link'] ?? '#products') ?>" class="btn btn-primary btn-lg fw-bold rounded-pill px-4">
                    <?= sanitize($themeConfig['hero']['button_text'] ?? 'Shop Tech Deals') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
