<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Core\Database;
use Exception;

class ProductService {
    private Product $productModel;
    private Category $categoryModel;
    private ProductImage $productImageModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->productImageModel = new ProductImage();
    }

    /**
     * Check if merchant store has reached plan product limit.
     */
    public function canAddProduct(int $storeId): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT p.product_limit FROM stores s JOIN plans p ON s.plan_id = p.id WHERE s.id = ? LIMIT 1");
        $stmt->execute([$storeId]);
        $plan = $stmt->fetch();
        $limit = $plan ? (int)$plan['product_limit'] : 10;

        $currentCount = $this->productModel->countProductsForStore($storeId);
        return $currentCount < $limit;
    }

    /**
     * Create product for tenant store.
     */
    public function createProduct(int $storeId, array $data, array $imageFiles = []): array {
        if (!$this->canAddProduct($storeId)) {
            return [
                'success' => false,
                'errors' => ['plan' => 'You have reached your subscription plan product limit. Upgrade to add more products.']
            ];
        }

        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Product Name is required.';
        }

        $price = (float)($data['price'] ?? 0);
        if ($price <= 0) {
            $errors['price'] = 'Valid Product Price is required.';
        }

        $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(str_replace(' ', '-', trim($data['name']))));
        if (!empty($data['slug'])) {
            $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($data['slug'])));
        }

        if ($this->productModel->slugExistsForStore($slug, $storeId)) {
            $slug .= '-' . rand(100, 999);
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $productId = $this->productModel->create([
                'store_id' => $storeId,
                'category_id' => !empty($data['category_id']) ? (int)$data['category_id'] : null,
                'name' => trim($data['name']),
                'slug' => $slug,
                'description' => $data['description'] ?? null,
                'short_description' => $data['short_description'] ?? null,
                'brand' => $data['brand'] ?? null,
                'price' => $price,
                'discount_price' => !empty($data['discount_price']) ? (float)$data['discount_price'] : null,
                'cost_price' => !empty($data['cost_price']) ? (float)$data['cost_price'] : null,
                'sku' => !empty($data['sku']) ? trim($data['sku']) : 'SKU-' . strtoupper(bin2hex(random_bytes(3))),
                'stock' => (int)($data['stock'] ?? 0),
                'low_stock_threshold' => (int)($data['low_stock_threshold'] ?? 5),
                'status' => $data['status'] ?? 'active',
                'is_featured' => !empty($data['is_featured']) ? 1 : 0,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_description' => $data['seo_description'] ?? null
            ]);

            // Process Image Uploads
            if (!empty($imageFiles['name']) && is_array($imageFiles['name'])) {
                $isPrimary = true;
                for ($i = 0; $i < count($imageFiles['name']); $i++) {
                    if ($imageFiles['error'][$i] === UPLOAD_ERR_OK) {
                        $singleFile = [
                            'name' => $imageFiles['name'][$i],
                            'type' => $imageFiles['type'][$i],
                            'tmp_name' => $imageFiles['tmp_name'][$i],
                            'error' => $imageFiles['error'][$i],
                            'size' => $imageFiles['size'][$i]
                        ];
                        $imagePath = ImageService::processAndSaveImage($singleFile, $storeId, 'products');
                        $this->productImageModel->addImage($productId, $imagePath, $isPrimary);
                        $isPrimary = false;
                    }
                }
            }

            // Process Variants (Sizes & Colors)
            $sizesInput = trim($data['sizes'] ?? '');
            $colorsInput = trim($data['colors'] ?? '');
            $sizes = !empty($sizesInput) ? array_filter(array_map('trim', explode(',', $sizesInput))) : [];
            $colors = !empty($colorsInput) ? array_filter(array_map('trim', explode(',', $colorsInput))) : [];

            if (!empty($sizes) || !empty($colors)) {
                $variantModel = new \App\Models\ProductVariant();
                if (!empty($sizes) && !empty($colors)) {
                    foreach ($sizes as $sz) {
                        foreach ($colors as $cl) {
                            $variantModel->addVariant($productId, ['size' => $sz, 'color' => $cl], $price, (int)($data['stock'] ?? 10));
                        }
                    }
                } elseif (!empty($sizes)) {
                    foreach ($sizes as $sz) {
                        $variantModel->addVariant($productId, ['size' => $sz], $price, (int)($data['stock'] ?? 10));
                    }
                } elseif (!empty($colors)) {
                    foreach ($colors as $cl) {
                        $variantModel->addVariant($productId, ['color' => $cl], $price, (int)($data['stock'] ?? 10));
                    }
                }
            }

            $db->commit();
            return ['success' => true, 'product_id' => $productId];

        } catch (Exception $e) {
            $db->rollBack();
            return ['success' => false, 'errors' => ['general' => $e->getMessage()]];
        }
    }
}
