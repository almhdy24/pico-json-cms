<?php
/**
 * Reusable Pagination Component
 *
 * Required variables:
 * - $currentPage (int)
 * - $totalPages (int)
 *
 * Optional:
 * - $basePath (string) → defaults to current path
 */

// Detect current path if not provided
$basePath = $basePath ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Helper to build page URLs safely
$pageUrl = function (int $page) use ($basePath) {
    return $this->route($basePath . '?page=' . $page);
};
?>

<?php if ($totalPages > 1): ?>
<nav class="pagination is-centered mt-4" role="navigation" aria-label="pagination">

  <!-- Previous -->
  <?php if ($currentPage > 1): ?>
    <a class="pagination-link"
       href="<?= $pageUrl($currentPage - 1) ?>">
      <i data-lucide="chevron-left"></i>
      <span>Previous</span>
    </a>
  <?php endif; ?>

  <!-- Page numbers -->
  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a class="pagination-link <?= $i === $currentPage ? 'is-current' : '' ?>"
       href="<?= $pageUrl($i) ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>

  <!-- Next -->
  <?php if ($currentPage < $totalPages): ?>
    <a class="pagination-link"
       href="<?= $pageUrl($currentPage + 1) ?>">
      <span>Next</span>
      <i data-lucide="chevron-right"></i>
    </a>
  <?php endif; ?>

</nav>
<?php endif; ?>