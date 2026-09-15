<!DOCTYPE html>
<html lang="bn" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Merchant Dashboard — Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/nabrijan-design-system.css">
    <style>
        :root { --sidebar-w: 248px; }
        body { background-color: var(--background); color: var(--text-primary); font-family: var(--font-bangla); }
        .dashboard-sidebar { width: var(--sidebar-w); position: fixed; top: 0; bottom: 0; left: 0; background-color: var(--surface); border-right: 1px solid var(--border-soft); overflow-y: auto; z-index: 1000; }
        .dashboard-main { margin-left: var(--sidebar-w); padding: 2rem; min-height: 100vh; }
        .dashboard-topbar { height: 64px; background-color: var(--surface); border-bottom: 1px solid var(--border-soft); margin-left: var(--sidebar-w); padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 999; }
        .sidebar-brand { padding: 1.25rem 1.5rem; font-size: 1.3rem; font-weight: 800; border-bottom: 1px solid var(--border-soft); text-decoration: none; display: flex; align-items: center; justify-content: space-between; }
        .nav-cat { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); padding: 1rem 1.5rem 0.25rem; font-weight: 700; }
        .dash-nav-link { color: var(--text-secondary); padding: 0.55rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.88rem; font-weight: 500; text-decoration: none; transition: all var(--duration-fast); border-left: 3px solid transparent; }
        .dash-nav-link:hover, .dash-nav-link.active { color: var(--brand-600); background: var(--brand-100); border-left-color: var(--brand-600); }
        .dash-nav-link i { font-size: 1.05rem; color: var(--text-muted); }
        .dash-nav-link:hover i, .dash-nav-link.active i { color: var(--brand-600); }
        
        /* Mobile Navigation Bottom Bar */
        .mobile-bottom-nav { display: none; position: fixed; bottom: 0; left: 0; right: 0; height: 60px; background: var(--surface); border-top: 1px solid var(--border-soft); z-index: 1000; justify-content: space-around; align-items: center; }
        .mobile-bottom-nav a { color: var(--text-secondary); text-decoration: none; font-size: 0.75rem; display: flex; flex-direction: column; align-items: center; }
        .mobile-bottom-nav a i { font-size: 1.2rem; }

        @media (max-width: 991.98px) {
            .dashboard-sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .dashboard-sidebar.show { transform: translateX(0); }
            .dashboard-main, .dashboard-topbar { margin-left: 0; }
            .mobile-bottom-nav { display: flex; }
        }
    </style>
</head>
<body>
    <!-- 30 & 31. Merchant Dashboard Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <a href="/dashboard" class="sidebar-brand">
            <span class="font-display text-dark">NABRI<span style="color: var(--brand-600);">JAN</span></span>
            <small class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1" style="font-size:0.6rem!important;">STORE</small>
        </a>

        <div class="nav flex-column my-2">
            <a href="/dashboard" class="dash-nav-link active"><i class="bi bi-layout-dashboard"></i> Dashboard</a>

            <div class="nav-cat">My Store Engine</div>
            <a href="/store/<?= sanitize($_SESSION['store_slug'] ?? '') ?>" target="_blank" class="dash-nav-link"><i class="bi bi-shop"></i> Storefront Preview</a>
            <a href="/dashboard/settings" class="dash-nav-link"><i class="bi bi-gear"></i> Store Settings</a>
            <a href="/dashboard/payment-methods" class="dash-nav-link"><i class="bi bi-wallet2"></i> Payment Methods</a>
            <a href="/dashboard/customize-theme" class="dash-nav-link"><i class="bi bi-palette"></i> Customize Theme</a>

            <div class="nav-cat">Catalog & Stock</div>
            <a href="/dashboard/products" class="dash-nav-link"><i class="bi bi-package"></i> Products</a>
            <a href="/dashboard/products/create" class="dash-nav-link"><i class="bi bi-plus-circle"></i> Add New Product</a>
            <a href="/dashboard/categories" class="dash-nav-link"><i class="bi bi-tags"></i> Categories</a>

            <div class="nav-cat">Sales & Orders</div>
            <a href="/dashboard/orders" class="dash-nav-link"><i class="bi bi-shopping-bag"></i> Orders</a>
            <a href="/dashboard/customers" class="dash-nav-link"><i class="bi bi-people"></i> Customers</a>

            <div class="nav-cat">Growth & Analytics</div>
            <a href="/dashboard/coupons" class="dash-nav-link"><i class="bi bi-ticket-perforated"></i> Coupons</a>
            <a href="/dashboard/reviews" class="dash-nav-link"><i class="bi bi-star"></i> Reviews</a>
            <a href="/dashboard/analytics" class="dash-nav-link"><i class="bi bi-chart-no-axes-combined"></i> Analytics</a>

            <div class="nav-cat">Account</div>
            <a href="/dashboard/subscription" class="dash-nav-link"><i class="bi bi-award"></i> Subscription Tier</a>
            <a href="/logout" class="dash-nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Sign Out</a>
        </div>

        <div class="p-3 mt-auto border-top border-soft text-center small text-muted">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                <span class="fw-semibold text-success" style="font-size:0.75rem;">Store Status: Online</span>
            </div>
            <a href="/dashboard/subscription" class="btn btn-sm btn-nj-accent w-100 py-1 font-display mt-2" style="font-size:0.75rem;">Upgrade Plan</a>
        </div>
    </aside>

    <!-- 32. Dashboard Topbar -->
    <header class="dashboard-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" onclick="document.getElementById('dashboardSidebar').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h5 class="mb-0 fw-bold font-display"><?= sanitize($_SESSION['store_name'] ?? 'Merchant Store') ?></h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Search Shortcut Badge -->
            <div class="d-none d-md-flex align-items-center bg-surface-soft px-3 py-1 rounded-pill border border-soft text-muted small">
                <i class="bi bi-search me-2"></i> Search... <kbd class="ms-2 bg-secondary bg-opacity-25 text-dark border-0 small px-1">Ctrl + K</kbd>
            </div>

            <!-- Light / Dark Theme Toggle Button -->
            <button class="btn btn-sm btn-nj-secondary" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                <i class="bi bi-sun-fill text-warning" id="themeIcon"></i>
            </button>

            <!-- Store Preview Button -->
            <a href="/store/<?= sanitize($_SESSION['store_slug'] ?? '') ?>" target="_blank" class="btn-nj btn-nj-secondary py-1 px-3 fs-6">
                <i class="bi bi-box-arrow-up-right me-1"></i> Storefront
            </a>
        </div>
    </header>

    <!-- Main Workspace Content -->
    <main class="dashboard-main">
        <?= $content ?>
    </main>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="mobile-bottom-nav">
        <a href="/dashboard"><i class="bi bi-layout-dashboard"></i><span>Home</span></a>
        <a href="/dashboard/orders"><i class="bi bi-shopping-bag"></i><span>Orders</span></a>
        <a href="/dashboard/products"><i class="bi bi-package"></i><span>Products</span></a>
        <a href="/dashboard/analytics"><i class="bi bi-chart-no-axes-combined"></i><span>Analytics</span></a>
        <a href="/dashboard/settings"><i class="bi bi-gear"></i><span>Settings</span></a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Light / Dark Theme Switcher Logic
        const toggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        const currentTheme = localStorage.getItem('nj_theme') || 'dark';
        html.setAttribute('data-theme', currentTheme);
        updateIcon(currentTheme);

        toggleBtn.addEventListener('click', function() {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('nj_theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun-fill text-warning';
            } else {
                themeIcon.className = 'bi bi-moon-fill text-primary';
            }
        }
    </script>
</body>
</html>
