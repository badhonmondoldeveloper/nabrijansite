<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Super Admin Overview</h4>
        <p class="text-secondary small mb-0">Platform-wide multi-tenant SaaS operational statistics.</p>
    </div>
</div>

<!-- Platform Stats Grid -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-4">
        <div class="card-custom">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small">Total Platform Stores</span>
                <i class="bi bi-shop fs-4 text-warning"></i>
            </div>
            <h3 class="fw-bold text-light mb-0"><?= number_format($stats['total_stores']) ?></h3>
            <div class="small text-success mt-1"><?= $stats['active_stores'] ?> Active Stores</div>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <div class="card-custom">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small">Total Registered Users</span>
                <i class="bi bi-people fs-4 text-info"></i>
            </div>
            <h3 class="fw-bold text-light mb-0"><?= number_format($stats['total_users']) ?></h3>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <div class="card-custom">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small">Platform Gross Sales</span>
                <i class="bi bi-currency-dollar fs-4 text-success"></i>
            </div>
            <h3 class="fw-bold text-success mb-0"><?= format_bdt($stats['total_revenue']) ?></h3>
            <div class="small text-secondary mt-1"><?= number_format($stats['total_orders']) ?> Total Orders</div>
        </div>
    </div>
</div>

<!-- Recent Stores Table -->
<div class="card-custom">
    <h6 class="fw-bold text-light mb-3"><i class="bi bi-shop-window me-2 text-warning"></i> Recently Created Stores</h6>
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="text-secondary small">
                    <th>Store Name</th>
                    <th>Subdomain</th>
                    <th>Owner</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentStores as $st): ?>
                    <tr>
                        <td class="fw-bold text-light"><?= sanitize($st['name']) ?></td>
                        <td><code class="text-warning"><?= sanitize($st['slug']) ?>.nabrijan.site</code></td>
                        <td><?= sanitize($st['owner_name']) ?> <small class="text-secondary d-block"><?= sanitize($st['owner_email']) ?></small></td>
                        <td><span class="badge bg-secondary"><?= sanitize($st['plan_name']) ?></span></td>
                        <td><span class="badge bg-success"><?= sanitize($st['status']) ?></span></td>
                        <td class="small text-secondary"><?= date('M d, Y', strtotime($st['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
