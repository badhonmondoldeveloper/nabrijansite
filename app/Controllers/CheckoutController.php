<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Services\ThemeService;
use App\Core\Database;
use App\Middleware\CSRFMiddleware;

class CheckoutController extends Controller {
    private CartService $cartService;
    private OrderService $orderService;
    private Store $storeModel;
    private StoreSetting $storeSettingModel;
    private ThemeService $themeService;

    public function __construct() {
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
        $this->storeModel = new Store();
        $this->storeSettingModel = new StoreSetting();
        $this->themeService = new ThemeService();
    }

    public function showCheckout(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) {
            http_response_code(404);
            $this->view('errors.404');
            return;
        }

        $cart = $this->cartService->getCart($store['id']);
        if (empty($cart['items'])) {
            redirect('/store/' . $slug . '/cart');
        }

        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']);
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);

        $this->view('storefront.checkout', [
            'pageTitle' => 'Checkout - ' . sanitize($store['name']),
            'store' => $store,
            'storeSettings' => $storeSettings,
            'themeConfig' => $themeConfig,
            'cart' => $cart,
            'error' => $_SESSION['flash_error'] ?? null,
            'old' => $_SESSION['flash_old'] ?? []
        ], 'storefront.layout');
        unset($_SESSION['flash_error'], $_SESSION['flash_old']);
    }

    public function processCheckout(string $slug): void {
        CSRFMiddleware::handle();

        $store = $this->storeModel->findBySlug($slug);
        if (!$store) redirect('/');

        $customerData = [
            'name' => trim($_POST['name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'notes' => trim($_POST['notes'] ?? '')
        ];

        $shippingData = [
            'delivery_location' => $_POST['delivery_location'] ?? 'dhaka',
            'division' => trim($_POST['division'] ?? 'Dhaka'),
            'district' => trim($_POST['district'] ?? 'Dhaka'),
            'area' => trim($_POST['area'] ?? ''),
            'full_address' => trim($_POST['full_address'] ?? '')
        ];

        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $transactionId = trim($_POST['transaction_id'] ?? '');
        $paymentNote = trim($_POST['payment_note'] ?? '');

        $normalizedPhone = $this->normalizeBdMobile($customerData['phone']);
        if ($normalizedPhone !== null) {
            $customerData['phone'] = $normalizedPhone;
        }

        $error = $this->validateCheckout($store['id'], $customerData, $shippingData, $paymentMethod, $transactionId, $normalizedPhone);
        if ($error !== null) {
            $this->failCheckout($slug, $error, $_POST);
        }

        $result = $this->orderService->placeOrder($store['id'], $customerData, $shippingData, $paymentMethod, $transactionId, $paymentNote);

        if ($result['success']) {
            unset($_SESSION['flash_old']);
            redirect('/store/' . $slug . '/order-success/' . $result['order_id']);
        }

        $this->failCheckout($slug, $result['message'], $_POST);
    }

    private function failCheckout(string $slug, string $message, array $old): void {
        $_SESSION['flash_error'] = $message;
        unset($old['_csrf_token'], $old['csrf_token']);
        $_SESSION['flash_old'] = $old;
        redirect('/store/' . $slug . '/checkout');
    }

    private function validateCheckout(int $storeId, array $customerData, array $shippingData, string $paymentMethod, string $transactionId, ?string $normalizedPhone): ?string {
        if ($customerData['name'] === '' || $shippingData['full_address'] === '') {
            return 'Please fill in all required customer name, phone, and address fields.';
        }

        if ($normalizedPhone === null) {
            return 'Enter a valid Bangladeshi mobile number (e.g. 01712345678).';
        }

        if ($customerData['email'] !== '' && !filter_var($customerData['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address, or leave it blank.';
        }

        if (!in_array($shippingData['delivery_location'], ['dhaka', 'outside_dhaka'], true)) {
            return 'Please select a delivery area.';
        }

        $storeSettings = $this->storeSettingModel->findByStoreId($storeId) ?: [];
        $allowedMethods = [];
        if ((int)($storeSettings['cod_enabled'] ?? 1) === 1) {
            $allowedMethods[] = 'cod';
        }
        if (!empty($storeSettings['bkash_enabled']) && !empty($storeSettings['bkash_number'])) {
            $allowedMethods[] = 'bkash';
        }
        if (!empty($storeSettings['nagad_enabled']) && !empty($storeSettings['nagad_number'])) {
            $allowedMethods[] = 'nagad';
        }
        if (!empty($storeSettings['rocket_enabled']) && !empty($storeSettings['rocket_number'])) {
            $allowedMethods[] = 'rocket';
        }

        if (!in_array($paymentMethod, $allowedMethods, true)) {
            return 'Please select a valid payment method.';
        }

        if ($paymentMethod !== 'cod' && $transactionId === '') {
            return 'Enter the Transaction ID (TrxID) for your ' . ucfirst($paymentMethod) . ' payment.';
        }

        return null;
    }

    private function normalizeBdMobile(string $phone): ?string {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if (str_starts_with($digits, '880') && strlen($digits) === 13) {
            $digits = '0' . substr($digits, 3);
        }
        if (preg_match('/^01[3-9]\d{8}$/', $digits)) {
            return $digits;
        }
        return null;
    }

    public function showSuccess(string $slug, string $orderId): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) {
            http_response_code(404);
            $this->view('errors.404');
            return;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT o.*, p.payment_method, p.status as payment_rec_status FROM orders o LEFT JOIN payments p ON o.id = p.order_id WHERE o.id = ? AND o.store_id = ? LIMIT 1");
        $stmt->execute([(int)$orderId, $store['id']]);
        $order = $stmt->fetch();

        if (!$order) {
            redirect('/store/' . $slug);
        }

        $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$order['id']]);
        $items = $stmt->fetchAll();

        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']);
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);

        $this->view('storefront.order-success', [
            'pageTitle' => 'Order Confirmation - ' . sanitize($store['name']),
            'store' => $store,
            'storeSettings' => $storeSettings,
            'themeConfig' => $themeConfig,
            'order' => $order,
            'items' => $items
        ], 'storefront.layout');
    }
}
