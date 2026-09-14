<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Models\Product;
use Exception;

class OrderService {
    private CartService $cartService;
    private Store $storeModel;
    private StoreSetting $storeSettingModel;
    private Product $productModel;

    public function __construct() {
        $this->cartService = new CartService();
        $this->storeModel = new Store();
        $this->storeSettingModel = new StoreSetting();
        $this->productModel = new Product();
    }

    /**
     * Create transactional order with strict server-side calculations & atomic DB updates.
     */
    public function placeOrder(int $storeId, array $customerData, array $shippingData, string $paymentMethod, ?string $transactionId = null, ?string $paymentNote = null): array {
        $cart = $this->cartService->getCart($storeId);
        if (empty($cart['items'])) {
            return ['success' => false, 'message' => 'Your cart is empty.'];
        }

        $storeSettings = $this->storeSettingModel->findByStoreId($storeId);
        $deliveryCharge = ($shippingData['delivery_location'] === 'dhaka') 
            ? (float)($storeSettings['dhaka_delivery_charge'] ?? 60.00)
            : (float)($storeSettings['outside_dhaka_delivery_charge'] ?? 120.00);

        $subtotal = $cart['subtotal'];
        $discountAmount = 0.00;
        $totalAmount = $subtotal - $discountAmount + $deliveryCharge;

        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            // 1. Validate & Lock Product Stock
            foreach ($cart['items'] as $item) {
                $stmt = $db->prepare("SELECT stock, status FROM products WHERE id = ? AND store_id = ? AND deleted_at IS NULL FOR UPDATE");
                $stmt->execute([$item['product_id'], $storeId]);
                $prod = $stmt->fetch();

                if (!$prod || $prod['status'] !== 'active' || $prod['stock'] < $item['quantity']) {
                    throw new Exception("Product '" . $item['name'] . "' is no longer available in the requested quantity.");
                }
            }

            // 2. Find or Create Customer
            $stmt = $db->prepare("SELECT id FROM customers WHERE phone = ? AND store_id = ? AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$customerData['phone'], $storeId]);
            $customer = $stmt->fetch();

            if ($customer) {
                $customerId = (int)$customer['id'];
            } else {
                $stmt = $db->prepare("INSERT INTO customers (store_id, name, email, phone) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $storeId,
                    trim($customerData['name']),
                    trim($customerData['email'] ?? ''),
                    trim($customerData['phone'])
                ]);
                $customerId = (int)$db->lastInsertId();
            }

            // 3. Insert Shipping Address
            $stmt = $db->prepare("INSERT INTO customer_addresses (customer_id, division, district, area, full_address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $customerId,
                $shippingData['division'] ?? 'Dhaka',
                $shippingData['district'] ?? 'Dhaka',
                $shippingData['area'] ?? 'Dhaka',
                $shippingData['full_address']
            ]);

            // 4. Generate Unique Order Number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            // 5. Create Order Record
            $shippingJson = json_encode([
                'name' => $customerData['name'],
                'phone' => $customerData['phone'],
                'email' => $customerData['email'] ?? '',
                'address' => $shippingData['full_address'],
                'district' => $shippingData['district'] ?? '',
                'division' => $shippingData['division'] ?? ''
            ]);

            $stmt = $db->prepare("INSERT INTO orders (store_id, customer_id, order_number, subtotal, discount_amount, delivery_charge, total_amount, order_status, payment_status, shipping_address_json, customer_notes) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', 'pending', ?, ?)");
            $stmt->execute([
                $storeId,
                $customerId,
                $orderNumber,
                $subtotal,
                $discountAmount,
                $deliveryCharge,
                $totalAmount,
                $shippingJson,
                $customerData['notes'] ?? null
            ]);
            $orderId = (int)$db->lastInsertId();

            // 6. Create Order Items & Deduct Stock
            foreach ($cart['items'] as $item) {
                // Insert Item
                $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, product_name, unit_price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['name'],
                    $item['unit_price'],
                    $item['quantity'],
                    $item['total_price']
                ]);

                // Deduct Inventory Stock
                $stmt = $db->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND store_id = ?");
                $stmt->execute([$item['quantity'], $item['product_id'], $storeId]);
            }

            // 7. Create Payment Record
            $stmt = $db->prepare("INSERT INTO payments (store_id, order_id, payment_method, transaction_id, payment_note, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $storeId,
                $orderId,
                $paymentMethod,
                $transactionId,
                $paymentNote,
                $totalAmount,
                ($paymentMethod === 'cod') ? 'pending' : 'pending'
            ]);

            // 8. Create Order Status History Record
            $stmt = $db->prepare("INSERT INTO order_status_history (order_id, status, comment) VALUES (?, 'pending', 'Order placed by customer.')");
            $stmt->execute([$orderId]);

            // Commit Transaction
            $db->commit();

            // Clear Cart
            $this->cartService->clearCart($storeId);

            return [
                'success' => true,
                'order_id' => $orderId,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount
            ];

        } catch (Exception $e) {
            $db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
