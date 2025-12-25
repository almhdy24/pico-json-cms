<?php $this->layout('layouts/site', ['title' => 'Home']) ?>

<section class="section">
  <div class="container">

    <h1 class="title">Latest Posts</h1>

    <?php if (empty($posts)): ?>
      <div class="notification is-light">
        <i data-lucide="file-text"></i>
        <p>No posts yet.</p>
      </div>
    <?php else: ?>

      <?php foreach ($posts as $post): ?>

        <article class="post-box">

          <h2 class="title is-4">
            <a href="/post/<?= $this->e($post['slug']) ?>">
              <?= $this->e($post['title']) ?>
            </a>
          </h2>

          <div class="post-excerpt">
            <?= $this->filter(
                'post_content',
                mb_substr($post['content'], 0, 250) . '…',
                $post
            ) ?>
          </div>

          <a href="/post/<?= $this->e($post['slug']) ?>" class="button is-small is-link">
            <i data-lucide="arrow-right"></i>
            <span>Read More</span>
          </a>

        </article>

      <?php endforeach; ?>

      <?php if ($totalPages > 1): ?>
        <?php $this->insert('partials/pagination', compact('currentPage', 'totalPages')) ?>
      <?php endif; ?>

    <?php endif; ?>

  </div>
</section>