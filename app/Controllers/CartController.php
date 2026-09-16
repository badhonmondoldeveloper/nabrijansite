<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\CartService;
use App\Services\StoreResolver;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Services\ThemeService;

class CartController extends Controller {
    private CartService $cartService;
    private Store $storeModel;
    private StoreSetting $storeSettingModel;
    private StoreResolver $storeResolver;
    private ThemeService $themeService;

    public function __construct() {
        $this->cartService = new CartService();
        $this->storeModel = new Store();
        $this->storeSettingModel = new StoreSetting();
        $this->storeResolver = new StoreResolver();
        $this->themeService = new ThemeService();
    }

    public function viewCart(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) {
            http_response_code(404);
            $this->view('errors.404');
            return;
        }

        $cart = $this->cartService->getCart($store['id']);
        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']);
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);

        $this->view('storefront.cart', [
            'pageTitle' => 'Shopping Cart - ' . sanitize($store['name']),
            'store' => $store,
            'storeSettings' => $storeSettings,
            'themeConfig' => $themeConfig,
            'cart' => $cart
        ], 'storefront.layout');
    }

    public function add(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) {
            $this->error('Store not found', [], 404);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $productId = (int)($input['product_id'] ?? 0);
        $quantity = (int)($input['quantity'] ?? 1);
        $size = trim($input['size'] ?? '');
        $color = trim($input['color'] ?? '');

        $added = $this->cartService->addItem($store['id'], $productId, $quantity, $size, $color);
        if ($added) {
            $cart = $this->cartService->getCart($store['id']);
            $this->success('Added to cart', ['count' => $cart['item_count']]);
        } else {
            $this->error('Failed to add product to cart or out of stock.', [], 400);
        }
    }

    public function update(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) redirect('/');

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        $this->cartService->updateItem($store['id'], $productId, $quantity);
        redirect('/store/' . $slug . '/cart');
    }

    public function remove(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) redirect('/');

        $productId = (int)($_POST['product_id'] ?? 0);
        $this->cartService->removeItem($store['id'], $productId);
        redirect('/store/' . $slug . '/cart');
    }

    public function count(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) {
            $this->json(['count' => 0]);
        }
        $cart = $this->cartService->getCart($store['id']);
        $this->json(['count' => $cart['item_count']]);
    }

    public function data(string $slug): void {
        $store = $this->storeModel->findBySlug($slug);
        if (!$store) {
            $this->json(['success' => false, 'cart' => ['items' => [], 'subtotal' => 0, 'item_count' => 0]]);
            return;
        }
        $cart = $this->cartService->getCart($store['id']);
        $this->json(['success' => true, 'cart' => $cart]);
    }
}
