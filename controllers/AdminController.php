<?php
namespace Controllers;

use Core\Controller;
use Core\Auth;
class AdminController extends Controller
{
  private $postsModel;
  private $settingsModel;

  public function __construct()
  {
    // Get current route from URI
    $uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
    $segments = explode("/", $uri);
    $action = $segments[1] ?? "index"; // second segment is method

    // Only require admin for methods other than login/logout
    if (!in_array($action, ["login", "logout"])) {
      \Core\Auth::requireAdmin();
    }

    $this->postsModel = $this->model("PostsModel");
    $this->settingsModel = $this->model("SettingsModel");
  }
  // Login page
  public function login(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user is already logged in
    if (!empty($_SESSION["is_admin"])) {
        header("Location: /admin/dashboard");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";

        $config = include __DIR__ . "/../admin.php";
        
        // Use password_verify for hashed password comparison
        if (
            $username === $config["admin_user"] &&
            password_verify($password, $config["admin_pass"])
        ) {
            \Core\Auth::loginAdmin();
            header("Location: /admin/dashboard");
            exit();
        } else {
            $this->setFlash("error", "Invalid credentials");
            header("Location: /admin/login");
            exit();
        }
    }
    
    // Get flash message using the parent controller's method
    $flash = $this->getFlash();
    $this->view("admin_login", ["flash" => $flash]);
}

  // Logout
  public function logout(): void
  {
    \Core\Auth::logoutAdmin();
    header("Location: /admin/login");
    exit();
  }

  // Admin dashboard
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

  // Posts list
  public function index(): void
  {
    $this->view("admin", ["posts" => $this->postsModel->all()]);
  }

  // Add new post
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

  // Edit post
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

  // Delete
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

  // Settings
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

    $this->view("settings", [
      "settings" => $this->settingsModel->all(),
    ]);
  }
  // Generate unique slug
  private function generateSlug(
    string $title,
    array $posts,
    ?int $currentId = null
  ): string {
    $baseSlug = strtolower(
      trim(preg_replace("/[^A-Za-z0-9]+/", "-", $title), "-")
    );
    $slug = $baseSlug;
    $i = 1;

    while (true) {
      $duplicate = false;
      foreach ($posts as $id => $post) {
        if ($currentId !== null && $id == $currentId) {
          continue;
        }
        if (isset($post["slug"]) && $post["slug"] === $slug) {
          $duplicate = true;
          break;
        }
      }
      if (!$duplicate) {
        break;
      }
      $slug = $baseSlug . "-" . $i++;
    }

    return $slug;
  }
}
