<?php
/**
* Pico JSON CMS - Router
*
* Author: Elmahdi
* GitHub: https://github.com/almhdy24/pico-json-cms
* Description:
*   Handles URL routing and request dispatching to appropriate controllers and methods.
*
* License: MIT
*/

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
      \Core\View::render('404', ['message' => 'Controller not found']);
      exit();
    }
    $controller = new $controllerClass();

    // Method existence check
    if (!method_exists($controller, $method)) {
    http_response_code(404);
    \Core\View::render('404', ['message' => 'Method not found']);
    exit();
}

    // Call method with params
    call_user_func_array([$controller, $method], $params);
  }
}