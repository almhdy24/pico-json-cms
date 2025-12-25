<?php

declare(strict_types=1);

namespace Core;

/**
 * ------------------------------------------------------------------
 * Pico JSON CMS — Application Core
 * ------------------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 * MINIMUM PHP:  8.1
 *
 * ⚠️ CORE FREEZE FILE
 * This file defines the runtime behavior of the CMS.
 * Breaking changes are NOT allowed after v1.0.0.
 * ------------------------------------------------------------------
 */

defined('BASE_PATH') || define(
    'BASE_PATH',
    realpath(__DIR__ . '/..')
);

final class App
{
    /* =====================================================
     * Core Metadata
     * ===================================================== */

    public const CORE_VERSION     = '1.0.0';
    public const MIN_PHP_VERSION  = '8.1.0';

    /* =====================================================
     * Runtime State
     * ===================================================== */

    public static array $config  = [];
    public static array $plugins = [];

    /* =====================================================
     * Event System (Middleware Layer)
     * ===================================================== */

    private static array $events = [];

    public static function on(string $event, callable $listener): void
    {
        self::$events[$event][] = $listener;
    }

    public static function trigger(string $event, array $payload = []): void
    {
        if (!empty(self::$events[$event])) {
            foreach (self::$events[$event] as $listener) {
                $listener($payload);
            }
        }
    }

    /* =====================================================
     * Path Helper
     * ===================================================== */

    public static function path(string ...$segments): string
    {
        return preg_replace(
            '#/+#',
            DIRECTORY_SEPARATOR,
            BASE_PATH . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $segments)
        );
    }

    /* =====================================================
     * Application Lifecycle
     * ===================================================== */

    public static function run(): void
    {
        self::trigger('beforeRun');

        self::sendSecurityHeaders();
        Session::start();

        self::bootstrap();
        self::loadConfig();
        self::loadPlugins();
        self::guardInstaller();

        self::trigger('beforeDispatch');

        self::dispatch();
    }

    /* =====================================================
     * Bootstrap
     * ===================================================== */

    private static function bootstrap(): void
    {
        self::ensureDirectories();
        self::ensureFiles();
    }

    /* =====================================================
     * Filesystem
     * ===================================================== */

    private static function ensureDirectories(): void
    {
        self::ensureDir(self::path('content'));
        self::ensureDir(self::path('logs'));
    }

    private static function ensureFiles(): void
    {
        self::ensureFile('content/posts.json', '[]');
        self::ensureFile('content/settings.json', '{}');
    }

    private static function ensureDir(string $path): void
    {
        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true) && !is_dir($path)) {
                throw new \RuntimeException("Failed to create directory: {$path}");
            }
        }
    }

    private static function ensureFile(string $relativePath, string $default): void
    {
        $path = self::path($relativePath);

        if (!file_exists($path)) {
            file_put_contents($path, $default, LOCK_EX);
        }
    }

    /* =====================================================
     * Configuration
     * ===================================================== */

    private static function loadConfig(): void
    {
        $configPath = self::path('config.php');

        if (!file_exists($configPath)) {
            throw new \RuntimeException("Config file missing: {$configPath}");
        }

        self::$config = require $configPath;

        if (!is_array(self::$config)) {
            throw new \RuntimeException("Invalid config format");
        }

        self::$config['base_url'] ??= '';
        self::$config['theme']    ??= 'default';
    }

    /* =====================================================
     * Plugin System (Manifest ONLY)
     * ===================================================== */

    private static function loadPlugins(): void
    {
        $loader = new PluginLoader(self::path('plugins'));
        self::$plugins = $loader->load();
    }

    /* =====================================================
     * Routing
     * ===================================================== */

    private static function dispatch(): void
    {
        (new Router())->dispatch();
    }

    /* =====================================================
     * Installer Guard
     * ===================================================== */

    private static function guardInstaller(): void
    {
        $installed = file_exists(self::path('content', '.installed'));
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        if (
            str_starts_with($uri, '/themes/') ||
            str_starts_with($uri, '/assets/')
        ) {
            return;
        }

        if (!$installed && !str_starts_with($uri, '/installer')) {
            header('Location: /installer');
            exit;
        }

        if ($installed && str_starts_with($uri, '/installer')) {
            header('Location: /');
            exit;
        }
    }

    /* =====================================================
     * Logging
     * ===================================================== */

    public static function log(string $message, string $level = 'info'): void
    {
        file_put_contents(
            self::path('logs', 'app.log'),
            '[' . date('c') . "][{$level}] {$message}\n",
            FILE_APPEND | LOCK_EX
        );
    }

    /* =====================================================
     * Security
     * ===================================================== */

    private static function sendSecurityHeaders(): void
    {
        if (headers_sent()) return;

        header('X-Frame-Options: DENY');
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}