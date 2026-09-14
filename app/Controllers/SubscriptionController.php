<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\TenantMiddleware;
use App\Core\Database;

class SubscriptionController extends Controller {
    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $db = Database::getInstance();
        $storeId = $store['id'];

        // Fetch Current Plan & Subscription Details
        $stmt = $db->prepare("SELECT p.*, sub.status as sub_status, sub.starts_at, sub.expires_at FROM stores s JOIN plans p ON s.plan_id = p.id LEFT JOIN subscriptions sub ON s.id = sub.store_id WHERE s.id = ? LIMIT 1");
        $stmt->execute([$storeId]);
        $currentPlan = $stmt->fetch();

        // Fetch Product Usage Count
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM products WHERE store_id = ? AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        $productCount = (int)$stmt->fetch()['total'];

        // Fetch All Available SaaS Plans
        $stmt = $db->prepare("SELECT * FROM plans WHERE is_active = 1 ORDER BY price ASC");
        $stmt->execute();
        $allPlans = $stmt->fetchAll();

        $this->view('dashboard.subscription', [
            'pageTitle' => 'Subscription & Plan Limits - Nabrijan',
            'store' => $store,
            'currentPlan' => $currentPlan,
            'productCount' => $productCount,
            'allPlans' => $allPlans
        ], 'dashboard.layout');
    }
}
