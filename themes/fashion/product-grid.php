<!-- Minimal Theme Product Grid -->
<section id="products" class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-light mb-0">Featured Products</h3>
            <span class="text-secondary small"><?= count($products) ?> items available</span>
        </div>

        <?php if (empty($products)): ?>
            <div class="text-center py-5 text-secondary card-custom">
                <i class="bi bi-box-seam fs-1 text-warning d-block mb-3"></i>
                <p>No products added to storefront yet.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($products as $prod): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 bg-dark text-light border-secondary">
                            <?php if (!empty($prod['primary_image'])): ?>
                                <img src="<?= sanitize($prod['primary_image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary d-flex align-items-center justify-content-center text-dark" style="height: 200px;">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold text-light text-truncate mb-2"><?= sanitize($prod['name']) ?></h6>
                                <div class="mt-auto d-flex align-items-center justify-content-between">
                                    <span class="fw-bold text-success fs-5"><?= format_bdt($prod['price']) ?></span>
                                    <button class="btn btn-sm btn-outline-warning" onclick="addToCart(<?= $prod['id'] ?>)">
                                        <i class="bi bi-cart-plus me-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
