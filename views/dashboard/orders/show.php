<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Order #<?= sanitize($order['order_number']) ?></h4>
        <p class="text-secondary small mb-0">Placed on <?= date('F d, Y \a\t h:i A', strtotime($order['created_at'])) ?></p>
    </div>
    <a href="/dashboard/orders" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Orders
    </a>
</div>

<div class="row g-4">
    <!-- Left Column: Items & Shipping -->
    <div class="col-lg-8">
        <!-- Order Items Card -->
        <div class="card-custom mb-4">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-bag-check me-2 text-warning"></i> Order Items</h6>
            <div class="table-responsive">
                <table class="table table-dark align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small">
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $it): ?>
                            <tr>
                                <td class="fw-bold text-light"><?= sanitize($it['product_name']) ?></td>
                                <td><?= format_bdt($it['unit_price']) ?></td>
                                <td><?= $it['quantity'] ?></td>
                                <td class="text-end fw-bold text-success"><?= format_bdt($it['total_price']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Financial Totals -->
            <div class="border-top border-secondary pt-3 mt-3">
                <div class="d-flex justify-content-between mb-1 text-secondary">
                    <span>Subtotal</span>
                    <span class="text-light fw-bold"><?= format_bdt($order['subtotal']) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-1 text-secondary">
                    <span>Delivery Charge</span>
                    <span class="text-warning"><?= format_bdt($order['delivery_charge']) ?></span>
                </div>
                <?php if ($order['discount_amount'] > 0): ?>
                    <div class="d-flex justify-content-between mb-1 text-secondary">
                        <span>Discount</span>
                        <span class="text-danger">-<?= format_bdt($order['discount_amount']) ?></span>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between mt-2 pt-2 border-top border-secondary fs-5 fw-bold">
                    <span class="text-light">Total Order Amount</span>
                    <span class="text-success"><?= format_bdt($order['total_amount']) ?></span>
                </div>
            </div>
        </div>

        <!-- Shipping & Customer Info Card -->
        <div class="card-custom mb-4">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-person-lines-fill me-2 text-info"></i> Customer & Shipping Address</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="text-secondary small">Customer Name</div>
                    <div class="fw-bold text-light"><?= sanitize($order['customer_name']) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-secondary small">Phone Number</div>
                    <div class="fw-bold text-warning"><?= sanitize($order['customer_phone']) ?></div>
                </div>
                <div class="col-12 mb-3">
                    <div class="text-secondary small">Shipping Address</div>
                    <div class="text-light"><?= sanitize($shipping['address'] ?? $order['shipping_address_json']) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Status Update & Payment -->
    <div class="col-lg-4">
        <!-- Status Update Card -->
        <div class="card-custom mb-4">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-gear-wide-connected me-2 text-warning"></i> Update Order Status</h6>
            <form action="/dashboard/orders/<?= $order['id'] ?>/status" method="POST">
                <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                <div class="mb-3">
                    <label for="order_status" class="form-label text-secondary">Fulfillment Status</label>
                    <select class="form-select bg-dark text-light border-secondary" id="order_status" name="order_status">
                        <option value="pending" <?= ($order['order_status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= ($order['order_status'] == 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                        <option value="processing" <?= ($order['order_status'] == 'processing') ? 'selected' : '' ?>>Processing</option>
                        <option value="shipped" <?= ($order['order_status'] == 'shipped') ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= ($order['order_status'] == 'delivered') ? 'selected' : '' ?>>Delivered</option>
                        <option value="cancelled" <?= ($order['order_status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                        <option value="returned" <?= ($order['order_status'] == 'returned') ? 'selected' : '' ?>>Returned</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="payment_status" class="form-label text-secondary">Payment Verification Status</label>
                    <select class="form-select bg-dark text-light border-secondary" id="payment_status" name="payment_status">
                        <option value="pending" <?= ($order['payment_status'] == 'pending') ? 'selected' : '' ?>>Pending Payment Verification</option>
                        <option value="paid" <?= ($order['payment_status'] == 'paid') ? 'selected' : '' ?>>Paid & Verified</option>
                        <option value="rejected" <?= ($order['payment_status'] == 'rejected') ? 'selected' : '' ?>>Payment Rejected</option>
                        <option value="refunded" <?= ($order['payment_status'] == 'refunded') ? 'selected' : '' ?>>Refunded</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label text-secondary">Note / Comment (Optional)</label>
                    <textarea class="form-control bg-dark text-light border-secondary" id="comment" name="comment" rows="2" placeholder="e.g. Handed over to courier..."></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Update Status</button>
            </form>
        </div>

        <!-- Payment Record Card -->
        <div class="card-custom mb-4">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-credit-card me-2 text-primary"></i> Payment Record</h6>
            <div class="mb-2"><span class="text-secondary small">Method:</span> <strong class="text-uppercase text-light"><?= sanitize($order['payment_method'] ?? 'COD') ?></strong></div>
            <?php if (!empty($order['transaction_id'])): ?>
                <div class="mb-2"><span class="text-secondary small">TrxID:</span> <code class="text-warning"><?= sanitize($order['transaction_id']) ?></code></div>
            <?php endif; ?>
            <?php if (!empty($order['payment_note'])): ?>
                <div class="mb-2"><span class="text-secondary small">Payment Note:</span> <span class="text-light"><?= sanitize($order['payment_note']) ?></span></div>
            <?php endif; ?>
            <div><span class="text-secondary small">Payment Status:</span> <span class="badge bg-secondary"><?= sanitize($order['payment_status']) ?></span></div>
        </div>

        <!-- Status History Timeline -->
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-clock-history me-2 text-info"></i> Status History</h6>
            <ul class="list-group list-group-flush bg-transparent">
                <?php foreach ($history as $h): ?>
                    <li class="list-group-item bg-transparent text-light border-secondary px-0">
                        <div class="d-flex justify-content-between">
                            <strong class="text-warning text-capitalize"><?= sanitize($h['status']) ?></strong>
                            <small class="text-secondary"><?= date('M d, H:i', strtotime($h['created_at'])) ?></small>
                        </div>
                        <?php if (!empty($h['comment'])): ?>
                            <div class="small text-secondary mt-1"><?= sanitize($h['comment']) ?></div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
