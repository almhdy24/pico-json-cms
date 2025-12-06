<?php
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

  // Homepage - list all posts
  public function index(): void
  {
    $postsModel = $this->model("PostsModel");
    $posts = array_reverse($postsModel->all(), true);

    $page = (int) ($_GET["page"] ?? 1);
    $pagination = paginate($posts, 5, $page);

    $settings = $this->model("SettingsModel")->all();

    $this->view("index", [
      "posts" => $pagination["items"],
      "totalPages" => $pagination["totalPages"],
      "currentPage" => $pagination["currentPage"],
      "pageTitle" => "Latest Posts", // Add this
    ]);
  }

  // Single post view
  public function viewPost(string $slug): void
  {
    $post = $this->model("PostsModel")->findBySlug($slug);

    if ($post === null) {
      http_response_code(404);
      die("Post not found");
    }

    $settings = $this->model("SettingsModel")->all();
    $this->view("single", [
      "post" => $post,
      "settings" => $settings,
    ]);
  }
}
