<?php
ob_start(); 
?>
<section class="section">
    <div class="container">
        <h1 class="title">Latest Posts</h1>
        
        <?php if (empty($posts)): ?>
            <div class="notification is-light">
                No posts yet. <a href="/admin/add">Add your first post</a>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $id => $post): ?>
                <article class="post-box">
                    <h2 class="title is-3">
                        <a href="/post/<?= htmlspecialchars($post['slug']) ?>" class="has-text-dark">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h2>
                    <div class="content">
                        <?= apply_filters('post_content', substr($post['content'], 0, 200) . '...', $post) ?>
                    </div>
                    <a href="/post/<?= htmlspecialchars($post['slug']) ?>" class="button is-small is-link">Read More</a>
                </article>
            <?php endforeach; ?>
            
            <?php if ($totalPages > 1): ?>
                <nav class="pagination is-centered mt-4">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="pagination-link <?= $i === $currentPage ? 'is-current' : '' ?>" 
                           href="/?page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = "Home";
include __DIR__ . "/base.php";