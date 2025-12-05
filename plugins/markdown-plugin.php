<?php
use Parsedown;

// Filter to convert post content from Markdown to HTML
add_filter("post_content", function ($content, $post) {
  static $parsedown = null;
  if (!$parsedown) {
    $parsedown = new Parsedown();
  }

  return $parsedown->text($content);
});
