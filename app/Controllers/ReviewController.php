<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Review;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;

class ReviewController extends Controller {
    private Review $reviewModel;

    public function __construct() {
        $this->reviewModel = new Review();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $reviews = $this->reviewModel->getForStore($store['id']);

        $this->view('dashboard.reviews.index', [
            'pageTitle' => 'Product Reviews Moderation - Nabrijan',
            'store' => $store,
            'reviews' => $reviews,
            'success' => $_SESSION['flash_success'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success']);
    }

    public function updateStatus(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $reviewId = (int)$id;
        $status = $_POST['status'] ?? 'approved';

        $stmt = $this->reviewModel->getDb()->prepare("UPDATE reviews SET status = ? WHERE id = ? AND store_id = ?");
        $stmt->execute([$status, $reviewId, $store['id']]);

        $_SESSION['flash_success'] = 'Review status updated to ' . sanitize($status) . '.';
        redirect('/dashboard/reviews');
    }
}
