<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-light"><i class="bi bi-credit-card-2-front text-warning me-2"></i> Merchant Subscription Payments</h4>
        <p class="text-secondary small mb-0">Review, verify, and approve/reject merchant plan upgrade manual payments (bKash, Nagad, Rocket, Bank).</p>
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

<div class="card-custom">
    <?php if (empty($payments)): ?>
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-inbox fs-1 text-secondary d-block mb-3"></i>
            <h5>No Subscription Payments Found</h5>
            <p class="small mb-0">No merchants have submitted subscription plan payment requests yet.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary small">
                        <th>ID</th>
                        <th>Merchant & Store</th>
                        <th>Plan Requested</th>
                        <th>Payment Method</th>
                        <th>Transaction ID (TrxID)</th>
                        <th>Sender Number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $pay): ?>
                        <tr>
                            <td>#<?= $pay['id'] ?></td>
                            <td>
                                <div class="fw-bold text-light"><?= sanitize($pay['store_name']) ?></div>
                                <div class="small text-secondary"><?= sanitize($pay['owner_email']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark fw-bold"><?= sanitize($pay['plan_name']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-secondary text-uppercase"><?= sanitize($pay['payment_method']) ?></span>
                            </td>
                            <td>
                                <code class="fs-6 text-warning"><?= sanitize($pay['transaction_id']) ?></code>
                            </td>
                            <td><?= sanitize($pay['sender_number'] ?? 'N/A') ?></td>
                            <td class="fw-bold text-success"><?= format_bdt($pay['amount']) ?></td>
                            <td>
                                <?php if ($pay['status'] === 'pending'): ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Pending Approval</span>
                                <?php elseif ($pay['status'] === 'approved'): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-secondary"><?= date('M d, Y H:i', strtotime($pay['created_at'])) ?></td>
                            <td class="text-end">
                                <?php if ($pay['status'] === 'pending'): ?>
                                    <form action="/admin/subscription-payments/<?= $pay['id'] ?>/approve" method="POST" class="d-inline">
                                        <input type="hidden" name="_csrf_token" value="<?= csrf_token() ?>">
                                        <button type="submit" class="btn btn-sm btn-success fw-bold me-1" onclick="return confirm('Approve this subscription payment and upgrade store plan?')">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $pay['id'] ?>">
                                        <i class="bi bi-x-lg"></i> Reject
                                    </button>

                                    <!-- Rejection Reason Modal -->
                                    <div class="modal fade text-start" id="rejectModal<?= $pay['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-dark text-light border-secondary">
                                                <form action="/admin/subscription-payments/<?= $pay['id'] ?>/reject" method="POST">
                                                    <input type="hidden" name="_csrf_token" value="<?= csrf_token() ?>">
                                                    <div class="modal-header border-secondary">
                                                        <h5 class="modal-title fw-bold">Reject Subscription Payment #<?= $pay['id'] ?></h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label text-secondary small fw-bold">Reason for Rejection</label>
                                                        <textarea name="rejection_reason" class="form-control bg-dark border-secondary text-light" rows="3" required placeholder="e.g. Invalid Transaction ID, amount does not match plan price..."></textarea>
                                                    </div>
                                                    <div class="modal-footer border-secondary">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger btn-sm fw-bold">Confirm Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-secondary small">Processed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
