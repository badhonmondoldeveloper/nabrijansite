<!-- Minimal Theme Footer -->
<footer class="bg-white text-dark py-5 border-top mt-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <h5 class="fw-bold text-success mb-3"><i class="bi bi-shop me-2"></i> <?= sanitize($store['name']) ?></h5>
                <p class="text-muted small mb-3">Your trusted online shopping destination in Bangladesh. Quality guaranteed with instant delivery.</p>
                <?php if (!empty($storeSettings['phone'])): ?>
                    <p class="text-muted small mb-1"><i class="bi bi-telephone-fill me-2 text-success"></i> <?= sanitize($storeSettings['phone']) ?></p>
                <?php endif; ?>
                <?php if (!empty($storeSettings['email'])): ?>
                    <p class="text-muted small mb-0"><i class="bi bi-envelope-fill me-2 text-success"></i> <?= sanitize($storeSettings['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Accepted Payments</h6>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark border"><i class="bi bi-cash me-1 text-success"></i> Cash on Delivery</span>
                    <?php if (!empty($storeSettings['bkash_enabled'])): ?>
                        <span class="badge bg-danger text-white">bKash</span>
                    <?php endif; ?>
                    <?php if (!empty($storeSettings['nagad_enabled'])): ?>
                        <span class="badge bg-warning text-dark">Nagad</span>
                    <?php endif; ?>
                    <?php if (!empty($storeSettings['rocket_enabled'])): ?>
                        <span class="badge bg-primary text-white">Rocket</span>
                    <?php endif; ?>
                </div>
                <p class="text-muted small mb-0"><i class="bi bi-truck me-1 text-success"></i> Express Home Delivery across Bangladesh</p>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Connect With Us</h6>
                <div class="d-flex gap-3 mb-3">
                    <?php if (!empty($themeConfig['footer']['facebook_url'])): ?>
                        <a href="<?= sanitize($themeConfig['footer']['facebook_url']) ?>" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i> Facebook</a>
                    <?php endif; ?>
                    <?php if (!empty($themeConfig['footer']['instagram_url'])): ?>
                        <a href="<?= sanitize($themeConfig['footer']['instagram_url']) ?>" target="_blank" class="btn btn-outline-danger btn-sm"><i class="bi bi-instagram"></i> Instagram</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-muted small">
            <div>
                <?= sanitize($themeConfig['footer']['copyright_text'] ?? ('© ' . date('Y') . ' ' . $store['name'] . '. All rights reserved.')) ?>
            </div>
            <div class="mt-2 mt-md-0">
                <span>Powered by <strong class="text-success">NABRIJAN Commerce OS</strong></span>
            </div>
        </div>
    </div>
</footer>
