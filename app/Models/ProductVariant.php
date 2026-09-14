<?php

namespace App\Models;

use App\Core\Model;

class ProductVariant extends Model {
    protected string $table = 'product_variants';

    public function getVariantsForProduct(int $productId): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE product_id = ? ORDER BY id ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }
}
