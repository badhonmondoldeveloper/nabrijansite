<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Services\StoreResolver;
use App\Services\ThemeService;

class StorefrontController extends Controller {
    private Store $storeModel;
    private StoreSetting $storeSettingModel;
    private Product $productModel;
    private Category $categoryModel;
    private ProductImage $productImageModel;
    private StoreResolver $storeResolver;
    private ThemeService $themeService;

    public function __construct() {
        $this->storeModel = new Store();
        $this->storeSettingModel = new StoreSetting();
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->productImageModel = new ProductImage();
        $this->storeResolver = new StoreResolver();
        $this->themeService = new ThemeService();
    }

    /**
     * Storefront Homepage
     */
    public function index(?string $slug = null): void {
        $store = $this->resolveStore($slug);
        if (!$store) return;

        $search = trim($_GET['q'] ?? '');
        $result = $this->productModel->getPaginatedForStore($store['id'], 1, 24, $search);
        $categories = $this->categoryModel->allForStore($store['id']);
        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']);
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);

        $this->view('storefront.index', [
            'pageTitle' => sanitize($store['name']) . ' - Online Store',
            'store' => $store,
            'storeSettings' => $storeSettings,
            'themeConfig' => $themeConfig,
            'products' => $result['items'],
            'categories' => $categories,
            'search' => $search
        ], 'storefront.layout');
    }

    /**
     * Storefront Category View
     */
    public function category(string $slug, string $categorySlug): void {
        $store = $this->resolveStore($slug);
        if (!$store) return;

        $cat = $this->categoryModel->findForStore(0, $store['id']); // Query by slug
        $stmt = $this->categoryModel->getDb()->prepare("SELECT * FROM categories WHERE slug = ? AND store_id = ? AND deleted_at IS NULL LIMIT 1");
        $stmt->execute([$categorySlug, $store['id']]);
        $category = $stmt->fetch();

        if (!$category) {
            http_response_code(404);
            $this->view('errors.404');
            return;
        }

        $result = $this->productModel->getPaginatedForStore($store['id'], 1, 24, '', $category['id']);
        $categories = $this->categoryModel->allForStore($store['id']);
        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']);
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);

        $this->view('storefront.index', [
            'pageTitle' => sanitize($category['name']) . ' - ' . sanitize($store['name']),
            'store' => $store,
            'storeSettings' => $storeSettings,
            'themeConfig' => $themeConfig,
            'products' => $result['items'],
            'categories' => $categories,
            'selectedCategory' => $category
        ], 'storefront.layout');
    }

    /**
     * Storefront Product Details Page
     */
    public function product(string $slug, string $productSlug): void {
        $store = $this->resolveStore($slug);
        if (!$store) return;

        $product = $this->productModel->findBySlugAndStore($productSlug, $store['id']);

        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']) ?: [];
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);

        if (!$product) {
            http_response_code(404);
            $this->view('storefront.product-not-found', [
                'pageTitle' => 'Product Not Found - ' . sanitize($store['name']),
                'store' => $store,
                'storeSettings' => $storeSettings,
                'themeConfig' => $themeConfig
            ], 'storefront.layout');
            return;
        }

        $images = $this->productImageModel->getImagesForProduct($product['id']);
        $variantModel = new \App\Models\ProductVariant();
        $variants = $variantModel->getVariantsForProduct($product['id']);

        $relatedProducts = [];
        if (!empty($product['category_id'])) {
            $relatedResult = $this->productModel->getPaginatedForStore($store['id'], 1, 4, '', (int)$product['category_id']);
            $relatedProducts = $relatedResult['items'] ?? [];
        } else {
            $relatedResult = $this->productModel->getPaginatedForStore($store['id'], 1, 4);
            $relatedProducts = $relatedResult['items'] ?? [];
        }

        $this->view('storefront.product-details', [
            'pageTitle' => sanitize($product['name']) . ' - ' . sanitize($store['name']),
            'store' => $store,
            'storeSettings' => $storeSettings,
            'themeConfig' => $themeConfig,
            'product' => $product,
            'images' => $images,
            'variants' => $variants,
            'relatedProducts' => $relatedProducts
        ], 'storefront.layout');
    }

    /**
     * Resolve store tenant or show 404
     */
    private function resolveStore(?string $pathSlug = null): ?array {
        $store = null;
        if (!empty($pathSlug)) {
            $store = $this->storeModel->findBySlug($pathSlug);
        }

        if (!$store) {
            $store = $this->storeResolver->resolve();
        }

        if (!$store) {
            http_response_code(404);
            $this->view('errors.404');
            return null;
        }

        return $store;
    }
}
