<?php

// Require Global Helper Functions
require_once __DIR__ . '/../app/Helpers/Functions.php';

// PSR-4 Autoloader for App\ namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Initialize Application
$app = new App\Core\Application();
$router = $app->getRouter();

// Health Check API Route
$router->get('/api/v1/health', [\App\Controllers\Api\V1\HealthApiController::class, 'index']);

// Auth Web Routes
$router->get('/login', [\App\Controllers\AuthController::class, 'showLogin']);
$router->post('/login', [\App\Controllers\AuthController::class, 'handleLogin']);
$router->get('/register', [\App\Controllers\AuthController::class, 'showRegister']);
$router->post('/register', [\App\Controllers\AuthController::class, 'handleRegister']);
$router->get('/forgot-password', [\App\Controllers\AuthController::class, 'showForgotPassword']);
$router->post('/forgot-password', [\App\Controllers\AuthController::class, 'handleForgotPassword']);
$router->get('/logout', [\App\Controllers\AuthController::class, 'logout']);
$router->post('/logout', [\App\Controllers\AuthController::class, 'logout']);

// Onboarding & Merchant Dashboard Web Routes
$router->get('/onboarding', [\App\Controllers\OnboardingController::class, 'index']);
$router->post('/onboarding', [\App\Controllers\OnboardingController::class, 'store']);
$router->get('/dashboard', [\App\Controllers\DashboardController::class, 'index']);

// Super Admin Web Routes
$router->get('/admin', [\App\Controllers\AdminController::class, 'dashboard']);
$router->get('/admin/stores', [\App\Controllers\AdminController::class, 'stores']);
$router->post('/admin/stores/{id}/status', [\App\Controllers\AdminController::class, 'updateStoreStatus']);
$router->get('/admin/users', [\App\Controllers\AdminController::class, 'users']);
$router->post('/admin/users/{id}/status', [\App\Controllers\AdminController::class, 'updateUserStatus']);
$router->get('/admin/plans', [\App\Controllers\AdminController::class, 'plans']);
$router->get('/admin/settings', [\App\Controllers\AdminController::class, 'settings']);
$router->post('/admin/settings/payment', [\App\Controllers\AdminController::class, 'updateSettings']);
$router->get('/admin/subscription-payments', [\App\Controllers\AdminController::class, 'subscriptionPayments']);
$router->post('/admin/subscription-payments/{id}/approve', [\App\Controllers\AdminController::class, 'approveSubscriptionPayment']);
$router->post('/admin/subscription-payments/{id}/reject', [\App\Controllers\AdminController::class, 'rejectSubscriptionPayment']);

// Category Web Routes
$router->get('/dashboard/categories', [\App\Controllers\CategoryController::class, 'index']);
$router->post('/dashboard/categories', [\App\Controllers\CategoryController::class, 'store']);
$router->post('/dashboard/categories/delete/{id}', [\App\Controllers\CategoryController::class, 'delete']);

// Product Web Routes
$router->get('/dashboard/products', [\App\Controllers\ProductController::class, 'index']);
$router->get('/dashboard/products/create', [\App\Controllers\ProductController::class, 'create']);
$router->post('/dashboard/products/create', [\App\Controllers\ProductController::class, 'store']);
$router->get('/dashboard/products/edit/{id}', [\App\Controllers\ProductController::class, 'edit']);
$router->post('/dashboard/products/edit/{id}', [\App\Controllers\ProductController::class, 'update']);
$router->post('/dashboard/products/delete/{id}', [\App\Controllers\ProductController::class, 'delete']);

// Merchant Order Management Web Routes
$router->get('/dashboard/orders', [\App\Controllers\OrderController::class, 'index']);
$router->get('/dashboard/orders/{id}', [\App\Controllers\OrderController::class, 'show']);
$router->post('/dashboard/orders/{id}/status', [\App\Controllers\OrderController::class, 'updateStatus']);

// Merchant Store Settings & Payment Methods Routes
$router->get('/dashboard/payment-methods', [\App\Controllers\StoreSettingController::class, 'paymentMethods']);
$router->post('/dashboard/payment-methods', [\App\Controllers\StoreSettingController::class, 'updatePaymentMethods']);

// Merchant Marketing & Customer Management Routes
$router->get('/dashboard/coupons', [\App\Controllers\CouponController::class, 'index']);
$router->post('/dashboard/coupons', [\App\Controllers\CouponController::class, 'store']);
$router->get('/dashboard/reviews', [\App\Controllers\ReviewController::class, 'index']);
$router->post('/dashboard/reviews/{id}/status', [\App\Controllers\ReviewController::class, 'updateStatus']);
$router->get('/dashboard/customers', [\App\Controllers\CustomerController::class, 'index']);

// Analytics, Notifications & Subscriptions Web Routes
$router->get('/dashboard/analytics', [\App\Controllers\AnalyticsController::class, 'index']);
$router->get('/dashboard/notifications', [\App\Controllers\NotificationController::class, 'index']);
$router->post('/dashboard/notifications/mark-read/{id}', [\App\Controllers\NotificationController::class, 'markRead']);
$router->get('/dashboard/subscription', [\App\Controllers\SubscriptionController::class, 'index']);
$router->post('/dashboard/subscription/upgrade', [\App\Controllers\SubscriptionController::class, 'submitUpgrade']);

// Theme Customizer Web Routes
$router->get('/dashboard/customize-theme', [\App\Controllers\ThemeCustomizerController::class, 'index']);
$router->post('/dashboard/customize-theme', [\App\Controllers\ThemeCustomizerController::class, 'update']);

// Storefront Cart & Checkout Web Routes
$router->get('/store/{slug}/cart', [\App\Controllers\CartController::class, 'viewCart']);
$router->post('/store/{slug}/cart/add', [\App\Controllers\CartController::class, 'add']);
$router->post('/store/{slug}/cart/update', [\App\Controllers\CartController::class, 'update']);
$router->post('/store/{slug}/cart/remove', [\App\Controllers\CartController::class, 'remove']);
$router->get('/store/{slug}/cart/count', [\App\Controllers\CartController::class, 'count']);
$router->get('/store/{slug}/cart/data', [\App\Controllers\CartController::class, 'data']);

$router->get('/store/{slug}/checkout', [\App\Controllers\CheckoutController::class, 'showCheckout']);
$router->post('/store/{slug}/checkout', [\App\Controllers\CheckoutController::class, 'processCheckout']);
$router->get('/store/{slug}/order-success/{id}', [\App\Controllers\CheckoutController::class, 'showSuccess']);

// Storefront Tenant Web Routes
$router->get('/store/{slug}', [\App\Controllers\StorefrontController::class, 'index']);
$router->get('/store/{slug}/category/{categorySlug}', [\App\Controllers\StorefrontController::class, 'category']);
$router->get('/store/{slug}/product/{productSlug}', [\App\Controllers\StorefrontController::class, 'product']);

// Subdomain / Domain Root Route Handler
$router->get('/', function() {
    $resolver = new \App\Services\StoreResolver();
    $tenant = $resolver->resolve();
    if ($tenant) {
        (new \App\Controllers\StorefrontController())->index($tenant['slug']);
    } else {
        \App\Core\View::render('saas.home');
    }
});

// Auth REST API Routes
$router->post('/api/v1/auth/login', [\App\Controllers\Api\V1\AuthApiController::class, 'login']);
$router->post('/api/v1/auth/register', [\App\Controllers\Api\V1\AuthApiController::class, 'register']);
$router->get('/api/v1/auth/me', [\App\Controllers\Api\V1\AuthApiController::class, 'me']);
$router->post('/api/v1/auth/logout', [\App\Controllers\Api\V1\AuthApiController::class, 'logout']);

// Product REST API Routes
$router->get('/api/v1/products', [\App\Controllers\Api\V1\ProductApiController::class, 'index']);
$router->get('/api/v1/products/{id}', [\App\Controllers\Api\V1\ProductApiController::class, 'show']);
$router->post('/api/v1/products', [\App\Controllers\Api\V1\ProductApiController::class, 'store']);
$router->delete('/api/v1/products/{id}', [\App\Controllers\Api\V1\ProductApiController::class, 'destroy']);

// Run Application
$app->run();
