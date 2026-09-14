<?php

namespace App\Core;

abstract class Controller {
    /**
     * Render HTML view.
     */
    protected function view(string $viewPath, array $data = [], ?string $layout = null): void {
        View::render($viewPath, $data, $layout);
    }

    /**
     * Return JSON response.
     */
    protected function json(array $data, int $statusCode = 200): void {
        Response::json($data, $statusCode);
    }

    /**
     * Return JSON success response.
     */
    protected function success(string $message = 'Success', array $data = [], int $statusCode = 200): void {
        Response::success($message, $data, $statusCode);
    }

    /**
     * Return JSON error response.
     */
    protected function error(string $message = 'Error', array $errors = [], int $statusCode = 400): void {
        Response::error($message, $errors, $statusCode);
    }
}
