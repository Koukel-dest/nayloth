<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($client['nom']) ?></h1>
    <div class="subtitle">Fiche client</div>
  </div>
  <div style="display:flex; gap:12px;">
    <a href="/NAYLOTH/public/admin/clients/edit?id=<?= urlencode($client['id_client']) ?>" class="btn-primary" style="font-size:14px; text-decoration:none; display:inline-flex; align-items:center;">Modifier</a>
    <a href="/NAYLOTH/public/admin/clients" class="btn-icon" style="display:inline-flex; align-items:center;">Retour à la liste</a>
  </div>
</div>

<div class="stat-card" style="max-width:560px;">

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Nom</span>
      <span class="item-title"><?= htmlspecialchars($client['nom']) ?></span>
    </div>
  </div>

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">SIRET</span>
      <span class="item-title"><?= htmlspecialchars($client['siret']) ?></span>
    </div>
  </div>

  <div class="list-item" style="border-bottom:none;">
    <div class="item-info">
      <span class="item-meta">Email de contact</span>
      <span class="item-title"><?= htmlspecialchars($client['contact_email']) ?></span>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
