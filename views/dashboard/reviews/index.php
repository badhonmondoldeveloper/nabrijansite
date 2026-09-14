<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= sanitize($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Reviews Moderation</h4>
        <p class="text-secondary small mb-0">Approve or reject customer product reviews before public display.</p>
    </div>
</div>

<div class="card-custom">
    <?php if (empty($reviews)): ?>
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-star fs-1 d-block mb-3 text-warning"></i>
            <h5>No product reviews submitted yet</h5>
            <p class="mb-0">Customer reviews will appear here for moderation.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary small">
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $rev): ?>
                        <tr>
                            <td class="fw-bold text-light"><?= sanitize($rev['product_name']) ?></td>
                            <td><?= sanitize($rev['customer_name']) ?></td>
                            <td class="text-warning">
                                <?php for ($i = 0; $i < $rev['rating']; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                            </td>
                            <td class="text-secondary" style="max-width: 300px;"><?= sanitize($rev['comment']) ?></td>
                            <td><span class="badge bg-secondary"><?= sanitize($rev['status']) ?></span></td>
                            <td>
                                <form action="/dashboard/reviews/<?= $rev['id'] ?>/status" method="POST" class="d-inline">
                                    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success me-1"><i class="bi bi-check-lg"></i> Approve</button>
                                </form>
                                <form action="/dashboard/reviews/<?= $rev['id'] ?>/status" method="POST" class="d-inline">
                                    <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i> Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
