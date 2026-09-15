<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-light"><i class="bi bi-wallet2 text-warning me-2"></i> Store Payment Gateways & Methods</h4>
        <p class="text-secondary small mb-0">Configure bKash, Nagad, Rocket, Bank Transfer & Cash on Delivery for your store's customer checkout.</p>
    </div>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="/dashboard/payment-methods" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= csrf_token() ?>">

    <div class="row g-4">
        <!-- Cash on Delivery (COD) -->
        <div class="col-12">
            <div class="card-custom">
                <div class="form-check form-switch d-flex align-items-center gap-3">
                    <input class="form-check-input fs-4" type="checkbox" name="cod_enabled" id="cod_enabled" value="1" <?= ($settings['cod_enabled'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold text-light fs-5" for="cod_enabled">
                        <i class="bi bi-truck text-success me-2"></i> Enable Cash on Delivery (COD)
                    </label>
                </div>
                <p class="text-secondary small mb-0 mt-2 ms-5">Allow customers to pay in cash upon receiving their delivery.</p>
            </div>
        </div>

        <!-- bKash Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger fs-6 px-3 py-2">bKash</span>
                        <h6 class="fw-bold text-light mb-0">bKash Personal / Merchant</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input fs-5" type="checkbox" name="bkash_enabled" id="bkash_enabled" value="1" <?= ($settings['bkash_enabled'] ?? 1) ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">bKash Mobile Number</label>
                    <input type="text" name="bkash_number" class="form-control bg-dark border-secondary text-light" value="<?= sanitize($settings['bkash_number'] ?? '') ?>" placeholder="017XXXXXXXX">
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
                    <label class="form-label text-secondary small fw-bold">Instructions for Customer</label>
                    <textarea name="bkash_instruction" class="form-control bg-dark border-secondary text-light" rows="3" placeholder="e.g. Please Send Money to our bKash Personal number. Enter the Transaction ID (TrxID) below."><?= sanitize($settings['bkash_instruction'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Nagad Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">Nagad</span>
                        <h6 class="fw-bold text-light mb-0">Nagad Personal / Merchant</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input fs-5" type="checkbox" name="nagad_enabled" id="nagad_enabled" value="1" <?= ($settings['nagad_enabled'] ?? 1) ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Nagad Mobile Number</label>
                    <input type="text" name="nagad_number" class="form-control bg-dark border-secondary text-light" value="<?= sanitize($settings['nagad_number'] ?? '') ?>" placeholder="017XXXXXXXX">
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
                    <label class="form-label text-secondary small fw-bold">Instructions for Customer</label>
                    <textarea name="nagad_instruction" class="form-control bg-dark border-secondary text-light" rows="3" placeholder="e.g. Please Send Money to our Nagad Personal number. Enter the Transaction ID (TrxID) below."><?= sanitize($settings['nagad_instruction'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Rocket Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary fs-6 px-3 py-2">Rocket</span>
                        <h6 class="fw-bold text-light mb-0">Rocket Personal / Agent</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input fs-5" type="checkbox" name="rocket_enabled" id="rocket_enabled" value="1" <?= ($settings['rocket_enabled'] ?? 0) ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Rocket Mobile Number (12 Digits)</label>
                    <input type="text" name="rocket_number" class="form-control bg-dark border-secondary text-light" value="<?= sanitize($settings['rocket_number'] ?? '') ?>" placeholder="017XXXXXXXXX">
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
                    <label class="form-label text-secondary small fw-bold">Instructions for Customer</label>
                    <textarea name="rocket_instruction" class="form-control bg-dark border-secondary text-light" rows="3" placeholder="e.g. Please Send Money to our Rocket number. Enter the Transaction ID (TrxID) below."><?= sanitize($settings['rocket_instruction'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Configuration -->
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-info text-dark fs-6 px-3 py-2">Bank Transfer</span>
                        <h6 class="fw-bold text-light mb-0">Bank Account Details</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input fs-5" type="checkbox" name="bank_enabled" id="bank_enabled" value="1" <?= ($settings['bank_enabled'] ?? 0) ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Full Bank Details for Customer Transfer</label>
                    <textarea name="bank_details" class="form-control bg-dark border-secondary text-light" rows="7" placeholder="Bank Name: Dutch Bangla Bank Ltd&#10;Account Name: Store Owner Name&#10;Account No: 123.456.7890&#10;Branch: Dhaka Branch"><?= sanitize($settings['bank_details'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-warning btn-lg fw-bold px-5">
            <i class="bi bi-save-fill me-2"></i> Save Store Payment Settings
        </button>
    </div>
</form>
