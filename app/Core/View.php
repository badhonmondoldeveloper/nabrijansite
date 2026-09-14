<?php

namespace App\Core;

class View {
    /**
     * Render view template.
     */
    public static function render(string $viewPath, array $data = [], ?string $layout = null): void {
        extract($data);
        $file = __DIR__ . '/../../views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($file)) {
            if (config('app.debug')) {
                die("View file not found: {$file}");
            } else {
                http_response_code(404);
                require __DIR__ . '/../../views/errors/404.php';
                exit;
            }
        }

        if ($layout) {
            ob_start();
            require $file;
            $content = ob_get_clean();
            $layoutFile = __DIR__ . '/../../views/' . str_replace('.', '/', $layout) . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            require $file;
        }
    }
}
