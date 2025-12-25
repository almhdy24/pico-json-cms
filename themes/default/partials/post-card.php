<article class="post-box">
  <h2>
    <a href="/post/<?= $this->e($post['slug']) ?>">
      <i data-lucide="file-text"></i>
      <?= $this->e($post['title']) ?>
    </a>
  </h2>

  <div class="content">
    <?= $this->filter(
      'post_content',
      substr($post['content'], 0, 200) . '...',
      $post
    ) ?>
  </div>
  
  <a href="/post/<?= $this->e($post['slug']) ?>" class="button is-small is-link">
    <i data-lucide="arrow-right"></i>
    <span>Read More</span>
  </a>
</article>