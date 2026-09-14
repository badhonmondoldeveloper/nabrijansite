<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">User & Role Management</h4>
        <p class="text-secondary small mb-0">Audit platform registered users, merchants, and administrative roles.</p>
    </div>
</div>

<div class="card-custom">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="text-secondary small">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="fw-bold text-light"><?= sanitize($u['name']) ?></td>
                        <td><?= sanitize($u['email']) ?></td>
                        <td><?= sanitize($u['phone'] ?? 'N/A') ?></td>
                        <td>
                            <span class="badge <?= ($u['role'] === 'super_admin' ? 'bg-danger' : ($u['role'] === 'merchant' ? 'bg-primary' : 'bg-secondary')) ?>">
                                <?= sanitize($u['role']) ?>
                            </span>
                        </td>
                        <td><span class="badge bg-success"><?= sanitize($u['status']) ?></span></td>
                        <td class="small text-secondary"><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <?php if ($u['role'] !== 'super_admin'): ?>
                                <?php if ($u['status'] === 'active'): ?>
                                    <form action="/admin/users/<?= $u['id'] ?>/status" method="POST" class="d-inline">
                                        <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                        <input type="hidden" name="status" value="suspended">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Suspend</button>
                                    </form>
                                <?php else: ?>
                                    <form action="/admin/users/<?= $u['id'] ?>/status" method="POST" class="d-inline">
                                        <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                        <input type="hidden" name="status" value="active">
                                        <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
