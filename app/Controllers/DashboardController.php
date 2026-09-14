<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\TenantMiddleware;
use App\Core\Database;

class DashboardController extends Controller {
    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $db = Database::getInstance();
        $storeId = $store['id'];

        // 1. Total Products
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM products WHERE store_id = ? AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        $totalProducts = (int)$stmt->fetch()['total'];

        // 2. Total Orders
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM orders WHERE store_id = ? AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        $totalOrders = (int)$stmt->fetch()['total'];

        // 3. Total Customers
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM customers WHERE store_id = ? AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        $totalCustomers = (int)$stmt->fetch()['total'];

        // 4. Today's Revenue
        $stmt = $db->prepare("SELECT SUM(total_amount) as total FROM orders WHERE store_id = ? AND payment_status = 'paid' AND DATE(created_at) = CURDATE()");
        $stmt->execute([$storeId]);
        $todaysRevenue = (float)($stmt->fetch()['total'] ?? 0.00);

        // 5. Recent Orders (limit 5)
        $stmt = $db->prepare("SELECT o.*, c.name as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.store_id = ? AND o.deleted_at IS NULL ORDER BY o.id DESC LIMIT 5");
        $stmt->execute([$storeId]);
        $recentOrders = $stmt->fetchAll();

        // 6. Low Stock Products
        $stmt = $db->prepare("SELECT * FROM products WHERE store_id = ? AND stock <= low_stock_threshold AND deleted_at IS NULL ORDER BY stock ASC LIMIT 5");
        $stmt->execute([$storeId]);
        $lowStockProducts = $stmt->fetchAll();

        $this->view('dashboard.index', [
            'pageTitle' => 'Merchant Dashboard - ' . sanitize($store['name']),
            'store' => $store,
            'stats' => [
                'todays_revenue' => $todaysRevenue,
                'total_orders' => $totalOrders,
                'total_customers' => $totalCustomers,
                'total_products' => $totalProducts,
            ],
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success']);
    }
}
