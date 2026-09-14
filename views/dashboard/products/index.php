<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Products</h4>
        <p class="text-secondary small mb-0">Manage your store catalog, pricing, and inventory stock levels.</p>
    </div>
    <a href="/dashboard/products/create" class="btn btn-success font-weight-bold">
        <i class="bi bi-plus-lg me-1"></i> Add New Product
    </a>
</div>

<!-- Search & Filter Card -->
<div class="card-custom mb-4">
    <form action="/dashboard/products" method="GET" class="row g-3">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by Product Name, SKU, Brand..." value="<?= sanitize($search ?? '') ?>">
            </div>
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>><?= sanitize($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-warning w-100"><i class="bi bi-funnel me-1"></i> Filter</button>
        </div>
    </form>
</div>

<!-- Product Table -->
<div class="card-custom">
    <?php if (empty($products)): ?>
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-box-seam fs-1 d-block mb-3 text-warning"></i>
            <h5>No products found</h5>
            <p class="mb-3">Start adding products to your storefront catalog.</p>
            <a href="/dashboard/products/create" class="btn btn-sm btn-success"><i class="bi bi-plus-lg me-1"></i> Add Product Now</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary small">
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $prod): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($prod['primary_image'])): ?>
                                        <img src="<?= sanitize($prod['primary_image']) ?>" class="rounded border border-secondary" style="width: 48px; height: 48px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-dark rounded border border-secondary d-flex align-items-center justify-content-center text-secondary" style="width: 48px; height: 48px;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-light"><?= sanitize($prod['name']) ?></div>
                                        <div class="small text-secondary">SKU: <code class="text-warning"><?= sanitize($prod['sku'] ?? 'N/A') ?></code></div>
                                    </div>
                                </div>
                            </td>
                            <td><?= sanitize($prod['category_name'] ?? 'Uncategorized') ?></td>
                            <td class="fw-bold text-success">
                                <?= format_bdt($prod['price']) ?>
                                <?php if (!empty($prod['discount_price'])): ?>
                                    <div class="small text-decoration-line-through text-secondary"><?= format_bdt($prod['discount_price']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($prod['stock'] <= 0): ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php elseif ($prod['stock'] <= $prod['low_stock_threshold']): ?>
                                    <span class="badge bg-warning text-dark"><?= $prod['stock'] ?> (Low Stock)</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= $prod['stock'] ?> in stock</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-success"><?= sanitize($prod['status']) ?></span></td>
                            <td>
                                <form action="/dashboard/products/delete/<?= $prod['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                                    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($pagination['total_pages'] > 1): ?>
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-secondary">
                <div class="small text-secondary">Showing Page <?= $pagination['page'] ?> of <?= $pagination['total_pages'] ?></div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <?php for ($p = 1; $p <= $pagination['total_pages']; $p++): ?>
                            <li class="page-item <?= ($p == $pagination['page']) ? 'active' : '' ?>">
                                <a class="page-link bg-dark border-secondary text-light" href="/dashboard/products?page=<?= $p ?>&search=<?= urlencode($search) ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
