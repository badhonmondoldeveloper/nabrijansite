<?php

namespace App\Models;

use App\Core\Model;

class Store extends Model {
    protected string $table = 'stores';

    public function findBySlug(string $slug): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND status = 'active' LIMIT 1");
        $stmt->execute([$slug]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function findByUserId(int $userId): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function slugExists(string $slug, ?int $excludeStoreId = null): bool {
        if ($excludeStoreId) {
            $stmt = $this->getDb()->prepare("SELECT id FROM {$this->table} WHERE slug = ? AND id != ? LIMIT 1");
            $stmt->execute([$slug, $excludeStoreId]);
        } else {
            $stmt = $this->getDb()->prepare("SELECT id FROM {$this->table} WHERE slug = ? LIMIT 1");
            $stmt->execute([$slug]);
        }
        return (bool)$stmt->fetch();
    }
}
