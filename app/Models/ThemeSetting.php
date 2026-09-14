<?php

namespace App\Models;

use App\Core\Model;

class ThemeSetting extends Model {
    protected string $table = 'theme_settings';

    public function findByStoreId(int $storeId): ?array {
        $stmt = $this->getDb()->prepare("SELECT ts.*, t.folder_name, t.slug as theme_slug FROM {$this->table} ts JOIN themes t ON ts.theme_id = t.id WHERE ts.store_id = ? LIMIT 1");
        $stmt->execute([$storeId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function updateOrCreateForStore(int $storeId, int $themeId, array $headerConfig, array $heroConfig, array $sectionOrder, array $footerConfig): void {
        $existing = $this->findByStoreId($storeId);
        $headerJson = json_encode($headerConfig);
        $heroJson = json_encode($heroConfig);
        $sectionJson = json_encode($sectionOrder);
        $footerJson = json_encode($footerConfig);

        if ($existing) {
            $stmt = $this->getDb()->prepare("UPDATE {$this->table} SET theme_id = ?, header_config = ?, hero_config = ?, section_order = ?, footer_config = ?, updated_at = NOW() WHERE store_id = ?");
            $stmt->execute([$themeId, $headerJson, $heroJson, $sectionJson, $footerJson, $storeId]);
        } else {
            $stmt = $this->getDb()->prepare("INSERT INTO {$this->table} (store_id, theme_id, header_config, hero_config, section_order, footer_config) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$storeId, $themeId, $headerJson, $heroJson, $sectionJson, $footerJson]);
        }
    }
}
