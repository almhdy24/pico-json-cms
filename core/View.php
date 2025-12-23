<?php
/**
 * Pico JSON CMS - View
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Handles template rendering with theme support and plugin hooks.
 *
 * License: MIT
 */

namespace Core;

use League\Plates\Engine;

class View {
    protected static $engine;

    public static function render($view, $data = []) {
        if (!self::$engine) {
            $config = App::$config;
            $themePath = App::path('themes', $config['theme']);
            self::$engine = new Engine($themePath);
        }
        Hooks::do_action('beforeRender', $view, $data);
        echo self::$engine->render($view, $data);
        Hooks::do_action('afterRender', $view, $data);
    }
}