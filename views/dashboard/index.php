<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Overview</h4>
        <p class="text-secondary small mb-0">Welcome back! Here is what's happening with <?= sanitize($store['name']) ?> today.</p>
    </div>
    <a href="/dashboard/products/create" class="btn btn-success font-weight-bold">
        <i class="bi bi-plus-lg me-1"></i> Add New Product
    </a>
</div>

<!-- Stats Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card-custom">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small font-weight-bold">Today's Revenue</span>
                <i class="bi bi-currency-dollar fs-4 text-warning"></i>
            </div>
            <h3 class="fw-bold mb-0 text-success"><?= format_bdt($stats['todays_revenue']) ?></h3>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-custom">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small font-weight-bold">Total Orders</span>
                <i class="bi bi-cart-check fs-4 text-info"></i>
            </div>
            <h3 class="fw-bold mb-0 text-light"><?= number_format($stats['total_orders']) ?></h3>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-custom">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small font-weight-bold">Total Customers</span>
                <i class="bi bi-people fs-4 text-primary"></i>
            </div>
            <h3 class="fw-bold mb-0 text-light"><?= number_format($stats['total_customers']) ?></h3>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-custom">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small font-weight-bold">Total Products</span>
                <i class="bi bi-box-seam fs-4 text-success"></i>
            </div>
            <h3 class="fw-bold mb-0 text-light"><?= number_format($stats['total_products']) ?></h3>
        </div>
    </div>
</div>

<!-- Main Widgets Grid -->
<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-light"><i class="bi bi-clock-history me-2 text-warning"></i> Recent Orders</h6>
                <a href="/dashboard/orders" class="small text-warning text-decoration-none">View All</a>
            </div>
            <?php if (empty($recentOrders)): ?>
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <p class="mb-0">No orders received yet. Your first order will appear here.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small">
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
                                    <td><a href="/dashboard/orders/<?= $order['id'] ?>" class="text-warning text-decoration-none fw-bold">#<?= sanitize($order['order_number']) ?></a></td>
                                    <td><?= sanitize($order['customer_name']) ?></td>
                                    <td><?= format_bdt($order['total_amount']) ?></td>
                                    <td><span class="badge bg-secondary"><?= sanitize($order['order_status']) ?></span></td>
                                    <td class="small text-secondary"><?= date('M d, H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    <div class="col-lg-4">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-light"><i class="bi bi-exclamation-triangle me-2 text-danger"></i> Low Stock Warning</h6>
                <a href="/dashboard/inventory" class="small text-warning text-decoration-none">Manage</a>
            </div>
            <?php if (empty($lowStockProducts)): ?>
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-check-circle fs-1 text-success d-block mb-2"></i>
                    <p class="mb-0">All product stock levels are healthy.</p>
                </div>
            <?php else: ?>
                <ul class="list-group list-group-flush bg-transparent">
                    <?php foreach ($lowStockProducts as $prod): ?>
                        <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                            <div>
                                <div class="fw-semibold text-truncate" style="max-width: 180px;"><?= sanitize($prod['name']) ?></div>
                                <small class="text-secondary"><?= format_bdt($prod['price']) ?></small>
                            </div>
                            <span class="badge bg-danger"><?= $prod['stock'] ?> left</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
