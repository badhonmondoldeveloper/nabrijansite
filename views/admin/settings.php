<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-light"><i class="bi bi-wallet2 text-warning me-2"></i> SaaS Manual Payment Configuration</h4>
        <p class="text-secondary small mb-0">Set up platform bKash, Nagad, Rocket & Bank details to collect subscription upgrade payments from merchants.</p>
    </div>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="/admin/settings/payment" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= csrf_token() ?>">

    <div class="row g-4">
        <!-- bKash Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-danger fs-6 px-3 py-2">bKash</span>
                    <h6 class="fw-bold text-light mb-0">Platform bKash Gateway</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">bKash Mobile Number</label>
                    <input type="text" name="bkash_number" class="form-control bg-dark border-secondary text-light" value="<?= sanitize($settings['bkash_number'] ?? '01700000000') ?>" required placeholder="017XXXXXXXX">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Account Type</label>
                    <select name="bkash_type" class="form-select bg-dark border-secondary text-light">
                        <option value="personal" <?= ($settings['bkash_type'] ?? '') === 'personal' ? 'selected' : '' ?>>Personal (Send Money)</option>
                        <option value="agent" <?= ($settings['bkash_type'] ?? '') === 'agent' ? 'selected' : '' ?>>Agent (Cash Out)</option>
                        <option value="merchant" <?= ($settings['bkash_type'] ?? '') === 'merchant' ? 'selected' : '' ?>>Merchant (Make Payment)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Payment Instructions for Merchant</label>
                    <textarea name="bkash_instruction" class="form-control bg-dark border-secondary text-light" rows="3" placeholder="Enter instructions..."><?= sanitize($settings['bkash_instruction'] ?? 'Send money to our bKash personal number and submit TrxID.') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Nagad Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Nagad</span>
                    <h6 class="fw-bold text-light mb-0">Platform Nagad Gateway</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Nagad Mobile Number</label>
                    <input type="text" name="nagad_number" class="form-control bg-dark border-secondary text-light" value="<?= sanitize($settings['nagad_number'] ?? '01700000000') ?>" required placeholder="017XXXXXXXX">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Account Type</label>
                    <select name="nagad_type" class="form-select bg-dark border-secondary text-light">
                        <option value="personal" <?= ($settings['nagad_type'] ?? '') === 'personal' ? 'selected' : '' ?>>Personal (Send Money)</option>
                        <option value="agent" <?= ($settings['nagad_type'] ?? '') === 'agent' ? 'selected' : '' ?>>Agent (Cash Out)</option>
                        <option value="merchant" <?= ($settings['nagad_type'] ?? '') === 'merchant' ? 'selected' : '' ?>>Merchant (Make Payment)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Payment Instructions for Merchant</label>
                    <textarea name="nagad_instruction" class="form-control bg-dark border-secondary text-light" rows="3" placeholder="Enter instructions..."><?= sanitize($settings['nagad_instruction'] ?? 'Send money to our Nagad personal number and submit TrxID.') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Rocket Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-primary fs-6 px-3 py-2">Rocket</span>
                    <h6 class="fw-bold text-light mb-0">Platform Rocket Gateway</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Rocket Mobile Number (12 Digits)</label>
                    <input type="text" name="rocket_number" class="form-control bg-dark border-secondary text-light" value="<?= sanitize($settings['rocket_number'] ?? '017000000007') ?>" placeholder="017XXXXXXXXX">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Account Type</label>
                    <select name="rocket_type" class="form-select bg-dark border-secondary text-light">
                        <option value="personal" <?= ($settings['rocket_type'] ?? '') === 'personal' ? 'selected' : '' ?>>Personal (Send Money)</option>
                        <option value="agent" <?= ($settings['rocket_type'] ?? '') === 'agent' ? 'selected' : '' ?>>Agent (Cash Out)</option>
                        <option value="merchant" <?= ($settings['rocket_type'] ?? '') === 'merchant' ? 'selected' : '' ?>>Merchant (Make Payment)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Payment Instructions for Merchant</label>
                    <textarea name="rocket_instruction" class="form-control bg-dark border-secondary text-light" rows="3" placeholder="Enter instructions..."><?= sanitize($settings['rocket_instruction'] ?? 'Send money to our Rocket number and submit TrxID.') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-info text-dark fs-6 px-3 py-2">Bank Transfer</span>
                    <h6 class="fw-bold text-light mb-0">Platform Bank Account</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Full Bank Account & Branch Details</label>
                    <textarea name="bank_details" class="form-control bg-dark border-secondary text-light" rows="7" placeholder="Bank Name: Dutch Bangla Bank Ltd&#10;Account Name: Nabrijan Tech Ltd&#10;Account No: 123.456.7890&#10;Branch: Gulshan Branch, Dhaka"><?= sanitize($settings['bank_details'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success btn-lg fw-bold px-5">
            <i class="bi bi-check-circle-fill me-2"></i> Save SaaS Payment Settings
        </button>
    </div>
</form>
