<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Modifier le devis</h1>
    <div class="subtitle">Contrat : <?= htmlspecialchars($contrat['titre']) ?></div>
  </div>
  <a href="/NAYLOTH/public/admin/contrat/show?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon" style="display:inline-flex; align-items:center;">Retour au contrat</a>
</div>

<div class="stat-card" style="max-width:480px;">

  <?php if (isset($erreur)): ?>
    <p style="color:#cc3333; font-size:13px; margin-bottom:20px;"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/admin/contrat/devis/edit">

    <input type="hidden" name="id_devis" value="<?= htmlspecialchars($devis['id_devis']) ?>">
    <input type="hidden" name="contrat_id" value="<?= htmlspecialchars($devis['contrat_id']) ?>">

    <div class="form-group">
      <label for="montant_ht">Montant HT (€)</label>
      <input type="number" id="montant_ht" name="montant_ht" step="0.01" min="0" value="<?= htmlspecialchars($devis['montant_ht']) ?>" required>
    </div>

    <div class="form-group">
      <label for="statut_devis">Statut</label>
      <select id="statut_devis" name="statut_devis" required>
        <?php foreach (['en_attente', 'accepte', 'refuse'] as $statut): ?>
          <option value="<?= $statut ?>" <?= $devis['statut_devis'] === $statut ? 'selected' : '' ?>>
            <?= $statut ?>
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
