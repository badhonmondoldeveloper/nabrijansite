<div class="container py-5 text-center" style="max-width: 720px;">
    <div class="bg-white border rounded-4 p-5 shadow-sm">
        <div class="mb-3">
            <i class="bi bi-check-circle-fill display-2 text-success"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Order Confirmed!</h2>
        <p class="text-muted lead mb-4">Thank you for shopping with <?= sanitize($store['name']) ?>. Your order has been received successfully.</p>

        <!-- Order Timeline Status Tracker -->
        <div class="store-order-timeline">
            <div class="store-timeline-step completed">
                <div class="store-timeline-icon"><i class="bi bi-check-lg"></i></div>
                <div class="small fw-bold text-success">Placed</div>
            </div>
            <div class="store-timeline-step">
                <div class="store-timeline-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="small text-muted">Confirmed</div>
            </div>
            <div class="store-timeline-step">
                <div class="store-timeline-icon"><i class="bi bi-box-seam"></i></div>
                <div class="small text-muted">Processing</div>
            </div>
            <div class="store-timeline-step">
                <div class="store-timeline-icon"><i class="bi bi-truck"></i></div>
                <div class="small text-muted">Shipped</div>
            </div>
        </div>

        <div class="bg-light p-4 rounded-3 border mb-4 text-start">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Order Number:</span>
                <span class="fw-bold text-success">#<?= sanitize($order['order_number']) ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Order Date:</span>
                <span class="text-dark fw-semibold"><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Payment Method:</span>
                <span class="text-dark text-uppercase fw-bold"><?= sanitize($order['payment_method']) ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Total Amount:</span>
                <span class="fw-bold text-success fs-5"><?= format_bdt($order['total_amount']) ?></span>
            </div>
        </div>

        <h6 class="fw-bold text-dark mb-3 text-start">Ordered Items</h6>
        <div class="table-responsive mb-4 text-start">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr class="text-muted small">
                        <th>Product</th>
                        <th>Qty</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                        <tr>
                            <td class="fw-semibold text-dark"><?= sanitize($it['product_name']) ?></td>
                            <td><?= $it['quantity'] ?></td>
                            <td class="text-end text-success fw-bold"><?= format_bdt($it['total_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <button onclick="window.print()" class="btn btn-outline-secondary px-4 py-2.5 fw-bold rounded-pill">
                <i class="bi bi-printer me-2"></i> Print Receipt
            </button>
            <a href="/store/<?= sanitize($store['slug']) ?>" class="btn btn-success px-5 py-2.5 fw-bold rounded-pill shadow-sm">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
