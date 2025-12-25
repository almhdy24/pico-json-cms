<?php $this->layout('layouts/admin', ['title' => 'Posts']) ?>

<section class="section">
  <div class="container">
    <div class="level">
      <div class="level-left">
        <h1 class="title">Posts</h1>
      </div>
      <div class="level-right">
        <a class="button is-primary" href="/admin/add">
          <i data-lucide="plus-circle"></i>
          <span>New Post</span>
        </a>
      </div>
    </div>

    <?php if (!empty($posts)): ?>
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Preview</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($posts as $id => $post): ?>
          <tr>
            <td><?= htmlspecialchars($post['title']) ?></td>
            <td><?= htmlspecialchars(substr($post['content'], 0, 60)) ?>...</td>
            <td>
              <div class="buttons are-small">
                <a href="/admin/edit/<?= $id ?>" class="button is-light">
                  <i data-lucide="edit"></i>
                  <span>Edit</span>
                </a>
                <a href="/admin/delete/<?= $id ?>" class="button is-danger" onclick="return confirm('Delete this post?')">
                  <i data-lucide="trash-2"></i>
                  <span>Delete</span>
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if ($totalPages > 1): ?>
    <?php
    $this->insert('partials/pagination', [
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
      'basePath' => '/admin'
    ]);
    ?>
    <?php endif; ?>
    <?php else : ?>
    <div class="notification is-light">
      <i data-lucide="file-text"></i>
      <p>
        No posts found. <a href="/admin/add">Create your first post</a>
      </p>
    </div>
    <?php endif; ?>
  </div>
</section>