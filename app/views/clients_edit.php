<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Modifier le client</h1>
    <div class="subtitle"><?= htmlspecialchars($client['nom']) ?></div>
  </div>
  <a href="/NAYLOTH/public/admin/clients" class="btn-icon" style="display:inline-flex; align-items:center;">Retour à la liste</a>
</div>

<div class="stat-card" style="max-width:560px;">

  <?php if (isset($erreur)): ?>
    <p style="color:#cc3333; font-size:13px; margin-bottom:20px;"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/admin/clients/edit">

    <input type="hidden" name="id_client" value="<?= htmlspecialchars($client['id_client']) ?>">

    <div class="form-group">
      <label for="nom">Nom du client</label>
      <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>
    </div>

    <div class="form-group">
      <label for="siret">SIRET</label>
      <input type="text" id="siret" name="siret" value="<?= htmlspecialchars($client['siret']) ?>" required>
    </div>

    <div class="form-group">
      <label for="contact_email">Email de contact</label>
      <input type="email" id="contact_email" name="contact_email" value="<?= htmlspecialchars($client['contact_email']) ?>" required>
    </div>

    <div style="display:flex; gap:12px; margin-top:28px;">
      <button type="submit" class="btn-primary" style="font-size:14px;">Enregistrer</button>
      <a href="/NAYLOTH/public/admin/clients" class="btn-icon" style="display:inline-flex; align-items:center;">Annuler</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
