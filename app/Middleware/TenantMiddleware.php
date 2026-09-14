<?php

namespace App\Middleware;

use App\Services\AuthService;
use App\Models\Store;
use App\Core\Response;

class TenantMiddleware {
    /**
     * Ensure current merchant has an active store session.
     */
    public static function handle(): ?array {
        if (!AuthMiddleware::requireRole('merchant', 'super_admin', 'admin')) {
            return null;
        }

        $user = AuthService::user();
        $storeModel = new Store();
        $store = $storeModel->findByUserId($user['id']);

        if (!$store) {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                Response::error('No store found for this account. Please complete merchant onboarding.', [], 404);
            } else {
                redirect('/onboarding');
            }
            return null;
        }

        if ($store['status'] === 'suspended') {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                Response::error('Your store has been suspended by administration.', [], 403);
            } else {
                http_response_code(403);
                die('403 Forbidden: Your store has been suspended.');
            }
            return null;
        }

        $_SESSION['store_id'] = $store['id'];
        $_SESSION['store_slug'] = $store['slug'];
        $_SESSION['store_name'] = $store['name'];

        return $store;
    }
}
