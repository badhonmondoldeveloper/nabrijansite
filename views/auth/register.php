<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Create Store Account — Nabrijan') ?></title>
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
            padding: 30px 20px;
        }
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            width: 100%;
            max-width: 500px;
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
            <h4 class="fw-bold mb-1">Build Your Online Store</h4>
            <p class="text-secondary small mb-0">Start selling in minutes with Nabrijan Commerce OS.</p>
        </div>

        <form action="/register" method="POST">
            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">

            <div class="mb-3">
                <label for="name" class="form-label text-secondary small fw-semibold">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="nj-input" id="name" name="name" required value="<?= sanitize($old['name'] ?? '') ?>" placeholder="Rahim Uddin">
                <?php if (!empty($errors['name'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['name']) ?></div><?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-semibold">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="nj-input" id="email" name="email" required value="<?= sanitize($old['email'] ?? '') ?>" placeholder="merchant@company.com">
                <?php if (!empty($errors['email'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['email']) ?></div><?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label text-secondary small fw-semibold">Phone Number (BD +880) <span class="text-danger">*</span></label>
                <input type="text" class="nj-input" id="phone" name="phone" required value="<?= sanitize($old['phone'] ?? '') ?>" placeholder="01712345678">
                <?php if (!empty($errors['phone'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['phone']) ?></div><?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label text-secondary small fw-semibold">Password <span class="text-danger">*</span></label>
                    <input type="password" class="nj-input" id="password" name="password" required placeholder="••••••••">
                    <?php if (!empty($errors['password'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['password']) ?></div><?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirm_password" class="form-label text-secondary small fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="nj-input" id="confirm_password" name="confirm_password" required placeholder="••••••••">
                    <?php if (!empty($errors['confirm_password'])): ?><div class="text-danger small mt-1"><?= sanitize($errors['confirm_password']) ?></div><?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn-nj btn-nj-primary w-100 mt-2 py-3">Create Store Account →</button>
        </form>

        <div class="text-center mt-4 text-secondary small">
            Already have an account? <a href="/login" class="fw-bold text-decoration-none" style="color: var(--brand-600);">Sign In</a>
        </div>
    </div>
</body>
</html>
