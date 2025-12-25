<?php

declare(strict_types=1);

namespace Core;

/**
 * ------------------------------------------------------
 * Pico JSON CMS — Hooks System (CORE)
 * ------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 *
 * Responsibilities:
 *  - Register and execute actions
 *  - Register and apply filters
 *
 * ⚠️ CORE FREEZE FILE
 * Hook semantics MUST remain stable
 * ------------------------------------------------------
 */

final class Hooks
{
    /**
     * Action hooks
     */
    private static array $actions = [];

    /**
     * Filter hooks
     */
    private static array $filters = [];

    /* =====================================================
     * Actions
     * ===================================================== */

    public static function add_action(string $hook, callable $callback): void
    {
        self::$actions[$hook][] = $callback;
    }

    public static function do_action(string $hook, mixed ...$args): void
    {
        if (empty(self::$actions[$hook])) {
            return;
        }

        foreach (self::$actions[$hook] as $callback) {
            $callback(...$args);
        }
    }

    /* =====================================================
     * Filters
     * ===================================================== */

    public static function add_filter(string $hook, callable $callback): void
    {
        self::$filters[$hook][] = $callback;
    }

    public static function apply_filters(
        string $hook,
        mixed $value,
        mixed ...$args
    ): mixed {
        if (empty(self::$filters[$hook])) {
            return $value;
        }

        foreach (self::$filters[$hook] as $callback) {
            $value = $callback($value, ...$args);
        }

        return $value;
    }
}