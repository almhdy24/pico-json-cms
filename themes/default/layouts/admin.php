<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? "Admin") ?> - Admin Panel</title>

  <link rel="stylesheet" href="<?= $this->asset('themes/default/assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= $this->asset('themes/default/assets/css/admin.css') ?>">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <?php $this->hook('admin_head') ?>
</head>
<body class="admin">

  <nav class="admin-nav">
    <div class="container">
      <a href="/admin/dashboard" class="admin-nav-brand">
        <i data-lucide="layout-dashboard"></i>
        <span>Admin Panel</span>
      </a>

      <button class="navbar-burger admin-nav-burger" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>

      <div class="admin-nav-menu">
        <div class="admin-nav-items">

          <a class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'], 'dashboard') ? 'is-active' : '' ?>" href="/admin/dashboard">
            <i data-lucide="layout-dashboard"></i>
            <span>Dashboard</span>
          </a>

          <a class="admin-nav-item <?= $_SERVER['REQUEST_URI'] === '/admin' ? 'is-active' : '' ?>" href="/admin">
            <i data-lucide="file-text"></i>
            <span>Posts</span>
          </a>

          <a class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/admin/add') ? 'is-active' : '' ?>" href="/admin/add">
            <i data-lucide="plus-circle"></i>
            <span>Add New</span>
          </a>

          <a class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/admin/trash') ? 'is-active' : '' ?>" href="/admin/trash">
            <i data-lucide="trash-2"></i>
            <span>Trash</span>

            <?php if (!empty($trashCount)): ?>
            <span class="admin-badge"><?= (int) $trashCount ?></span>
            <?php endif; ?>
          </a>

          <a class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'], 'settings') ? 'is-active' : '' ?>" href="/admin/settings">
            <i data-lucide="settings"></i>
            <span>Settings</span>
          </a>

          <a class="admin-nav-item" href="/admin/system">
            <i data-lucide="info"></i>
            <span>System</span>
          </a>

          <a class="admin-nav-item" href="/admin/logout">
            <i data-lucide="log-out"></i>
            <span>Logout</span>
          </a>

        </div>
      </div>
    </div>
  </nav>

  <div class="admin-container">
    <?php $this->insert('partials/flash', ['flash' => $flash]) ?>
    <?= $this->section('content') ?>
  </div>

  <footer class="admin-footer">
    <div class="container">
      <p>
        Powered by <strong>pico-json-cms</strong> |
        <a href="https://github.com/almhdy24/pico-json-cms" target="_blank" rel="noopener noreferrer">
          <i data-lucide="github"></i> GitHub Repository
        </a> &copy; <?= date('Y') ?>
      </p>
    </div>
  </footer>

  <script>
    lucide.createIcons();

    document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.admin-nav-burger');
    const menu = document.querySelector('.admin-nav-menu');

    if (burger && menu) {
    burger.addEventListener('click', function () {
    burger.classList.toggle('active');
    menu.classList.toggle('active');
    });
    }
    });
  </script>

</body>
</html>