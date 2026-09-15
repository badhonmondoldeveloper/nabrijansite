<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Merchant Sign In — Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/nabrijan-design-system.css">
    <style>
        body {
            background-color: var(--background);
            background-image: radial-gradient(circle at 50% 0%, rgba(10, 148, 96, 0.12), transparent 55%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <a href="/" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
                <span class="font-display fw-extrabold fs-3 text-dark">NABRI<span style="color: var(--brand-600);">JAN</span></span>
            </a>
            <h4 class="fw-bold mb-1">Welcome Back</h4>
            <p class="text-secondary small mb-0">Sign in to manage your online store & business.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 small rounded-3 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= sanitize($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success py-2 small rounded-3 mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> <?= sanitize($success) ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">

            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-semibold">Email Address</label>
                <input type="email" class="nj-input" id="email" name="email" required placeholder="name@company.com" autocomplete="email">
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label text-secondary small fw-semibold mb-0">Password</label>
                    <a href="/forgot-password" class="small text-decoration-none" style="color: var(--brand-600);">Forgot Password?</a>
                </div>
                <input type="password" class="nj-input" id="password" name="password" required placeholder="••••••••" autocomplete="current-password">
            </div>

            <button type="submit" class="btn-nj btn-nj-primary w-100 mt-2 py-3">Sign In To Dashboard →</button>
        </form>

        <div class="text-center mt-4 text-secondary small">
            Don't have a store yet? <a href="/register" class="fw-bold text-decoration-none" style="color: var(--brand-600);">Create Your Store</a>
        </div>
    </div>
</body>
</html>
