<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title><?= htmlspecialchars($title ?? "Admin") ?> - Admin Panel </title>

<link rel="stylesheet" href="/assets/bulma.min.css">
<link rel="stylesheet" href="/assets/easymde.min.css">

<style>
    body {
        background: #f9f9f9;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .admin-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px;
        flex: 1;
    }
    .flash {
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .flash-success {
        background: #d4ffd9;
        border-left: 4px solid #22c55e;
    }
    .flash-error {
        background: #ffe2e6;
        border-left: 4px solid #ef4444;
    }
    .plugin-notice {
        padding: 10px 15px;
        margin-bottom: 20px;
        border-left: 4px solid #3b82f6;
        background: #e0f2fe;
        border-radius: 5px;
    }
    footer.admin-footer {
        text-align: center;
        padding: 20px 0;
        background: #f5f5f5;
        border-top: 1px solid #ddd;
        font-size: 14px;
        color: #555;
    }
    footer.admin-footer a {
        color: #3b82f6;
        text-decoration: none;
    }
    footer.admin-footer a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>

<nav class="navbar is-white has-shadow">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold" href="/admin/dashboard">Admin Panel</a>
        <a role="button" class="navbar-burger" data-target="navMenu">
            <span></span><span></span><span></span>
        </a>
    </div>

    <div id="navMenu" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') ? 'is-active' : '' ?>" href="/admin/dashboard">Dashboard</a>
            <a class="navbar-item <?= $_SERVER['REQUEST_URI'] === '/admin' ? 'is-active' : '' ?>" href="/admin">Posts</a>
            <a class="navbar-item <?= strpos($_SERVER['REQUEST_URI'], 'add') ? 'is-active' : '' ?>" href="/admin/add">Add New</a>
            <a class="navbar-item <?= strpos($_SERVER['REQUEST_URI'], 'settings') ? 'is-active' : '' ?>" href="/admin/settings">Settings</a>
            <a class="navbar-item" href="/admin/logout">Logout</a>
        </div>
    </div>
</nav>

<div class="admin-container">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash <?= $_SESSION['flash']['type'] === 'error' ? 'flash-error' : 'flash-success' ?>">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Admin Notices Hook -->
    <?php if (function_exists('do_action')): ?>
        <?php do_action('admin_notices'); ?>
    <?php endif; ?>

    <?= $content ?>

</div>

<footer class="admin-footer">
    Powered by <strong>pico-json-cms</strong> | 
    <a href="https://github.com/almhdy24/pico-json-cms" target="_blank" rel="noopener noreferrer">
        GitHub Repository
    </a> &copy; <?= date('Y') ?>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.navbar-burger');
    const menu   = document.getElementById('navMenu');

    if (burger && menu) {
        burger.addEventListener('click', function () {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    }

    const editors = document.querySelectorAll('.simple-editor');
    editors.forEach(textarea => {
        new EasyMDE({
            element: textarea,
            spellChecker: false,
            autofocus: true,
            forceSync: true,
            status: false,
            toolbar: [
                "bold", "italic", "heading", "|",
                "unordered-list", "ordered-list", "|",
                "link", "image", "|",
                "preview", "side-by-side", "fullscreen"
            ]
        });
    });
});
</script>
<script src="/assets/easymde.min.js"></script>
</body>
</html>