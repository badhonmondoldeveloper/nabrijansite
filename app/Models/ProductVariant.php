<?php

namespace App\Models;

use App\Core\Model;

class ProductVariant extends Model {
    protected string $table = 'product_variants';

    /**
     * Get all variants for a product
     */
    public function getVariantsForProduct(int $productId): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE product_id = ? ORDER BY id ASC");
        $stmt->execute([$productId]);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$r) {
            $r['attributes'] = !empty($r['attributes_json']) ? json_decode($r['attributes_json'], true) : [];
        }
        return $rows;
    }

    /**
     * Add a variant record
     */
    public function addVariant(int $productId, array $attributes, float $price, int $stock, ?string $sku = null): int {
        return $this->create([
            'product_id' => $productId,
            'sku' => $sku,
            'attributes_json' => json_encode($attributes),
            'price' => $price,
            'stock' => $stock
        ]);
    }

    /**
     * Clear all variants for product
     */
    public function deleteVariantsForProduct(int $productId): void {
        $stmt = $this->getDb()->prepare("DELETE FROM {$this->table} WHERE product_id = ?");
        $stmt->execute([$productId]);
    }
}
