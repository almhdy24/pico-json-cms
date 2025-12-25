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