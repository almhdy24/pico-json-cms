<?php
/**
 * Pico JSON CMS — Home Controller
 *
 * CORE STATUS: SEMI-FROZEN (v1.0)
 *
 * Responsibilities:
 * - Homepage listing
 * - Single post rendering
 *
 * License: MIT
 */

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\PostsModel;
use Models\SettingsModel;

final class HomeController extends Controller
{
    private PostsModel $posts;
    private SettingsModel $settings;

    public function __construct()
    {
        parent::__construct();

        $this->posts    = $this->model(PostsModel::class);
        $this->settings = $this->model(SettingsModel::class);
    }

    /**
     * Homepage
     */
    public function index(): void
    {
        $posts = array_reverse($this->posts->published(), true);

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $pagination = paginate($posts, 5, $page);

        $this->view('pages/home', [
            'posts'       => $pagination['items'],
            'currentPage' => $pagination['currentPage'],
            'totalPages'  => $pagination['totalPages'],
            'settings'    => $this->settings->all(),
        ]);
    }

    /**
     * Single post by slug
     */
    public function viewPost(string $slug): void
    {
        $post = $this->posts->findBySlug($slug);

        if (!$post) {
            http_response_code(404);
            $this->view('pages/404', ['message' => 'Post not found']);
            return;
        }

        $this->view('pages/single', [
            'post'     => $post,
            'settings' => $this->settings->all(),
        ]);
    }
}