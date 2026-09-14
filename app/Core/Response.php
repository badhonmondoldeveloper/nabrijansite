<?php

namespace App\Core;

class Response {
    /**
     * Send JSON Response.
     */
    public static function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Send JSON Success Response.
     */
    public static function success(string $message = 'Success', array $data = [], int $statusCode = 200): void {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send JSON Error Response.
     */
    public static function error(string $message = 'Error', array $errors = [], int $statusCode = 400): void {
        self::json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }
}
