<?php

namespace App\Middleware;

use App\Helpers\Security;
use App\Core\Response;

class CSRFMiddleware {
    public static function handle(): bool {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
            $token = $_POST['_csrf_token'] ?? $_POST['csrf_token'] ?? $_REQUEST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_SERVER['HTTP_X_XSRF_TOKEN'] ?? null;
            
            if (!Security::verifyCsrfToken($token)) {
                if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                    Response::error('CSRF token validation failed.', [], 403);
                    return false;
                } else {
                    // Regenerate fresh CSRF token for next attempt
                    Security::generateCsrfToken();
                    $_SESSION['flash_error'] = 'Security session refreshed. Please submit the form again.';
                    
                    $referer = $_SERVER['HTTP_REFERER'] ?? '/';
                    header('Location: ' . $referer);
                    exit;
                }
            }
        }
        return true;
    }
}
