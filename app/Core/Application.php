<?php

namespace App\Core;

class Application {
    private Router $router;
    private static Application $instance;

    public function __construct() {
        self::$instance = $this;
        $this->bootstrap();
        $this->router = new Router();
    }

    public static function getInstance(): Application {
        return self::$instance;
    }

    public function getRouter(): Router {
        return $this->router;
    }

    private function bootstrap(): void {
        // Load Environment
        load_env(__DIR__ . '/../../.env');

        // Set Timezone & Locale
        date_default_timezone_set(config('app.timezone', 'Asia/Dhaka'));

        // Error Handling
        if (config('app.debug')) {
            ini_set('display_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', '0');
            error_reporting(0);
        }

        // Session Setup
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_only_cookies', '1');
            if (config('security.session_secure')) {
                ini_set('session.cookie_secure', '1');
            }
            session_start();
        }
    }

    public function run(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->router->dispatch($method, $uri);
    }
}
