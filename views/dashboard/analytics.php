<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Store Analytics</h4>
        <p class="text-secondary small mb-0">Track revenue performance, order volume, and top-selling products.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-custom">
            <span class="text-secondary small">Total Store Revenue</span>
            <h3 class="fw-bold text-success mt-1 mb-0"><?= format_bdt($metrics['total_revenue']) ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-custom">
            <span class="text-secondary small">Total Orders</span>
            <h3 class="fw-bold text-info mt-1 mb-0"><?= number_format($metrics['total_orders']) ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-custom">
            <span class="text-secondary small">Average Order Value (AOV)</span>
            <h3 class="fw-bold text-warning mt-1 mb-0"><?= format_bdt($metrics['aov']) ?></h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Top Selling Products Table -->
    <div class="col-lg-6">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-trophy me-2 text-warning"></i> Top Selling Products</h6>
            <?php if (empty($metrics['top_products'])): ?>
                <div class="text-center py-4 text-secondary">
                    <p class="mb-0">No sales data available yet.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Product Name</th>
                                <th>Qty Sold</th>
                                <th class="text-end">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($metrics['top_products'] as $prod): ?>
                                <tr>
                                    <td class="fw-bold text-light"><?= sanitize($prod['product_name']) ?></td>
                                    <td><span class="badge bg-secondary"><?= $prod['total_qty'] ?> units</span></td>
                                    <td class="text-end fw-bold text-success"><?= format_bdt($prod['total_sales']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Monthly Revenue History -->
    <div class="col-lg-6">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-graph-up-arrow me-2 text-success"></i> Revenue Breakdown</h6>
            <?php if (empty($metrics['monthly_revenue'])): ?>
                <div class="text-center py-4 text-secondary">
                    <p class="mb-0">No monthly revenue history available yet.</p>
                </div>
            <?php else: ?>
                <ul class="list-group list-group-flush bg-transparent">
                    <?php foreach ($metrics['monthly_revenue'] as $m): ?>
                        <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between px-0">
                            <span class="fw-bold"><?= sanitize($m['month']) ?></span>
                            <span class="fw-bold text-success"><?= format_bdt($m['amount']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
