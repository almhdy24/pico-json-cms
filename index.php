<?php

declare(strict_types=1);

/**
 * Pico JSON CMS - Application Entry Point
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 *
 * License: MIT
 */

/* =====================================================
 * PHP Version Guard
 * ===================================================== */

$minPhp = '8.1.0';

if (version_compare(PHP_VERSION, $minPhp, '<')) {
    http_response_code(500);
    echo "Pico JSON CMS requires PHP {$minPhp} or higher. "
       . "Current version: " . PHP_VERSION;
    exit;
}

use Core\App;

/* =====================================================
 * Error Reporting
 * ===================================================== */

$debug = true; // move to config later

error_reporting(E_ALL);

if ($debug) {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

/* =====================================================
 * Bootstrap
 * ===================================================== */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/functions.php';

/* =====================================================
 * Run Application
 * ===================================================== */

try {
    App::run();

    // Disable Kint disk usage (dev helper)
    \Kint\Renderer\RichRenderer::$folder = false;

} catch (Throwable $e) {
    http_response_code(500);
    echo $e;
}