<div class="container py-5 text-center" style="max-width: 700px;">
    <div class="card-custom p-5">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill display-1 text-success"></i>
        </div>
        <h2 class="fw-bold text-light mb-2">Order Confirmed!</h2>
        <p class="text-secondary lead mb-4">Thank you for shopping with <?= sanitize($store['name']) ?>. Your order has been placed successfully.</p>

        <div class="bg-dark p-3 rounded border border-secondary mb-4 text-start">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary">Order Number:</span>
                <span class="fw-bold text-warning">#<?= sanitize($order['order_number']) ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary">Order Date:</span>
                <span class="text-light"><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary">Payment Method:</span>
                <span class="text-light text-uppercase fw-bold"><?= sanitize($order['payment_method']) ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-secondary">Total Amount:</span>
                <span class="fw-bold text-success fs-5"><?= format_bdt($order['total_amount']) ?></span>
            </div>
        </div>

        <h6 class="fw-bold text-light mb-3 text-start">Ordered Items</h6>
        <div class="table-responsive mb-4 text-start">
            <table class="table table-dark table-sm mb-0">
                <thead>
                    <tr class="text-secondary">
                        <th>Product</th>
                        <th>Qty</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                        <tr>
                            <td><?= sanitize($it['product_name']) ?></td>
                            <td><?= $it['quantity'] ?></td>
                            <td class="text-end text-success"><?= format_bdt($it['total_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="/store/<?= sanitize($store['slug']) ?>" class="btn btn-brand px-5 py-2 fw-bold">Continue Shopping</a>
    </div>
</div>
