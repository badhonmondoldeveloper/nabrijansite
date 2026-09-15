<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="h3-heading mb-1">Dashboard Overview</h3>
        <p class="text-secondary small mb-0">Welcome back! Here is your daily store telemetry for <?= sanitize($store['name']) ?>.</p>
    </div>
    <a href="/dashboard/products/create" class="btn-nj btn-nj-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Product
    </a>
</div>

<!-- 33. Metric Cards System -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="nj-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-semibold">Today's Revenue</span>
                <div class="rounded-circle bg-warning bg-opacity-10 p-2 text-warning">
                    <i class="bi bi-currency-dollar fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1 text-success font-display"><?= format_bdt($stats['todays_revenue']) ?></h3>
            <div class="small text-success"><i class="bi bi-arrow-up-right me-1"></i> Live sales tracking</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="nj-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-semibold">Total Orders</span>
                <div class="rounded-circle bg-info bg-opacity-10 p-2 text-info">
                    <i class="bi bi-shopping-bag fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1 text-light font-display"><?= number_format($stats['total_orders']) ?></h3>
            <div class="small text-secondary"><i class="bi bi-bag-check me-1"></i> Received orders</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="nj-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-semibold">Total Customers</span>
                <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                    <i class="bi bi-users fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1 text-light font-display"><?= number_format($stats['total_customers']) ?></h3>
            <div class="small text-secondary"><i class="bi bi-person-check me-1"></i> Registered buyers</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="nj-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-semibold">Products Stocked</span>
                <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success">
                    <i class="bi bi-package fs-5"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1 text-light font-display"><?= number_format($stats['total_products']) ?></h3>
            <div class="small text-secondary"><i class="bi bi-box-seam me-1"></i> Live inventory</div>
        </div>
    </div>
</div>

<!-- 34. Orders Table System & Low Stock Panel -->
<div class="row g-4">
    <!-- Recent Orders Table -->
    <div class="col-lg-8">
        <div class="nj-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="h4-heading mb-0 text-light"><i class="bi bi-clock-history me-2 text-warning"></i> Recent Orders</h6>
                <a href="/dashboard/orders" class="small text-decoration-none fw-semibold" style="color: var(--brand-400);">View All Orders →</a>
            </div>

            <?php if (empty($recentOrders)): ?>
                <!-- 49. Empty State Component -->
                <div class="text-center py-5 text-secondary">
                    <i class="bi bi-package fs-1 text-muted d-block mb-3"></i>
                    <h6 class="fw-bold text-light">No orders received yet</h6>
                    <p class="small text-secondary mb-3">Add products to your store and share your store link to start receiving customer orders.</p>
                    <a href="/dashboard/products/create" class="btn-nj btn-nj-secondary">Add Your First Product</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small border-bottom border-secondary">
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>
                                        <a href="/dashboard/orders/<?= $order['id'] ?>" class="fw-bold text-decoration-none" style="color: var(--accent-500);">
                                            #<?= sanitize($order['order_number']) ?>
                                        </a>
                                    </td>
                                    <td><?= sanitize($order['customer_name']) ?></td>
                                    <td class="fw-bold text-success"><?= format_bdt($order['total_amount']) ?></td>
                                    <td>
                                        <?php 
                                            $st = strtolower($order['order_status']);
                                            $badgeClass = 'nj-badge-pending';
                                            if ($st === 'confirmed') $badgeClass = 'nj-badge-confirmed';
                                            if ($st === 'processing') $badgeClass = 'nj-badge-processing';
                                            if ($st === 'shipped') $badgeClass = 'nj-badge-shipped';
                                            if ($st === 'delivered') $badgeClass = 'nj-badge-delivered';
                                            if ($st === 'cancelled') $badgeClass = 'nj-badge-cancelled';
                                        ?>
                                        <span class="nj-badge <?= $badgeClass ?>"><?= ucfirst(sanitize($order['order_status'])) ?></span>
                                    </td>
                                    <td class="small text-secondary"><?= date('M d, H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Low Stock Panel -->
    <div class="col-lg-4">
        <div class="nj-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="h4-heading mb-0 text-light"><i class="bi bi-exclamation-triangle me-2 text-danger"></i> Low Stock Alerts</h6>
                <a href="/dashboard/inventory" class="small text-decoration-none fw-semibold" style="color: var(--brand-400);">Manage</a>
            </div>

            <?php if (empty($lowStockProducts)): ?>
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>
                    <p class="small mb-0">All product stock levels are healthy.</p>
                </div>
            <?php else: ?>
                <ul class="list-group list-group-flush bg-transparent">
                    <?php foreach ($lowStockProducts as $prod): ?>
                        <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                            <div>
                                <div class="fw-semibold text-truncate" style="max-width: 170px;"><?= sanitize($prod['name']) ?></div>
                                <small class="text-secondary"><?= format_bdt($prod['price']) ?></small>
                            </div>
                            <span class="badge bg-danger rounded-pill px-2 py-1"><?= $prod['stock'] ?> left</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
