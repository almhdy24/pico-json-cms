<?php
/**
 * Pico JSON CMS — Admin Controller
 *
 * CORE STATUS: SEMI-FROZEN (v1.0)
 * Public methods & routes should remain stable.
 *
 * Responsibilities:
 * - Authentication
 * - Dashboard & metrics
 * - Posts CRUD + trash
 * - Settings management
 *
 * License: MIT
 */

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Session;
use Core\View;
use Core\App;
use Core\Auth;
use Models\PostsModel;
use Models\SettingsModel;

final class AdminController extends Controller
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS   = 300;
    private const TRASH_DAYS        = 30;

    private PostsModel $posts;
    private SettingsModel $settings;

    public function __construct()
    {
        parent::__construct();
        $this->guard();

        $this->posts    = $this->model(PostsModel::class);
        $this->settings = $this->model(SettingsModel::class);

        $this->autoCleanTrash();

        View::share([
            'trashCount' => count($this->posts->trashed()),
        ]);
    }

    /* =====================================================
     * Authentication
     * ===================================================== */

    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('/admin/dashboard');
        }

        $throttle = Session::get('login_throttle', [
            'attempts'     => 0,
            'locked_until' => null,
        ]);

        if ($throttle['locked_until'] && time() < $throttle['locked_until']) {
            $this->view('admin/login', [
                'flash' => [[
                    'type'    => 'error',
                    'message' => 'Too many attempts. Please wait.',
                ]],
            ]);
            return;
        }

        if ($this->isPost()) {
            $this->processLogin($throttle);
            return;
        }

        $this->view('admin/login', ['flash' => $this->getFlash()]);
    }

    private function processLogin(array $throttle): void
    {
        $username = trim($this->input('username', ''));
        $password = (string) $this->input('password', '');

        $config = require App::path('content', '.admin.php');

        $valid =
            hash_equals($config['admin_user'], $username) &&
            password_verify($password, $config['admin_pass']);

        if ($valid) {
            Session::remove('login_throttle');
            Auth::login();
            $this->flash('success', 'Login successful.');
            $this->redirect('/admin/dashboard');
        }

        $throttle['attempts']++;

        if ($throttle['attempts'] >= self::MAX_LOGIN_ATTEMPTS) {
            $throttle['locked_until'] = time() + self::LOCKOUT_SECONDS;
        }

        Session::set('login_throttle', $throttle);
        sleep(1);

        $this->flash('error', 'Invalid credentials.');
        $this->redirect('/admin/login');
    }

    public function logout(): void
    {
        Auth::logout();
        Session::destroy();
        $this->flash('success', 'Logged out successfully.');
        $this->redirect('/admin/login');
    }

    /* =====================================================
     * Dashboard
     * ===================================================== */

    public function dashboard(): void
    {
        $published = $this->posts->published();
        $trashed   = $this->posts->trashed();

        $this->view('admin/dashboard', [
            'postsCount' => count($published),
            'trashCount' => count($trashed),
            'settings'   => $this->settings->all(),
            'flash'      => $this->getFlash(),
        ]);
    }

    /* =====================================================
     * Posts
     * ===================================================== */

    public function index(): void
    {
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 5;

        $posts = $this->posts->published();
        $total = count($posts);

        $totalPages = max(1, (int) ceil($total / $perPage));
        $page       = min($page, $totalPages);

        $offset = (int) (($page - 1) * $perPage);

        $this->view('admin/posts', [
            'posts'       => array_slice($posts, $offset, $perPage, true),
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'basePath'    => '/admin',
            'flash'       => $this->getFlash(),
        ]);
    }

    public function add(): void
    {
        if (!$this->isPost()) {
            $this->view('admin/post-add', [
                'flash' => $this->getFlash(),
            ]);
            return;
        }

        [$title, $content] = $this->validatePost();

        $id = time();

        $this->posts->savePost($id, [
            'title'      => $title,
            'slug'       => $this->generateSlug($title),
            'content'    => $content,
            'created_at' => time(),
            'updated_at' => time(),
            'deleted_at' => null,
        ]);

        $this->flash('success', 'Post created successfully.');
        $this->redirect('/admin');
    }

    public function edit(?int $id): void
    {
        if (!$id || !$post = $this->posts->find($id)) {
            $this->flash('error', 'Post not found.');
            $this->redirect('/admin');
        }

        if ($this->isPost()) {
            [$title, $content] = $this->validatePost();

            $post['title']      = $title;
            $post['content']    = $content;
            $post['slug']       = $this->generateSlug($title, $id);
            $post['updated_at'] = time();

            $this->posts->savePost($id, $post);

            $this->flash('success', 'Post updated successfully.');
            $this->redirect('/admin');
        }

        $this->view('admin/post-edit', [
            'id'    => $id,
            'post'  => $post,
            'flash' => $this->getFlash(),
        ]);
    }

    public function delete(?int $id): void
    {
        if ($post = $this->posts->find($id)) {
            $post['deleted_at'] = time();
            $this->posts->savePost($id, $post);
            $this->flash('success', 'Post moved to trash.');
        } else {
            $this->flash('error', 'Post not found.');
        }

        $this->redirect('/admin');
    }

    public function trash(): void
    {
        $this->view('admin/trash', [
            'posts' => $this->posts->trashed(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function restore(?int $id): void
    {
        if ($post = $this->posts->find($id)) {
            $post['deleted_at'] = null;
            $this->posts->savePost($id, $post);
            $this->flash('success', 'Post restored successfully.');
        } else {
            $this->flash('error', 'Post not found.');
        }

        $this->redirect('/admin/trash');
    }

    public function destroy(?int $id): void
    {
        $this->posts->deletePost($id);
        $this->flash('success', 'Post permanently deleted.');
        $this->redirect('/admin/trash');
    }

    public function emptyTrash(): void
    {
        $trashed = $this->posts->trashed();
        $count = count($trashed);
        
        foreach ($trashed as $id => $_) {
            $this->posts->deletePost($id);
        }

        $this->flash('success', "{$count} posts permanently deleted.");
        $this->redirect('/admin/trash');
    }

    /* =====================================================
     * Settings
     * ===================================================== */

    public function settings(): void
    {
        if ($this->isPost()) {
            $this->settings->setMany($_POST);
            $this->flash('success', 'Settings saved successfully.');
            $this->redirect('/admin/settings');
        }

        $this->view('admin/settings', [
            'settings' => $this->settings->all(),
            'flash'    => $this->getFlash(),
        ]);
    }

    public function system(): void
    {
        $system = [
            'cms' => [
                'name'    => 'Pico JSON CMS',
                'version' => App::CORE_VERSION,
                'storage' => 'Flat-file JSON',
            ],

            'env' => [
                'php_version' => PHP_VERSION,
                'php_sapi'    => PHP_SAPI,
                'os'          => PHP_OS_FAMILY,
                'timezone'    => date_default_timezone_get(),
                'memory'      => ini_get('memory_limit'),
            ],

            'paths' => [
                'content_writable' => is_writable(App::path('content')),
                'logs_writable'    => is_writable(App::path('logs')),
                'root_writable'    => is_writable(BASE_PATH),
            ],

            'plugins' => []
        ];

        $this->view('admin/system', [
            'system' => $system,
            'flash'  => $this->getFlash(),
        ]);
    }

    /* =====================================================
     * Helpers (Frozen)
     * ===================================================== */

    private function guard(): void
    {
        $action = explode('/', trim($_SERVER['REQUEST_URI'], '/'))[1] ?? 'index';

        if (!in_array($action, ['login', 'logout'], true)) {
            Auth::requireAdmin();
        }
    }

    private function validatePost(): array
    {
        $title   = trim($this->input('title', ''));
        $content = trim($this->input('content', ''));

        if ($title === '' || $content === '') {
            $this->flash('error', 'Title and content are required.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin');
        }

        return [$title, $content];
    }

    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $base = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));
        $slug = $base;
        $i    = 1;

        foreach ($this->posts->all() as $id => $post) {
            if ($id === $ignoreId) continue;
            if (($post['slug'] ?? '') === $slug) {
                $slug = $base . '-' . $i++;
            }
        }

        return $slug;
    }

    private function autoCleanTrash(): void
    {
        $limit = time() - (self::TRASH_DAYS * 86400);
        $cleaned = 0;

        foreach ($this->posts->trashed() as $id => $post) {
            if ($post['deleted_at'] < $limit) {
                $this->posts->deletePost($id);
                $cleaned++;
            }
        }

        // Optionally add flash for auto-cleanup
        if ($cleaned > 0) {
            // Note: This won't display since it's in constructor
            // Consider logging instead
        }
    }
}