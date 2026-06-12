<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Clients</h1>
    <div class="subtitle"><?= count($clients) ?> client(s) enregistré(s)</div>
  </div>
  <a href="/NAYLOTH/public/admin/clients/create" class="btn-primary">+ Nouveau client</a>
</div>

<div class="list-card">
  <div class="list-header">
    <h3>Liste des clients</h3>
  </div>
  <div class="list-body">

    <?php if (empty($clients)): ?>
      <p class="subtitle" style="padding: 16px 0;">Aucun client enregistré pour le moment.</p>

    <?php else: ?>
      <?php foreach ($clients as $client): ?>
        <div class="list-item">
          <div class="item-info">
            <span class="item-title"><?= htmlspecialchars($client['nom']) ?></span>
            <span class="item-meta"><?= htmlspecialchars($client['contact_email']) ?> — SIRET : <?= htmlspecialchars($client['siret']) ?></span>
          </div>
          <div style="display:flex; gap:8px; align-items:center;">
            <a href="/NAYLOTH/public/admin/clients/show?id=<?= urlencode($client['id_client']) ?>" class="btn-icon">Voir</a>
            <a href="/NAYLOTH/public/admin/clients/edit?id=<?= urlencode($client['id_client']) ?>" class="btn-icon">Modifier</a>
            <form method="POST" action="/NAYLOTH/public/admin/clients/delete" onsubmit="return confirm('Supprimer « <?= htmlspecialchars($client['nom'], ENT_QUOTES) ?> » ?')">
              <input type="hidden" name="id_client" value="<?= htmlspecialchars($client['id_client']) ?>">
              <button type="submit" class="btn-danger">Supprimer</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
