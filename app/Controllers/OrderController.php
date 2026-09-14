<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;
use App\Core\Database;
use App\Services\AuthService;

class OrderController extends Controller {
    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $db = Database::getInstance();
        $statusFilter = trim($_GET['status'] ?? '');
        $params = [$store['id']];
        $where = "WHERE o.store_id = ? AND o.deleted_at IS NULL";

        if (!empty($statusFilter)) {
            $where .= " AND o.order_status = ?";
            $params[] = $statusFilter;
        }

        $sql = "SELECT o.*, c.name as customer_name, c.phone as customer_phone FROM orders o JOIN customers c ON o.customer_id = c.id {$where} ORDER BY o.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $orders = $stmt->fetchAll();

        $this->view('dashboard.orders.index', [
            'pageTitle' => 'Order Management - ' . sanitize($store['name']),
            'store' => $store,
            'orders' => $orders,
            'selectedStatus' => $statusFilter,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function show(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $db = Database::getInstance();
        $orderId = (int)$id;

        $stmt = $db->prepare("SELECT o.*, c.name as customer_name, c.phone as customer_phone, c.email as customer_email, p.payment_method, p.transaction_id, p.payment_note, p.status as payment_rec_status FROM orders o JOIN customers c ON o.customer_id = c.id LEFT JOIN payments p ON o.id = p.order_id WHERE o.id = ? AND o.store_id = ? AND o.deleted_at IS NULL LIMIT 1");
        $stmt->execute([$orderId, $store['id']]);
        $order = $stmt->fetch();

        if (!$order) {
            http_response_code(404);
            $this->view('errors.404');
            return;
        }

        // Fetch Order Items
        $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $items = $stmt->fetchAll();

        // Fetch Status History
        $stmt = $db->prepare("SELECT h.*, u.name as user_name FROM order_status_history h LEFT JOIN users u ON h.changed_by_user_id = u.id WHERE h.order_id = ? ORDER BY h.id DESC");
        $stmt->execute([$orderId]);
        $history = $stmt->fetchAll();

        $this->view('dashboard.orders.show', [
            'pageTitle' => 'Order #' . sanitize($order['order_number']) . ' Details',
            'store' => $store,
            'order' => $order,
            'items' => $items,
            'history' => $history,
            'shipping' => json_decode($order['shipping_address_json'], true) ?? [],
            'success' => $_SESSION['flash_success'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success']);
    }

    public function updateStatus(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $orderId = (int)$id;
        $newStatus = $_POST['order_status'] ?? 'pending';
        $comment = trim($_POST['comment'] ?? '');

        $db = Database::getInstance();
        $user = AuthService::user();

        // Verify Store Ownership
        $stmt = $db->prepare("SELECT id FROM orders WHERE id = ? AND store_id = ? LIMIT 1");
        $stmt->execute([$orderId, $store['id']]);
        if (!$stmt->fetch()) {
            $_SESSION['flash_error'] = 'Order not found.';
            redirect('/dashboard/orders');
        }

        // Update Order Status
        $stmt = $db->prepare("UPDATE orders SET order_status = ?, updated_at = NOW() WHERE id = ? AND store_id = ?");
        $stmt->execute([$newStatus, $orderId, $store['id']]);

        // Record Order Status History
        $stmt = $db->prepare("INSERT INTO order_status_history (order_id, status, comment, changed_by_user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $newStatus, $comment ?: ('Status updated to ' . $newStatus), $user['id']]);

        $_SESSION['flash_success'] = 'Order status updated to ' . sanitize($newStatus) . '.';
        redirect('/dashboard/orders/' . $orderId);
    }
}
