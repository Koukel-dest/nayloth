<?php
$page_title = 'Tableau de bord';
require_once __DIR__ . '/layout/header.php'; ?>

<div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:16px; margin-bottom:24px;">

  <div class="stat-card">
    <div class="stat-title">Affectations actives</div>
    <div class="stat-value"><?= $nb_affectations_actives ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Total affectations</div>
    <div class="stat-value"><?= $nb_affectations_total ?></div>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
