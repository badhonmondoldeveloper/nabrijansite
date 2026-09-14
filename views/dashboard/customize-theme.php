<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Customize Store Theme</h4>
        <p class="text-secondary small mb-0">Personalize your storefront design, colors, hero banners, and brand identity.</p>
    </div>
    <a href="/store/<?= sanitize($_SESSION['store_slug'] ?? '') ?>" target="_blank" class="btn btn-outline-warning">
        <i class="bi bi-eye me-1"></i> Live Preview Store
    </a>
</div>

<form action="/dashboard/customize-theme" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">

    <div class="row g-4">
        <!-- Main Customizer Sections -->
        <div class="col-lg-8">
            <!-- 1. Theme Selector -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3"><i class="bi bi-layout-window-reverse me-2 text-warning"></i> Select Active Theme Template</h6>
                <div class="row g-3">
                    <?php foreach ($themes as $theme): ?>
                        <div class="col-6 col-md-3">
                            <label class="w-100 border border-secondary rounded p-2 text-center text-light cursor-pointer" style="background:#0f172a;">
                                <input type="radio" name="theme_id" value="<?= $theme['id'] ?>" <?= ($themeConfig['theme_id'] == $theme['id']) ? 'checked' : '' ?> class="form-check-input mb-2">
                                <div class="fw-bold"><?= sanitize($theme['name']) ?></div>
                                <div class="small text-secondary"><?= sanitize($theme['slug']) ?></div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 2. Hero Banner Settings -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3"><i class="bi bi-image-fill me-2 text-info"></i> Homepage Hero Banner</h6>
                <div class="mb-3">
                    <label for="hero_title" class="form-label">Hero Headline Title</label>
                    <input type="text" class="form-control" id="hero_title" name="hero_title" value="<?= sanitize($themeConfig['hero']['title'] ?? '') ?>" placeholder="Quality Products Delivered Fast">
                </div>
                <div class="mb-3">
                    <label for="hero_subtitle" class="form-label">Hero Subtitle / Description</label>
                    <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="2" placeholder="Browse our latest collection with best price guarantee."><?= sanitize($themeConfig['hero']['subtitle'] ?? '') ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="hero_button_text" class="form-label">CTA Button Label</label>
                        <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" value="<?= sanitize($themeConfig['hero']['button_text'] ?? '') ?>" placeholder="Shop Now">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hero_button_link" class="form-label">CTA Button Link</label>
                        <input type="text" class="form-control" id="hero_button_link" name="hero_button_link" value="<?= sanitize($themeConfig['hero']['button_link'] ?? '') ?>" placeholder="#products">
                    </div>
                </div>
            </div>

            <!-- 3. Announcement Bar & Header -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3"><i class="bi bi-megaphone me-2 text-success"></i> Announcement Bar & Header</h6>
                <div class="mb-3">
                    <label for="announcement_bar" class="form-label">Top Announcement Text</label>
                    <input type="text" class="form-control" id="announcement_bar" name="announcement_bar" value="<?= sanitize($themeConfig['header']['announcement_bar'] ?? '') ?>" placeholder="Free shipping on orders over ৳2000!">
                </div>
                <div class="d-flex gap-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_search" name="show_search" <?= !empty($themeConfig['header']['show_search']) ? 'checked' : '' ?>>
                        <label class="form-check-label text-light" for="show_search">Show Storefront Search Bar</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_cart" name="show_cart" <?= !empty($themeConfig['header']['show_cart']) ? 'checked' : '' ?>>
                        <label class="form-check-label text-light" for="show_cart">Show Shopping Cart Icon</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side Panel: Colors & Footer -->
        <div class="col-lg-4">
            <!-- Brand Colors -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3"><i class="bi bi-palette me-2 text-warning"></i> Brand Palette</h6>
                <div class="mb-3">
                    <label for="primary_color" class="form-label">Primary Brand Color</label>
                    <div class="input-group">
                        <input type="color" class="form-control form-control-color border-secondary" id="primary_color_picker" value="<?= sanitize($storeSettings['primary_color'] ?? '#059669') ?>" onchange="document.getElementById('primary_color').value = this.value">
                        <input type="text" class="form-control" id="primary_color" name="primary_color" value="<?= sanitize($storeSettings['primary_color'] ?? '#059669') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="secondary_color" class="form-label">Secondary Brand Color</label>
                    <div class="input-group">
                        <input type="color" class="form-control form-control-color border-secondary" id="secondary_color_picker" value="<?= sanitize($storeSettings['secondary_color'] ?? '#eab308') ?>" onchange="document.getElementById('secondary_color').value = this.value">
                        <input type="text" class="form-control" id="secondary_color" name="secondary_color" value="<?= sanitize($storeSettings['secondary_color'] ?? '#eab308') ?>">
                    </div>
                </div>
            </div>

            <!-- Footer Details -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3"><i class="bi bi-layout-sidebar-reverse me-2 text-primary"></i> Footer & Social Links</h6>
                <div class="mb-3">
                    <label for="copyright_text" class="form-label">Copyright Notice</label>
                    <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="<?= sanitize($themeConfig['footer']['copyright_text'] ?? '') ?>" placeholder="© 2026 Store Name. All Rights Reserved.">
                </div>
                <div class="mb-3">
                    <label for="facebook_url" class="form-label">Facebook Page URL</label>
                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="<?= sanitize($themeConfig['footer']['facebook_url'] ?? '') ?>" placeholder="https://facebook.com/yourstore">
                </div>
                <div class="mb-3">
                    <label for="instagram_url" class="form-label">Instagram Page URL</label>
                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="<?= sanitize($themeConfig['footer']['instagram_url'] ?? '') ?>" placeholder="https://instagram.com/yourstore">
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold"><i class="bi bi-check2-circle me-1"></i> Save Theme Settings</button>
        </div>
    </div>
</form>
