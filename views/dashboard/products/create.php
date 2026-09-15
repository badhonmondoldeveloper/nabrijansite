<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add New Product</h4>
        <p class="text-secondary small mb-0">Fill in product details and upload product images.</p>
    </div>
    <a href="/dashboard/products" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Products
    </a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <h6 class="fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Please resolve the following errors:</h6>
        <ul class="mb-0 ps-3">
            <?php foreach ($errors as $err): ?>
                <li><?= sanitize($err) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="/dashboard/products/create" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">

    <div class="row g-4">
        <!-- Main Form Columns -->
        <div class="col-lg-8">
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3">Basic Details</h6>
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= sanitize($old['name'] ?? '') ?>" placeholder="e.g. RGB Mechanical Keyboard">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?= sanitize($old['brand'] ?? '') ?>" placeholder="e.g. Redragon">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= (($old['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>><?= sanitize($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="2" placeholder="Brief summary of product features..."><?= sanitize($old['short_description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Full Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Detailed product specifications and information..."><?= sanitize($old['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3">Pricing & Inventory</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Regular Price (BDT ৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required value="<?= sanitize($old['price'] ?? '') ?>" placeholder="1500.00">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="discount_price" class="form-label">Discount Price (BDT ৳)</label>
                        <input type="number" step="0.01" class="form-control" id="discount_price" name="discount_price" value="<?= sanitize($old['discount_price'] ?? '') ?>" placeholder="1200.00">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cost_price" class="form-label">Cost Price (BDT ৳)</label>
                        <input type="number" step="0.01" class="form-control" id="cost_price" name="cost_price" value="<?= sanitize($old['cost_price'] ?? '') ?>" placeholder="900.00">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="sku" class="form-label">SKU Code</label>
                        <input type="text" class="form-control" id="sku" name="sku" value="<?= sanitize($old['sku'] ?? '') ?>" placeholder="KEY-RGB-001">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock" required value="<?= sanitize($old['stock'] ?? '10') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="low_stock_threshold" class="form-label">Low Stock Threshold</label>
                        <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" value="5">
                    </div>
                </div>
            </div>

            <!-- Product Variants (Size & Color) -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3"><i class="bi bi-tags me-2 text-success"></i>Product Variants (Optional)</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sizes" class="form-label">Available Sizes (Comma Separated)</label>
                        <input type="text" class="form-control" id="sizes" name="sizes" value="<?= sanitize($old['sizes'] ?? '') ?>" placeholder="e.g. S, M, L, XL, XXL or 39, 40, 41, 42">
                        <div class="form-text text-secondary">Enter sizes separated by commas.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="colors" class="form-label">Available Colors (Comma Separated)</label>
                        <input type="text" class="form-control" id="colors" name="colors" value="<?= sanitize($old['colors'] ?? '') ?>" placeholder="e.g. Red, Blue, Black, White, Navy">
                        <div class="form-text text-secondary">Enter color names separated by commas.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">
            <!-- Product Images -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3">Product Images</h6>
                <div class="mb-3">
                    <label for="images" class="form-label">Upload Images (JPEG, PNG, WebP)</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/jpeg,image/png,image/webp">
                    <div class="form-text text-secondary mt-1">Images will be automatically compressed and converted to WebP format. Max file size: 2MB.</div>
                </div>
            </div>

            <!-- SEO Metadata -->
            <div class="card-custom mb-4">
                <h6 class="fw-bold text-light mb-3">SEO Optimization</h6>
                <div class="mb-3">
                    <label for="seo_title" class="form-label">SEO Title</label>
                    <input type="text" class="form-control" id="seo_title" name="seo_title" value="<?= sanitize($old['seo_title'] ?? '') ?>" placeholder="Buy RGB Mechanical Keyboard Online">
                </div>
                <div class="mb-3">
                    <label for="seo_description" class="form-label">SEO Meta Description</label>
                    <textarea class="form-control" id="seo_description" name="seo_description" rows="3" placeholder="Best price mechanical keyboard in Bangladesh..."><?= sanitize($old['seo_description'] ?? '') ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 font-weight-bold"><i class="bi bi-cloud-upload me-1"></i> Save & Publish Product</button>
        </div>
    </div>
</form>
