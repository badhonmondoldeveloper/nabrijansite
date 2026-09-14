<?php

namespace App\Models;

use App\Core\Model;

class Coupon extends Model {
    protected string $table = 'coupons';

    public function findByCodeForStore(string $code, int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE code = ? AND store_id = ? AND status = 'active' LIMIT 1");
        $stmt->execute([strtoupper(trim($code)), $storeId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function allForStore(int $storeId, string $orderBy = 'id DESC'): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE store_id = ? ORDER BY {$orderBy}");
        $stmt->execute([$storeId]);
        return $stmt->fetchAll();
    }
}
