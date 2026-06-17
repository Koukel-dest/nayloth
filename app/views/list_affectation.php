<?php
$page_title = 'Affectations';
$page_btn_label = '+ Nouvelle affectation';
$page_btn_url = '/NAYLOTH/public/ajouter_affectation';
require_once __DIR__ . '/layout/header.php';
?>

<div class="list-page">

  <!-- TOPBAR -->
  <div class="list-header">
    <div>
      <div class="list-title">Affectations</div>
      <div class="list-subtitle"><?= count($affectations) ?> affectations au total</div>
    </div>
  </div>

  <!-- FILTRES -->
  <div class="list-filters">
    <input type="text" class="filter-search" placeholder="Rechercher..." />
    <select class="filter-select">
      <option>Tous les statuts</option>
      <option>Active</option>
      <option>Terminée</option>
      <option>Suspendue</option>
    </select>
  </div>


  <div class="list-card">
    <div class="list-card-header">
      <span class="list-card-title">Liste des affectations</span>
      <span class="list-card-count"><?= count($affectations) ?> affectations</span>
    </div>

    <table class="list-table">
      <thead>
        <tr>
          <th>Agent</th>
          <th>Client / Contrat</th>
          <th>Période</th>
          <th>Compétences</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($affectations as $affectation): ?>
        <tr>
          <td class="agent-name"><?= htmlspecialchars($affectation['agent_nom'] . ', ' . $affectation['agent_prenom']) ?></td>
          <td class="agent-email"><?= htmlspecialchars($affectation['contrat_titre']) ?></td>
          <td class="agent-email"><?= formatPeriode($affectation['date_debut'], $affectation['date_fin']) ?></td>
          <td>
            <?php foreach ($affectation['competences'] as $comp): ?>
              <span class="tag"><?= htmlspecialchars($comp) ?></span>
            <?php endforeach; ?>
          </td>
          <td>
            <?php
              $statut = $affectation['statut_affectation'];
              $badgeClass = match($statut) {
                  'active'    => 'badge-dispo',
                  'terminee'  => 'badge-assigned',
                  'suspendue' => 'badge-pending',
                  default     => 'badge-dispo',
              };
              $statutLabel = match($statut) {
                  'active'    => 'Active',
                  'terminee'  => 'Terminée',
                  'suspendue' => 'Suspendue',
                  default     => $statut,
              };
            ?>
            <span class="badge <?= $badgeClass ?>"><?= $statutLabel ?></span>
          </td>
          <td>
            <a href="/NAYLOTH/public/affectation_detail?id=<?= $affectation['id_affectation'] ?>" class="btn-voir">Voir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>