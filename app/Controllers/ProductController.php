<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;

class ProductController extends Controller {
    private Product $productModel;
    private Category $categoryModel;
    private ProductService $productService;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->productService = new ProductService();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $page = (int)($_GET['page'] ?? 1);
        $search = trim($_GET['search'] ?? '');
        $categoryId = !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        $result = $this->productModel->getPaginatedForStore($store['id'], $page, 10, $search, $categoryId);
        $categories = $this->categoryModel->allForStore($store['id']);

        $this->view('dashboard.products.index', [
            'pageTitle' => 'Product Management - Nabrijan',
            'store' => $store,
            'products' => $result['items'],
            'pagination' => $result,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $categoryId,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function create(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $categories = $this->categoryModel->allForStore($store['id']);

        $this->view('dashboard.products.create', [
            'pageTitle' => 'Add New Product - Nabrijan',
            'store' => $store,
            'categories' => $categories,
            'errors' => $_SESSION['flash_errors'] ?? [],
            'old' => $_SESSION['flash_old'] ?? []
        ], 'dashboard.layout');
        unset($_SESSION['flash_errors'], $_SESSION['flash_old']);
    }

    public function store(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $imageFiles = $_FILES['images'] ?? [];
        $result = $this->productService->createProduct($store['id'], $_POST, $imageFiles);

        if ($result['success']) {
            $_SESSION['flash_success'] = 'Product created successfully!';
            redirect('/dashboard/products');
        } else {
            $_SESSION['flash_errors'] = $result['errors'];
            $_SESSION['flash_old'] = $_POST;
            redirect('/dashboard/products/create');
        }
    }

    public function edit(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $productId = (int)$id;
        $product = $this->productModel->findForStore($productId, $store['id']);
        if (!$product) {
            $_SESSION['flash_error'] = 'Product not found.';
            redirect('/dashboard/products');
        }

        $categories = $this->categoryModel->allForStore($store['id']);
        $images = (new \App\Models\ProductImage())->getImagesForProduct($productId);
        $variants = (new \App\Models\ProductVariant())->getVariantsForProduct($productId);

        $sizes = [];
        $colors = [];
        foreach ($variants as $v) {
            if (!empty($v['attributes']['size']) && !in_array($v['attributes']['size'], $sizes)) {
                $sizes[] = $v['attributes']['size'];
            }
            if (!empty($v['attributes']['color']) && !in_array($v['attributes']['color'], $colors)) {
                $colors[] = $v['attributes']['color'];
            }
        }

        $this->view('dashboard.products.edit', [
            'pageTitle' => 'Edit Product - ' . sanitize($product['name']),
            'store' => $store,
            'product' => $product,
            'categories' => $categories,
            'images' => $images,
            'existingSizes' => implode(', ', $sizes),
            'existingColors' => implode(', ', $colors),
            'errors' => $_SESSION['flash_errors'] ?? [],
            'success' => $_SESSION['flash_success'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_errors'], $_SESSION['flash_success']);
    }

    public function update(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $productId = (int)$id;
        $imageFiles = $_FILES['images'] ?? [];
        $result = $this->productService->updateProduct($productId, $store['id'], $_POST, $imageFiles);

        if ($result['success']) {
            $_SESSION['flash_success'] = 'Product updated successfully!';
            redirect('/dashboard/products');
        } else {
            $_SESSION['flash_errors'] = $result['errors'];
            redirect('/dashboard/products/edit/' . $productId);
        }
    }

    public function delete(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $productId = (int)$id;
        $this->productModel->deleteForStore($productId, $store['id'], true);

        $_SESSION['flash_success'] = 'Product deleted successfully.';
        redirect('/dashboard/products');
    }
}
