<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Notification;
use App\Services\AuthService;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;

class NotificationController extends Controller {
    private Notification $notificationModel;

    public function __construct() {
        $this->notificationModel = new Notification();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $user = AuthService::user();
        $notifications = $this->notificationModel->getForUserAndStore($user['id'], $store['id']);

        $this->view('dashboard.notifications', [
            'pageTitle' => 'Notifications Center - Nabrijan',
            'store' => $store,
            'notifications' => $notifications
        ], 'dashboard.layout');
    }

    public function markRead(string $id): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $user = AuthService::user();
        $this->notificationModel->markAsRead((int)$id, $user['id']);

        redirect('/dashboard/notifications');
    }
}
