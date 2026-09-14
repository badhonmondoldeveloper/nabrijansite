<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Notification Center</h4>
        <p class="text-secondary small mb-0">System alerts, new order notifications, and low stock warnings.</p>
    </div>
</div>

<div class="card-custom">
    <?php if (empty($notifications)): ?>
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-bell-slash fs-1 d-block mb-3 text-warning"></i>
            <h5>No notifications</h5>
            <p class="mb-0">You're all caught up! System notifications will appear here.</p>
        </div>
    <?php else: ?>
        <div class="list-group list-group-flush bg-transparent">
            <?php foreach ($notifications as $notif): ?>
                <div class="list-group-item bg-transparent text-light border-secondary p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold <?= ($notif['is_read'] ? 'text-secondary' : 'text-warning') ?>">
                            <i class="bi bi-info-circle me-2"></i><?= sanitize($notif['title']) ?>
                        </div>
                        <p class="mb-0 text-secondary small"><?= sanitize($notif['message']) ?></p>
                        <small class="text-secondary" style="font-size: 0.75rem;"><?= date('M d, Y h:i A', strtotime($notif['created_at'])) ?></small>
                    </div>
                    <?php if (!$notif['is_read']): ?>
                        <form action="/dashboard/notifications/mark-read/<?= $notif['id'] ?>" method="POST">
                            <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
                            <button type="submit" class="btn btn-sm btn-outline-success">Mark Read</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
