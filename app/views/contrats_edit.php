<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Modifier le contrat</h1>
    <div class="subtitle"><?= htmlspecialchars($contrat['titre']) ?></div>
  </div>
  <a href="/NAYLOTH/public/admin/contrat/show?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon" style="display:inline-flex; align-items:center;">Retour au contrat</a>
</div>

<div class="stat-card" style="max-width:620px;">

  <?php if (isset($erreur)): ?>
    <p style="color:#cc3333; font-size:13px; margin-bottom:20px;"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/admin/contrat/edit">

    <input type="hidden" name="id_contrat" value="<?= htmlspecialchars($contrat['id_contrat']) ?>">

    <div class="form-group">
      <label for="titre">Titre du contrat</label>
      <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($contrat['titre']) ?>" required>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="statut_contrat">Statut</label>
        <select id="statut_contrat" name="statut_contrat" required>
          <?php foreach (['en_attente', 'actif', 'clos', 'annule'] as $statut): ?>
            <option value="<?= $statut ?>" <?= $contrat['statut_contrat'] === $statut ? 'selected' : '' ?>>
              <?= $statut ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="quota_agents">Quota agents</label>
        <input type="number" id="quota_agents" name="quota_agents" min="1" value="<?= htmlspecialchars($contrat['quota_agents']) ?>" required>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="date_debut">Date de début</label>
        <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($contrat['date_debut']) ?>" required>
      </div>
      <div class="form-group">
        <label for="date_fin">Date de fin <span style="color:#999; font-size:12px;">(optionnelle)</span></label>
        <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($contrat['date_fin'] ?? '') ?>">
      </div>
    </div>

    <div class="form-group">
      <label for="client_id">Client</label>
      <select id="client_id" name="client_id" required>
        <?php foreach ($clients as $client): ?>
          <option value="<?= htmlspecialchars($client['id_client']) ?>"
            <?= $contrat['client_id'] === $client['id_client'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($client['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="manager_id">Manager responsable</label>
      <select id="manager_id" name="manager_id" required>
        <?php foreach ($managers as $manager): ?>
          <option value="<?= htmlspecialchars($manager['id_user']) ?>"
            <?= $contrat['manager_id'] === $manager['id_user'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($manager['prenom'] . ' ' . $manager['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div style="display:flex; gap:12px; margin-top:28px;">
      <button type="submit" class="btn-primary" style="font-size:14px;">Enregistrer</button>
      <a href="/NAYLOTH/public/admin/contrat/show?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon" style="display:inline-flex; align-items:center;">Annuler</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
