<?php
/**
 * Pico JSON CMS - Markdown Plugin
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Plugin for converting Markdown content to HTML using Parsedown.
 *
 * License: MIT
 */

use Parsedown;

// Filter to convert post content from Markdown to HTML
add_filter("post_content", function ($content, $post) {
  static $parsedown = null;
  if (!$parsedown) {
    $parsedown = new Parsedown();
  }

  return $parsedown->text($content);
});