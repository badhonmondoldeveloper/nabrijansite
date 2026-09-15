<?php

namespace App\Models;

use App\Core\Model;

class SubscriptionPayment extends Model {
    protected string $table = 'subscription_payments';

    public function createPayment(array $data): int {
        $stmt = $this->getDb()->prepare("INSERT INTO {$this->table} (store_id, plan_id, payment_method, transaction_id, sender_number, amount, payment_note, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
        $stmt->execute([
            $data['store_id'],
            $data['plan_id'],
            $data['payment_method'],
            $data['transaction_id'],
            $data['sender_number'] ?? null,
            $data['amount'],
            $data['payment_note'] ?? null
        ]);
        return (int)$this->getDb()->lastInsertId();
    }

    public function getAllWithDetails(?string $status = null): array {
        $where = "";
        $params = [];
        if ($status) {
            $where = "WHERE sp.status = ?";
            $params[] = $status;
        }

        $stmt = $this->getDb()->prepare("SELECT sp.*, s.name as store_name, s.slug as store_slug, u.name as owner_name, u.email as owner_email, p.name as plan_name, p.price as plan_price FROM {$this->table} sp JOIN stores s ON sp.store_id = s.id JOIN users u ON s.user_id = u.id JOIN plans p ON sp.plan_id = p.id {$where} ORDER BY sp.id DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findWithDetails(int $id): ?array {
        $stmt = $this->getDb()->prepare("SELECT sp.*, s.name as store_name, s.slug as store_slug, u.name as owner_name, u.email as owner_email, p.name as plan_name, p.price as plan_price FROM {$this->table} sp JOIN stores s ON sp.store_id = s.id JOIN users u ON s.user_id = u.id JOIN plans p ON sp.plan_id = p.id WHERE sp.id = ? LIMIT 1");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function updateStatus(int $id, string $status, ?string $rejectionReason = null): bool {
        $stmt = $this->getDb()->prepare("UPDATE {$this->table} SET status = ?, rejection_reason = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $rejectionReason, $id]);
    }
}
