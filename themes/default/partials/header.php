<header class="navbar">
  <div class="container">
    <div class="level">
      <div class="level-left">
        <a href="/" class="navbar-brand">
          <i data-lucide="home"></i>
          <span><?= $this->e($config['site_name'] ?? 'Pico CMS') ?></span>
        </a>
      </div>
      
      <button class="navbar-burger" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
      
      <div class="navbar-menu">
        <?php $this->hook('header_nav') ?>
      </div>
    </div>
  </div>
</header>