<?php

/**
 * Load environment variables from .env file into $_ENV array.
 */
function load_env(string $filePath): void {
    if (!file_exists($filePath)) {
        return;
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (str_starts_with($line, '#') || empty($line)) {
            continue;
        }
        if (str_contains($line, '=')) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }
}

/**
 * Get configuration setting value.
 */
function config(string $key, $default = null) {
    static $configs = [];
    $parts = explode('.', $key);
    $file = $parts[0];

    if (!isset($configs[$file])) {
        $path = __DIR__ . '/../../config/' . $file . '.php';
        if (file_exists($path)) {
            $configs[$file] = require $path;
        } else {
            $configs[$file] = [];
        }
    }

    $current = $configs[$file];
    for ($i = 1; $i < count($parts); $i++) {
        if (!isset($current[$parts[$i]])) {
            return $default;
        }
        $current = $current[$parts[$i]];
    }

    return $current;
}

/**
 * Escape HTML output to prevent XSS.
 */
function sanitize(?string $value): string {
    if ($value === null) {
        return '';
    }
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Format currency in Bangladeshi Taka (BDT / ৳).
 */
function format_bdt(float $amount): string {
    return '৳' . number_format($amount, 2, '.', ',');
}

/**
 * Generate full URL.
 */
function url(string $path = ''): string {
    $baseUrl = rtrim(config('app.url'), '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

/**
 * Redirect to path.
 */
function redirect(string $path): void {
    header('Location: ' . url($path));
    exit;
}

/**
 * Generate or get current CSRF token.
 */
function csrf_token(): string {
    return \App\Helpers\Security::generateCsrfToken();
}
