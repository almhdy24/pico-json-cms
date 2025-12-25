<footer class="footer">
  <div class="container">
    <p>
      <i data-lucide="copyright"></i>
      <?= date('Y') ?>
      <?= $this->e($config['site_name'] ?? 'Pico CMS') ?>
    </p>

    <?php $this->hook('footer') ?>
  </div>
</footer>