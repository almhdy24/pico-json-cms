<?php
/**
 * Pico JSON CMS - Posts Model
 *
 * Handles blog post storage, retrieval,
 * and soft-delete logic.
 *
 * Domain rules:
 * - Posts live in posts.json
 * - deleted_at === null → published
 * - deleted_at !== null → trashed
 */

declare(strict_types=1);

namespace Models;

use Core\App;
use Core\Model;

class PostsModel extends Model
{
    /**
     * Path to posts storage
     */
    protected string $file;

    public function __construct()
    {
        $this->file = App::path('content', 'posts.json');
        parent::__construct();
    }

    /**
     * Find a published post by slug
     */
    public function findBySlug(string $slug): ?array
    {
        foreach ($this->all() as $id => $post) {
            if (
                ($post['slug'] ?? '') === $slug &&
                empty($post['deleted_at'])
            ) {
                return $post + ['id' => $id];
            }
        }

        return null;
    }

    /**
     * Get all published posts
     */
    public function published(): array
    {
        return array_filter(
            $this->all(),
            fn ($post) => empty($post['deleted_at'])
        );
    }

    /**
     * Get all trashed posts
     */
    public function trashed(): array
    {
        return array_filter(
            $this->all(),
            fn ($post) => !empty($post['deleted_at'])
        );
    }

    /**
     * Create or update a post
     */
    public function savePost(int|string $id, array $post): bool
    {
        $posts = $this->all();
        $posts[$id] = $post;

        return $this->save($posts);
    }

    /**
     * Permanently delete a post
     */
    public function deletePost(int|string $id): bool
    {
        $posts = $this->all();

        if (!isset($posts[$id])) {
            return false;
        }

        unset($posts[$id]);
        return $this->save($posts);
    }
}