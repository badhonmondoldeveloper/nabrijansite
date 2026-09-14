<?php

namespace App\Models;

use App\Core\Model;

class StoreSetting extends Model {
    protected string $table = 'store_settings';

    public function findByStoreId(int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE store_id = ? LIMIT 1");
        $stmt->execute([$storeId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }
}
