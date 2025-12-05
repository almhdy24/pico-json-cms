<?php
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