<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Super Admin Panel - Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --sidebar-width: 250px; --primary-green: #059669; --accent-yellow: #eab308; }
        body { background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { width: var(--sidebar-width); position: fixed; top: 0; bottom: 0; left: 0; background: #111827; border-right: 1px solid #1f2937; overflow-y: auto; z-index: 1000; }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; }
        .sidebar-brand { padding: 1.25rem 1.5rem; font-size: 1.4rem; font-weight: 800; color: var(--primary-green); border-bottom: 1px solid #1f2937; text-decoration: none; display: flex; align-items: center; justify-content: space-between; }
        .sidebar-brand span { color: var(--accent-yellow); }
        .nav-category { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #4b5563; padding: 1rem 1.5rem 0.25rem; font-weight: 700; }
        .nav-link { color: #9ca3af; padding: 0.6rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; border-left: 3px solid transparent; text-decoration: none; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { color: #ffffff; background: #1f2937; border-left-color: var(--accent-yellow); }
        .nav-link i { font-size: 1.1rem; color: #6b7280; }
        .nav-link:hover i, .nav-link.active i { color: var(--accent-yellow); }
        .topbar { background: #111827; border-bottom: 1px solid #1f2937; padding: 0.75rem 2rem; margin-left: var(--sidebar-width); display: flex; align-items: center; justify-content: space-between; }
        .card-custom { background: #111827; border: 1px solid #1f2937; border-radius: 0.75rem; padding: 1.5rem; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content, .topbar { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Super Admin Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="/admin" class="sidebar-brand">
            NABRI<span>JAN</span>
            <small class="badge bg-danger text-white px-2 py-1" style="font-size:0.6rem!important;">SUPER ADMIN</small>
        </a>

        <div class="nav flex-column my-2">
            <a href="/admin" class="nav-link"><i class="bi bi-speedometer2"></i> Control Dashboard</a>

            <div class="nav-category">SaaS & Billing</div>
            <a href="/admin/subscription-payments" class="nav-link"><i class="bi bi-credit-card-2-front"></i> Subscriptions <span class="badge bg-warning text-dark ms-auto">Pay</span></a>
            <a href="/admin/plans" class="nav-link"><i class="bi bi-award"></i> Plan Tier Matrix</a>

            <div class="nav-category">Platform Audit</div>
            <a href="/admin/stores" class="nav-link"><i class="bi bi-shop"></i> Stores & Tenants</a>
            <a href="/admin/users" class="nav-link"><i class="bi bi-people"></i> User Roles & Access</a>

            <div class="nav-category">System Configuration</div>
            <a href="/admin/settings" class="nav-link"><i class="bi bi-wallet2"></i> Manual Payment Setup</a>
            <a href="/logout" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Sign Out</a>
        </div>
    </aside>

    <!-- Topbar Header -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <h6 class="mb-0 text-light fw-bold">Platform Super Admin Control Panel</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="/" target="_blank" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-globe me-1"></i> SaaS Main Site
            </a>
            <a href="/logout" class="btn btn-sm btn-outline-danger">Sign Out</a>
        </div>
    </header>

    <!-- Main Workspace Content -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
