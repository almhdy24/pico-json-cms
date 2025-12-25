<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->e($title ?? 'Installer') ?></title>

  <link rel="stylesheet" href="<?= $this->asset('themes/default/assets/css/style.css') ?>">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <?php $this->hook('head') ?>

  <style>
    .installer-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .installer-box {
    background: white;
    width: 100%;
    max-width: 520px;
    padding: 2rem;
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    }

    .installer-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
    font-size: 0.875rem;
    }

    .installer-step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    }

    .installer-step.active {
    color: var(--primary);
    font-weight: 600;
    }

    .installer-step.done {
    color: var(--success);
    }

    .installer-step i {
    width: 16px;
    height: 16px;
    }
  </style>
</head>
<body>

  <div class="installer-wrap">
    <div class="installer-box">

      <!-- Stepper -->
      <div class="installer-steps">
        <div class="installer-step <?= $step === 'system' ? 'active' : ($step !== 'system' ? 'done' : '') ?>">
          <i data-lucide="cpu"></i> System
        </div>
        <div class="installer-step <?= $step === 'admin' ? 'active' : ($step === 'finish' ? 'done' : '') ?>">
          <i data-lucide="user-cog"></i> Admin
        </div>
        <div class="installer-step <?= $step === 'finish' ? 'active' : '' ?>">
          <i data-lucide="check-circle"></i> Finish
        </div>
      </div>
      <?php $this->insert('partials/flash', ['flash' => $flash]) ?>
      <?= $this->section('content') ?>

    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>

  <?php $this->hook('body_end') ?>

</body>
</html>