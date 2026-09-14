<?php

namespace App\Middleware;

use App\Helpers\Security;
use App\Core\Response;

class CSRFMiddleware {
    public static function handle(): bool {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
            $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!Security::verifyCsrfToken($token)) {
                if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                    Response::error('CSRF token validation failed.', [], 403);
                } else {
                    http_response_code(403);
                    die('403 Forbidden: Invalid CSRF Token.');
                }
                return false;
            }
        }
        return true;
    }
}
