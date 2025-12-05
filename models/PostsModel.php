<?php
namespace Models;
use Core\Model;

class PostsModel extends Model
{
  protected $file = __DIR__ . "/../content/posts.json";
  
  public function findBySlug(string $slug): ?array
  {
    foreach ($this->all() as $id => $post) {
      if (isset($post["slug"]) && $post["slug"] === $slug) {
        $post["id"] = $id; // include id if needed
        return $post;
      }
    }
    return null;
  }
}
