<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Store Audit & Management</h4>
        <p class="text-secondary small mb-0">Manage all merchant stores across the Nabrijan SaaS platform.</p>
    </div>
</div>

<!-- Search Card -->
<div class="card-custom mb-4">
    <form action="/admin/stores" method="GET" class="row g-3">
        <div class="col-md-9">
            <input type="text" name="search" class="form-control bg-dark text-light border-secondary" placeholder="Search by Store Name, Slug, or Owner Email..." value="<?= sanitize($search) ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-warning w-100"><i class="bi bi-search me-1"></i> Search Stores</button>
        </div>
    </form>
</div>

<!-- Stores Table -->
<div class="card-custom">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="text-secondary small">
                    <th>Store Name</th>
                    <th>Subdomain</th>
                    <th>Owner</th>
                    <th>Plan</th>
                    <th>Products</th>
                    <th>Orders</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stores as $st): ?>
                    <tr>
                        <td class="fw-bold text-light"><?= sanitize($st['name']) ?></td>
                        <td><code class="text-warning"><?= sanitize($st['slug']) ?>.nabrijan.site</code></td>
                        <td><?= sanitize($st['owner_name']) ?><small class="text-secondary d-block"><?= sanitize($st['owner_email']) ?></small></td>
                        <td><span class="badge bg-secondary"><?= sanitize($st['plan_name']) ?></span></td>
                        <td><?= number_format($st['product_count']) ?></td>
                        <td><?= number_format($st['order_count']) ?></td>
                        <td>
                            <?php if ($st['status'] === 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Suspended</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($st['status'] === 'active'): ?>
                                <form action="/admin/stores/<?= $st['id'] ?>/status" method="POST" class="d-inline" onsubmit="return confirm('Suspend this store? Merchant access will be restricted.');">
                                    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                    <input type="hidden" name="status" value="suspended">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Suspend</button>
                                </form>
                            <?php else: ?>
                                <form action="/admin/stores/<?= $st['id'] ?>/status" method="POST" class="d-inline">
                                    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
