<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">SaaS Subscription Plans Matrix</h4>
        <p class="text-secondary small mb-0">View subscription pricing, product quotas, theme allowances, and domain permissions.</p>
    </div>
</div>

<div class="row g-4">
    <?php foreach ($plans as $plan): ?>
        <div class="col-md-6 col-lg-3">
            <div class="card-custom text-center h-100 d-flex flex-column">
                <span class="badge bg-warning text-dark align-self-center mb-2"><?= sanitize($plan['slug']) ?></span>
                <h3 class="fw-bold text-light mb-2"><?= sanitize($plan['name']) ?></h3>
                <div class="display-6 fw-bold text-success mb-3"><?= format_bdt($plan['price']) ?> <span class="fs-6 text-secondary font-weight-normal">/mo</span></div>
                
                <ul class="list-group list-group-flush bg-transparent text-start mb-4 small">
                    <li class="list-group-item bg-transparent text-light border-secondary">
                        <i class="bi bi-box-seam me-2 text-warning"></i> Max Products: <strong><?= ($plan['product_limit'] >= 99999) ? 'Unlimited' : $plan['product_limit'] ?></strong>
                    </li>
                    <li class="list-group-item bg-transparent text-light border-secondary">
                        <i class="bi bi-palette me-2 text-info"></i> Themes Limit: <strong><?= $plan['theme_limit'] ?></strong>
                    </li>
                    <li class="list-group-item bg-transparent text-light border-secondary">
                        <i class="bi bi-globe me-2 text-primary"></i> Custom Domain: <strong><?= $plan['custom_domain_allowed'] ? 'Included' : 'Subdomain only' ?></strong>
                    </li>
                    <li class="list-group-item bg-transparent text-light border-secondary">
                        <i class="bi bi-bar-chart me-2 text-success"></i> Analytics: <strong><?= $plan['analytics_allowed'] ? 'Full Access' : 'Basic' ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>
