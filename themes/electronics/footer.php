<!-- Electronics Theme Footer -->
<footer class="bg-white text-dark py-5 border-top mt-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-cpu me-2"></i> <?= sanitize($store['name']) ?></h5>
                <p class="text-muted small mb-3">Authentic tech & electronic gadgets delivered with warranty across Bangladesh.</p>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Payment & Delivery</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark border">COD</span>
                    <span class="badge bg-danger text-white">bKash</span>
                    <span class="badge bg-warning text-dark">Nagad</span>
                    <span class="badge bg-primary text-white">Rocket</span>
                </div>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Socials</h6>
                <div class="d-flex gap-3">
                    <?php if (!empty($themeConfig['footer']['facebook_url'])): ?>
                        <a href="<?= sanitize($themeConfig['footer']['facebook_url']) ?>" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i> Facebook</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-muted small">
            <div><?= sanitize($themeConfig['footer']['copyright_text'] ?? ('© ' . date('Y') . ' ' . $store['name'] . '.')) ?></div>
            <div>Powered by <strong class="text-primary">NABRIJAN Commerce OS</strong></div>
        </div>
    </div>
</footer>
