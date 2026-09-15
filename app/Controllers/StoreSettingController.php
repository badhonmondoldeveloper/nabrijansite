<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;
use App\Models\StoreSetting;

class StoreSettingController extends Controller {
    private StoreSetting $storeSettingModel;

    public function __construct() {
        $this->storeSettingModel = new StoreSetting();
    }

    public function paymentMethods(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $settings = $this->storeSettingModel->findByStoreId($store['id']);

        $this->view('dashboard.payment-methods', [
            'pageTitle' => 'Store Manual Payment Setup - ' . sanitize($store['name']),
            'store' => $store,
            'settings' => $settings,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success']);
    }

    public function updatePaymentMethods(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $data = [
            'cod_enabled' => isset($_POST['cod_enabled']) ? 1 : 0,
            'bkash_enabled' => isset($_POST['bkash_enabled']) ? 1 : 0,
            'bkash_number' => trim($_POST['bkash_number'] ?? ''),
            'bkash_type' => $_POST['bkash_type'] ?? 'personal',
            'bkash_instruction' => trim($_POST['bkash_instruction'] ?? ''),
            'nagad_enabled' => isset($_POST['nagad_enabled']) ? 1 : 0,
            'nagad_number' => trim($_POST['nagad_number'] ?? ''),
            'nagad_type' => $_POST['nagad_type'] ?? 'personal',
            'nagad_instruction' => trim($_POST['nagad_instruction'] ?? ''),
            'rocket_enabled' => isset($_POST['rocket_enabled']) ? 1 : 0,
            'rocket_number' => trim($_POST['rocket_number'] ?? ''),
            'rocket_type' => $_POST['rocket_type'] ?? 'personal',
            'rocket_instruction' => trim($_POST['rocket_instruction'] ?? ''),
            'bank_enabled' => isset($_POST['bank_enabled']) ? 1 : 0,
            'bank_details' => trim($_POST['bank_details'] ?? '')
        ];

        $this->storeSettingModel->updatePaymentSettings($store['id'], $data);

        $_SESSION['flash_success'] = 'Store Manual Payment Methods updated successfully!';
        redirect('/dashboard/payment-methods');
    }
}
