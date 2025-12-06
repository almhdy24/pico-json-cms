<?php
/**
 * Pico JSON CMS - Controller
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Base controller class providing view rendering, model loading, and flash messaging.
 *
 * License: MIT
 */

namespace Core;

class Controller
{
    protected function view($view, $data = [])
    {
        View::render($view, $data);
    }

    protected function model($model)
    {
        $class = "Models\\$model";
        if (class_exists($class)) {
            return new $class();
        }
        return null;
    }

    protected function setFlash(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION["flash"] = [
            "type" => $type,
            "message" => $message,
        ];
    }

    protected function getFlash(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
            return $flash;
        }
        return null;
    }
}