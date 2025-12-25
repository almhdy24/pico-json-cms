<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->e($title ?? 'Pico JSON CMS') ?></title>
  
  <link rel="stylesheet" href="<?= $this->asset('themes/default/assets/css/style.css') ?>">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  
  <?php $this->hook('head') ?>
</head>
<body>

<?php $this->insert('partials/header') ?>

<main class="container">
<?php $this->insert('partials/flash', ['flash' => $flash]) ?>
  <?= $this->section('content') ?>
</main>

<?php $this->insert('partials/footer') ?>

<script>
  lucide.createIcons();
  
  // Mobile menu toggle
  document.addEventListener('DOMContentLoaded', function() {
    const burger = document.querySelector('.navbar-burger');
    const menu = document.querySelector('.navbar-menu');
    
    if (burger && menu) {
      burger.addEventListener('click', function() {
        burger.classList.toggle('active');
        menu.classList.toggle('active');
      });
    }
  });
</script>

<?php $this->hook('body_end') ?>

</body>
</html>