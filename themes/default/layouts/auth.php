<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'Login') ?></title>
  <link rel="stylesheet" href="<?= $this->asset('themes/default/assets/css/style.css') ?>">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    .auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 1rem;
    }

    .auth-box {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: var(--shadow-lg);
    width: 100%;
    max-width: 400px;
    }

    .auth-logo {
    text-align: center;
    margin-bottom: 2rem;
    }

    .auth-logo i {
    width: 48px;
    height: 48px;
    color: var(--primary);
    }
  </style>
</head>
<body>

  <div class="auth-container">
    <div class="auth-box">
      <div class="auth-logo">
        <i data-lucide="shield"></i>
      </div>
      <?php $this->insert('partials/flash', ['flash' => $flash]) ?>
      <?= $this->section('content') ?>
    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>