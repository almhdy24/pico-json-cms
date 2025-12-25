<?php $this->layout('layouts/admin', ['title' => 'Dashboard']) ?>

<section class="section">
  <div class="container">
    <h1 class="title">Dashboard</h1>

    <div class="dashboard-widgets mb-5">
    <div class="widget">
        <i data-lucide="file-text" class="icon" style="width: 32px; height: 32px; color: var(--primary); margin-bottom: 1rem;"></i>
        <p class="heading">Total Posts</p>
        <p class="title"><?= $postsCount ?></p>
    </div>

    <div class="widget">
        <i data-lucide="type" class="icon" style="width: 32px; height: 32px; color: var(--primary); margin-bottom: 1rem;"></i>
        <p class="heading">Site Title</p>
        <p class="subtitle"><?= $this->e($settings['site_title'] ?? 'My Blog') ?></p>
    </div>

    <div class="widget">
    <i data-lucide="trash-2"
       class="icon"
       style="width: 32px; height: 32px; color: var(--danger); margin-bottom: 1rem;"></i>

    <p class="heading">Trashed Posts</p>
    <p class="title"><?= $trashCount ?></p>

    <?php if ($trashCount > 0): ?>
        <a href="/admin/trash"
           class="button is-small is-danger is-outlined mt-2">
            <i data-lucide="trash-2"></i>
            <span>View Trash</span>
        </a>
    <?php endif; ?>
</div>
</div>

    <div class="buttons mb-4">
      <a class="button is-primary" href="<?= $this->route('/admin/add') ?>">
        <i data-lucide="plus-circle"></i>
        <span>New Post</span>
      </a>
      <a class="button is-light" href="<?= $this->route('/admin') ?>">
        <i data-lucide="list"></i>
        <span>All Posts</span>
      </a>
      <a class="button is-light" href="<?= $this->route('/admin/settings') ?>">
        <i data-lucide="settings"></i>
        <span>Settings</span>
      </a>
    </div>

    <h2 class="subtitle">Recent Posts</h2>

    <?php if (!empty($posts)): ?>
      <div class="columns">
        <?php foreach (array_slice(array_reverse($posts), 0, 3, true) as $id => $post): ?>
          <div class="column is-one-third">
            <div class="box">
              <h3 class="title is-5 mb-3"><?= htmlspecialchars($post['title']) ?></h3>
              <p class="mb-3"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
              <div class="buttons are-small">
                <a href="/admin/edit/<?= $id ?>" class="button is-light">
                  <i data-lucide="edit"></i>
                  <span>Edit</span>
                </a>
                <a href="/post/<?= htmlspecialchars($post['slug']) ?>" class="button is-light" target="_blank">
                  <i data-lucide="eye"></i>
                  <span>View</span>
                </a>
                <a href="/admin/delete/<?= $id ?>" class="button is-danger" onclick="return confirm('Delete this post?')">
                  <i data-lucide="trash-2"></i>
                  <span>Delete</span>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="notification is-light">
        <i data-lucide="file-text"></i>
        <p>No posts yet. <a href="/admin/add">Create your first post</a></p>
      </div>
    <?php endif; ?>
  </div>
</section>