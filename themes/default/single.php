<?php 
ob_start(); 
?>
<article class="post-box">
    <h1 class="title"><?= htmlspecialchars($post['title']) ?></h1>
    <div class="content post-content">
        <?= apply_filters('post_content', $post['content'], $post) ?>
    </div>
    <div class="mt-4">
        <a href="/" class="button is-light">← Back to Posts</a>
    </div>
</article>
<?php 
$content = ob_get_clean(); 
include __DIR__ . '/base.php'; 
?>