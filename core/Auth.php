<?php

declare(strict_types=1);

namespace Core;

/**
 * ------------------------------------------------------
 * Pico JSON CMS — Authentication (CORE)
 * ------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 *
 * Responsibilities:
 *  - Admin authentication state
 *  - Login / logout handling
 *  - Access guarding
 *
 * ⚠️ CORE FREEZE FILE
 * Authentication mechanism MAY evolve internally,
 * but public API MUST remain stable.
 * ------------------------------------------------------
 */

final class Auth
{
    /**
     * Check if current user is admin
     */
    public static function check(): bool
    {
        return Session::get('is_admin') === true;
    }

    /**
     * Require admin access or redirect
     */
    public static function requireAdmin(): void
    {
        if (!self::check()) {
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Mark current session as admin
     */
    public static function login(): void
    {
        Session::regenerate();
        Session::set('is_admin', true);
    }

    /**
     * Remove admin privileges
     */
    public static function logout(): void
    {
        Session::remove('is_admin');
    }
}