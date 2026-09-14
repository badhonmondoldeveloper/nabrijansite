<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Middleware\CSRFMiddleware;
use App\Core\Database;

class AdminController extends Controller {
    public function __construct() {
        // Enforce Super Admin or Admin role for all admin routes
    }

    private function checkAdminAuth(): bool {
        return AuthMiddleware::requireRole('super_admin', 'admin');
    }

    public function dashboard(): void {
        if (!$this->checkAdminAuth()) return;

        $db = Database::getInstance();

        // Stats Aggregation
        $totalUsers = (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalStores = (int)$db->query("SELECT COUNT(*) FROM stores")->fetchColumn();
        $activeStores = (int)$db->query("SELECT COUNT(*) FROM stores WHERE status = 'active'")->fetchColumn();
        $totalProducts = (int)$db->query("SELECT COUNT(*) FROM products WHERE deleted_at IS NULL")->fetchColumn();
        $totalOrders = (int)$db->query("SELECT COUNT(*) FROM orders WHERE deleted_at IS NULL")->fetchColumn();
        $totalRevenue = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0.00) FROM orders WHERE payment_status = 'paid' AND deleted_at IS NULL")->fetchColumn();

        // Recent Stores
        $recentStores = $db->query("SELECT s.*, u.name as owner_name, u.email as owner_email, p.name as plan_name FROM stores s JOIN users u ON s.user_id = u.id JOIN plans p ON s.plan_id = p.id ORDER BY s.id DESC LIMIT 5")->fetchAll();

        $this->view('admin.dashboard', [
            'pageTitle' => 'Super Admin Panel - Nabrijan',
            'stats' => [
                'total_users' => $totalUsers,
                'total_stores' => $totalStores,
                'active_stores' => $activeStores,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue
            ],
            'recentStores' => $recentStores
        ], 'admin.layout');
    }

    public function stores(): void {
        if (!$this->checkAdminAuth()) return;

        $db = Database::getInstance();
        $search = trim($_GET['search'] ?? '');
        $params = [];
        $where = "";

        if (!empty($search)) {
            $where = "WHERE s.name LIKE ? OR s.slug LIKE ? OR u.email LIKE ?";
            $term = "%{$search}%";
            $params = [$term, $term, $term];
        }

        $stmt = $db->prepare("SELECT s.*, u.name as owner_name, u.email as owner_email, p.name as plan_name, (SELECT COUNT(*) FROM products WHERE store_id = s.id AND deleted_at IS NULL) as product_count, (SELECT COUNT(*) FROM orders WHERE store_id = s.id AND deleted_at IS NULL) as order_count FROM stores s JOIN users u ON s.user_id = u.id JOIN plans p ON s.plan_id = p.id {$where} ORDER BY s.id DESC");
        $stmt->execute($params);
        $stores = $stmt->fetchAll();

        $this->view('admin.stores', [
            'pageTitle' => 'Store Management - Super Admin',
            'stores' => $stores,
            'search' => $search,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success']);
    }

    public function updateStoreStatus(string $id): void {
        if (!$this->checkAdminAuth()) return;
        CSRFMiddleware::handle();

        $storeId = (int)$id;
        $status = $_POST['status'] ?? 'active';

        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE stores SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $storeId]);

        $_SESSION['flash_success'] = 'Store status updated to ' . sanitize($status) . '.';
        redirect('/admin/stores');
    }

    public function users(): void {
        if (!$this->checkAdminAuth()) return;

        $db = Database::getInstance();
        $users = $db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();

        $this->view('admin.users', [
            'pageTitle' => 'User Management - Super Admin',
            'users' => $users,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success']);
    }

    public function updateUserStatus(string $id): void {
        if (!$this->checkAdminAuth()) return;
        CSRFMiddleware::handle();

        $userId = (int)$id;
        $status = $_POST['status'] ?? 'active';

        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE users SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $userId]);

        $_SESSION['flash_success'] = 'User status updated to ' . sanitize($status) . '.';
        redirect('/admin/users');
    }

    public function plans(): void {
        if (!$this->checkAdminAuth()) return;

        $db = Database::getInstance();
        $plans = $db->query("SELECT * FROM plans ORDER BY price ASC")->fetchAll();

        $this->view('admin.plans', [
            'pageTitle' => 'Subscription Plans - Super Admin',
            'plans' => $plans,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success']);
    }

    public function settings(): void {
        if (!$this->checkAdminAuth()) return;

        $this->view('admin.settings', [
            'pageTitle' => 'Platform Settings - Super Admin',
            'success' => $_SESSION['flash_success'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success']);
    }
}
