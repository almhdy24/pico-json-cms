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
define('BASE_PATH', realpath(__DIR__ . '/..'));


class App {
  public static $config;
  public static $plugins = [];

  public static function path(...$segments) {
    return preg_replace('#/+#', '/', join(DIRECTORY_SEPARATOR, array_merge([BASE_PATH], $segments)));
  }

  private static function initialize() {
    $contentDir = self::path('content');
    $logDir = self::path('logs');

    // Ensure dirs
    if (!is_dir($contentDir)) {
      mkdir($contentDir, 0777, true);
      self::logSetup("Created content directory");
    }
    if (!is_dir($logDir)) {
      mkdir($logDir, 0777, true);
      self::logSetup("Created logs directory");
    }

    // Ensure files
    $defaultFiles = [
      'posts.json' => '[]',
      'settings.json' => '{}'
    ];
    foreach ($defaultFiles as $file => $defaultContents) {
      $filePath = self::path('content', $file);
      if (!file_exists($filePath)) {
        file_put_contents($filePath, $defaultContents);
        self::logSetup("Created $file");
      }
    }
  }

  private static function logSetup($msg) {
    $logPath = self::path('logs', 'setup.log');
    $timestamp = date('c');
    file_put_contents($logPath, "[$timestamp] $msg\n", FILE_APPEND);
  }
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
    foreach (self::$config['plugins'] as $plugin) {
      $file = self::path('plugins', $plugin);
      if (file_exists($file)) {
        require_once $file;
      } else {
        // Log missing plugin
        error_log("Plugin not found: $file");
      }
    }
  }
}