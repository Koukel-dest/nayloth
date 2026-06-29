<?php
$page_title = 'Tableau de bord';
require_once __DIR__ . '/layout/header.php'; ?>

<div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:16px; margin-bottom:24px;">

  <div class="stat-card">
    <div class="stat-title">Mes contrats actifs</div>
    <div class="stat-value"><?= $nb_contrats_actifs ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Mes contrats en attente</div>
    <div class="stat-value"><?= $nb_contrats_attente ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Total mes contrats</div>
    <div class="stat-value"><?= $nb_contrats ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Agents actifs affectés</div>
    <div class="stat-value"><?= $nb_agents_actifs ?></div>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
