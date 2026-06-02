<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Nouveau client</h1>
    <div class="subtitle">Remplissez les informations du client à créer.</div>
  </div>
</div>

<div class="stat-card" style="max-width:560px;">

  <?php if (isset($erreur)): ?>
    <p style="color:#cc3333; font-size:13px; margin-bottom:20px;"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/admin/clients/create">

    <div class="form-group">
      <label for="nom">Nom du client</label>
      <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
    </div>

    <div class="form-group">
      <label for="siret">SIRET</label>
      <input type="text" id="siret" name="siret" value="<?= htmlspecialchars($_POST['siret'] ?? '') ?>" required>
    </div>

    <div class="form-group">
      <label for="contact_email">Email de contact</label>
      <input type="email" id="contact_email" name="contact_email" value="<?= htmlspecialchars($_POST['contact_email'] ?? '') ?>" required>
    </div>

    <div style="display:flex; gap:12px; margin-top:28px;">
      <button type="submit" class="btn-primary" style="font-size:14px;">Créer le client</button>
      <a href="/NAYLOTH/public/admin/clients" class="btn-icon" style="display:inline-flex; align-items:center;">Annuler</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
