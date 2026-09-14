<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\StoreService;
use App\Models\Store;
use App\Middleware\AuthMiddleware;
use App\Middleware\CSRFMiddleware;

class OnboardingController extends Controller {
    private StoreService $storeService;
    private Store $storeModel;

    public function __construct() {
        $this->storeService = new StoreService();
        $this->storeModel = new Store();
    }

    public function index(): void {
        AuthMiddleware::requireRole('merchant');
        $user = AuthService::user();

        // If user already owns a store, redirect directly to dashboard
        $existingStore = $this->storeModel->findByUserId($user['id']);
        if ($existingStore) {
            redirect('/dashboard');
        }

        $this->view('onboarding.wizard', [
            'pageTitle' => 'Store Setup Wizard - Nabrijan',
            'user' => $user,
            'errors' => $_SESSION['flash_errors'] ?? [],
            'old' => $_SESSION['flash_old'] ?? []
        ]);
        unset($_SESSION['flash_errors'], $_SESSION['flash_old']);
    }

    public function store(): void {
        AuthMiddleware::requireRole('merchant');
        CSRFMiddleware::handle();

        $user = AuthService::user();
        $data = [
            'name' => $_POST['business_name'] ?? '',
            'category' => $_POST['business_category'] ?? 'general',
            'slug' => $_POST['store_slug'] ?? '',
            'theme_id' => (int)($_POST['theme_id'] ?? 1),
            'dhaka_delivery_charge' => (float)($_POST['dhaka_delivery_charge'] ?? 60.00),
            'outside_dhaka_delivery_charge' => (float)($_POST['outside_dhaka_delivery_charge'] ?? 120.00)
        ];

        $result = $this->storeService->createStore($user['id'], $data);

        if ($result['success']) {
            $_SESSION['flash_success'] = 'Congratulations! Your store "' . sanitize($result['store']['name']) . '" is ready!';
            redirect('/dashboard');
        } else {
            $_SESSION['flash_errors'] = $result['errors'];
            $_SESSION['flash_old'] = $data;
            redirect('/onboarding');
        }
    }
}
