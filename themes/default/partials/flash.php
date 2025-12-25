<?php
/**
* $flash is a list of messages:
* [
*   ['type' => 'error|success', 'message' => string],
*   ...
* ]
*/




if (!empty($flash)): ?>
<?php foreach ($flash as $msg): ?>
<div class="notification is-<?= $msg['type'] === 'error' ? 'danger' : 'success' ?>">
  <?= htmlspecialchars($msg['message'], ENT_QUOTES, 'UTF-8') ?>
</div>
<?php endforeach; ?>
<?php endif; ?>