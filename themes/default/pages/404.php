<?php $this->layout('layouts/site', ['title' => 'Page Not Found']) ?>

<section class="section has-text-centered" style="min-height: 60vh; display: flex; align-items: center; justify-content: center;">
  <div>
    <i data-lucide="alert-circle" style="width: 80px; height: 80px; color: var(--secondary); margin-bottom: 2rem;"></i>
    <h1 class="title is-1">404</h1>
    <p class="subtitle">Page not found</p>
    
    <!-- Add this line to display the message -->
    <?php if (isset($message)): ?>
      <p class="content" style="color: var(--text-light); margin-top: 1rem;">
        <em><?= htmlspecialchars($message) ?></em>
      </p>
    <?php endif; ?>
    
    <?php $this->hook('404_content') ?>

    <a href="<?= $this->route('/') ?>" class="button is-primary mt-4">
      <i data-lucide="home"></i>
      <span>Go Home</span>
    </a>
  </div>
</section>