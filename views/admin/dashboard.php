<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-light"><i class="bi bi-speedometer2 text-warning me-2"></i> Multitalented Super Admin Dashboard</h4>
        <p class="text-secondary small mb-0">Real-time SaaS operational analytics, store growth, subscription revenues & system telemetry.</p>
    </div>
    <div>
        <a href="/admin/subscription-payments" class="btn btn-warning fw-bold">
            <i class="bi bi-clock-history me-1"></i> Pending Payments (<?= $stats['pending_sub_approvals'] ?>)
        </a>
    </div>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= sanitize($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Core Telemetry Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small fw-bold">SaaS Subscription Revenue</span>
                <i class="bi bi-wallet2 fs-4 text-success"></i>
            </div>
            <h3 class="fw-bold text-success mb-1"><?= format_bdt($stats['saas_revenue']) ?></h3>
            <div class="small text-secondary"><i class="bi bi-shield-check text-info me-1"></i> Paid Subscriptions Total</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small fw-bold">Platform Stores & Tenants</span>
                <i class="bi bi-shop fs-4 text-warning"></i>
            </div>
            <h3 class="fw-bold text-light mb-1"><?= number_format($stats['total_stores']) ?></h3>
            <div class="small text-success"><i class="bi bi-check-circle me-1"></i> <?= $stats['active_stores'] ?> Active Stores</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small fw-bold">Platform Merchant GMV</span>
                <i class="bi bi-graph-up-arrow fs-4 text-info"></i>
            </div>
            <h3 class="fw-bold text-info mb-1"><?= format_bdt($stats['total_gmv']) ?></h3>
            <div class="small text-secondary"><i class="bi bi-bag-check me-1"></i> <?= number_format($stats['total_orders']) ?> Total Orders</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small fw-bold">Registered Users & Products</span>
                <i class="bi bi-people fs-4 text-danger"></i>
            </div>
            <h3 class="fw-bold text-light mb-1"><?= number_format($stats['total_users']) ?></h3>
            <div class="small text-secondary"><i class="bi bi-box-seam me-1"></i> <?= number_format($stats['total_products']) ?> Live Products</div>
        </div>
    </div>
</div>

<!-- Interactive Analytics Charts Section -->
<div class="row g-3 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-light mb-0"><i class="bi bi-bar-chart-fill text-warning me-2"></i> Merchant Registration Trajectory</h6>
                <span class="badge bg-secondary">Last 6 Months</span>
            </div>
            <div style="height: 260px;">
                <canvas id="storeRegistrationChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card-custom h-100">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-pie-chart-fill text-success me-2"></i> SaaS Subscription Plan Breakdown</h6>
            <div style="height: 260px;" class="d-flex align-items-center justify-content-center">
                <canvas id="planBreakdownChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Pending Subscription Approvals & Recent Stores Grid -->
<div class="row g-3 mb-4">
    <!-- Pending Payments Table -->
    <div class="col-12 col-xl-6">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-light mb-0"><i class="bi bi-clock-history text-warning me-2"></i> Pending Subscription Payments</h6>
                <a href="/admin/subscription-payments" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <?php if (empty($pendingPayments)): ?>
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>
                    No pending subscription payments requiring approval.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr class="text-secondary">
                                <th>Store</th>
                                <th>Plan</th>
                                <th>Method</th>
                                <th>TrxID</th>
                                <th>Amount</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($pendingPayments, 0, 4) as $pay): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-light"><?= sanitize($pay['store_name']) ?></div>
                                        <div class="text-secondary" style="font-size:0.75rem;"><?= sanitize($pay['owner_email']) ?></div>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?= sanitize($pay['plan_name']) ?></span></td>
                                    <td><span class="badge bg-secondary"><?= strtoupper(sanitize($pay['payment_method'])) ?></span></td>
                                    <td><code class="text-warning"><?= sanitize($pay['transaction_id']) ?></code></td>
                                    <td class="fw-bold text-success"><?= format_bdt($pay['amount']) ?></td>
                                    <td class="text-end">
                                        <form action="/admin/subscription-payments/<?= $pay['id'] ?>/approve" method="POST" class="d-inline">
                                            <input type="hidden" name="_csrf_token" value="<?= csrf_token() ?>">
                                            <button type="submit" class="btn btn-sm btn-success py-0 px-2">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Stores List -->
    <div class="col-12 col-xl-6">
        <div class="card-custom h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-light mb-0"><i class="bi bi-shop-window text-info me-2"></i> Recently Created Stores</h6>
                <a href="/admin/stores" class="btn btn-sm btn-outline-info">Manage Stores</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 small">
                    <thead>
                        <tr class="text-secondary">
                            <th>Store Name</th>
                            <th>Domain Slug</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentStores as $st): ?>
                            <tr>
                                <td class="fw-bold text-light"><?= sanitize($st['name']) ?></td>
                                <td><code class="text-warning"><?= sanitize($st['slug']) ?></code></td>
                                <td><span class="badge bg-secondary"><?= sanitize($st['plan_name']) ?></span></td>
                                <td><span class="badge bg-success"><?= sanitize($st['status']) ?></span></td>
                                <td class="text-secondary"><?= date('M d, Y', strtotime($st['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- System Health & Environment Monitor -->
<div class="card-custom mb-4">
    <h6 class="fw-bold text-light mb-3"><i class="bi bi-cpu-fill text-danger me-2"></i> System Telemetry & Server Diagnostics</h6>
    <div class="row g-3 text-secondary small">
        <div class="col-6 col-md-4 col-lg-2">
            <div class="p-2 bg-dark rounded border border-secondary">
                <div class="text-muted" style="font-size:0.7rem;">PHP VERSION</div>
                <div class="fw-bold text-light"><?= sanitize($serverInfo['php_version']) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="p-2 bg-dark rounded border border-secondary">
                <div class="text-muted" style="font-size:0.7rem;">WEB SERVER</div>
                <div class="fw-bold text-light"><?= sanitize($serverInfo['server_software']) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="p-2 bg-dark rounded border border-secondary">
                <div class="text-muted" style="font-size:0.7rem;">DATABASE</div>
                <div class="fw-bold text-light"><?= sanitize($serverInfo['database_name']) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="p-2 bg-dark rounded border border-secondary">
                <div class="text-muted" style="font-size:0.7rem;">TIMEZONE</div>
                <div class="fw-bold text-light"><?= sanitize($serverInfo['timezone']) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="p-2 bg-dark rounded border border-secondary">
                <div class="text-muted" style="font-size:0.7rem;">HOST STORAGE BUDGET</div>
                <div class="fw-bold text-warning"><?= sanitize($serverInfo['storage_limit']) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="p-2 bg-dark rounded border border-secondary">
                <div class="text-muted" style="font-size:0.7rem;">SYSTEM TIME</div>
                <div class="fw-bold text-success"><?= date('H:i:s T') ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts Initialization -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Merchant Registration Trajectory Line Chart
    const regMonths = <?= json_encode(array_column($monthlyRegistrations, 'month')) ?>;
    const regCounts = <?= json_encode(array_column($monthlyRegistrations, 'count')) ?>;

    const ctxReg = document.getElementById('storeRegistrationChart').getContext('2d');
    new Chart(ctxReg, {
        type: 'line',
        data: {
            labels: regMonths.length > 0 ? regMonths : ['Sep 2026'],
            datasets: [{
                label: 'New Merchant Stores',
                data: regCounts.length > 0 ? regCounts : [<?= $stats['total_stores'] ?>],
                borderColor: '#eab308',
                backgroundColor: 'rgba(234, 179, 8, 0.15)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#059669',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: '#1f2937' }, ticks: { color: '#9ca3af' } },
                y: { grid: { color: '#1f2937' }, ticks: { color: '#9ca3af', precision: 0 }, beginAtZero: true }
            }
        }
    });

    // 2. Subscription Plan Breakdown Doughnut Chart
    const planLabels = <?= json_encode(array_column($planStats, 'name')) ?>;
    const planCounts = <?= json_encode(array_column($planStats, 'store_count')) ?>;

    const ctxPlan = document.getElementById('planBreakdownChart').getContext('2d');
    new Chart(ctxPlan, {
        type: 'doughnut',
        data: {
            labels: planLabels,
            datasets: [{
                data: planCounts,
                backgroundColor: ['#6b7280', '#059669', '#3b82f6', '#eab308'],
                borderColor: '#111827',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#f8fafc', font: { size: 11 } } }
            }
        }
    });
});
</script>
