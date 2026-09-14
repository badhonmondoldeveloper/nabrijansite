<?php

namespace App\Models;

use App\Core\Model;

class Theme extends Model {
    protected string $table = 'themes';

    public function getActiveThemes(): array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$slug]);
        $res = $stmt->fetch();
        return $res ?: null;
    }
}
