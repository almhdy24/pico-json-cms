<?php $this->layout('layouts/admin', ['title' => 'System']) ?>

<h1 class="title">System Information</h1>

<h2 class="subtitle">CMS</h2>
<ul>
  <li><strong>Name:</strong> <?= $system['cms']['name'] ?></li>
  <li><strong>Version:</strong> <?= $system['cms']['version'] ?></li>
  <li><strong>Storage:</strong> <?= $system['cms']['storage'] ?></li>
</ul>

<h2 class="subtitle">Environment</h2>
<ul>
  <li>PHP: <?= $system['env']['php_version'] ?> (<?= $system['env']['php_sapi'] ?>)</li>
  <li>OS: <?= $system['env']['os'] ?></li>
  <li>Timezone: <?= $system['env']['timezone'] ?></li>
  <li>Memory Limit: <?= $system['env']['memory'] ?></li>
</ul>

<h2 class="subtitle">Filesystem</h2>
<ul>
  <li>Content writable: <?= $system['paths']['content_writable'] ? 'Yes' : 'No' ?></li>
  <li>Logs writable: <?= $system['paths']['logs_writable'] ? 'Yes' : 'No' ?></li>
  <li>Root writable: <?= $system['paths']['root_writable'] ? 'Yes' : 'No' ?></li>
</ul>

<h2 class="subtitle">Plugins</h2>
<?php if (empty($system['plugins'])): ?>
  <p>No plugins loaded.</p>
<?php else: ?>
  <ul>
    <?php foreach ($system['plugins'] as $plugin): ?>
      <li><?= $plugin ?></li>
    <?php endforeach ?>
  </ul>
<?php endif ?>