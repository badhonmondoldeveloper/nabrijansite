<?php

namespace App\Services;

use App\Core\Database;

class AnalyticsService {
    public function getStoreMetrics(int $storeId, string $period = '30days'): array {
        $db = Database::getInstance();

        // 1. Total Revenue (Paid & Delivered/Shipped/Processing)
        $stmt = $db->prepare("SELECT COALESCE(SUM(total_amount), 0.00) as revenue FROM orders WHERE store_id = ? AND payment_status = 'paid' AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        $totalRevenue = (float)$stmt->fetch()['revenue'];

        // 2. Total Orders
        $stmt = $db->prepare("SELECT COUNT(*) as total_orders FROM orders WHERE store_id = ? AND deleted_at IS NULL");
        $stmt->execute([$storeId]);
        $totalOrders = (int)$stmt->fetch()['total_orders'];

        // 3. Average Order Value (AOV)
        $aov = ($totalOrders > 0) ? ($totalRevenue / $totalOrders) : 0.00;

        // 4. Monthly Revenue History (Last 6 Months)
        $stmt = $db->prepare("SELECT DATE_FORMAT(created_at, '%b %Y') as month, SUM(total_amount) as amount FROM orders WHERE store_id = ? AND payment_status = 'paid' AND deleted_at IS NULL GROUP BY DATE_FORMAT(created_at, '%b %Y') ORDER BY created_at ASC LIMIT 6");
        $stmt->execute([$storeId]);
        $monthlyRevenue = $stmt->fetchAll();

        // 5. Top Selling Products
        $stmt = $db->prepare("SELECT product_name, SUM(quantity) as total_qty, SUM(total_price) as total_sales FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.store_id = ? AND o.deleted_at IS NULL GROUP BY oi.product_id, oi.product_name ORDER BY total_qty DESC LIMIT 5");
        $stmt->execute([$storeId]);
        $topProducts = $stmt->fetchAll();

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'aov' => $aov,
            'monthly_revenue' => $monthlyRevenue,
            'top_products' => $topProducts
        ];
    }
}
