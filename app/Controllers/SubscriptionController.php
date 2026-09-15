<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;
use App\Core\Database;
use App\Models\PlatformPaymentSetting;
use App\Models\SubscriptionPayment;

class SubscriptionController extends Controller {
    private PlatformPaymentSetting $platformPaymentSettingModel;
    private SubscriptionPayment $subscriptionPaymentModel;

    public function __construct() {
        $this->platformPaymentSettingModel = new PlatformPaymentSetting();
        $this->subscriptionPaymentModel = new SubscriptionPayment();
    }

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

        // Fetch Platform Manual Payment Settings
        $platformPayments = $this->platformPaymentSettingModel->getAllSettings();

        // Fetch Merchant's Subscription Payment History
        $stmt = $db->prepare("SELECT sp.*, p.name as plan_name FROM subscription_payments sp JOIN plans p ON sp.plan_id = p.id WHERE sp.store_id = ? ORDER BY sp.id DESC");
        $stmt->execute([$storeId]);
        $paymentHistory = $stmt->fetchAll();

        $this->view('dashboard.subscription', [
            'pageTitle' => 'Subscription & Plan Limits - Nabrijan',
            'store' => $store,
            'currentPlan' => $currentPlan,
            'productCount' => $productCount,
            'allPlans' => $allPlans,
            'platformPayments' => $platformPayments,
            'paymentHistory' => $paymentHistory,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function submitUpgrade(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $planId = (int)($_POST['plan_id'] ?? 0);
        $paymentMethod = trim($_POST['payment_method'] ?? 'bkash');
        $transactionId = trim($_POST['transaction_id'] ?? '');
        $senderNumber = trim($_POST['sender_number'] ?? '');
        $paymentNote = trim($_POST['payment_note'] ?? '');

        if (!$planId || empty($transactionId)) {
            $_SESSION['flash_error'] = 'Please select a plan and enter a valid Transaction ID (TrxID).';
            redirect('/dashboard/subscription');
            return;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM plans WHERE id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$planId]);
        $plan = $stmt->fetch();

        if (!$plan) {
            $_SESSION['flash_error'] = 'Invalid subscription plan selected.';
            redirect('/dashboard/subscription');
            return;
        }

        $this->subscriptionPaymentModel->createPayment([
            'store_id' => $store['id'],
            'plan_id' => $plan['id'],
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'sender_number' => $senderNumber,
            'amount' => $plan['price'],
            'payment_note' => $paymentNote
        ]);

        $_SESSION['flash_success'] = 'Subscription upgrade payment request submitted successfully! Super Admin will review and activate your plan.';
        redirect('/dashboard/subscription');
    }
}
