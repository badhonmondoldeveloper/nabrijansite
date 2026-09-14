<?php

namespace App\Models;

use App\Core\Model;

class Wishlist extends Model {
    protected string $table = 'wishlists';

    public function getCustomerWishlist(int $customerId, int $storeId): array {
        $stmt = $this->getDb()->prepare("SELECT w.*, p.name, p.slug, p.price, p.discount_price FROM {$this->table} w JOIN products p ON w.product_id = p.id WHERE w.customer_id = ? AND w.store_id = ? AND p.deleted_at IS NULL");
        $stmt->execute([$customerId, $storeId]);
        return $stmt->fetchAll();
    }
}
