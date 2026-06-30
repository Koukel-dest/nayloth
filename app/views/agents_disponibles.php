<?php
$page_title = 'Agents disponibles';
$page_btn_label = '+ Créer une affectation';
$page_btn_url = '/NAYLOTH/public/ajouter_affectation';
require_once __DIR__ . '/layout/header.php';
?>

<div class="list-page">
  <div class="list-header">
    <div>
      <div class="list-title">Agents disponibles</div>
      <div class="list-subtitle"><?= count($agents) ?> agent(s) disponible(s)</div>
    </div>
  </div>

  <div class="list-card">
    <div class="list-card-header">
      <span class="list-card-title">Liste des agents disponibles</span>
      <span class="list-card-count"><?= count($agents) ?> résultat(s)</span>
    </div>

    <?php if (empty($agents)): ?>
      <p>Aucun agent disponible pour le moment.</p>
    <?php else: ?>
      <table class="list-table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Date d'entrée</th>
            <th>Compétences</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($agents as $agent): ?>
            <tr>
              <td class="agent-name"><?= htmlspecialchars($agent['prenom'] . ' ' . $agent['nom']) ?></td>
              <td class="agent-email"><?= htmlspecialchars($agent['email']) ?></td>
              <td><?= htmlspecialchars($agent['date_entree']) ?></td>
              <td>
                <?php foreach ($agent['competences'] as $comp): ?>
                  <span class="tag"><?= htmlspecialchars($comp) ?></span>
                <?php endforeach; ?>
              </td>
              <td>
                <a href="/NAYLOTH/public/ajouter_affectation?agent_id=<?= urlencode($agent['id_user']) ?>" class="btn-primary">Affecter</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
