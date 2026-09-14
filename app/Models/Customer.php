<?php

namespace App\Models;

use App\Core\Model;

class Customer extends Model {
    protected string $table = 'customers';

    public function getCustomersWithStats(int $storeId): array {
        $sql = "SELECT c.*, 
                COUNT(o.id) as total_orders, 
                COALESCE(SUM(o.total_amount), 0.00) as total_spent,
                MAX(o.created_at) as last_order_date
                FROM {$this->table} c 
                LEFT JOIN orders o ON c.id = o.customer_id AND o.deleted_at IS NULL
                WHERE c.store_id = ? AND c.deleted_at IS NULL 
                GROUP BY c.id 
                ORDER BY c.id DESC";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([$storeId]);
        return $stmt->fetchAll();
    }
}
