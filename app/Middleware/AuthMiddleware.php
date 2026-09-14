<?php

namespace App\Middleware;

use App\Services\AuthService;
use App\Core\Response;

class AuthMiddleware {
    /**
     * Require authenticated session.
     */
    public static function requireAuth(): bool {
        if (!AuthService::check()) {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                Response::error('Unauthenticated.', [], 401);
            } else {
                redirect('/login');
            }
            return false;
        }
        return true;
    }

    /**
     * Require specified role (e.g. merchant, super_admin).
     */
    public static function requireRole(string ...$roles): bool {
        if (!self::requireAuth()) {
            return false;
        }

        $user = AuthService::user();
        if (!in_array($user['role'], $roles)) {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                Response::error('Unauthorized role access.', [], 403);
            } else {
                http_response_code(403);
                die('403 Forbidden: You do not have permission to access this area.');
            }
            return false;
        }
        return true;
    }
}
