<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Subscription & Usage Limits</h4>
        <p class="text-secondary small mb-0">Manage your SaaS plan subscription and store feature permissions.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Current Plan Card -->
    <div class="col-lg-6">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-award me-2 text-warning"></i> Current Active Plan</h6>
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
                    <span>Products Limit</span>
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
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-arrow-up-circle me-2 text-info"></i> Available SaaS Plans</h6>
            <div class="list-group list-group-flush bg-transparent">
                <?php foreach ($allPlans as $plan): ?>
                    <div class="list-group-item bg-transparent text-light border-secondary px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-warning"><?= sanitize($plan['name']) ?></strong> - <?= format_bdt($plan['price']) ?> / mo
                            <div class="small text-secondary"><?= ($plan['product_limit'] >= 99999) ? 'Unlimited' : $plan['product_limit'] ?> products | <?= $plan['custom_domain_allowed'] ? 'Custom Domain' : 'Subdomain' ?></div>
                        </div>
                        <?php if ($plan['id'] == ($currentPlan['id'] ?? 1)): ?>
                            <span class="badge bg-secondary">Current</span>
                        <?php else: ?>
                            <button class="btn btn-sm btn-outline-warning" onclick="alert('Subscription upgrades will be processed via payment gateway in production.')">Upgrade</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
