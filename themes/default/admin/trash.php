<?php $this->layout('layouts/admin', ['title' => 'Trash']) ?>

<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">
                    <i data-lucide="trash-2"></i>
                    <span>Trash</span>
                </h1>
            </div>
            <div class="level-right">
                <a href="/admin" class="button is-light">
                    <i data-lucide="arrow-left"></i>
                    <span>Back to Posts</span>
                </a>
            </div>
        </div>

        <?php if (!empty($posts)): ?>
            <div class="notification is-light mb-4">
                <i data-lucide="info"></i>
                <span>Posts in trash will be automatically deleted after 30 days.</span>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Deleted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $id => $post): ?>
                            <?php if (!empty($post['deleted_at'])): ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?= htmlspecialchars($post['title']) ?></strong>
                                            <div class="help">
                                                <?= htmlspecialchars(substr($post['content'], 0, 60)) ?>...
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($post['deleted_at']): ?>
                                            <?= date('F j, Y g:i A', $post['deleted_at']) ?>
                                            <div class="help">
                                                <?php
                                                $days_ago = floor((time() - $post['deleted_at']) / 86400);
                                                echo "Deleted $days_ago day" . ($days_ago != 1 ? 's' : '') . " ago";
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="buttons are-small">
                                            <a href="/admin/restore/<?= $id ?>" class="button is-success" onclick="return confirm('Restore this post?')">
                                                <i data-lucide="refresh-cw"></i>
                                                <span>Restore</span>
                                            </a>
                                            <a href="/admin/destroy/<?= $id ?>" class="button is-danger" onclick="return confirm('Permanently delete this post?\nThis action cannot be undone!')">
                                                <i data-lucide="trash"></i>
                                                <span>Delete Permanently</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="buttons mt-4">
                <form method="POST" action="/admin/emptyTrash" style="display: inline;" onsubmit="return confirm('Empty all trash?\nThis action cannot be undone!')">
                    <button type="submit" class="button is-danger">
                        <i data-lucide="trash-2"></i>
                        <span>Empty Trash</span>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="notification is-light has-text-centered" style="padding: 3rem;">
                <i data-lucide="trash-2" style="width: 48px; height: 48px; color: var(--secondary); margin-bottom: 1rem;"></i>
                <h3 class="title is-5">Trash is empty</h3>
                <p>No posts in the trash bin.</p>
                <a href="/admin" class="button is-light mt-3">
                    <i data-lucide="arrow-left"></i>
                    <span>Back to Posts</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>