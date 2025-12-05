<?php
namespace Core;

class Router
{
    public function dispatch(): void
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $segments = $uri === '' ? [] : explode('/', $uri);

        // Default controller
        $controllerName = $segments[0] ?? 'home';
        $method = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        // Special route: /post/{slug}
        if ($controllerName === 'post' && isset($segments[1])) {
            $controllerClass = "Controllers\\HomeController";
            $method = 'viewPost';
            $params = [$segments[1]]; // slug as string
        } else {
            $controllerClass = "Controllers\\" . ucfirst($controllerName) . "Controller";
        }

        // Controller existence check
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            die('Controller not found');
        }

        $controller = new $controllerClass();

        // Method existence check
        if (!method_exists($controller, $method)) {
            http_response_code(404);
            die('Method not found');
        }

        // Call method with params
        call_user_func_array([$controller, $method], $params);
    }
}