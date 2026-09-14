<?php

namespace App\Models;

use App\Core\Model;

class StoreDomain extends Model {
    protected string $table = 'store_domains';

    public function findByDomain(string $domain): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE domain = ? AND status = 'verified' LIMIT 1");
        $stmt->execute([$domain]);
        $res = $stmt->fetch();
        return $res ?: null;
    }
}
