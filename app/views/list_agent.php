<?php require_once __DIR__ . '/layout/header.php'; ?>


<div class="list-page">

 
  <div class="list-header">
    <div>
      <div class="list-title">Gestion des agents</div>
      <div class="list-subtitle"><?= count($agents) ?> agents au total</div>
    </div>
    <a href="/NAYLOTH/public/ajouter_agent" class="btn-primary">+ Ajouter un agent</a>
  </div>

  <div class="list-filters">
    <input type="text" class="filter-search" placeholder="Rechercher un agent..." />
    <select class="filter-select">
      <option>Tous les statuts</option>
      <option>Disponible</option>
      <option>Affecté</option>
    </select>
    <select class="filter-select">
      <option>Toutes compétences</option>
      <?php foreach ($competences as $comp): ?>
        <option><?= htmlspecialchars($comp['nom']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="list-card">
    <div class="list-card-header">
      <span class="list-card-title">Liste des agents</span>
      <span class="list-card-count"><?= count($agents) ?> agents</span>
    </div>

    <table class="list-table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>E-mail</th>
          <th>Compétences</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($agents as $agent): ?>
        <tr>
          <td class="agent-name"><?= htmlspecialchars($agent['nom'] . ', ' . $agent['prenom']) ?></td>
          <td class="agent-email"><?= htmlspecialchars($agent['email']) ?></td>
          <td>
            <?php foreach ($agent['competences'] as $comp): ?>
              <span class="tag"><?= htmlspecialchars($comp) ?></span>
            <?php endforeach; ?>
          </td>
          <td>
            <span class="badge <?= $agent['statut'] === 'Disponible' ? 'badge-dispo' : 'badge-assigned' ?>">
              <?= $agent['statut'] ?>
            </span>
          </td>
          <td>
            <a href="/NAYLOTH/public/agent/<?= $agent['id_user'] ?>" class="btn-voir">Voir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>