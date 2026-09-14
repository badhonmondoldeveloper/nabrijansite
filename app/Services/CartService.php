<?php

namespace App\Services;

use App\Models\Product;

class CartService {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    private function getCartKey(int $storeId): string {
        return 'cart_store_' . $storeId;
    }

    public function getCart(int $storeId): array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        $rawCart = $_SESSION[$key] ?? [];
        $validatedItems = [];
        $subtotal = 0.00;

        foreach ($rawCart as $productId => $qty) {
            $product = $this->productModel->findForStore((int)$productId, $storeId);
            if ($product && $product['status'] === 'active' && $product['stock'] > 0) {
                $itemQty = min((int)$qty, (int)$product['stock']);
                $unitPrice = !empty($product['discount_price']) ? (float)$product['discount_price'] : (float)$product['price'];
                $itemTotal = $unitPrice * $itemQty;
                $subtotal += $itemTotal;

                $validatedItems[] = [
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'sku' => $product['sku'],
                    'unit_price' => $unitPrice,
                    'quantity' => $itemQty,
                    'total_price' => $itemTotal,
                    'stock' => $product['stock'],
                    'image' => $product['primary_image'] ?? null
                ];
            }
        }

        return [
            'items' => $validatedItems,
            'subtotal' => $subtotal,
            'item_count' => array_sum(array_column($validatedItems, 'quantity'))
        ];
    }

    public function addItem(int $storeId, int $productId, int $quantity = 1): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $product = $this->productModel->findForStore($productId, $storeId);
        if (!$product || $product['status'] !== 'active' || $product['stock'] <= 0) {
            return false;
        }

        $key = $this->getCartKey($storeId);
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        $currentQty = $_SESSION[$key][$productId] ?? 0;
        $newQty = min($currentQty + $quantity, $product['stock']);
        $_SESSION[$key][$productId] = $newQty;
        return true;
    }

    public function updateItem(int $storeId, int $productId, int $quantity): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        if ($quantity <= 0) {
            unset($_SESSION[$key][$productId]);
        } else {
            $product = $this->productModel->findForStore($productId, $storeId);
            if ($product) {
                $_SESSION[$key][$productId] = min($quantity, $product['stock']);
            }
        }
    }

    public function removeItem(int $storeId, int $productId): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        unset($_SESSION[$key][$productId]);
    }

    public function clearCart(int $storeId): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        unset($_SESSION[$key]);
    }
}
