<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Nouveau devis</h1>
    <div class="subtitle">Contrat : <?= htmlspecialchars($contrat['titre']) ?></div>
  </div>
  <a href="/NAYLOTH/public/admin/contrat/show?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon" style="display:inline-flex; align-items:center;">Retour au contrat</a>
</div>

<div class="stat-card" style="max-width:480px;">

  <?php if (isset($erreur)): ?>
    <p style="color:#cc3333; font-size:13px; margin-bottom:20px;"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/admin/contrat/devis/create">

    <input type="hidden" name="contrat_id" value="<?= htmlspecialchars($contrat['id_contrat']) ?>">

    <div class="form-group">
      <label for="montant_ht">Montant HT (€)</label>
      <input type="number" id="montant_ht" name="montant_ht" step="0.01" min="0" value="<?= htmlspecialchars($_POST['montant_ht'] ?? '') ?>" required>
    </div>

    <div style="display:flex; gap:12px; margin-top:28px;">
      <button type="submit" class="btn-primary" style="font-size:14px;">Créer le devis</button>
      <a href="/NAYLOTH/public/admin/contrat/show?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon" style="display:inline-flex; align-items:center;">Annuler</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
