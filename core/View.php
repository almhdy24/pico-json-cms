<?php

declare(strict_types=1);

namespace Core;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * ------------------------------------------------------
 * Pico JSON CMS — View Renderer (CORE)
 * ------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 *
 * Responsibilities:
 *  - Initialize template engine
 *  - Render views
 *  - Expose safe template helpers
 *
 * ⚠️ CORE FREEZE FILE
 * Rendering behavior MUST remain stable
 * ------------------------------------------------------
 */

final class View
{
    /**
     * Plates engine instance
     */
    private static ?Engine $engine = null;

    /**
     * Initialize and return template engine
     */
    private static function engine(): Engine
    {
        if (self::$engine !== null) {
            return self::$engine;
        }

        $config = App::$config;
        $theme  = $config['theme'] ?? 'default';

        $themePath = App::path('themes', $theme);

        if (!is_dir($themePath)) {
            throw new \RuntimeException("Theme not found: {$theme}");
        }

        self::$engine = new Engine($themePath);

        // Global shared data
        self::$engine->addData([
            'config' => $config,
            'flash'  => Session::getFlash(),
        ]);
         
        // Pico extension
        self::$engine->loadExtension(new class implements ExtensionInterface {

            public function register(Engine $engine): void
            {
                // Hooks
                $engine->registerFunction('hook', function (string $name, ...$args) {
                    Hooks::do_action($name, ...$args);
                });

                // Filters
                $engine->registerFunction('filter', function (
                    string $name,
                    mixed $value,
                    ...$args
                ) {
                    return apply_filters($name, $value, ...$args);
                });

                // Asset helper
                $engine->registerFunction('asset', function (string $path) {
                    return rtrim(App::$config['base_url'], '/')
                        . '/' . ltrim($path, '/');
                });

                // Route helper
                $engine->registerFunction('route', function (string $path) {
                    return rtrim(App::$config['base_url'], '/')
                        . $path;
                });

                // CSRF field
                $engine->registerFunction('csrf', function () {
                    return '<input type="hidden" name="csrf" value="'
                        . csrf_token() . '">';
                });

                // Admin flag
                $engine->registerFunction('is_admin', function () {
                    return defined('IS_ADMIN') && IS_ADMIN;
                });
            }
        });

        return self::$engine;
    }

    /**
     * Render a view
     */
    public static function render(string $view, array $data = []): void
    {
        Hooks::do_action('beforeRender', $view, $data);

        echo self::engine()->render($view, $data);

        Hooks::do_action('afterRender', $view, $data);
    }

    /**
     * Share data globally with all views
     */
    public static function share(array $data): void
    {
        self::engine()->addData($data);
    }
}