<?php
$page_title = 'Suivi des missions';
$page_btn_label = '';
$page_btn_url = '';
require_once __DIR__ . '/layout/header.php';
?>

<div class="list-page">
  <div class="list-header">
    <div>
      <div class="list-title">Suivi des missions</div>
      <div class="list-subtitle"><?= count($missions) ?> mission(s) enregistrée(s)</div>
    </div>
  </div>

  <div class="list-filters">
    <span class="tag">Actives : <?= $stats['active'] ?? 0 ?></span>
    <span class="tag">Terminées : <?= $stats['terminee'] ?? 0 ?></span>
    <span class="tag">Suspendues : <?= $stats['suspendue'] ?? 0 ?></span>
  </div>

  <div class="list-card">
    <div class="list-card-header">
      <span class="list-card-title">Historique des missions</span>
      <span class="list-card-count"><?= count($missions) ?> résultat(s)</span>
    </div>

    <?php if (empty($missions)): ?>
      <p>Aucune mission à afficher.</p>
    <?php else: ?>
      <table class="list-table">
        <thead>
          <tr>
            <th>Agent</th>
            <th>Contrat</th>
            <th>Période</th>
            <th>Compétences</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($missions as $mission): ?>
            <tr>
              <td class="agent-name"><?= htmlspecialchars($mission['agent_prenom'] . ' ' . $mission['agent_nom']) ?></td>
              <td><?= htmlspecialchars($mission['contrat_titre']) ?></td>
              <td><?= htmlspecialchars($mission['date_debut'] . ' → ' . $mission['date_fin']) ?></td>
              <td>
                <?php foreach ($mission['competences'] as $comp): ?>
                  <span class="tag"><?= htmlspecialchars($comp) ?></span>
                <?php endforeach; ?>
              </td>
              <td>
                <span class="badge">
                  <?= htmlspecialchars($mission['statut_affectation']) ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
