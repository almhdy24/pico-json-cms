<?php
/**
 * Pico JSON CMS - Hooks
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Plugin hook system supporting actions and filters for extensibility.
 *
 * License: MIT
 */

namespace Core;

class Hooks {
    private static $actions = [];
    private static $filters = [];

    public static function add_action($hook, $callback) {
        if(!isset(self::$actions[$hook])) self::$actions[$hook] = [];
        self::$actions[$hook][] = $callback;
    }

    public static function do_action($hook, ...$args) {
        if(isset(self::$actions[$hook])) {
            foreach(self::$actions[$hook] as $callback) {
                call_user_func_array($callback, $args);
            }
        }
    }

    // Filters allow modifying a value
    public static function add_filter($hook, $callback) {
        if(!isset(self::$filters[$hook])) self::$filters[$hook] = [];
        self::$filters[$hook][] = $callback;
    }

    public static function apply_filters($hook, $value, ...$args) {
        if(isset(self::$filters[$hook])) {
            foreach(self::$filters[$hook] as $callback) {
                $value = call_user_func_array($callback, array_merge([$value], $args));
            }
        }
        return $value;
    }
}