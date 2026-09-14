<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Store Setup Wizard - Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 2rem 1rem; }
        .wizard-card { background: #1e293b; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.4); width: 100%; max-width: 650px; padding: 2.5rem; border: 1px solid #334155; }
        .brand-logo { font-size: 1.8rem; font-weight: 800; color: #059669; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; justify-content: center; margin-bottom: 0.5rem; }
        .brand-logo span { color: #eab308; }
        .btn-primary-custom { background: #059669; border: none; color: #ffffff; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 0.5rem; transition: background 0.2s; }
        .btn-primary-custom:hover { background: #047857; color: #ffffff; }
        .form-control, .form-select { background: #0f172a; border: 1px solid #334155; color: #f8fafc; padding: 0.75rem; border-radius: 0.5rem; }
        .form-control:focus, .form-select:focus { background: #0f172a; border-color: #059669; color: #f8fafc; box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25); }
        .form-label { font-size: 0.9rem; font-weight: 500; color: #cbd5e1; }
        .theme-card { border: 2px solid #334155; border-radius: 0.5rem; padding: 1rem; text-align: center; cursor: pointer; transition: all 0.2s; background: #0f172a; }
        .theme-card.active, .theme-card:hover { border-color: #059669; background: #111827; }
        .step-badge { background: #eab308; color: #0f172a; font-weight: 700; border-radius: 50%; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; margin-right: 0.5rem; }
    </style>
</head>
<body>
    <div class="wizard-card">
        <a href="/" class="brand-logo">NABRI<span>JAN</span></a>
        <h4 class="text-center text-light mb-1">Set Up Your Online Store</h4>
        <p class="text-center text-secondary small mb-4">Complete these basic details to generate your storefront instantly.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger py-2 mb-3">
                <?php foreach ($errors as $err): ?>
                    <div><?= sanitize($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/onboarding" method="POST" id="onboardingForm">
            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
            <input type="hidden" name="theme_id" id="selected_theme_id" value="1">

            <!-- Step 1: Business Details -->
            <div class="mb-4">
                <h6 class="text-light mb-3"><span class="step-badge">1</span> Business Information</h6>
                <div class="mb-3">
                    <label for="business_name" class="form-label">Business / Store Name</label>
                    <input type="text" class="form-control" id="business_name" name="business_name" required value="<?= sanitize($old['name'] ?? '') ?>" placeholder="e.g. Nabrijan Gadgets" oninput="updateSlug(this.value)">
                </div>
                <div class="mb-3">
                    <label for="business_category" class="form-label">Business Category</label>
                    <select class="form-select" id="business_category" name="business_category">
                        <option value="electronics">Electronics & Gadgets</option>
                        <option value="fashion">Fashion & Clothing</option>
                        <option value="grocery">Grocery & Supermarket</option>
                        <option value="restaurant">Restaurant & Food</option>
                        <option value="general">General E-Commerce</option>
                    </select>
                </div>
            </div>

            <!-- Step 2: Subdomain / Slug -->
            <div class="mb-4">
                <h6 class="text-light mb-3"><span class="step-badge">2</span> Choose Store Subdomain</h6>
                <div class="input-group">
                    <input type="text" class="form-control" id="store_slug" name="store_slug" required value="<?= sanitize($old['slug'] ?? '') ?>" placeholder="gadgetstore">
                    <span class="input-group-text bg-dark border-secondary text-secondary">.nabrijan.site</span>
                </div>
                <div class="form-text text-secondary mt-1">Your storefront URL will be accessible globally at this address.</div>
            </div>

            <!-- Step 3: Theme Selector -->
            <div class="mb-4">
                <h6 class="text-light mb-3"><span class="step-badge">3</span> Select Initial Theme</h6>
                <div class="row g-2">
                    <div class="col-6 col-md-3">
                        <div class="theme-card active" onclick="selectTheme(1, this)">
                            <div class="fw-bold text-light">Minimal</div>
                            <div class="small text-secondary">Clean Layout</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="theme-card" onclick="selectTheme(2, this)">
                            <div class="fw-bold text-light">Fashion</div>
                            <div class="small text-secondary">Apparel & Style</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="theme-card" onclick="selectTheme(3, this)">
                            <div class="fw-bold text-light">Electronics</div>
                            <div class="small text-secondary">Tech Gadgets</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="theme-card" onclick="selectTheme(4, this)">
                            <div class="fw-bold text-light">Grocery</div>
                            <div class="small text-secondary">Daily Essentials</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Initial Delivery Charges -->
            <div class="mb-4">
                <h6 class="text-light mb-3"><span class="step-badge">4</span> Default Delivery Charges (BDT ৳)</h6>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="dhaka_delivery_charge" class="form-label">Inside Dhaka Charge</label>
                        <input type="number" class="form-control" id="dhaka_delivery_charge" name="dhaka_delivery_charge" value="60" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="outside_dhaka_delivery_charge" class="form-label">Outside Dhaka Charge</label>
                        <input type="number" class="form-control" id="outside_dhaka_delivery_charge" name="outside_dhaka_delivery_charge" value="120" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100">Launch My Store Now</button>
        </form>
    </div>

    <script>
        function updateSlug(val) {
            const slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('store_slug').value = slug;
        }
        function selectTheme(themeId, el) {
            document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selected_theme_id').value = themeId;
        }
    </script>
</body>
</html>
