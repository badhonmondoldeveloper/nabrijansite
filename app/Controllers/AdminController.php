<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Middleware\CSRFMiddleware;
use App\Core\Database;
use App\Models\PlatformPaymentSetting;
use App\Models\SubscriptionPayment;

class AdminController extends Controller {
    private PlatformPaymentSetting $paymentSettingModel;
    private SubscriptionPayment $subscriptionPaymentModel;

    public function __construct() {
        $this->paymentSettingModel = new PlatformPaymentSetting();
        $this->subscriptionPaymentModel = new SubscriptionPayment();
    }

    private function checkAdminAuth(): bool {
        return AuthMiddleware::requireRole('super_admin', 'admin');
    }

    public function dashboard(): void {
        if (!$this->checkAdminAuth()) return;

        $db = Database::getInstance();

        // 1. Multitalented Aggregation Stats
        $totalUsers = (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalStores = (int)$db->query("SELECT COUNT(*) FROM stores")->fetchColumn();
        $activeStores = (int)$db->query("SELECT COUNT(*) FROM stores WHERE status = 'active'")->fetchColumn();
        $suspendedStores = (int)$db->query("SELECT COUNT(*) FROM stores WHERE status = 'suspended'")->fetchColumn();
        
        $totalProducts = (int)$db->query("SELECT COUNT(*) FROM products WHERE deleted_at IS NULL")->fetchColumn();
        $totalOrders = (int)$db->query("SELECT COUNT(*) FROM orders WHERE deleted_at IS NULL")->fetchColumn();
        
        // GMV: Total Gross Merchandise Volume across all merchant stores
        $totalGmv = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0.00) FROM orders WHERE payment_status = 'paid' AND deleted_at IS NULL")->fetchColumn();

        // SaaS Subscription Revenue: Sum of all approved subscription payments
        $saasRevenue = (float)$db->query("SELECT COALESCE(SUM(amount), 0.00) FROM subscription_payments WHERE status = 'approved'")->fetchColumn();
        $pendingSubApprovals = (int)$db->query("SELECT COUNT(*) FROM subscription_payments WHERE status = 'pending'")->fetchColumn();

        // 2. SaaS Plan Distribution
        $planStats = $db->query("SELECT p.name, p.slug, COUNT(s.id) as store_count FROM plans p LEFT JOIN stores s ON p.id = s.plan_id GROUP BY p.id ORDER BY p.price ASC")->fetchAll();

        // 3. Monthly Store Registrations (Last 6 Months)
        $monthlyRegistrations = $db->query("SELECT DATE_FORMAT(created_at, '%b %Y') as month, COUNT(*) as count FROM stores GROUP BY DATE_FORMAT(created_at, '%Y-%m') ORDER BY created_at DESC LIMIT 6")->fetchAll();
        $monthlyRegistrations = array_reverse($monthlyRegistrations);

        // 4. Pending Subscription Payment Requests
        $pendingPayments = $this->subscriptionPaymentModel->getAllWithDetails('pending');

        // 5. Recent Merchant Stores
        $recentStores = $db->query("SELECT s.*, u.name as owner_name, u.email as owner_email, p.name as plan_name FROM stores s JOIN users u ON s.user_id = u.id JOIN plans p ON s.plan_id = p.id ORDER BY s.id DESC LIMIT 5")->fetchAll();

        // 6. System Health Metrics
        $serverInfo = [
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'LiteSpeed/Apache',
            'timezone' => date_default_timezone_get(),
            'database_name' => 'nabrijan_db',
            'storage_limit' => '2.00 GB',
            'active_time' => date('Y-m-d H:i:s')
        ];

        $this->view('admin.dashboard', [
            'pageTitle' => 'Multitalented Super Admin Control Dashboard - Nabrijan',
            'stats' => [
                'total_users' => $totalUsers,
                'total_stores' => $totalStores,
                'active_stores' => $activeStores,
                'suspended_stores' => $suspendedStores,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_gmv' => $totalGmv,
                'saas_revenue' => $saasRevenue,
                'pending_sub_approvals' => $pendingSubApprovals
            ],
            'planStats' => $planStats,
            'monthlyRegistrations' => $monthlyRegistrations,
            'pendingPayments' => $pendingPayments,
            'recentStores' => $recentStores,
            'serverInfo' => $serverInfo,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
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

    // Platform Payment Settings Page
    public function settings(): void {
        if (!$this->checkAdminAuth()) return;

        $settings = $this->paymentSettingModel->getAllSettings();

        $this->view('admin.settings', [
            'pageTitle' => 'SaaS Platform Settings & Manual Payments - Super Admin',
            'settings' => $settings,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success']);
    }

    public function updateSettings(): void {
        if (!$this->checkAdminAuth()) return;
        CSRFMiddleware::handle();

        $settingsData = [
            'bkash_number' => trim($_POST['bkash_number'] ?? ''),
            'bkash_type' => $_POST['bkash_type'] ?? 'personal',
            'bkash_instruction' => trim($_POST['bkash_instruction'] ?? ''),
            'nagad_number' => trim($_POST['nagad_number'] ?? ''),
            'nagad_type' => $_POST['nagad_type'] ?? 'personal',
            'nagad_instruction' => trim($_POST['nagad_instruction'] ?? ''),
            'rocket_number' => trim($_POST['rocket_number'] ?? ''),
            'rocket_type' => $_POST['rocket_type'] ?? 'personal',
            'rocket_instruction' => trim($_POST['rocket_instruction'] ?? ''),
            'bank_details' => trim($_POST['bank_details'] ?? '')
        ];

        $this->paymentSettingModel->updateSettings($settingsData);

        $_SESSION['flash_success'] = 'SaaS Platform Manual Payment Settings updated successfully!';
        redirect('/admin/settings');
    }

    // Subscription Payments Management
    public function subscriptionPayments(): void {
        if (!$this->checkAdminAuth()) return;

        $payments = $this->subscriptionPaymentModel->getAllWithDetails();

        $this->view('admin.subscription-payments', [
            'pageTitle' => 'Merchant Subscription Payments - Super Admin',
            'payments' => $payments,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'admin.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function approveSubscriptionPayment(string $id): void {
        if (!$this->checkAdminAuth()) return;
        CSRFMiddleware::handle();

        $paymentId = (int)$id;
        $payment = $this->subscriptionPaymentModel->findWithDetails($paymentId);

        if (!$payment || $payment['status'] !== 'pending') {
            $_SESSION['flash_error'] = 'Invalid or non-pending subscription payment.';
            redirect('/admin/subscription-payments');
            return;
        }

        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            // 1. Mark Payment Approved
            $this->subscriptionPaymentModel->updateStatus($paymentId, 'approved');

            // 2. Update Store Plan ID
            $stmt = $db->prepare("UPDATE stores SET plan_id = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$payment['plan_id'], $payment['store_id']]);

            // 3. Upsert Subscription Active Record (30 Days)
            $startsAt = date('Y-m-d H:i:s');
            $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

            $stmt = $db->prepare("INSERT INTO subscriptions (store_id, plan_id, status, starts_at, expires_at, updated_at) VALUES (?, ?, 'active', ?, ?, NOW()) ON DUPLICATE KEY UPDATE plan_id = VALUES(plan_id), status = 'active', starts_at = VALUES(starts_at), expires_at = VALUES(expires_at), updated_at = NOW()");
            $stmt->execute([$payment['store_id'], $payment['plan_id'], $startsAt, $expiresAt]);

            // 4. Create Notification for Store Owner
            $stmt = $db->prepare("INSERT INTO notifications (store_id, user_id, title, message, type, created_at) SELECT ?, user_id, 'Subscription Approved!', ?, 'success', NOW() FROM stores WHERE id = ?");
            $message = "Your subscription payment of BDT " . number_format($payment['amount'], 2) . " for plan '" . $payment['plan_name'] . "' has been approved! Your plan is now ACTIVE.";
            $stmt->execute([$payment['store_id'], $message, $payment['store_id']]);

            $db->commit();
            $_SESSION['flash_success'] = 'Subscription payment APPROVED and Store Plan updated to ' . sanitize($payment['plan_name']) . '!';
        } catch (\Exception $e) {
            $db->rollBack();
            $_SESSION['flash_error'] = 'Failed to approve subscription payment: ' . $e->getMessage();
        }

        redirect('/admin/subscription-payments');
    }

    public function rejectSubscriptionPayment(string $id): void {
        if (!$this->checkAdminAuth()) return;
        CSRFMiddleware::handle();

        $paymentId = (int)$id;
        $reason = trim($_POST['rejection_reason'] ?? 'Invalid transaction details or verification failed');

        $payment = $this->subscriptionPaymentModel->findWithDetails($paymentId);
        if (!$payment || $payment['status'] !== 'pending') {
            $_SESSION['flash_error'] = 'Invalid or non-pending subscription payment.';
            redirect('/admin/subscription-payments');
            return;
        }

        $this->subscriptionPaymentModel->updateStatus($paymentId, 'rejected', $reason);

        // Notify Merchant
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO notifications (store_id, user_id, title, message, type, created_at) SELECT ?, user_id, 'Subscription Payment Rejected', ?, 'warning', NOW() FROM stores WHERE id = ?");
        $message = "Your subscription payment request of BDT " . number_format($payment['amount'], 2) . " was rejected. Reason: " . $reason;
        $stmt->execute([$payment['store_id'], $message, $payment['store_id']]);

        $_SESSION['flash_success'] = 'Subscription payment rejected.';
        redirect('/admin/subscription-payments');
    }
}
