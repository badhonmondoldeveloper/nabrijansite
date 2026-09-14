<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;

class CategoryController extends Controller {
    private Category $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $categories = $this->categoryModel->allForStore($store['id']);

        $this->view('dashboard.categories.index', [
            'pageTitle' => 'Category Management - Nabrijan',
            'store' => $store,
            'categories' => $categories,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function store(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            $_SESSION['flash_error'] = 'Category Name is required.';
            redirect('/dashboard/categories');
        }

        $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(str_replace(' ', '-', $name)));
        if ($this->categoryModel->slugExistsForStore($slug, $store['id'])) {
            $slug .= '-' . rand(10, 99);
        }

        $this->categoryModel->create([
            'store_id' => $store['id'],
            'name' => $name,
            'slug' => $slug,
            'description' => trim($_POST['description'] ?? ''),
            'status' => 'active'
        ]);

        $_SESSION['flash_success'] = 'Category "' . sanitize($name) . '" created successfully!';
        redirect('/dashboard/categories');
    }

    public function delete(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $categoryId = (int)$id;
        $this->categoryModel->deleteForStore($categoryId, $store['id'], true);

        $_SESSION['flash_success'] = 'Category deleted successfully.';
        redirect('/dashboard/categories');
    }
}
