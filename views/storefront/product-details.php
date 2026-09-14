<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/store/<?= sanitize($store['slug']) ?>" class="text-secondary text-decoration-none">Home</a></li>
            <?php if (!empty($product['category_name'])): ?>
                <li class="breadcrumb-item"><a href="/store/<?= sanitize($store['slug']) ?>/category/<?= sanitize($product['category_slug']) ?>" class="text-secondary text-decoration-none"><?= sanitize($product['category_name']) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active text-warning" aria-current="page"><?= sanitize($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Image Gallery Column -->
        <div class="col-lg-6">
            <div class="card-custom p-3 mb-3 text-center">
                <?php if (!empty($images[0]['image_path'])): ?>
                    <img id="mainProductImage" src="<?= sanitize($images[0]['image_path']) ?>" class="img-fluid rounded" style="max-height: 420px; object-fit: contain;">
                <?php else: ?>
                    <div class="py-5 text-secondary">
                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                        No Image Available
                    </div>
                <?php endif; ?>
            </div>

            <!-- Thumbnail Selector Row -->
            <?php if (count($images) > 1): ?>
                <div class="d-flex gap-2 overflow-auto">
                    <?php foreach ($images as $img): ?>
                        <img src="<?= sanitize($img['image_path']) ?>" class="rounded border border-secondary cursor-pointer" style="width: 70px; height: 70px; object-fit: cover;" onclick="document.getElementById('mainProductImage').src = this.src">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Purchase Options Column -->
        <div class="col-lg-6">
            <div class="card-custom p-4">
                <span class="badge bg-secondary mb-2"><?= sanitize($product['category_name'] ?? 'General') ?></span>
                <h2 class="fw-bold text-light mb-3"><?= sanitize($product['name']) ?></h2>

                <?php if (!empty($product['brand'])): ?>
                    <div class="small text-secondary mb-3">Brand: <span class="text-light fw-bold"><?= sanitize($product['brand']) ?></span> | SKU: <code class="text-warning"><?= sanitize($product['sku'] ?? 'N/A') ?></code></div>
                <?php endif; ?>

                <!-- Price Row -->
                <div class="d-flex align-items-baseline gap-3 mb-4">
                    <span class="display-6 fw-bold text-success"><?= format_bdt($product['price']) ?></span>
                    <?php if (!empty($product['discount_price'])): ?>
                        <span class="fs-4 text-decoration-line-through text-secondary"><?= format_bdt($product['discount_price']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Stock Badge -->
                <div class="mb-4">
                    <?php if ($product['stock'] <= 0): ?>
                        <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i> Out of Stock</span>
                    <?php elseif ($product['stock'] <= $product['low_stock_threshold']): ?>
                        <span class="badge bg-warning text-dark fs-6"><i class="bi bi-exclamation-triangle me-1"></i> Only <?= $product['stock'] ?> Left in Stock</span>
                    <?php else: ?>
                        <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i> In Stock (<?= $product['stock'] ?> Available)</span>
                    <?php endif; ?>
                </div>

                <!-- Short Description -->
                <?php if (!empty($product['short_description'])): ?>
                    <p class="text-secondary mb-4"><?= nl2br(sanitize($product['short_description'])) ?></p>
                <?php endif; ?>

                <!-- Quantity & Actions -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="input-group" style="width: 130px;">
                        <button class="btn btn-outline-secondary text-light" type="button" onclick="const q = document.getElementById('qtyInput'); if(q.value>1) q.value--;">-</button>
                        <input type="number" class="form-control bg-dark text-light border-secondary text-center" id="qtyInput" value="1" min="1" max="<?= $product['stock'] ?>">
                        <button class="btn btn-outline-secondary text-light" type="button" onclick="const q = document.getElementById('qtyInput'); q.value++;">+</button>
                    </div>

                    <button class="btn btn-brand btn-lg flex-grow-1" onclick="addToCart(<?= $product['id'] ?>, document.getElementById('qtyInput').value)">
                        <i class="bi bi-cart-plus me-1"></i> Add To Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Full Description -->
    <?php if (!empty($product['description'])): ?>
        <div class="card-custom p-4 mt-5">
            <h5 class="fw-bold text-light mb-3"><i class="bi bi-file-text me-2 text-warning"></i> Product Description</h5>
            <div class="text-secondary"><?= nl2br(sanitize($product['description'])) ?></div>
        </div>
    <?php endif; ?>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mt-5">
            <h4 class="fw-bold text-light mb-4">Related Products</h4>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $rel): ?>
                    <?php if ($rel['id'] != $product['id']): ?>
                        <div class="col-6 col-md-3">
                            <div class="card h-100 bg-dark text-light border-secondary">
                                <?php if (!empty($rel['primary_image'])): ?>
                                    <img src="<?= sanitize($rel['primary_image']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary d-flex align-items-center justify-content-center text-dark" style="height: 180px;">
                                        <i class="bi bi-image fs-1"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($rel['slug']) ?>" class="fw-bold text-light text-decoration-none text-truncate mb-2"><?= sanitize($rel['name']) ?></a>
                                    <span class="fw-bold text-success mt-auto"><?= format_bdt($rel['price']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
