<?php
/**
 * Pico JSON CMS - App
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Main application class handling configuration, plugin loading, and bootstrapping.
 *
 * License: MIT
 */

namespace Core;

class App {
    public static $config;
    public static $plugins = [];

    public static function run() {
        // Use __DIR__ to get the absolute path to config.php
        $configPath = __DIR__ . '/../config.php';
        if (!file_exists($configPath)) {
            die("Config file not found at: $configPath");
        }
        self::$config = require $configPath;
        self::loadPlugins();
        $router = new Router();
        $router->dispatch();
    }

    private static function loadPlugins() {
        foreach(self::$config['plugins'] as $plugin) {
            $file = __DIR__ . "/../plugins/$plugin";
            if(file_exists($file)) {
                require_once $file;
            } else {
                // Log missing plugin
                error_log("Plugin not found: $file");
            }
        }
    }
}