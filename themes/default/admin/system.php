<?php $this->layout('layouts/admin'); ?>

<h1 class="admin-title">
  <i data-lucide="activity"></i>
  System Information
</h1>

<div class="system-grid">

  <!-- Pico -->
  <section class="system-card">
    <header>
      <i data-lucide="package"></i>
      <h2>Pico JSON CMS</h2>
    </header>

    <ul class="system-list">
      <li>
        <span>Version</span>
        <strong><?= $this->e($pico['version']) ?></strong>
      </li>
      <li>
        <span>Base Path</span>
        <code><?= $this->e($pico['base_path']) ?></code>
      </li>
    </ul>
  </section>

  <!-- PHP -->
  <section class="system-card">
    <header>
      <i data-lucide="code"></i>
      <h2>PHP</h2>
    </header>

    <ul class="system-list">
      <li>
        <span>Version</span>
        <strong><?= $this->e($php['version']) ?></strong>
      </li>
      <li>
        <span>SAPI</span>
        <strong><?= $this->e($php['sapi']) ?></strong>
      </li>
    </ul>

    <details class="system-details">
      <summary>
        <i data-lucide="layers"></i>
        Loaded Extensions (<?= count($php['extensions']) ?>)
      </summary>

      <div class="badge-list">
        <?php foreach ($php['extensions'] as $ext): ?>
          <span class="badge"><?= $this->e($ext) ?></span>
        <?php endforeach; ?>
      </div>
    </details>
  </section>

  <!-- Plugins -->
  <section class="system-card">
    <header>
      <i data-lucide="plug"></i>
      <h2>Plugins</h2>
    </header>

    <?php if (empty($plugins)): ?>
      <p class="muted">
        <i data-lucide="alert-circle"></i>
        No plugins loaded
      </p>
    <?php else: ?>
      <ul class="plugin-list">
        <?php foreach ($plugins as $plugin): ?>
          <li>
            <i data-lucide="check-circle"></i>
            <?= $this->e($plugin) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>

  <!-- Server -->
  <section class="system-card">
    <header>
      <i data-lucide="server"></i>
      <h2>Server</h2>
    </header>

    <ul class="system-list">
      <li>
        <span>OS</span>
        <strong><?= $this->e($server['os']) ?></strong>
      </li>
      <li>
        <span>Time</span>
        <strong><?= $this->e($server['time']) ?></strong>
      </li>
    </ul>
  </section>

</div>