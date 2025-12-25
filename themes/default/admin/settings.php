<?php $this->layout('layouts/admin', ['title' => 'Settings']) ?>

<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Settings</h1>
            </div>
            <div class="level-right">
                <a href="/admin/dashboard" class="button is-light">
                    <i data-lucide="arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </div>
        
        <form method="POST" action="/admin/settings" class="box">
            <div class="field">
                <label class="label">
                    <i data-lucide="type"></i>
                    <span>Site Title</span>
                </label>
                <div class="control">
                    <input class="input" type="text" name="site_title" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>" placeholder="My Awesome Blog">
                </div>
            </div>

            <div class="field">
                <label class="label">
                    <i data-lucide="align-left"></i>
                    <span>Site Description</span>
                </label>
                <div class="control">
                    <textarea class="textarea" name="site_description" rows="3" placeholder="A brief description of your website"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
                </div>
                <p class="help">
                    <i data-lucide="info"></i>
                    This appears in search results and social media shares.
                </p>
            </div>

            <div class="field">
                <label class="label">
                    <i data-lucide="search"></i>
                    <span>SEO Keywords</span>
                </label>
                <div class="control">
                    <input class="input" type="text" name="site_keywords" value="<?= htmlspecialchars($settings['site_keywords'] ?? '') ?>" placeholder="blog, cms, php, json">
                </div>
                <p class="help">
                    <i data-lucide="info"></i>
                    Comma separated keywords for search engines
                </p>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">
                        <i data-lucide="save"></i>
                        <span>Save Settings</span>
                    </button>
                    <a class="button is-light" href="/admin/dashboard">
                        <i data-lucide="x"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </form>
        
        <?php $this->hook('admin_settings_after') ?>
    </div>
</section>