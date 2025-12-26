<?php

declare(strict_types=1);

namespace Core;

/**
 * ------------------------------------------------------
 * Pico JSON CMS — Base Controller (CORE)
 * ------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 *
 * Responsibilities:
 *  - Provide view rendering helpers
 *  - Provide model loading
 *  - Provide request & session helpers
 *
 * ⚠️ CORE FREEZE FILE
 * Public methods MUST NOT change after v1.0.0
 * ------------------------------------------------------
 */

abstract class Controller
{
    /**
     * Controller constructor
     * Session is guaranteed to be available
     */
    public function __construct()
    {
        Session::start();
    }

    /* =====================================================
     * View / Model
     * ===================================================== */

    /**
     * Render a view
     */
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    /**
     * Load a model by name
     */
    protected function model(string $model): object
{
    // If fully-qualified class name is given
    if (str_contains($model, '\\')) {
        $class = $model;
    } else {
        // Short name → assume Models namespace
        $class = 'Models\\' . $model;
    }

    if (!class_exists($class)) {
        throw new \RuntimeException("Model not found: {$class}");
    }

    return new $class();
}

    /* =====================================================
     * Session Helpers
     * ===================================================== */

    /**
     * Flash a message to the session
     */
    protected function flash(string $type, string $message): void
    {
        Session::flash($type, $message);
    }

    /**
     * Retrieve and clear flash messages
     */
    protected function getFlash(): array
    {
        return Session::getFlash();
    }

    /* =====================================================
     * Request Helpers
     * ===================================================== */

    /**
     * Check if request method is POST
     */
    protected function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    /**
     * Retrieve input value from POST or GET
     */
    protected function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key]
            ?? $_GET[$key]
            ?? $default;
    }

    /**
     * Redirect and terminate execution
     */
    protected function redirect(string $path): never
    {
        header("Location: {$path}");
        exit;
    }

    /**
     * Escape output safely
     */
    protected function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}