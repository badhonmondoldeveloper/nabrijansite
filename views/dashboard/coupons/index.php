<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i><?= sanitize($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Coupons & Discounts</h4>
        <p class="text-secondary small mb-0">Create promotional codes for your storefront customer checkout.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Coupon Creation Form -->
    <div class="col-lg-4">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-ticket-perforated me-2 text-warning"></i> Create New Coupon</h6>
            <form action="/dashboard/coupons" method="POST">
                <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                <div class="mb-3">
                    <label for="code" class="form-label">Coupon Code</label>
                    <input type="text" class="form-control" id="code" name="code" required style="text-transform: uppercase;" placeholder="e.g. EID2026">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Discount Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (৳)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="discount_value" class="form-label">Discount Value</label>
                        <input type="number" step="0.01" class="form-control" id="discount_value" name="discount_value" required placeholder="10">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="min_order_amount" class="form-label">Min Order Subtotal (BDT ৳)</label>
                    <input type="number" step="0.01" class="form-control" id="min_order_amount" name="min_order_amount" value="0">
                </div>
                <div class="mb-3">
                    <label for="usage_limit" class="form-label">Usage Limit (Optional)</label>
                    <input type="number" class="form-control" id="usage_limit" name="usage_limit" placeholder="Unlimited">
                </div>
                <button type="submit" class="btn btn-success w-100"><i class="bi bi-plus-lg me-1"></i> Save Coupon</button>
            </form>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="col-lg-8">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-tags me-2 text-info"></i> All Active Coupons (<?= count($coupons) ?>)</h6>
            <?php if (empty($coupons)): ?>
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-ticket-perforated fs-1 d-block mb-2"></i>
                    <p class="mb-0">No coupons created yet.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Min Order</th>
                                <th>Used Count</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($coupons as $c): ?>
                                <tr>
                                    <td><code class="text-warning font-weight-bold fs-6"><?= sanitize($c['code']) ?></code></td>
                                    <td class="fw-bold text-success">
                                        <?= ($c['type'] === 'percentage') ? ($c['discount_value'] . '%') : format_bdt($c['discount_value']) ?>
                                    </td>
                                    <td><?= format_bdt($c['min_order_amount']) ?></td>
                                    <td><?= $c['used_count'] ?> <?= ($c['usage_limit'] ? ('/ ' . $c['usage_limit']) : '') ?></td>
                                    <td><span class="badge bg-success"><?= sanitize($c['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
