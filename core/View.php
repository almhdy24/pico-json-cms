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

class View {
    public static function render($view, $data = []) {
        extract($data);
        $config = App::$config;
        $theme = __DIR__ . "/../themes/{$config['theme']}/$view.php";

        // Allow plugins to hook before render
        Hooks::do_action('beforeRender', $view, $data);

        if(file_exists($theme)) {
            include $theme;
        } else {
            echo "View not found";
        }

        Hooks::do_action('afterRender', $view, $data);
    }
}