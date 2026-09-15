<!-- Electronics Theme Product Grid -->
<section id="products" class="py-3 py-md-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold mb-0 fs-5 fs-md-3">Featured Electronics</h3>
                <p class="text-muted small mb-0 d-none d-sm-block">Original tech with warranty</p>
            </div>
            <span class="badge bg-primary text-white px-2.5 py-1.5 rounded-pill font-weight-bold">
                <?= count($products) ?> items
            </span>
        </div>

        <?php if (empty($products)): ?>
            <div class="text-center py-5 bg-white rounded-4 border p-4">
                <i class="bi bi-cpu fs-1 text-muted d-block mb-2"></i>
                <h6 class="fw-bold">No Electronics Available</h6>
            </div>
        <?php else: ?>
            <div class="store-product-grid-mobile">
                <?php foreach ($products as $prod): ?>
                    <div class="store-product-card">
                        <div class="store-product-thumb">
                            <?php if (!empty($prod['discount_price']) && $prod['discount_price'] < $prod['price']): ?>
                                <?php $pct = round((($prod['price'] - $prod['discount_price']) / $prod['price']) * 100); ?>
                                <span class="store-badge-discount">-<?= $pct ?>%</span>
                            <?php endif; ?>

                            <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($prod['slug']) ?>">
                                <?php if (!empty($prod['primary_image'])): ?>
                                    <img src="<?= sanitize($prod['primary_image']) ?>" alt="<?= sanitize($prod['name']) ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                        <i class="bi bi-image fs-1"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="store-product-body">
                            <span class="store-product-category"><?= sanitize($prod['category_name'] ?? 'Electronics') ?></span>
                            <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($prod['slug']) ?>" class="store-product-title">
                                <?= sanitize($prod['name']) ?>
                            </a>

                            <div class="store-product-price-row">
                                <span class="store-price-current"><?= format_bdt($prod['price']) ?></span>
                                <?php if (!empty($prod['discount_price'])): ?>
                                    <span class="store-price-original"><?= format_bdt($prod['discount_price']) ?></span>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="store-btn-add-cart" onclick="addToCart(<?= $prod['id'] ?>)">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
