<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AnalyticsService;
use App\Middleware\TenantMiddleware;

class AnalyticsController extends Controller {
    private AnalyticsService $analyticsService;

    public function __construct() {
        $this->analyticsService = new AnalyticsService();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $metrics = $this->analyticsService->getStoreMetrics($store['id']);

        $this->view('dashboard.analytics', [
            'pageTitle' => 'Store Analytics - ' . sanitize($store['name']),
            'store' => $store,
            'metrics' => $metrics
        ], 'dashboard.layout');
    }
}
