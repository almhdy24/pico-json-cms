<?php

declare(strict_types=1);

namespace Core;

use Core\View;
use Core\App;
use Core\Container;

/**
 * ------------------------------------------------------
 * Pico JSON CMS — Router (CORE)
 * ------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 *
 * Responsibilities:
 *  - Parse request URI
 *  - Resolve controller & method
 *  - Dispatch request
 *  - Handle 404 errors
 *
 * ⚠️ CORE FREEZE FILE
 * Behavior MUST remain stable after v1.0.0
 * ------------------------------------------------------
 */

final class Router
{
    /**
     * Render a 404 error page and terminate
     */
    private function show404(string $message = 'Page not found'): void
    {
        http_response_code(404);
        View::render('pages/404', [
            'message' => $message
        ]);
        exit;
    }

    /**
     * Dispatch the current HTTP request
     */
    public function dispatch(): void
    {
        // Normalize URI
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri  = trim($path ?? '', '/');

        // Split into segments
        $segments = $uri === '' ? [] : explode('/', $uri);

        /**
         * Default routing
         * /              → HomeController@index
         * /admin         → AdminController@index
         * /admin/edit/1  → AdminController@edit(1)
         */
        $controllerName = $segments[0] ?? 'home';
        $method         = $segments[1] ?? 'index';
        $params         = array_slice($segments, 2);

        /**
         * Special route
         * /post/{slug}
         */
        if ($controllerName === 'post' && isset($segments[1])) {
            $controllerClass = 'Controllers\\HomeController';
            $method          = 'viewPost';
            $params          = [$segments[1]];
        } else {
            $controllerClass = 'Controllers\\' . ucfirst($controllerName) . 'Controller';
        }

        /**
         * Fire routing event
         */
        App::trigger('beforeController', [
            'controller' => $controllerClass,
            'method'     => $method,
            'params'     => $params
        ]);

        /**
         * Controller existence check
         */
        if (!class_exists($controllerClass)) {
            $this->show404('Controller not found');
        }

        /**
         * Controller instantiation
         * (container override allowed)
         */
        if (Container::has($controllerClass)) {
            $controller = Container::get($controllerClass);
        } else {
            $controller = new $controllerClass();
        }

        /**
         * Method validation
         */
        if (!is_callable([$controller, $method])) {
            $this->show404('Method not found');
        }

        /**
         * Dispatch controller method
         */
        call_user_func_array([$controller, $method], $params);
    }
}