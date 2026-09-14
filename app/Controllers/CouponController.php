<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Coupon;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;

class CouponController extends Controller {
    private Coupon $couponModel;

    public function __construct() {
        $this->couponModel = new Coupon();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $coupons = $this->couponModel->allForStore($store['id']);

        $this->view('dashboard.coupons.index', [
            'pageTitle' => 'Coupon Management - Nabrijan',
            'store' => $store,
            'coupons' => $coupons,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function store(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $code = strtoupper(trim($_POST['code'] ?? ''));
        $type = $_POST['type'] ?? 'percentage';
        $discountValue = (float)($_POST['discount_value'] ?? 0);
        $minOrderAmount = (float)($_POST['min_order_amount'] ?? 0);
        $usageLimit = !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null;

        if (empty($code) || $discountValue <= 0) {
            $_SESSION['flash_error'] = 'Valid Coupon Code and Discount Value are required.';
            redirect('/dashboard/coupons');
        }

        if ($this->couponModel->findByCodeForStore($code, $store['id'])) {
            $_SESSION['flash_error'] = 'Coupon code "' . sanitize($code) . '" already exists.';
            redirect('/dashboard/coupons');
        }

        $this->couponModel->create([
            'store_id' => $store['id'],
            'code' => $code,
            'type' => $type,
            'discount_value' => $discountValue,
            'min_order_amount' => $minOrderAmount,
            'usage_limit' => $usageLimit,
            'status' => 'active'
        ]);

        $_SESSION['flash_success'] = 'Coupon code "' . sanitize($code) . '" created successfully!';
        redirect('/dashboard/coupons');
    }
}
