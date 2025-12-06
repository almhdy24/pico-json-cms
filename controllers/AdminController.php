<?php
/**
 * Pico JSON CMS - AdminController
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Lightweight PHP flat-file CMS using JSON storage.
 *   Handles admin login, dashboard, posts management, and settings.
 *
 * Security Notes:
 *   - Login attempts limited
 *   - Session regenerated on login
 *   - Password hashed in admin.php
 *   - Consider enabling HTTPS & secure cookies in production
 *
 * License: MIT
 */

namespace Controllers;

use Core\Controller;
use Core\Auth;
use Models\PostsModel;
use Models\SettingsModel;

class AdminController extends Controller
{
    private PostsModel $postsModel;
    private SettingsModel $settingsModel;

    public function __construct()
    {
        // Determine the current action from the URL
        $uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        $segments = explode("/", $uri);
        $action = $segments[1] ?? "index";

        // Require admin authentication for all methods except login/logout
        if (!in_array($action, ["login", "logout"])) {
            Auth::requireAdmin();
        }

        $this->postsModel = $this->model("PostsModel");
        $this->settingsModel = $this->model("SettingsModel");
    }

    /**
     * Admin login page
     */
    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                "httponly" => true,
                // "secure" => true, // enable if using HTTPS
                "samesite" => "Lax",
            ]);
            session_start();
        }

        if (!empty($_SESSION["is_admin"])) {
            header("Location: /admin/dashboard");
            exit();
        }

        $_SESSION["login_attempts"] = $_SESSION["login_attempts"] ?? 0;

        // Lock out if too many attempts
        if ($_SESSION["login_attempts"] >= 5) {
            $this->setFlash("error", "Too many login attempts. Please try again later.");
            header("Location: /admin/login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST["username"] ?? "");
            $password = $_POST["password"] ?? "";

            $config = include __DIR__ . "/../admin.php";

            if ($username === $config["admin_user"] && password_verify($password, $config["admin_pass"])) {
                session_regenerate_id(true);
                $_SESSION["is_admin"] = true;
                $_SESSION["login_attempts"] = 0;

                Auth::loginAdmin();
                header("Location: /admin/dashboard");
                exit();
            } else {
                $_SESSION["login_attempts"]++;
                sleep(1); // small delay to slow brute force
                $this->setFlash("error", "Invalid credentials");
                header("Location: /admin/login");
                exit();
            }
        }

        $flash = $this->getFlash();
        $this->view("admin_login", ["flash" => $flash]);
    }

    /**
     * Logout admin
     */
    public function logout(): void
    {
        Auth::logoutAdmin();
        header("Location: /admin/login");
        exit();
    }

    /**
     * Dashboard view
     */
    public function dashboard(): void
    {
        $posts = $this->postsModel->all();
        $settings = $this->settingsModel->all();
        $postsCount = count($posts);

        $this->view("dashboard", [
            "posts" => $posts,
            "postsCount" => $postsCount,
            "settings" => $settings,
        ]);
    }

    /**
     * Posts list
     */
    public function index(): void
    {
        $this->view("admin", ["posts" => $this->postsModel->all()]);
    }

    /**
     * Add new post
     */
    public function add(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = trim($_POST["title"] ?? "");
            $content = trim($_POST["content"] ?? "");

            if (!$title || !$content) {
                $this->setFlash("error", "Title and content are required.");
                header("Location: /admin/add");
                exit();
            }

            $posts = $this->postsModel->all();
            $id = time();
            $slug = $this->generateSlug($title, $posts);

            $posts[$id] = [
                "title" => $title,
                "slug" => $slug,
                "content" => $content,
            ];

            $this->postsModel->save($posts);

            $this->setFlash("success", "Post added successfully!");
            header("Location: /admin");
            exit();
        }

        $this->view("admin_add");
    }

    /**
     * Edit existing post
     */
    public function edit(?int $id = null): void
    {
        $posts = $this->postsModel->all();

        if ($id === null || !isset($posts[$id])) {
            $this->setFlash("error", "Post not found.");
            header("Location: /admin");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = trim($_POST["title"] ?? "");
            $content = trim($_POST["content"] ?? "");

            if (!$title || !$content) {
                $this->setFlash("error", "Title and content are required.");
                header("Location: /admin/edit/$id");
                exit();
            }

            $posts[$id] = [
                "title" => $title,
                "content" => $content,
                "slug" => $this->generateSlug($title, $posts, $id),
            ];

            $this->postsModel->save($posts);
            $this->setFlash("success", "Post updated successfully!");
            header("Location: /admin");
            exit();
        }

        $this->view("admin_edit", [
            "id" => $id,
            "post" => $posts[$id],
        ]);
    }

    /**
     * Delete post
     */
    public function delete(?int $id = null): void
    {
        if ($id === null) {
            $this->setFlash("error", "Invalid post ID.");
            header("Location: /admin");
            exit();
        }

        $posts = $this->postsModel->all();

        if (isset($posts[$id])) {
            unset($posts[$id]);
            $this->postsModel->save($posts);
            $this->setFlash("success", "Post deleted.");
        } else {
            $this->setFlash("error", "Post not found.");
        }

        header("Location: /admin");
        exit();
    }

    /**
     * Update settings
     */
    public function settings(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            foreach ($_POST as $key => $value) {
                $this->settingsModel->update($key, $value);
            }

            $this->setFlash("success", "Settings updated successfully!");
            header("Location: /admin/settings");
            exit();
        }

        $this->view("settings", ["settings" => $this->settingsModel->all()]);
    }

    /**
     * Generate unique slug for post
     */
    private function generateSlug(string $title, array $posts, ?int $currentId = null): string
    {
        $baseSlug = strtolower(trim(preg_replace("/[^A-Za-z0-9]+/", "-", $title), "-"));
        $slug = $baseSlug;
        $i = 1;

        while (true) {
            $duplicate = false;
            foreach ($posts as $id => $post) {
                if ($currentId !== null && $id == $currentId) continue;
                if (isset($post["slug"]) && $post["slug"] === $slug) {
                    $duplicate = true;
                    break;
                }
            }
            if (!$duplicate) break;
            $slug = $baseSlug . "-" . $i++;
        }

        return $slug;
    }
}