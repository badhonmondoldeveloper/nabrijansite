<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Merchant Dashboard - Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 250px; --primary-green: #059669; --accent-yellow: #eab308; }
        body { background-color: #0f172a; color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { width: var(--sidebar-width); position: fixed; top: 0; bottom: 0; left: 0; background: #1e293b; border-right: 1px solid #334155; overflow-y: auto; z-index: 1000; }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; }
        .sidebar-brand { padding: 1.25rem 1.5rem; font-size: 1.4rem; font-weight: 800; color: var(--primary-green); border-bottom: 1px solid #334155; text-decoration: none; display: flex; align-items: center; justify-content: space-between; }
        .sidebar-brand span { color: var(--accent-yellow); }
        .nav-category { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; padding: 1rem 1.5rem 0.25rem; font-weight: 700; }
        .nav-link { color: #94a3b8; padding: 0.6rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; border-left: 3px solid transparent; text-decoration: none; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { color: #ffffff; background: #0f172a; border-left-color: var(--primary-green); }
        .nav-link i { font-size: 1.1rem; color: #64748b; }
        .nav-link:hover i, .nav-link.active i { color: var(--accent-yellow); }
        .topbar { background: #1e293b; border-bottom: 1px solid #334155; padding: 0.75rem 2rem; margin-left: var(--sidebar-width); display: flex; align-items: center; justify-content: space-between; }
        .card-custom { background: #1e293b; border: 1px solid #334155; border-radius: 0.75rem; padding: 1.5rem; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content, .topbar { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <a href="/dashboard" class="sidebar-brand">
            NABRI<span>JAN</span>
            <small class="badge bg-success text-white px-2 py-1 fs-6" style="font-size:0.6rem!important;">STORE</small>
        </a>

        <div class="nav flex-column my-2">
            <a href="/dashboard" class="nav-link active"><i class="bi bi-speedometer2"></i> Dashboard</a>

            <div class="nav-category">My Store</div>
            <a href="/store/<?= sanitize($_SESSION['store_slug'] ?? '') ?>" target="_blank" class="nav-link"><i class="bi bi-shop"></i> View Store</a>
            <a href="/dashboard/settings" class="nav-link"><i class="bi bi-gear"></i> Store Settings</a>
            <a href="/dashboard/customize-theme" class="nav-link"><i class="bi bi-palette"></i> Customize Theme</a>

            <div class="nav-category">Catalog</div>
            <a href="/dashboard/products" class="nav-link"><i class="bi bi-box-seam"></i> Products</a>
            <a href="/dashboard/products/create" class="nav-link"><i class="bi bi-plus-circle"></i> Add Product</a>
            <a href="/dashboard/categories" class="nav-link"><i class="bi bi-tags"></i> Categories</a>
            <a href="/dashboard/inventory" class="nav-link"><i class="bi bi-stack"></i> Inventory</a>

            <div class="nav-category">Sales</div>
            <a href="/dashboard/orders" class="nav-link"><i class="bi bi-cart-check"></i> Orders</a>
            <a href="/dashboard/customers" class="nav-link"><i class="bi bi-people"></i> Customers</a>
            <a href="/dashboard/payments" class="nav-link"><i class="bi bi-credit-card"></i> Payments</a>
            <a href="/dashboard/delivery" class="nav-link"><i class="bi bi-truck"></i> Delivery Settings</a>

            <div class="nav-category">Marketing & Feedback</div>
            <a href="/dashboard/coupons" class="nav-link"><i class="bi bi-ticket-perforated"></i> Coupons</a>
            <a href="/dashboard/reviews" class="nav-link"><i class="bi bi-star"></i> Reviews</a>
            <a href="/dashboard/analytics" class="nav-link"><i class="bi bi-bar-chart-line"></i> Analytics</a>

            <div class="nav-category">Account</div>
            <a href="/dashboard/subscription" class="nav-link"><i class="bi bi-award"></i> Subscription Plan</a>
            <a href="/logout" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Sign Out</a>
        </div>
    </aside>

    <!-- Topbar Header -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <h6 class="mb-0 text-light fw-bold"><?= sanitize($_SESSION['store_name'] ?? 'Merchant Store') ?></h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="/store/<?= sanitize($_SESSION['store_slug'] ?? '') ?>" target="_blank" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-box-arrow-up-right me-1"></i> Visit Store
            </a>
            <div class="dropdown">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> <?= sanitize($_SESSION['user_name'] ?? 'Merchant') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                    <li><a class="dropdown-item" href="/dashboard/settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Workspace Content -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
