<?php

namespace App\Core;

use PDO;
use Exception;

abstract class Model {
    protected ?PDO $db = null;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct() {
        // Database connection acquired lazily when queries are executed
    }

    protected function getDb(): PDO {
        if ($this->db === null) {
            $this->db = Database::getInstance();
            if ($this->db === null) {
                throw new Exception("Unable to connect to MySQL database. Please verify your .env database credentials.");
            }
        }
        return $this->db;
    }

    /**
     * Find record by ID.
     */
    public function find(int $id): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find record with strict store_id tenant isolation.
     */
    public function findForStore(int $id, int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? AND store_id = ? LIMIT 1");
        $stmt->execute([$id, $storeId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Fetch all records for a store.
     */
    public function allForStore(int $storeId, string $orderBy = 'id DESC'): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE store_id = ? ORDER BY {$orderBy}");
        $stmt->execute([$storeId]);
        return $stmt->fetchAll();
    }

    /**
     * Insert record.
     */
    public function create(array $data): int {
        $fields = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $fieldNames = implode(', ', $fields);

        $sql = "INSERT INTO {$this->table} ({$fieldNames}) VALUES ({$placeholders})";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(array_values($data));
        return (int)$this->getDb()->lastInsertId();
    }

    /**
     * Update record for a specific store.
     */
    public function updateForStore(int $id, int $storeId, array $data): bool {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $values[] = $storeId;

        $setClause = implode(', ', $fields);
        $sql = "UPDATE {$this->table} SET {$setClause}, updated_at = NOW() WHERE {$this->primaryKey} = ? AND store_id = ?";
        $stmt = $this->getDb()->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Soft or hard delete for a specific store.
     */
    public function deleteForStore(int $id, int $storeId, bool $soft = true): bool {
        if ($soft) {
            $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE {$this->primaryKey} = ? AND store_id = ?";
        } else {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ? AND store_id = ?";
        }
        $stmt = $this->getDb()->prepare($sql);
        return $stmt->execute([$id, $storeId]);
    }
}
