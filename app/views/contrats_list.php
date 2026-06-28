<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Contrats</h1>
    <div class="subtitle"><?= count($contrats) ?> contrat(s) enregistré(s)</div>
  </div>
  <a href="/NAYLOTH/public/admin/contrat/create" class="btn-primary">+ Nouveau contrat</a>
</div>

<div class="list-card">
  <div class="list-header">
    <h3>Liste des contrats</h3>
  </div>
  <div class="list-body">

    <?php if (empty($contrats)): ?>
      <p class="subtitle" style="padding: 16px 0;">Aucun contrat enregistré pour le moment.</p>

    <?php else: ?>

      <table class="list-table">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Client</th>
            <th>Statut</th>
            <th>Date de début</th>
            <th>Quota agents</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contrats as $contrat): ?>
            <?php
              $badgeStyle = match($contrat['statut_contrat']) {
                'actif'      => 'background:#EAF6FC; color:#1a7a9e;',
                'clos'       => 'background:#f5f5f5; color:#777777;',
                'annule'     => 'background:#fef2f2; color:#dc2626;',
                default      => 'background:#fff8e1; color:#f57f17;',
              };
            ?>
            <tr>
              <td class="agent-name"><?= htmlspecialchars($contrat['titre']) ?></td>
              <td class="agent-email"><?= htmlspecialchars($contrat['nom']) ?></td>
              <td>
                <span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:500; <?= $badgeStyle ?>">
                  <?= htmlspecialchars($contrat['statut_contrat']) ?>
                </span>
              </td>
              <td><?= htmlspecialchars($contrat['date_debut']) ?></td>
              <td><?= htmlspecialchars($contrat['quota_agents']) ?></td>
              <td style="display:flex; gap:8px; align-items:center;">
                <a href="/NAYLOTH/public/admin/contrat/show?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon">Voir</a>
                <?php if ($contrat['statut_contrat'] !== 'clos'): ?>
                  <a href="/NAYLOTH/public/admin/contrat/edit?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-icon">Modifier</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    <?php endif; ?>

  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
