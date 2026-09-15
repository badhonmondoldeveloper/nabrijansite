<!-- Fashion Theme Footer -->
<footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <h5 class="fw-bold text-uppercase text-warning mb-3"><?= sanitize($store['name']) ?></h5>
                <p class="text-secondary small mb-3">Modern fashion storefront in Bangladesh. Elevate your everyday style.</p>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3 text-light">Payment Methods</h6>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-secondary">Cash on Delivery</span>
                    <span class="badge bg-danger">bKash</span>
                    <span class="badge bg-warning text-dark">Nagad</span>
                    <span class="badge bg-primary">Rocket</span>
                </div>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3 text-light">Follow Us</h6>
                <div class="d-flex gap-3">
                    <?php if (!empty($themeConfig['footer']['facebook_url'])): ?>
                        <a href="<?= sanitize($themeConfig['footer']['facebook_url']) ?>" target="_blank" class="text-light fs-5"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($themeConfig['footer']['instagram_url'])): ?>
                        <a href="<?= sanitize($themeConfig['footer']['instagram_url']) ?>" target="_blank" class="text-light fs-5"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-secondary small">
            <div><?= sanitize($themeConfig['footer']['copyright_text'] ?? ('© ' . date('Y') . ' ' . $store['name'] . '.')) ?></div>
            <div class="mt-2 mt-md-0">Powered by <strong>NABRIJAN Commerce OS</strong></div>
        </div>
    </div>
</footer>
