<?php

namespace App\Controllers\Api\V1;

use App\Core\Controller;
use App\Models\Product;
use App\Services\ProductService;
use App\Middleware\TenantMiddleware;

class ProductApiController extends Controller {
    private Product $productModel;
    private ProductService $productService;

    public function __construct() {
        $this->productModel = new Product();
        $this->productService = new ProductService();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $page = (int)($_GET['page'] ?? 1);
        $search = trim($_GET['search'] ?? '');
        $categoryId = !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        $result = $this->productModel->getPaginatedForStore($store['id'], $page, 20, $search, $categoryId);
        $this->success('Products retrieved successfully.', $result);
    }

    public function show(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $productId = (int)$id;
        $product = $this->productModel->findForStore($productId, $store['id']);

        if ($product) {
            $this->success('Product retrieved.', ['product' => $product]);
        } else {
            $this->error('Product not found.', [], 404);
        }
    }

    public function store(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $result = $this->productService->createProduct($store['id'], $input, $_FILES['images'] ?? []);

        if ($result['success']) {
            $this->success('Product created successfully.', ['product_id' => $result['product_id']], 201);
        } else {
            $this->error('Failed to create product.', $result['errors'], 422);
        }
    }

    public function destroy(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $productId = (int)$id;
        $deleted = $this->productModel->deleteForStore($productId, $store['id'], true);

        if ($deleted) {
            $this->success('Product deleted successfully.');
        } else {
            $this->error('Failed to delete product.', [], 400);
        }
    }
}
