<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Nouveau contrat</h1>
    <div class="subtitle">Remplissez les informations du contrat à créer.</div>
  </div>
  <a href="/NAYLOTH/public/admin/contrat" class="btn-icon" style="display:inline-flex; align-items:center;">Retour à la liste</a>
</div>

<div class="stat-card" style="max-width:620px;">

  <?php if (isset($erreur)): ?>
    <p style="color:#cc3333; font-size:13px; margin-bottom:20px;"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/admin/contrat/create">

    <div class="form-group">
      <label for="titre">Titre du contrat</label>
      <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" required>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="quota_agents">Quota agents</label>
        <input type="number" id="quota_agents" name="quota_agents" min="1" value="<?= htmlspecialchars($_POST['quota_agents'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label for="date_debut">Date de début</label>
        <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($_POST['date_debut'] ?? '') ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label for="client_id">Client</label>
      <select id="client_id" name="client_id" required>
        <option value="">-- Sélectionner un client --</option>
        <?php foreach ($clients as $client): ?>
          <option value="<?= htmlspecialchars($client['id_client']) ?>"
            <?= (($_POST['client_id'] ?? '') === $client['id_client']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($client['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="manager_id">Manager responsable</label>
      <select id="manager_id" name="manager_id" required>
        <option value="">-- Sélectionner un manager --</option>
        <?php foreach ($managers as $manager): ?>
          <option value="<?= htmlspecialchars($manager['id_user']) ?>"
            <?= (($_POST['manager_id'] ?? '') === $manager['id_user']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($manager['prenom'] . ' ' . $manager['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div style="display:flex; gap:12px; margin-top:28px;">
      <button type="submit" class="btn-primary" style="font-size:14px;">Créer le contrat</button>
      <a href="/NAYLOTH/public/admin/contrat" class="btn-icon" style="display:inline-flex; align-items:center;">Annuler</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
