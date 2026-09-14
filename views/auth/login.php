<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Login - Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .auth-card { background: #1e293b; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.4); width: 100%; max-width: 420px; padding: 2.5rem; border: 1px solid #334155; }
        .brand-logo { font-size: 1.8rem; font-weight: 800; color: #059669; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; justify-content: center; margin-bottom: 0.5rem; }
        .brand-logo span { color: #eab308; }
        .btn-primary-custom { background: #059669; border: none; color: #ffffff; font-weight: 600; padding: 0.75rem; border-radius: 0.5rem; transition: background 0.2s; }
        .btn-primary-custom:hover { background: #047857; color: #ffffff; }
        .form-control { background: #0f172a; border: 1px solid #334155; color: #f8fafc; padding: 0.75rem; border-radius: 0.5rem; }
        .form-control:focus { background: #0f172a; border-color: #059669; color: #f8fafc; box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25); }
        .form-label { font-size: 0.9rem; font-weight: 500; color: #cbd5e1; }
        a { color: #eab308; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="/" class="brand-logo">NABRI<span>JAN</span></a>
        <h5 class="text-center text-light mb-4">Welcome Back</h5>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2" role="alert">
                <?= sanitize($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success py-2" role="alert">
                <?= sanitize($success) ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="merchant@example.com">
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label for="password" class="form-label">Password</label>
                    <a href="/forgot-password" class="small">Forgot?</a>
                </div>
                <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary-custom w-100 mt-2">Sign In</button>
        </form>

        <div class="text-center mt-4 text-secondary small">
            Don't have a store yet? <a href="/register">Create Store</a>
        </div>
    </div>
</body>
</html>
