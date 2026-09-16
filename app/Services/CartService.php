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

        foreach ($rawCart as $itemKey => $itemData) {
            $productId = is_array($itemData) ? (int)($itemData['product_id'] ?? 0) : (int)$itemKey;
            $qty = is_array($itemData) ? (int)($itemData['quantity'] ?? 1) : (int)$itemData;
            $size = is_array($itemData) ? ($itemData['size'] ?? '') : '';
            $color = is_array($itemData) ? ($itemData['color'] ?? '') : '';

            $product = $this->productModel->findForStore($productId, $storeId);
            if ($product && $product['status'] === 'active' && $product['stock'] > 0) {
                $itemQty = min((int)$qty, (int)$product['stock']);
                $unitPrice = !empty($product['discount_price']) ? (float)$product['discount_price'] : (float)$product['price'];
                $itemTotal = $unitPrice * $itemQty;
                $subtotal += $itemTotal;

                $validatedItems[] = [
                    'item_key' => (string)$itemKey,
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'sku' => $product['sku'],
                    'unit_price' => $unitPrice,
                    'price' => $unitPrice,
                    'quantity' => $itemQty,
                    'size' => $size,
                    'color' => $color,
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

    public function addItem(int $storeId, int $productId, int $quantity = 1, string $size = '', string $color = ''): bool {
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

        $itemKey = $productId . ($size ? '_' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $size) : '') . ($color ? '_' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $color) : '');

        $currentQty = 0;
        if (isset($_SESSION[$key][$itemKey])) {
            $currentQty = is_array($_SESSION[$key][$itemKey]) ? (int)$_SESSION[$key][$itemKey]['quantity'] : (int)$_SESSION[$key][$itemKey];
        }

        $newQty = min($currentQty + $quantity, $product['stock']);
        $_SESSION[$key][$itemKey] = [
            'product_id' => $productId,
            'quantity' => $newQty,
            'size' => $size,
            'color' => $color
        ];
        return true;
    }

    public function updateItem(int $storeId, $itemKey, int $quantity): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        if ($quantity <= 0) {
            unset($_SESSION[$key][$itemKey]);
        } else {
            if (isset($_SESSION[$key][$itemKey])) {
                if (is_array($_SESSION[$key][$itemKey])) {
                    $_SESSION[$key][$itemKey]['quantity'] = $quantity;
                } else {
                    $_SESSION[$key][$itemKey] = $quantity;
                }
            }
        }
    }

    public function removeItem(int $storeId, $itemKey): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        unset($_SESSION[$key][$itemKey]);
    }

    public function clearCart(int $storeId): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = $this->getCartKey($storeId);
        unset($_SESSION[$key]);
    }
}
