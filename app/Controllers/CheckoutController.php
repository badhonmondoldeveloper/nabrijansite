<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Services\ThemeService;
use App\Core\Database;

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
            'error' => $_SESSION['flash_error'] ?? null
        ], 'storefront.layout');
        unset($_SESSION['flash_error']);
    }

    public function processCheckout(string $slug): void {
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

        // Basic Validation
        if (empty($customerData['name']) || empty($customerData['phone']) || empty($shippingData['full_address'])) {
            $_SESSION['flash_error'] = 'Please fill in all required customer name, phone, and address fields.';
            redirect('/store/' . $slug . '/checkout');
        }

        $result = $this->orderService->placeOrder($store['id'], $customerData, $shippingData, $paymentMethod, $transactionId, $paymentNote);

        if ($result['success']) {
            redirect('/store/' . $slug . '/order-success/' . $result['order_id']);
        } else {
            $_SESSION['flash_error'] = $result['message'];
            redirect('/store/' . $slug . '/checkout');
        }
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
