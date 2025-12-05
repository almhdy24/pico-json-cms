<?php
ob_start();
?>
<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Posts</h1>
            </div>
            <div class="level-right">
                <a class="button is-primary" href="/admin/add">New Post</a>
            </div>
        </div>

        <?php
        $page = (int)($_GET['page'] ?? 1);
        $pagination = paginate($posts, 10, $page);
        ?>

        <?php if (!empty($pagination['items'])): ?>
            <div class="table-container">
                <table class="table is-fullwidth is-hoverable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Preview</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagination['items'] as $id => $post): ?>
                            <tr>
                                <td><?= htmlspecialchars($post['title']) ?></td>
                                <td><?= htmlspecialchars(substr($post['content'], 0, 60)) ?>...</td>
                                <td>
                                    <div class="buttons are-small">
                                        <a href="/admin/edit/<?= $id ?>" class="button is-info">Edit</a>
                                        <a href="/admin/delete/<?= $id ?>" class="button is-danger" onclick="return confirm('Delete this post?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pagination['totalPages'] > 1): ?>
                <nav class="pagination is-centered mt-4">
                    <ul class="pagination-list">
                        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
                            <li>
                                <a class="pagination-link <?= $i === $pagination['currentPage'] ? 'is-current' : '' ?>" 
                                   href="/admin?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="notification is-light">
                No posts found. <a href="/admin/add">Create your first post</a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Posts';
include __DIR__ . '/admin_layout.php';