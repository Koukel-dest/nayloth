<?php
$page_title = 'Tableau de bord';
require_once __DIR__ . '/layout/header.php'; ?>

<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:24px;">

  <div class="stat-card">
    <div class="stat-title">Contrats actifs</div>
    <div class="stat-value"><?= $nb_contrats_actifs ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Contrats en attente</div>
    <div class="stat-value"><?= $nb_contrats_attente ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Total contrats</div>
    <div class="stat-value"><?= $nb_contrats ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Clients</div>
    <div class="stat-value"><?= $nb_clients ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Agents</div>
    <div class="stat-value"><?= $nb_agents ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Devis en attente</div>
    <div class="stat-value"><?= $nb_devis_attente ?></div>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
