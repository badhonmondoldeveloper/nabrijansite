<!-- Grocery Theme Product Grid -->
<section id="products" class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Everyday Essentials</h3>
                <p class="text-muted small mb-0">Fresh produce & grocery items</p>
            </div>
            <span class="badge bg-success text-white px-3 py-2 rounded-pill font-weight-bold">
                <?= count($products) ?> items
            </span>
        </div>

        <?php if (empty($products)): ?>
            <div class="text-center py-5 bg-white rounded-4 border p-5">
                <i class="bi bi-basket fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold">No Items Available</h5>
            </div>
        <?php else: ?>
            <div class="row g-3 g-md-4">
                <?php foreach ($products as $prod): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="store-product-card">
                            <div class="store-product-thumb">
                                <?php if (!empty($prod['discount_price']) && $prod['discount_price'] < $prod['price']): ?>
                                    <?php $pct = round((($prod['price'] - $prod['discount_price']) / $prod['price']) * 100); ?>
                                    <span class="store-badge-discount">-<?= $pct ?>%</span>
                                <?php endif; ?>

                                <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($prod['slug']) ?>">
                                    <?php if (!empty($prod['primary_image'])): ?>
                                        <img src="<?= sanitize($prod['primary_image']) ?>" alt="<?= sanitize($prod['name']) ?>">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-image fs-1"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="store-product-body">
                                <span class="store-product-category"><?= sanitize($prod['category_name'] ?? 'Grocery') ?></span>
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
                                    <i class="bi bi-basket-fill"></i> Add to Basket
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
