<?php

namespace App\Models;

use App\Core\Model;

class StoreSetting extends Model {
    protected string $table = 'store_settings';

    public function findByStoreId(int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT * FROM {$this->table} WHERE store_id = ? LIMIT 1");
        $stmt->execute([$storeId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function updatePaymentSettings(int $storeId, array $data): bool {
        $stmt = $this->getDb()->prepare("INSERT INTO {$this->table} (
            store_id, cod_enabled, bkash_enabled, bkash_number, bkash_type, bkash_instruction,
            nagad_enabled, nagad_number, nagad_type, nagad_instruction,
            rocket_enabled, rocket_number, rocket_type, rocket_instruction,
            bank_enabled, bank_details, updated_at
        ) VALUES (
            :store_id, :cod_enabled, :bkash_enabled, :bkash_number, :bkash_type, :bkash_instruction,
            :nagad_enabled, :nagad_number, :nagad_type, :nagad_instruction,
            :rocket_enabled, :rocket_number, :rocket_type, :rocket_instruction,
            :bank_enabled, :bank_details, NOW()
        ) ON DUPLICATE KEY UPDATE
            cod_enabled = VALUES(cod_enabled),
            bkash_enabled = VALUES(bkash_enabled),
            bkash_number = VALUES(bkash_number),
            bkash_type = VALUES(bkash_type),
            bkash_instruction = VALUES(bkash_instruction),
            nagad_enabled = VALUES(nagad_enabled),
            nagad_number = VALUES(nagad_number),
            nagad_type = VALUES(nagad_type),
            nagad_instruction = VALUES(nagad_instruction),
            rocket_enabled = VALUES(rocket_enabled),
            rocket_number = VALUES(rocket_number),
            rocket_type = VALUES(rocket_type),
            rocket_instruction = VALUES(rocket_instruction),
            bank_enabled = VALUES(bank_enabled),
            bank_details = VALUES(bank_details),
            updated_at = NOW()");

        return $stmt->execute([
            'store_id' => $storeId,
            'cod_enabled' => $data['cod_enabled'] ?? 1,
            'bkash_enabled' => $data['bkash_enabled'] ?? 0,
            'bkash_number' => $data['bkash_number'] ?? null,
            'bkash_type' => $data['bkash_type'] ?? 'personal',
            'bkash_instruction' => $data['bkash_instruction'] ?? null,
            'nagad_enabled' => $data['nagad_enabled'] ?? 0,
            'nagad_number' => $data['nagad_number'] ?? null,
            'nagad_type' => $data['nagad_type'] ?? 'personal',
            'nagad_instruction' => $data['nagad_instruction'] ?? null,
            'rocket_enabled' => $data['rocket_enabled'] ?? 0,
            'rocket_number' => $data['rocket_number'] ?? null,
            'rocket_type' => $data['rocket_type'] ?? 'personal',
            'rocket_instruction' => $data['rocket_instruction'] ?? null,
            'bank_enabled' => $data['bank_enabled'] ?? 0,
            'bank_details' => $data['bank_details'] ?? null
        ]);
    }
}
