<?php $this->layout('layouts/installer', ['title' => 'Installation Complete']) ?>

<div class="box has-text-centered">
  <h2 class="title">
    <i data-lucide="check-circle"></i> Installation Complete
  </h2>

  <p>Your site is ready and secured.</p>

  <a class="button is-fullwidth mt-4" href="<?= $this->route('/admin/login') ?>">
    <i data-lucide="log-in"></i> Go to Admin Login
  </a>
</div>