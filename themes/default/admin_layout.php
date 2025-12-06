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
    }
    .admin-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px;
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
            <a class="navbar-item" href="admin/logout">Logout</a>
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

    <?= $content ?>

</div>

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
});
</script>
<script src="/assets/easymde.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editors = document.querySelectorAll('.simple-editor');
    editors.forEach(textarea => {
        new EasyMDE({
            element: textarea,
            spellChecker: false,
            autofocus: true,
            forceSync: true,   // IMPORTANT: ensures textarea updates on submit
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
</body>
</html>