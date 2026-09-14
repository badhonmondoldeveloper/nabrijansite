<!-- Minimal Theme Hero -->
<section class="py-5 text-center text-light" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="container py-4">
        <h1 class="display-4 fw-bold mb-3" style="color: <?= sanitize($storeSettings['secondary_color'] ?? '#eab308') ?>;"><?= sanitize($themeConfig['hero']['title'] ?? 'Welcome') ?></h1>
        <p class="lead text-secondary mx-auto mb-4" style="max-width: 600px;"><?= sanitize($themeConfig['hero']['subtitle'] ?? '') ?></p>
        <a href="<?= sanitize($themeConfig['hero']['button_link'] ?? '#products') ?>" class="btn btn-lg fw-bold px-4 text-white" style="background: <?= sanitize($storeSettings['primary_color'] ?? '#059669') ?>;">
            <?= sanitize($themeConfig['hero']['button_text'] ?? 'Shop Now') ?>
        </a>
    </div>
</section>
