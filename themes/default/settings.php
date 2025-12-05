<?php
ob_start();
?>
<section class="section">
    <div class="container">
        <h1 class="title">Settings</h1>
        
        <form method="POST" action="/admin/settings" class="box">
            <div class="field">
                <label class="label">Site Title</label>
                <div class="control">
                    <input class="input" type="text" name="site_title" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>">
                </div>
            </div>

            <div class="field">
                <label class="label">Site Description</label>
                <div class="control">
                    <textarea class="textarea" name="site_description"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="field">
                <label class="label">SEO Keywords</label>
                <div class="control">
                    <input class="input" type="text" name="site_keywords" value="<?= htmlspecialchars($settings['site_keywords'] ?? '') ?>">
                </div>
                <p class="help">Comma separated keywords</p>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">Save Settings</button>
                    <a class="button is-light" href="/admin/dashboard">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
$title = 'Settings';
include __DIR__ . '/admin_layout.php';