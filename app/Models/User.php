<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function findByPhone(string $phone): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE phone = ? LIMIT 1");
        $stmt->execute([$phone]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function createCustomerOrMerchant(array $data): int {
        return $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => $data['role'] ?? 'merchant',
            'status' => 'active'
        ]);
    }
}
