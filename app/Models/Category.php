<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model {
    protected string $table = 'categories';

    public function allForStore(int $storeId, string $orderBy = 'name ASC'): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE store_id = ? AND deleted_at IS NULL ORDER BY {$orderBy}");
        $stmt->execute([$storeId]);
        return $stmt->fetchAll();
    }

    public function findForStore(int $id, int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE id = ? AND store_id = ? AND deleted_at IS NULL LIMIT 1");
        $stmt->execute([$id, $storeId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function slugExistsForStore(string $slug, int $storeId, ?int $excludeCategoryId = null): bool {
        if ($excludeCategoryId) {
            $stmt = $this->getDb()->prepare("SELECT id FROM {$this->table} WHERE slug = ? AND store_id = ? AND id != ? AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$slug, $storeId, $excludeCategoryId]);
        } else {
            $stmt = $this->getDb()->prepare("SELECT id FROM {$this->table} WHERE slug = ? AND store_id = ? AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$slug, $storeId]);
        }
        return (bool)$stmt->fetch();
    }
}
