<?php

/**
 * Load environment variables from .env file into $_ENV array.
 */
function load_env(string $filePath): void {
    $possiblePaths = [
        $filePath,
        dirname(__DIR__, 2) . '/.env',
        dirname(__DIR__, 3) . '/.env',
        dirname(__DIR__, 1) . '/.env',
        ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/.env',
        ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/../.env'
    ];

    $targetFile = null;
    foreach ($possiblePaths as $path) {
        if (!empty($path) && file_exists($path) && is_readable($path)) {
            $targetFile = $path;
            break;
        }
    }

    if (!$targetFile) {
        return;
    }

    $lines = file($targetFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (str_starts_with($line, '#') || empty($line)) {
            continue;
        }
        if (str_contains($line, '=')) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if ($value !== '') {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }
}

/**
 * Get environment variable value with fallback.
 */
function env(string $key, $default = null) {
    $val = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    if ($val === false || $val === null || $val === '') {
        return $default;
    }
    return $val;
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
