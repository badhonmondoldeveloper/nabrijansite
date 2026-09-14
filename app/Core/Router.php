<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, $handler): void {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, $handler): void {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, $handler): void {
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_\-]+)', $path);
        $regex = '#^' . $regex . '$#';
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'regex' => $regex,
            'handler' => $handler
        ];
    }

    public function dispatch(string $requestMethod, string $requestUri): void {
        $uri = parse_url($requestUri, PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }

        // Support _method override for forms (PUT, DELETE)
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['regex'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                $handler = $route['handler'];
                if (is_callable($handler)) {
                    call_user_func_array($handler, $params);
                    return;
                }

                if (is_array($handler) && count($handler) === 2) {
                    list($controllerClass, $method) = $handler;
                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $method)) {
                            call_user_func_array([$controller, $method], $params);
                            return;
                        }
                    }
                }
            }
        }

        // 404 Not Found
        http_response_code(404);
        if (str_starts_with($uri, '/api/')) {
            Response::error('Endpoint not found', [], 404);
        } else {
            View::render('errors.404');
        }
    }
}
