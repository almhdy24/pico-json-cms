<?php
ob_start();
?>

<section class="section">
    <div class="container">
        <h1 class="title">Dashboard</h1>
        
        <div class="columns is-multiline mb-5">
            <div class="column is-one-third">
                <div class="box has-text-centered has-background-light">
                    <p class="heading has-text-grey">Total Posts</p>
                    <p class="title has-text-primary"><?= $postsCount ?></p>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="box has-text-centered has-background-light">
                    <p class="heading has-text-grey">Site Title</p>
                    <p class="subtitle has-text-dark"><?= htmlspecialchars($settings['site_title'] ?? 'My Blog') ?></p>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="box has-text-centered has-background-light">
                    <p class="heading has-text-grey">Site Description</p>
                    <p class="subtitle has-text-dark"><?= htmlspecialchars($settings['site_description'] ?? 'Simple Blog') ?></p>
                </div>
            </div>
        </div>

        <div class="buttons mb-4">
            <a class="button is-primary is-rounded" href="/admin/add">
                <span class="icon">+</span>
                <span>New Post</span>
            </a>
            <a class="button is-link is-light is-rounded" href="/admin">All Posts</a>
            <a class="button is-info is-light is-rounded" href="/admin/settings">Settings</a>
        </div>

        <div class="level">
            <div class="level-left">
                <h2 class="subtitle">Recent Posts</h2>
            </div>
            <div class="level-right">
                <a href="/admin" class="button is-small is-text">View All →</a>
            </div>
        </div>
        
        <?php if (!empty($posts)): ?>
            <?php
            $recentPosts = array_slice(array_reverse($posts), 0, 3, true);
            ?>
            
            <div class="columns is-multiline">
                <?php foreach ($recentPosts as $id => $post): ?>
                    <div class="column is-one-third">
                        <div class="box has-background-white-bis">
                            <h3 class="title is-5 mb-3"><?= htmlspecialchars($post['title']) ?></h3>
                            <p class="mb-3 has-text-grey"><?= htmlspecialchars(substr($post['content'], 0, 80)) ?>...</p>
                            <div class="buttons are-small">
                                <a href="/admin/edit/<?= $id ?>" class="button is-info is-outlined is-small">Edit</a>
                                <a href="/post/<?= htmlspecialchars($post['slug']) ?>" class="button is-link is-outlined is-small" target="_blank">View</a>
                                <a href="/admin/delete/<?= $id ?>" class="button is-danger is-outlined is-small" onclick="return confirm('Delete this post?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="notification is-light has-text-centered">
                No posts yet. <a href="/admin/add">Create your first post</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
$title = 'Dashboard';
include __DIR__ . '/admin_layout.php';