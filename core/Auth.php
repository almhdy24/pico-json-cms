<?php
namespace Core;

class Auth
{
    public static function requireAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            header("HTTP/1.1 403 Forbidden");
            die("Access denied. Admins only.");
        }
    }

    public static function loginAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['is_admin'] = true;
    }

    public static function logoutAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['is_admin']);
    }
}