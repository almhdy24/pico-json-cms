<?php
/**
 * Pico JSON CMS - Application Entry Point
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Main entry point for the application, bootstraps autoloading and runs the app.
 *
 * License: MIT
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/functions.php';

\Core\App::run();