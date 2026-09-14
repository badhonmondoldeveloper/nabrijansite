<?php

namespace App\Services;

use App\Models\Store;
use App\Models\StoreSetting;
use App\Core\Database;
use Exception;

class StoreService {
    private Store $storeModel;
    private StoreSetting $storeSettingModel;

    public function __construct() {
        $this->storeModel = new Store();
        $this->storeSettingModel = new StoreSetting();
    }

    /**
     * Create new merchant store with default settings, theme, and trial subscription.
     */
    public function createStore(int $userId, array $data): array {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Business Name is required.';
        }

        $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(str_replace(' ', '-', trim($data['name']))));
        if (!empty($data['slug'])) {
            $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($data['slug'])));
        }

        if (empty($slug)) {
            $errors['slug'] = 'Store Slug is invalid.';
        } elseif ($this->storeModel->slugExists($slug)) {
            $errors['slug'] = 'Store Slug "' . sanitize($slug) . '" is already taken. Please choose another.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // 1. Insert Store
            $storeId = $this->storeModel->create([
                'user_id' => $userId,
                'plan_id' => $data['plan_id'] ?? 1, // Default FREE plan
                'name' => trim($data['name']),
                'slug' => $slug,
                'business_category' => $data['category'] ?? 'general',
                'status' => 'active'
            ]);

            // 2. Insert Store Settings
            $this->storeSettingModel->create([
                'store_id' => $storeId,
                'primary_color' => $data['primary_color'] ?? '#059669',
                'secondary_color' => $data['secondary_color'] ?? '#eab308',
                'currency' => 'BDT',
                'timezone' => 'Asia/Dhaka',
                'dhaka_delivery_charge' => $data['dhaka_delivery_charge'] ?? 60.00,
                'outside_dhaka_delivery_charge' => $data['outside_dhaka_delivery_charge'] ?? 120.00
            ]);

            // 3. Insert Theme Setting Default (Minimal or selected theme)
            $themeId = $data['theme_id'] ?? 1;
            $stmt = $db->prepare("INSERT INTO theme_settings (store_id, theme_id, section_order) VALUES (?, ?, ?)");
            $stmt->execute([
                $storeId,
                $themeId,
                json_encode(['hero', 'categories', 'featured_products', 'new_arrivals', 'footer'])
            ]);

            // 4. Insert Subscription Record (Default Trial / Free)
            $stmt = $db->prepare("INSERT INTO subscriptions (store_id, plan_id, status, starts_at, expires_at) VALUES (?, ?, 'active', NOW(), DATE_ADD(NOW(), INTERVAL 365 DAY))");
            $stmt->execute([$storeId, $data['plan_id'] ?? 1]);

            $db->commit();

            $store = $this->storeModel->find($storeId);
            return ['success' => true, 'store' => $store];

        } catch (Exception $e) {
            $db->rollBack();
            return ['success' => false, 'errors' => ['general' => $e->getMessage()]];
        }
    }
}
