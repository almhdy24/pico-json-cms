<?php
/**
* Pico JSON CMS - PostsModel
*
* Author: Elmahdi
* GitHub: https://github.com/almhdy24/pico-json-cms
* Description:
*   Model for managing blog posts with slug-based retrieval.
*
* License: MIT
*/

namespace Models;
use Core\App;
use Core\Model;

class PostsModel extends Model
{
  protected $file = App::path('content', 'posts.json');

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