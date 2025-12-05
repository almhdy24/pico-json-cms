<?php
ob_start();
?>
<section class="section">
    <div class="container">
        <h1 class="title">Edit Post</h1>
        
        <form method="POST" action="/admin/edit/<?= $id ?>" class="box">
            <div class="field">
                <label class="label">Title *</label>
                <div class="control">
                    <input class="input" type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
                </div>
            </div>
            
            <div class="field">
                <label class="label">Content *</label>
                <div class="control">
                    <textarea 
                        class="textarea simple-editor" 
                        name="content" 
                        rows="15"
                        placeholder="Write your post content here..." 
                        required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>
                <p class="help">
                    <span class="has-text-grey">
                        Use <code>**bold**</code> for bold text, 
                        <code>*italic*</code> for italics,
                        <code>#</code> for headers
                    </span>
                </p>
            </div>
            
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-primary" type="submit">Update Post</button>
                </div>
                <div class="control">
                    <a class="button is-light" href="/admin">Cancel</a>
                </div>
                <div class="control">
                    <a href="/post/<?= htmlspecialchars($post['slug']) ?>" class="button is-link" target="_blank">View</a>
                </div>
            </div>
        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
$title = 'Edit Post';
include __DIR__ . '/admin_layout.php';
