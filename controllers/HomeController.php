<?php
/**
 * Pico JSON CMS - HomeController
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Handles the public-facing pages: homepage listing and single post view.
 *
 * License: MIT
 */

namespace Controllers;

use Core\Controller;
use Models\PostsModel;
use Models\SettingsModel;

class HomeController extends Controller
{
    private PostsModel $postsModel;
    private SettingsModel $settingsModel;

    public function __construct()
    {
        $this->postsModel = $this->model("PostsModel");
        $this->settingsModel = $this->model("SettingsModel");
    }

    /**
     * Homepage - list all posts with pagination
     */
    public function index(): void
    {
        $posts = array_reverse($this->postsModel->all(), true);

        $page = max(1, (int) ($_GET["page"] ?? 1));
        $pagination = paginate($posts, 5, $page);

        $settings = $this->settingsModel->all();

        $this->view("index", [
            "posts"       => $pagination["items"],
            "totalPages"  => $pagination["totalPages"],
            "currentPage" => $pagination["currentPage"],
            "pageTitle"   => "Latest Posts",
            "settings"    => $settings,
        ]);
    }

    /**
     * Single post view by slug
     */
    public function viewPost(string $slug): void
    {
        $post = $this->postsModel->findBySlug($slug);

        if ($post === null) {
    http_response_code(404);
    $this->view("404", ["message" => "Post not found"]);
    return;
}

        $settings = $this->settingsModel->all();

        $this->view("single", [
            "post"     => $post,
            "settings" => $settings,
            "pageTitle" => $post["title"] ?? "Post",
        ]);
    }
}