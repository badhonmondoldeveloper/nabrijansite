<div class="container py-3 py-md-4">
    <h3 class="fw-bold mb-3 mb-md-4 fs-4 fs-md-3"><i class="bi bi-credit-card me-2 text-success"></i> Checkout</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= sanitize($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="/store/<?= sanitize($store['slug']) ?>/checkout" method="POST">
        <div class="row g-3 g-md-4">
            <!-- Customer & Delivery Form -->
            <div class="col-lg-8">
                <!-- Step 1: Customer Info -->
                <div class="store-checkout-step">
                    <h5 class="fw-bold mb-3 fs-6 fs-md-5"><span class="store-checkout-step-num">1</span> Customer Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6 mb-1 mb-md-3">
                            <label for="name" class="form-label text-muted small fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="e.g. Rahim Uddin" autocomplete="name">
                        </div>
                        <div class="col-md-6 mb-1 mb-md-3">
                            <label for="phone" class="form-label text-muted small fw-bold">Phone Number (BD +880) <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" required placeholder="01712345678" autocomplete="tel" inputmode="tel">
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="email" class="form-label text-muted small fw-bold">Email Address (Optional)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="customer@example.com" autocomplete="email">
                    </div>
                </div>

                <!-- Step 2: Shipping & Delivery -->
                <div class="store-checkout-step">
                    <h5 class="fw-bold mb-3 fs-6 fs-md-5"><span class="store-checkout-step-num">2</span> Delivery Area & Shipping Address</h5>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Delivery Area</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="store-payment-card" onclick="document.getElementById('location_dhaka').click()">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="radio" name="delivery_location" id="location_dhaka" value="dhaka" checked onchange="updateDeliveryFee(<?= (float)($storeSettings['dhaka_delivery_charge'] ?? 60) ?>)">
                                        <label class="form-check-label fw-bold d-block small" for="location_dhaka">
                                            Inside Dhaka
                                            <span class="d-block text-success small font-weight-normal"><?= format_bdt($storeSettings['dhaka_delivery_charge'] ?? 60) ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="store-payment-card" onclick="document.getElementById('location_outside').click()">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="radio" name="delivery_location" id="location_outside" value="outside_dhaka" onchange="updateDeliveryFee(<?= (float)($storeSettings['outside_dhaka_delivery_charge'] ?? 120) ?>)">
                                        <label class="form-check-label fw-bold d-block small" for="location_outside">
                                            Outside Dhaka
                                            <span class="d-block text-success small font-weight-normal"><?= format_bdt($storeSettings['outside_dhaka_delivery_charge'] ?? 120) ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6 mb-1 mb-md-3">
                            <label for="division" class="form-label text-muted small fw-bold">Division</label>
                            <input type="text" class="form-control" id="division" name="division" value="Dhaka">
                        </div>
                        <div class="col-6 mb-1 mb-md-3">
                            <label for="district" class="form-label text-muted small fw-bold">District</label>
                            <input type="text" class="form-control" id="district" name="district" value="Dhaka">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="full_address" class="form-label text-muted small fw-bold">Full Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="full_address" name="full_address" rows="2" required placeholder="House #, Road #, Area, Landmarks..."></textarea>
                    </div>
                    <div class="mb-0">
                        <label for="notes" class="form-label text-muted small fw-bold">Order Notes (Optional)</label>
                        <input type="text" class="form-control" id="notes" name="notes" placeholder="Special delivery instructions...">
                    </div>
                </div>

                <!-- Step 3: Payment Selection -->
                <div class="store-checkout-step">
                    <h5 class="fw-bold mb-3 fs-6 fs-md-5"><span class="store-checkout-step-num">3</span> Payment Method</h5>
                    
                    <!-- COD Option -->
                    <?php if ($storeSettings['cod_enabled'] ?? 1): ?>
                        <div class="store-payment-card mb-2" onclick="selectPaymentMethod('cod')">
                            <div class="form-check w-100 m-0">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_cod" value="cod" checked>
                                <label class="form-check-label fw-bold d-block text-dark" for="pay_cod">
                                    <i class="bi bi-cash me-2 text-success"></i> Cash on Delivery (COD)
                                    <span class="d-block small text-muted font-weight-normal">Pay with cash when package arrives</span>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- bKash Option -->
                    <?php if (!empty($storeSettings['bkash_enabled']) && !empty($storeSettings['bkash_number'])): ?>
                        <div class="store-payment-card mb-2" onclick="selectPaymentMethod('bkash')">
                            <div class="form-check w-100 m-0">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_bkash" value="bkash">
                                <label class="form-check-label fw-bold d-block text-dark" for="pay_bkash">
                                    <span class="badge bg-danger me-2">bKash</span> Manual bKash Payment
                                </label>
                            </div>
                        </div>
                        <div id="bkash_details" class="payment-method-details mb-2 small" style="display: none;">
                            <div class="p-3 bg-danger bg-opacity-10 rounded-3 border border-danger">
                                <strong class="text-dark">bKash Mobile:</strong> <code class="fs-6 text-danger fw-bold"><?= sanitize($storeSettings['bkash_number']) ?></code> (<?= ucfirst($storeSettings['bkash_type'] ?? 'personal') ?>)
                                <?php if (!empty($storeSettings['bkash_instruction'])): ?>
                                    <div class="mt-1 text-dark"><?= nl2br(sanitize($storeSettings['bkash_instruction'])) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Nagad Option -->
                    <?php if (!empty($storeSettings['nagad_enabled']) && !empty($storeSettings['nagad_number'])): ?>
                        <div class="store-payment-card mb-2" onclick="selectPaymentMethod('nagad')">
                            <div class="form-check w-100 m-0">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_nagad" value="nagad">
                                <label class="form-check-label fw-bold d-block text-dark" for="pay_nagad">
                                    <span class="badge bg-warning text-dark me-2">Nagad</span> Manual Nagad Payment
                                </label>
                            </div>
                        </div>
                        <div id="nagad_details" class="payment-method-details mb-2 small" style="display: none;">
                            <div class="p-3 bg-warning bg-opacity-10 rounded-3 border border-warning">
                                <strong class="text-dark">Nagad Mobile:</strong> <code class="fs-6 text-dark fw-bold"><?= sanitize($storeSettings['nagad_number']) ?></code> (<?= ucfirst($storeSettings['nagad_type'] ?? 'personal') ?>)
                                <?php if (!empty($storeSettings['nagad_instruction'])): ?>
                                    <div class="mt-1 text-dark"><?= nl2br(sanitize($storeSettings['nagad_instruction'])) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Rocket Option -->
                    <?php if (!empty($storeSettings['rocket_enabled']) && !empty($storeSettings['rocket_number'])): ?>
                        <div class="store-payment-card mb-2" onclick="selectPaymentMethod('rocket')">
                            <div class="form-check w-100 m-0">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_rocket" value="rocket">
                                <label class="form-check-label fw-bold d-block text-dark" for="pay_rocket">
                                    <span class="badge bg-primary me-2">Rocket</span> Manual Rocket Payment
                                </label>
                            </div>
                        </div>
                        <div id="rocket_details" class="payment-method-details mb-2 small" style="display: none;">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-3 border border-primary">
                                <strong class="text-dark">Rocket Mobile:</strong> <code class="fs-6 text-primary fw-bold"><?= sanitize($storeSettings['rocket_number']) ?></code> (<?= ucfirst($storeSettings['rocket_type'] ?? 'personal') ?>)
                                <?php if (!empty($storeSettings['rocket_instruction'])): ?>
                                    <div class="mt-1 text-dark"><?= nl2br(sanitize($storeSettings['rocket_instruction'])) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Manual Payment Proof Inputs -->
                    <div id="manualPaymentInputs" class="mt-3 p-3 bg-white rounded-3 border border-warning" style="display: none;">
                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle text-warning me-1"></i> Payment Proof Details</h6>
                        <div class="row g-2">
                            <div class="col-md-6 mb-1">
                                <label for="transaction_id" class="form-label small fw-bold">Transaction ID (TrxID) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="e.g. 9N8B7A6C5">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="payment_note" class="form-label small fw-bold">Sender Mobile / Account</label>
                                <input type="tel" class="form-control" id="payment_note" name="payment_note" placeholder="Sender phone number" inputmode="tel">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="bg-white border rounded-4 p-3 p-md-4 shadow-sm">
                    <h5 class="fw-bold mb-3 fs-6 fs-md-5">Order Summary</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($cart['items'] as $item): ?>
                            <li class="list-group-item bg-transparent border-bottom d-flex justify-content-between px-0 py-2">
                                <div>
                                    <div class="fw-semibold text-dark small fs-md-6"><?= sanitize($item['name']) ?></div>
                                    <small class="text-muted"><?= $item['quantity'] ?> x <?= format_bdt($item['unit_price']) ?></small>
                                </div>
                                <span class="fw-bold text-success small fs-md-6"><?= format_bdt($item['total_price']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="d-flex justify-content-between mb-2 text-muted small">
                        <span>Subtotal</span>
                        <span class="text-dark fw-bold"><?= format_bdt($cart['subtotal']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted small">
                        <span>Delivery Fee</span>
                        <span class="text-success fw-bold" id="deliveryFeeDisplay"><?= format_bdt($storeSettings['dhaka_delivery_charge'] ?? 60) ?></span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-6 fs-md-5 fw-bold">Total Amount</span>
                        <span class="fs-5 fs-md-4 fw-bold text-success" id="totalAmountDisplay"><?= format_bdt($cart['subtotal'] + ($storeSettings['dhaka_delivery_charge'] ?? 60)) ?></span>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-5 rounded-pill shadow-sm" style="min-height: 48px;">Place Order Now</button>
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
        const details = document.querySelectorAll('.payment-method-details');
        details.forEach(el => el.style.display = 'none');

        const radios = document.querySelectorAll('input[name="payment_method"]');
        radios.forEach(r => {
            if (r.value === method) r.checked = true;
        });

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
