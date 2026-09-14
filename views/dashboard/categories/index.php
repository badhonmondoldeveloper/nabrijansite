<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i><?= sanitize($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Categories</h4>
        <p class="text-secondary small mb-0">Organize your store catalog into searchable categories.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Category Creation Form -->
    <div class="col-lg-4">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-folder-plus me-2 text-warning"></i> Add New Category</h6>
            <form action="/dashboard/categories" method="POST">
                <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="e.g. Mechanical Keyboards">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief overview of category products..."></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100"><i class="bi bi-plus-lg me-1"></i> Save Category</button>
            </form>
        </div>
    </div>

    <!-- Category List Table -->
    <div class="col-lg-8">
        <div class="card-custom">
            <h6 class="fw-bold text-light mb-3"><i class="bi bi-tags me-2 text-info"></i> All Store Categories (<?= count($categories) ?>)</h6>
            <?php if (empty($categories)): ?>
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-folder2-open fs-1 d-block mb-2"></i>
                    <p class="mb-0">No categories created yet. Create your first category on the left.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td class="fw-bold text-light"><?= sanitize($cat['name']) ?></td>
                                    <td><code class="text-warning"><?= sanitize($cat['slug']) ?></code></td>
                                    <td><span class="badge bg-success"><?= sanitize($cat['status']) ?></span></td>
                                    <td class="small text-secondary"><?= date('M d, Y', strtotime($cat['created_at'])) ?></td>
                                    <td>
                                        <form action="/dashboard/categories/delete/<?= $cat['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="display:inline;">
                                            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
