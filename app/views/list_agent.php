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
    <form action="/NAYLOTH/public/Agents" method="get" class="search-form">
      <input type="text" name="q" class="filter-search" placeholder="Rechercher un agent..." value="<?= htmlspecialchars($searchTerm ?? '') ?>" />
      <select name="competence" class="filter-select">
        <option value="">Toutes compétences</option>
        <?php foreach ($competences as $comp): ?>
          <option value="<?= htmlspecialchars($comp['nom']) ?>" <?= isset($competenceTerm) && $competenceTerm === $comp['nom'] ? 'selected' : '' ?>><?= htmlspecialchars($comp['nom']) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn-primary">Rechercher</button>
    </form>
    <select class="filter-select">
      <option>Tous les statuts</option>
      <option>Disponible</option>
      <option>Affecté</option>
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
            <a href="/NAYLOTH/public/profil_agent?id=<?= $agent['id_user'] ?>" class="btn-voir">Voir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>