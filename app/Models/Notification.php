<?php

namespace App\Models;

use App\Core\Model;

class Notification extends Model {
    protected string $table = 'notifications';

    public function getForUserAndStore(int $userId, int $storeId): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE (user_id = ? OR store_id = ?) ORDER BY id DESC LIMIT 50");
        $stmt->execute([$userId, $storeId]);
        return $stmt->fetchAll();
    }

    public function markAsRead(int $notificationId, int $userId): void {
        $stmt = $this->getDb()->prepare("UPDATE {$this->table} SET is_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$notificationId, $userId]);
    }
}
