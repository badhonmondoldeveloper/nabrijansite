<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Register - Nabrijan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 2rem 1rem; }
        .auth-card { background: #1e293b; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.4); width: 100%; max-width: 480px; padding: 2.5rem; border: 1px solid #334155; }
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
        <h5 class="text-center text-light mb-1">Build Your Online Store</h5>
        <p class="text-center text-secondary small mb-4">Start selling in minutes with Nabrijan SaaS</p>

        <form action="/register" method="POST">
            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?= sanitize($old['name'] ?? '') ?>" placeholder="Rahim Uddin">
                <?php if (!empty($errors['name'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['name']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?= sanitize($old['email'] ?? '') ?>" placeholder="merchant@example.com">
                <?php if (!empty($errors['email'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['email']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number (BD +880)</label>
                <input type="text" class="form-control" id="phone" name="phone" required value="<?= sanitize($old['phone'] ?? '') ?>" placeholder="01712345678">
                <?php if (!empty($errors['phone'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['phone']) ?></div><?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    <?php if (!empty($errors['password'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['password']) ?></div><?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="••••••••">
                    <?php if (!empty($errors['confirm_password'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['confirm_password']) ?></div><?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary-custom w-100 mt-2">Create Store Account</button>
        </form>

        <div class="text-center mt-4 text-secondary small">
            Already have an account? <a href="/login">Sign In</a>
        </div>
    </div>
</body>
</html>
