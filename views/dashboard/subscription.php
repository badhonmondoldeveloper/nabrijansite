<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-light"><i class="bi bi-award text-warning me-2"></i> Subscription & Plan Limits</h4>
        <p class="text-secondary small mb-0">Manage your SaaS plan tier, view feature usage limits, and request manual plan upgrades.</p>
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

<div class="row g-4 mb-4">
    <!-- Current Plan Card -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-shield-check me-2 text-warning"></i> Current Active Plan</h6>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold text-success mb-0"><?= sanitize($currentPlan['name'] ?? 'FREE') ?> Plan</h3>
                <span class="badge bg-success fs-6"><?= sanitize($currentPlan['sub_status'] ?? 'active') ?></span>
            </div>
            <div class="text-secondary small mb-3">
                Price: <span class="text-light fw-bold"><?= format_bdt($currentPlan['price'] ?? 0) ?> / month</span>
            </div>

            <!-- Product Usage Progress Bar -->
            <div class="mb-3">
                <div class="d-flex justify-content-between small text-secondary mb-1">
                    <span>Products Usage Limit</span>
                    <span><?= $productCount ?> / <?= ($currentPlan['product_limit'] >= 99999) ? 'Unlimited' : $currentPlan['product_limit'] ?> used</span>
                </div>
                <?php 
                    $limit = ($currentPlan['product_limit'] >= 99999) ? 99999 : $currentPlan['product_limit'];
                    $pct = min(100, round(($productCount / max(1, $limit)) * 100));
                ?>
                <div class="progress bg-dark" style="height: 10px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pct ?>%;"></div>
                </div>
            </div>

            <div class="row text-secondary small">
                <div class="col-6 mb-2">
                    <i class="bi bi-palette me-1 text-info"></i> Themes Limit: <strong class="text-light"><?= $currentPlan['theme_limit'] ?></strong>
                </div>
                <div class="col-6 mb-2">
                    <i class="bi bi-globe me-1 text-info"></i> Custom Domain: <strong class="text-light"><?= $currentPlan['custom_domain_allowed'] ? 'Yes' : 'No' ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Upgrade Plans -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-arrow-up-circle me-2 text-info"></i> Upgrade SaaS Plan Tier</h6>
            <div class="list-group list-group-flush bg-transparent">
                <?php foreach ($allPlans as $plan): ?>
                    <div class="list-group-item bg-transparent text-light border-secondary px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-warning fs-5"><?= sanitize($plan['name']) ?></strong> - <?= format_bdt($plan['price']) ?> / mo
                            <div class="small text-secondary"><?= ($plan['product_limit'] >= 99999) ? 'Unlimited' : $plan['product_limit'] ?> products | <?= $plan['custom_domain_allowed'] ? 'Custom Domain Allowed' : 'Subdomain' ?></div>
                        </div>
                        <?php if ($plan['id'] == ($currentPlan['id'] ?? 1)): ?>
                            <span class="badge bg-secondary">Current Active</span>
                        <?php else: ?>
                            <button type="button" class="btn btn-sm btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#upgradeModal<?= $plan['id'] ?>">
                                Upgrade Plan
                            </button>

                            <!-- Upgrade Modal -->
                            <div class="modal fade text-start" id="upgradeModal<?= $plan['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content bg-dark text-light border-secondary">
                                        <form action="/dashboard/subscription/upgrade" method="POST">
                                            <input type="hidden" name="_csrf_token" value="<?= csrf_token() ?>">
                                            <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">

                                            <div class="modal-header border-secondary">
                                                <h5 class="modal-title fw-bold">Upgrade to <?= sanitize($plan['name']) ?> Plan (<?= format_bdt($plan['price']) ?>/mo)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="fw-bold text-warning mb-2">Step 1: Send Payment via bKash / Nagad / Rocket / Bank</h6>
                                                
                                                <div class="row g-3 mb-3 small">
                                                    <!-- bKash -->
                                                    <?php if (!empty($platformPayments['bkash_number'])): ?>
                                                        <div class="col-md-6">
                                                            <div class="p-2 bg-secondary bg-opacity-25 rounded border border-danger">
                                                                <strong class="text-danger">bKash (<?= ucfirst($platformPayments['bkash_type'] ?? 'personal') ?>):</strong> <code class="text-warning fs-6"><?= sanitize($platformPayments['bkash_number']) ?></code>
                                                                <div class="text-secondary mt-1"><?= sanitize($platformPayments['bkash_instruction'] ?? '') ?></div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Nagad -->
                                                    <?php if (!empty($platformPayments['nagad_number'])): ?>
                                                        <div class="col-md-6">
                                                            <div class="p-2 bg-secondary bg-opacity-25 rounded border border-warning">
                                                                <strong class="text-warning">Nagad (<?= ucfirst($platformPayments['nagad_type'] ?? 'personal') ?>):</strong> <code class="text-warning fs-6"><?= sanitize($platformPayments['nagad_number']) ?></code>
                                                                <div class="text-secondary mt-1"><?= sanitize($platformPayments['nagad_instruction'] ?? '') ?></div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Rocket -->
                                                    <?php if (!empty($platformPayments['rocket_number'])): ?>
                                                        <div class="col-md-6">
                                                            <div class="p-2 bg-secondary bg-opacity-25 rounded border border-primary">
                                                                <strong class="text-primary">Rocket (<?= ucfirst($platformPayments['rocket_type'] ?? 'personal') ?>):</strong> <code class="text-warning fs-6"><?= sanitize($platformPayments['rocket_number']) ?></code>
                                                                <div class="text-secondary mt-1"><?= sanitize($platformPayments['rocket_instruction'] ?? '') ?></div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Bank Details -->
                                                    <?php if (!empty($platformPayments['bank_details'])): ?>
                                                        <div class="col-md-6">
                                                            <div class="p-2 bg-secondary bg-opacity-25 rounded border border-info">
                                                                <strong class="text-info">Bank Transfer:</strong>
                                                                <div class="text-secondary mt-1"><?= nl2br(sanitize($platformPayments['bank_details'])) ?></div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <h6 class="fw-bold text-warning mb-2">Step 2: Enter Transaction Details</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label text-secondary small fw-bold">Payment Method Used</label>
                                                        <select name="payment_method" class="form-select bg-dark border-secondary text-light" required>
                                                            <option value="bkash">bKash</option>
                                                            <option value="nagad">Nagad</option>
                                                            <option value="rocket">Rocket</option>
                                                            <option value="bank">Bank Transfer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-secondary small fw-bold">Transaction ID (TrxID) <span class="text-danger">*</span></label>
                                                        <input type="text" name="transaction_id" class="form-control bg-dark border-secondary text-light" required placeholder="e.g. 9N8B7A6C5">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-secondary small fw-bold">Sender Mobile Number / Reference</label>
                                                        <input type="text" name="sender_number" class="form-control bg-dark border-secondary text-light" placeholder="017XXXXXXXX">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label text-secondary small fw-bold">Additional Notes (Optional)</label>
                                                        <input type="text" name="payment_note" class="form-control bg-dark border-secondary text-light" placeholder="Payment note...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-header border-secondary justify-content-end">
                                                <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success fw-bold">Submit Payment for Approval</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Merchant Subscription Payment History -->
<div class="card-custom">
    <h6 class="fw-bold text-light mb-3"><i class="bi bi-clock-history text-warning me-2"></i> Subscription Upgrade Request History</h6>
    <?php if (empty($paymentHistory)): ?>
        <p class="text-secondary small mb-0">No plan upgrade requests submitted yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 small">
                <thead>
                    <tr class="text-secondary">
                        <th>Requested Plan</th>
                        <th>Method</th>
                        <th>TrxID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paymentHistory as $pay): ?>
                        <tr>
                            <td class="fw-bold text-light"><?= sanitize($pay['plan_name']) ?></td>
                            <td><span class="badge bg-secondary"><?= strtoupper(sanitize($pay['payment_method'])) ?></span></td>
                            <td><code class="text-warning"><?= sanitize($pay['transaction_id']) ?></code></td>
                            <td class="fw-bold text-success"><?= format_bdt($pay['amount']) ?></td>
                            <td>
                                <?php if ($pay['status'] === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending Approval</span>
                                <?php elseif ($pay['status'] === 'approved'): ?>
                                    <span class="badge bg-success">Approved & Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-secondary"><?= date('M d, Y H:i', strtotime($pay['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
