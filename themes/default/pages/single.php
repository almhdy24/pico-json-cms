<?php $this->layout('layouts/site', ['title' => $post['title']]) ?>

<article class="post-box">
  <div class="level">
    <div class="level-left">
      <a href="<?= $this->route('/') ?>" class="button is-light">
        <i data-lucide="arrow-left"></i>
        <span>Back to Posts</span>
      </a>
    </div>
    <div class="level-right">
      <span class="has-text-secondary">
        <i data-lucide="calendar"></i>
      <?= date('F j, Y', (int) $post['created_at']) ?>
      </span>
    </div>
  </div>

  <h1 class="title"><?= $this->e($post['title']) ?></h1>

  <div class="content post-content">
    <?= $this->filter('post_content', $post['content'], $post) ?>
  </div>

  <div class="mt-4">
    <a href="<?= $this->route('/') ?>" class="button is-light">
      <i data-lucide="home"></i>
      <span>Back to Home</span>
    </a>
  </div>
</article>