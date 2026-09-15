<?php

namespace App\Models;

use App\Core\Model;

class PlatformPaymentSetting extends Model {
    protected string $table = 'platform_payment_settings';

    public function getAllSettings(): array {
        $stmt = $this->getDb()->query("SELECT setting_key, setting_value FROM {$this->table}");
        $results = $stmt->fetchAll();
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function updateSettings(array $settings): void {
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO {$this->table} (setting_key, setting_value) VALUES (:key, :val) ON DUPLICATE KEY UPDATE setting_value = :val2, updated_at = NOW()");
        foreach ($settings as $key => $val) {
            $stmt->execute([
                'key' => $key,
                'val' => $val,
                'val2' => $val
            ]);
        }
    }
}
