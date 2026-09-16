<div class="container py-3 py-md-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="/store/<?= sanitize($store['slug']) ?>" class="text-decoration-none text-muted">Home</a></li>
            <?php if (!empty($product['category_name'])): ?>
                <li class="breadcrumb-item"><a href="/store/<?= sanitize($store['slug']) ?>/category/<?= sanitize($product['category_slug']) ?>" class="text-decoration-none text-muted"><?= sanitize($product['category_name']) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active text-success fw-bold text-truncate" style="max-width: 150px;" aria-current="page"><?= sanitize($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row g-3 g-md-4">
        <!-- Gallery Column -->
        <div class="col-lg-6">
            <div class="store-pdp-gallery-main mb-2 mb-md-3">
                <?php if (!empty($images[0]['image_path'])): ?>
                    <img id="mainProductImage" src="<?= sanitize($images[0]['image_path']) ?>" alt="<?= sanitize($product['name']) ?>">
                <?php else: ?>
                    <div class="py-5 text-muted text-center">
                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                        No Image Available
                    </div>
                <?php endif; ?>
            </div>

            <?php if (count($images) > 1): ?>
                <div class="d-flex gap-2 overflow-auto py-1">
                    <?php foreach ($images as $idx => $img): ?>
                        <img src="<?= sanitize($img['image_path']) ?>" class="store-pdp-thumb <?= $idx === 0 ? 'active' : '' ?>" onclick="document.querySelectorAll('.store-pdp-thumb').forEach(t=>t.classList.remove('active')); this.classList.add('active'); document.getElementById('mainProductImage').src = this.src">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Purchase Options Column -->
        <div class="col-lg-6">
            <div class="store-pdp-card">
                <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill mb-2 fw-bold">
                    <?= sanitize($product['category_name'] ?? 'General') ?>
                </span>
                <h1 class="fw-bold mb-2 fs-3 fs-md-2"><?= sanitize($product['name']) ?></h1>

                <?php if (!empty($product['brand'])): ?>
                    <div class="small text-muted mb-3">
                        Brand: <span class="fw-bold text-dark"><?= sanitize($product['brand']) ?></span> | SKU: <code class="text-dark bg-light px-2 py-0.5 rounded"><?= sanitize($product['sku'] ?? 'N/A') ?></code>
                    </div>
                <?php endif; ?>

                <!-- Price Row -->
                <div class="d-flex align-items-baseline gap-3 mb-3">
                    <span class="fs-2 fw-bold text-success"><?= format_bdt($product['price']) ?></span>
                    <?php if (!empty($product['discount_price'])): ?>
                        <span class="fs-5 text-decoration-line-through text-muted"><?= format_bdt($product['discount_price']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Stock Badge -->
                <div class="mb-3">
                    <?php if ($product['stock'] <= 0): ?>
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Out of Stock</span>
                    <?php elseif ($product['stock'] <= $product['low_stock_threshold']): ?>
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill"><i class="bi bi-exclamation-triangle me-1"></i> Only <?= $product['stock'] ?> Left in Stock</span>
                    <?php else: ?>
                        <span class="badge bg-success-subtle text-success border border-success fs-6 px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> In Stock (<?= $product['stock'] ?> Available)</span>
                    <?php endif; ?>
                </div>

                <!-- Product Variants (Size & Color) -->
                <?php
                $sizes = [];
                $colors = [];
                if (!empty($variants)) {
                    foreach ($variants as $v) {
                        if (!empty($v['attributes']['size']) && !in_array($v['attributes']['size'], $sizes)) {
                            $sizes[] = $v['attributes']['size'];
                        }
                        if (!empty($v['attributes']['color']) && !in_array($v['attributes']['color'], $colors)) {
                            $colors[] = $v['attributes']['color'];
                        }
                    }
                }
                ?>

                <?php if (!empty($sizes)): ?>
                    <div class="mb-3">
                        <label class="fw-bold small d-block mb-1 text-dark">Select Size:</label>
                        <div class="d-flex flex-wrap gap-2" id="sizeOptions">
                            <?php foreach ($sizes as $idx => $sz): ?>
                                <button type="button" class="btn btn-outline-dark btn-sm rounded-3 px-3 py-1 <?= $idx === 0 ? 'active' : '' ?>" onclick="document.querySelectorAll('#sizeOptions .btn').forEach(b => b.classList.remove('active')); this.classList.add('active');">
                                    <?= sanitize($sz) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($colors)): ?>
                    <div class="mb-3">
                        <label class="fw-bold small d-block mb-1 text-dark">Select Color:</label>
                        <div class="d-flex flex-wrap gap-2" id="colorOptions">
                            <?php foreach ($colors as $idx => $cl): ?>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-1 <?= $idx === 0 ? 'active' : '' ?>" onclick="document.querySelectorAll('#colorOptions .btn').forEach(b => b.classList.remove('active')); this.classList.add('active');">
                                    <?= sanitize($cl) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Short Description -->
                <?php if (!empty($product['short_description'])): ?>
                    <p class="text-muted mb-4 small fs-md-6"><?= nl2br(sanitize($product['short_description'])) ?></p>
                <?php endif; ?>

                <!-- Actions -->
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="input-group" style="width: 110px; height: 44px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="const q = document.getElementById('qtyInput'); if(q.value>1) q.value--;">-</button>
                            <input type="number" class="form-control text-center font-weight-bold px-1" id="qtyInput" value="1" min="1" max="<?= $product['stock'] ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="const q = document.getElementById('qtyInput'); q.value++;">+</button>
                        </div>

                        <button class="btn btn-outline-success btn-lg flex-grow-1 fw-bold rounded-pill" style="min-height: 44px;" onclick="addToCart(<?= $product['id'] ?>, document.getElementById('qtyInput').value)">
                            <i class="bi bi-bag-plus me-1"></i> Cart
                        </button>

                        <button class="btn btn-success btn-lg flex-grow-1 fw-bold rounded-pill" style="min-height: 44px;" onclick="buyNow(<?= $product['id'] ?>, document.getElementById('qtyInput').value)">
                            Buy Now
                        </button>
                    </div>

                    <?php if (!empty($storeSettings['phone'])): ?>
                        <?php 
                            $waMsg = urlencode("Hello " . $store['name'] . ", I want to buy " . $product['name'] . " (" . format_bdt($product['price']) . ")");
                            $waPhone = preg_replace('/[^0-9]/', '', $storeSettings['phone']);
                            if (!str_starts_with($waPhone, '880') && str_starts_with($waPhone, '0')) {
                                $waPhone = '88' . $waPhone;
                            }
                        ?>
                        <a href="https://wa.me/<?= $waPhone ?>?text=<?= $waMsg ?>" target="_blank" class="btn btn-outline-success btn-lg fw-bold rounded-pill" style="min-height: 44px;">
                            <i class="bi bi-whatsapp me-2"></i> Order via WhatsApp
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Trust Badges -->
                <div class="store-trust-badge-row">
                    <div class="store-trust-item">
                        <i class="bi bi-truck text-success fs-5"></i>
                        <span>Fast Delivery BD</span>
                    </div>
                    <div class="store-trust-item">
                        <i class="bi bi-cash-coin text-success fs-5"></i>
                        <span>Cash on Delivery</span>
                    </div>
                    <div class="store-trust-item">
                        <i class="bi bi-shield-check text-success fs-5"></i>
                        <span>100% Authentic</span>
                    </div>
                    <div class="store-trust-item">
                        <i class="bi bi-arrow-counterclockwise text-success fs-5"></i>
                        <span>Easy Returns</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <?php if (!empty($product['description'])): ?>
        <div class="store-pdp-card mt-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-file-text me-2 text-success"></i> Product Description</h5>
            <div class="text-muted small fs-md-6"><?= nl2br(sanitize($product['description'])) ?></div>
        </div>
    <?php endif; ?>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mt-4 mt-md-5 mb-5 mb-md-0">
            <h4 class="fw-bold mb-3 fs-5 fs-md-4">Related Products</h4>
            <div class="store-product-grid-mobile">
                <?php foreach ($relatedProducts as $rel): ?>
                    <?php if ($rel['id'] != $product['id']): ?>
                        <div class="store-product-card" onclick="window.location.href='/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($rel['slug']) ?>'" style="cursor: pointer;">
                            <div class="store-product-thumb">
                                <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($rel['slug']) ?>">
                                    <?php if (!empty($rel['primary_image'])): ?>
                                        <img src="<?= sanitize($rel['primary_image']) ?>" alt="<?= sanitize($rel['name']) ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-image fs-1"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="store-product-body">
                                <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($rel['slug']) ?>" class="store-product-title">
                                    <?= sanitize($rel['name']) ?>
                                </a>
                                <div class="store-product-price-row">
                                    <span class="store-price-current"><?= format_bdt($rel['price']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Sticky Mobile Purchase Bar -->
<div class="store-mobile-sticky-purchase-bar d-md-none">
    <div>
        <div class="text-muted small" style="font-size: 0.7rem;">Price</div>
        <div class="fw-bold text-success fs-6"><?= format_bdt($product['price']) ?></div>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-success btn-sm fw-bold rounded-pill" onclick="addToCart(<?= $product['id'] ?>, document.getElementById('qtyInput').value)" style="min-height: 40px; padding: 0 14px;">
            <i class="bi bi-bag-plus me-1"></i> Cart
        </button>
        <button type="button" class="btn btn-success btn-sm fw-bold rounded-pill" onclick="buyNow(<?= $product['id'] ?>, document.getElementById('qtyInput').value)" style="min-height: 40px; padding: 0 16px;">
            Buy Now
        </button>
    </div>
</div>

<script>
function buyNow(productId, qty = 1) {
    fetch('/store/<?= sanitize($store['slug']) ?>/cart/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, quantity: qty })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            window.location.href = '/store/<?= sanitize($store['slug']) ?>/checkout';
        } else {
            alert(data.message || 'Error adding to cart');
        }
    });
}
</script>
