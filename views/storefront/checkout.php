<div class="container py-5">
    <h3 class="fw-bold text-light mb-4"><i class="bi bi-credit-card me-2 text-warning"></i> Checkout</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= sanitize($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="/store/<?= sanitize($store['slug']) ?>/checkout" method="POST">
        <div class="row g-4">
            <!-- Customer & Delivery Form -->
            <div class="col-lg-8">
                <!-- Customer Information -->
                <div class="card-custom p-4 mb-4">
                    <h5 class="fw-bold text-light mb-3"><span class="badge bg-warning text-dark me-2">1</span> Customer Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label text-secondary">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="name" name="name" required placeholder="e.g. Rahim Uddin">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label text-secondary">Phone Number (BD +880) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="phone" name="phone" required placeholder="01712345678">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary">Email Address (Optional)</label>
                        <input type="email" class="form-control bg-dark text-light border-secondary" id="email" name="email" placeholder="customer@example.com">
                    </div>
                </div>

                <!-- Delivery & Shipping Address -->
                <div class="card-custom p-4 mb-4">
                    <h5 class="fw-bold text-light mb-3"><span class="badge bg-warning text-dark me-2">2</span> Delivery Location & Address</h5>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Delivery Area</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_location" id="location_dhaka" value="dhaka" checked onchange="updateDeliveryFee(<?= (float)($storeSettings['dhaka_delivery_charge'] ?? 60) ?>)">
                                <label class="form-check-label text-light" for="location_dhaka">Inside Dhaka (<?= format_bdt($storeSettings['dhaka_delivery_charge'] ?? 60) ?>)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_location" id="location_outside" value="outside_dhaka" onchange="updateDeliveryFee(<?= (float)($storeSettings['outside_dhaka_delivery_charge'] ?? 120) ?>)">
                                <label class="form-check-label text-light" for="location_outside">Outside Dhaka (<?= format_bdt($storeSettings['outside_dhaka_delivery_charge'] ?? 120) ?>)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="division" class="form-label text-secondary">Division</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="division" name="division" value="Dhaka">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label text-secondary">District</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="district" name="district" value="Dhaka">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="full_address" class="form-label text-secondary">Full Delivery Address <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-dark text-light border-secondary" id="full_address" name="full_address" rows="3" required placeholder="House #, Road #, Area, Landmarks..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label text-secondary">Order Notes (Optional)</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" id="notes" name="notes" placeholder="Special delivery instructions...">
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="card-custom p-4 mb-4">
                    <h5 class="fw-bold text-light mb-3"><span class="badge bg-warning text-dark me-2">3</span> Select Payment Method</h5>
                    
                    <!-- COD Option -->
                    <?php if ($storeSettings['cod_enabled'] ?? 1): ?>
                        <div class="form-check mb-3 p-3 bg-dark rounded border border-secondary">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_cod" value="cod" checked onclick="selectPaymentMethod('cod')">
                            <label class="form-check-label text-light fw-bold" for="pay_cod">
                                <i class="bi bi-cash me-2 text-success"></i> Cash on Delivery (COD)
                            </label>
                            <div class="small text-secondary mt-1">Pay with cash when your product arrives at your doorstep.</div>
                        </div>
                    <?php endif; ?>

                    <!-- bKash Option -->
                    <?php if (!empty($storeSettings['bkash_enabled']) && !empty($storeSettings['bkash_number'])): ?>
                        <div class="form-check mb-3 p-3 bg-dark rounded border border-secondary">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_bkash" value="bkash" onclick="selectPaymentMethod('bkash')">
                            <label class="form-check-label text-light fw-bold" for="pay_bkash">
                                <span class="badge bg-danger me-2">bKash</span> Manual bKash Payment
                            </label>
                            <div id="bkash_details" class="payment-method-details mt-2 text-secondary small" style="display: none;">
                                <div class="p-2 bg-secondary bg-opacity-25 rounded border border-danger mb-2">
                                    <strong class="text-light">bKash Mobile:</strong> <code class="fs-6 text-warning"><?= sanitize($storeSettings['bkash_number']) ?></code> (<?= ucfirst($storeSettings['bkash_type'] ?? 'personal') ?>)
                                    <?php if (!empty($storeSettings['bkash_instruction'])): ?>
                                        <div class="mt-1 text-light"><?= nl2br(sanitize($storeSettings['bkash_instruction'])) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Nagad Option -->
                    <?php if (!empty($storeSettings['nagad_enabled']) && !empty($storeSettings['nagad_number'])): ?>
                        <div class="form-check mb-3 p-3 bg-dark rounded border border-secondary">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_nagad" value="nagad" onclick="selectPaymentMethod('nagad')">
                            <label class="form-check-label text-light fw-bold" for="pay_nagad">
                                <span class="badge bg-warning text-dark me-2">Nagad</span> Manual Nagad Payment
                            </label>
                            <div id="nagad_details" class="payment-method-details mt-2 text-secondary small" style="display: none;">
                                <div class="p-2 bg-secondary bg-opacity-25 rounded border border-warning mb-2">
                                    <strong class="text-light">Nagad Mobile:</strong> <code class="fs-6 text-warning"><?= sanitize($storeSettings['nagad_number']) ?></code> (<?= ucfirst($storeSettings['nagad_type'] ?? 'personal') ?>)
                                    <?php if (!empty($storeSettings['nagad_instruction'])): ?>
                                        <div class="mt-1 text-light"><?= nl2br(sanitize($storeSettings['nagad_instruction'])) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Rocket Option -->
                    <?php if (!empty($storeSettings['rocket_enabled']) && !empty($storeSettings['rocket_number'])): ?>
                        <div class="form-check mb-3 p-3 bg-dark rounded border border-secondary">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_rocket" value="rocket" onclick="selectPaymentMethod('rocket')">
                            <label class="form-check-label text-light fw-bold" for="pay_rocket">
                                <span class="badge bg-primary me-2">Rocket</span> Manual Rocket Payment
                            </label>
                            <div id="rocket_details" class="payment-method-details mt-2 text-secondary small" style="display: none;">
                                <div class="p-2 bg-secondary bg-opacity-25 rounded border border-primary mb-2">
                                    <strong class="text-light">Rocket Mobile:</strong> <code class="fs-6 text-warning"><?= sanitize($storeSettings['rocket_number']) ?></code> (<?= ucfirst($storeSettings['rocket_type'] ?? 'personal') ?>)
                                    <?php if (!empty($storeSettings['rocket_instruction'])): ?>
                                        <div class="mt-1 text-light"><?= nl2br(sanitize($storeSettings['rocket_instruction'])) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Bank Transfer Option -->
                    <?php if (!empty($storeSettings['bank_enabled']) && !empty($storeSettings['bank_details'])): ?>
                        <div class="form-check mb-3 p-3 bg-dark rounded border border-secondary">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_bank" value="bank" onclick="selectPaymentMethod('bank')">
                            <label class="form-check-label text-light fw-bold" for="pay_bank">
                                <span class="badge bg-info text-dark me-2">Bank</span> Direct Bank Transfer
                            </label>
                            <div id="bank_details" class="payment-method-details mt-2 text-secondary small" style="display: none;">
                                <div class="p-2 bg-secondary bg-opacity-25 rounded border border-info mb-2 text-light">
                                    <?= nl2br(sanitize($storeSettings['bank_details'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Transaction ID and Sender Number Input Fields -->
                    <div id="manualPaymentInputs" class="mt-3 p-3 bg-dark rounded border border-warning" style="display: none;">
                        <h6 class="fw-bold text-warning mb-2"><i class="bi bi-info-circle me-1"></i> Enter Payment Proof Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="transaction_id" class="form-label text-secondary small fw-bold">Transaction ID (TrxID) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-dark text-light border-secondary" id="transaction_id" name="transaction_id" placeholder="e.g. 9N8B7A6C5">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="payment_note" class="form-label text-secondary small fw-bold">Sender Mobile / Account Reference</label>
                                <input type="text" class="form-control bg-dark text-light border-secondary" id="payment_note" name="payment_note" placeholder="Sender phone number or name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Column -->
            <div class="col-lg-4">
                <div class="card-custom p-4">
                    <h5 class="fw-bold text-light mb-3">Order Summary</h5>
                    <ul class="list-group list-group-flush bg-transparent mb-3">
                        <?php foreach ($cart['items'] as $item): ?>
                            <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between px-0">
                                <div>
                                    <div class="fw-bold"><?= sanitize($item['name']) ?></div>
                                    <small class="text-secondary"><?= $item['quantity'] ?> x <?= format_bdt($item['unit_price']) ?></small>
                                </div>
                                <span class="fw-bold text-success"><?= format_bdt($item['total_price']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="d-flex justify-content-between mb-2 text-secondary">
                        <span>Subtotal</span>
                        <span class="text-light fw-bold"><?= format_bdt($cart['subtotal']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-secondary">
                        <span>Delivery Fee</span>
                        <span class="text-warning" id="deliveryFeeDisplay"><?= format_bdt($storeSettings['dhaka_delivery_charge'] ?? 60) ?></span>
                    </div>
                    <hr class="border-secondary mb-3">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold text-light">Total Amount</span>
                        <span class="fs-4 fw-bold text-success" id="totalAmountDisplay"><?= format_bdt($cart['subtotal'] + ($storeSettings['dhaka_delivery_charge'] ?? 60)) ?></span>
                    </div>

                    <button type="submit" class="btn btn-brand w-100 py-3 fw-bold fs-5">Place Order Now</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const subtotal = <?= (float)$cart['subtotal'] ?>;
    function updateDeliveryFee(fee) {
        document.getElementById('deliveryFeeDisplay').innerText = '৳' + fee.toFixed(2);
        document.getElementById('totalAmountDisplay').innerText = '৳' + (subtotal + fee).toFixed(2);
    }

    function selectPaymentMethod(method) {
        // Hide all instruction details
        const details = document.querySelectorAll('.payment-method-details');
        details.forEach(el => el.style.display = 'none');

        const inputs = document.getElementById('manualPaymentInputs');
        if (method === 'cod') {
            inputs.style.display = 'none';
        } else {
            inputs.style.display = 'block';
            const target = document.getElementById(method + '_details');
            if (target) target.style.display = 'block';
        }
    }
</script>
