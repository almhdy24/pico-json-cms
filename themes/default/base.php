<?php
use Models\SettingsModel;

$settingsModel = new SettingsModel();
$siteTitle = htmlspecialchars($settingsModel->get('site_title', 'My Blog'));
$siteDescription = htmlspecialchars($settingsModel->get('site_description', 'Simple Blog'));

// Determine page title
$pageTitle = $siteTitle;
if (isset($title)) {
    $pageTitle = htmlspecialchars($title) . ' | ' . $siteTitle;
} elseif (isset($post['title'])) {
    $pageTitle = htmlspecialchars($post['title']) . ' | ' . $siteTitle;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?></title>
<meta name="description" content="<?= $siteDescription ?>">
<link rel="stylesheet" href="/assets/bulma.min.css">

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .navbar {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .post-box {
        margin-bottom: 2rem;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
        transition: transform 0.2s ease;
    }

    .post-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .post-content {
        font-size: 1.1rem;
    }

    .post-content h1 { font-size: 2rem; margin: 1.5rem 0 1rem; }
    .post-content h2 { font-size: 1.75rem; margin: 1.25rem 0 0.75rem; }
    .post-content h3 { font-size: 1.5rem; margin: 1rem 0 0.5rem; }

    .footer {
        margin-top: auto;
        padding: 2rem 0;
        border-top: 1px solid #eee;
        background: #f5f5f5;
        font-size: 14px;
        color: #555;
    }

    .footer a {
        color: #3b82f6;
        text-decoration: none;
    }

    .footer a:hover {
        text-decoration: underline;
    }
</style>

<?php if (function_exists('do_action')) do_action('head'); ?>
</head>
<body>
<nav class="navbar is-light">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <strong><?= $siteTitle ?></strong>
            </a>
            <a role="button" class="navbar-burger" data-target="navMenu">
                <span></span><span></span><span></span>
            </a>
        </div>
        <div id="navMenu" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="/admin/dashboard">Admin</a>
            </div>
        </div>
    </div>
</nav>

<section class="section">
    <div class="container">
        <?php if (function_exists('do_action')) do_action('before_content'); ?>
        <?= $content ?>
        <?php if (function_exists('do_action')) do_action('after_content'); ?>
    </div>
</section>

<footer class="footer">
    <div class="container has-text-centered">
        <p>&copy; <?= date('Y') ?> <?= $siteTitle ?> | Powered by <a href="https://github.com/almhdy24/pico-json-cms" target="_blank" rel="noopener noreferrer">pico-json-cms</a></p>
        <p class="has-text-grey"><?= $siteDescription ?></p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.navbar-burger');
    const menu = document.getElementById('navMenu');
    if (burger && menu) {
        burger.addEventListener('click', function () {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    }
});
</script>

<?php if (function_exists('do_action')) do_action('footer'); ?>
</body>
</html>