<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model {
    protected string $table = 'products';

    public function getPaginatedForStore(int $storeId, int $page = 1, int $limit = 10, string $search = '', ?int $categoryId = null): array {
        $offset = ($page - 1) * $limit;
        $params = [$storeId];
        $where = "WHERE p.store_id = ? AND p.deleted_at IS NULL";

        if (!empty($search)) {
            $where .= " AND (p.name LIKE ? OR p.sku LIKE ? OR p.brand LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if ($categoryId) {
            $where .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }

        // Count Total
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} p {$where}";
        $stmt = $this->getDb()->prepare($countSql);
        $stmt->execute($params);
        $total = (int)$stmt->fetch()['total'];

        // Fetch Records
        $sql = "SELECT p.*, c.name as category_name, 
                (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_primary DESC, id ASC LIMIT 1) as primary_image
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                {$where}
                ORDER BY p.id DESC LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($total / $limit)
        ];
    }

    public function findForStore(int $id, int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT p.*, c.name as category_name FROM {$this->table} p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? AND p.store_id = ? AND p.deleted_at IS NULL LIMIT 1");
        $stmt->execute([$id, $storeId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function countProductsForStore(int $storeId): int {
        $stmt = $this->getDb()->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE store_id = ? AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        return (int)$stmt->fetch()['total'];
    }

    public function slugExistsForStore(string $slug, int $storeId, ?int $excludeProductId = null): bool {
        if ($excludeProductId) {
            $stmt = $this->getDb()->prepare("SELECT id FROM {$this->table} WHERE slug = ? AND store_id = ? AND id != ? AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$slug, $storeId, $excludeProductId]);
        } else {
            $stmt = $this->getDb()->prepare("SELECT id FROM {$this->table} WHERE slug = ? AND store_id = ? AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$slug, $storeId]);
        }
        return (bool)$stmt->fetch();
    }
}
