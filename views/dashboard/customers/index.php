<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Customers</h4>
        <p class="text-secondary small mb-0">View customer contact details, order totals, and spending history.</p>
    </div>
</div>

<div class="card-custom">
    <?php if (empty($customers)): ?>
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-people fs-1 d-block mb-3 text-primary"></i>
            <h5>No customers registered yet</h5>
            <p class="mb-0">Customer accounts and guest shoppers will appear here after making purchases.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary small">
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Total Orders</th>
                        <th>Total Spent</th>
                        <th>Last Order</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $cust): ?>
                        <tr>
                            <td class="fw-bold text-light"><?= sanitize($cust['name']) ?></td>
                            <td class="text-warning"><?= sanitize($cust['phone']) ?></td>
                            <td><?= sanitize($cust['email'] ?? 'N/A') ?></td>
                            <td><span class="badge bg-secondary"><?= number_format($cust['total_orders']) ?> orders</span></td>
                            <td class="fw-bold text-success"><?= format_bdt($cust['total_spent']) ?></td>
                            <td class="small text-secondary"><?= $cust['last_order_date'] ? date('M d, Y', strtotime($cust['last_order_date'])) : 'N/A' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
