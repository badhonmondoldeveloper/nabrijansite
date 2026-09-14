<?php

namespace App\Models;

use App\Core\Model;

class Review extends Model {
    protected string $table = 'reviews';

    public function getForStore(int $storeId): array {
        $stmt = $this->getDb()->prepare("SELECT r.*, p.name as product_name, c.name as customer_name FROM {$this->table} r JOIN products p ON r.product_id = p.id JOIN customers c ON r.customer_id = c.id WHERE r.store_id = ? ORDER BY r.id DESC");
        $stmt->execute([$storeId]);
        return $stmt->fetchAll();
    }
}
