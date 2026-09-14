<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Orders</h4>
        <p class="text-secondary small mb-0">Track and manage customer orders and fulfillment statuses.</p>
    </div>
</div>

<!-- Order Status Filter Navigation -->
<div class="card-custom mb-4 p-2">
    <div class="d-flex gap-2 overflow-auto">
        <a href="/dashboard/orders" class="btn btn-sm <?= empty($selectedStatus) ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">All Orders</a>
        <a href="/dashboard/orders?status=pending" class="btn btn-sm <?= ($selectedStatus == 'pending') ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">Pending</a>
        <a href="/dashboard/orders?status=confirmed" class="btn btn-sm <?= ($selectedStatus == 'confirmed') ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">Confirmed</a>
        <a href="/dashboard/orders?status=processing" class="btn btn-sm <?= ($selectedStatus == 'processing') ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">Processing</a>
        <a href="/dashboard/orders?status=shipped" class="btn btn-sm <?= ($selectedStatus == 'shipped') ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">Shipped</a>
        <a href="/dashboard/orders?status=delivered" class="btn btn-sm <?= ($selectedStatus == 'delivered') ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">Delivered</a>
        <a href="/dashboard/orders?status=cancelled" class="btn btn-sm <?= ($selectedStatus == 'cancelled') ? 'btn-warning fw-bold' : 'btn-outline-secondary text-light' ?>">Cancelled</a>
    </div>
</div>

<!-- Orders Table -->
<div class="card-custom">
    <?php if (empty($orders)): ?>
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-inbox fs-1 d-block mb-3 text-warning"></i>
            <h5>No orders found</h5>
            <p class="mb-0">Customer orders will appear here once placed on your storefront.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary small">
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $ord): ?>
                        <tr>
                            <td><a href="/dashboard/orders/<?= $ord['id'] ?>" class="fw-bold text-warning text-decoration-none">#<?= sanitize($ord['order_number']) ?></a></td>
                            <td class="fw-bold text-light"><?= sanitize($ord['customer_name']) ?></td>
                            <td><?= sanitize($ord['customer_phone']) ?></td>
                            <td class="fw-bold text-success"><?= format_bdt($ord['total_amount']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= sanitize($ord['order_status']) ?></span></td>
                            <td><span class="badge bg-secondary"><?= sanitize($ord['payment_status']) ?></span></td>
                            <td class="small text-secondary"><?= date('M d, Y H:i', strtotime($ord['created_at'])) ?></td>
                            <td>
                                <a href="/dashboard/orders/<?= $ord['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-eye"></i> View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
