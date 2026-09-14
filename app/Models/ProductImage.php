<?php

namespace App\Models;

use App\Core\Model;

class ProductImage extends Model {
    protected string $table = 'product_images';

    public function getImagesForProduct(int $productId): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE product_id = ? ORDER BY is_primary DESC, sort_order ASC, id ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function addImage(int $productId, string $path, bool $isPrimary = false): int {
        return $this->create([
            'product_id' => $productId,
            'image_path' => $path,
            'is_primary' => $isPrimary ? 1 : 0,
            'sort_order' => 0
        ]);
    }
}
