<?php require_once __DIR__ . '/layout/header.php'; ?>

<?php
  $badgeStyle = match($contrat['statut_contrat']) {
    'actif'  => 'background:#EAF6FC; color:#1a7a9e;',
    'clos'   => 'background:#f5f5f5; color:#777777;',
    'annule' => 'background:#fef2f2; color:#dc2626;',
    default  => 'background:#fff8e1; color:#f57f17;',
  };
?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($contrat['titre']) ?></h1>
    <div class="subtitle">Fiche contrat</div>
  </div>
  <div style="display:flex; gap:12px; align-items:center;">
    <?php if ($contrat['statut_contrat'] !== 'clos'): ?>
      <a href="/NAYLOTH/public/admin/contrat/edit?id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-primary" style="font-size:14px; display:inline-flex; align-items:center;">Modifier</a>
    <?php endif; ?>
    <?php if (file_exists(__DIR__ . '/../../storage/pdfs/contrat_' . $contrat['id_contrat'] . '.pdf')): ?>
      <a href="/NAYLOTH/public/admin/pdf?file=contrat_<?= urlencode($contrat['id_contrat']) ?>.pdf" target="_blank" class="btn-icon" style="display:inline-flex; align-items:center;">Télécharger le contrat PDF</a>
    <?php endif; ?>
    <a href="/NAYLOTH/public/admin/contrat" class="btn-icon" style="display:inline-flex; align-items:center;">Retour à la liste</a>
  </div>
</div>

<div class="stat-card" style="max-width:700px; margin-bottom:32px;">

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Titre</span>
      <span class="item-title"><?= htmlspecialchars($contrat['titre']) ?></span>
    </div>
  </div>

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Statut</span>
      <span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:500; margin-top:4px; <?= $badgeStyle ?>">
        <?= htmlspecialchars($contrat['statut_contrat']) ?>
      </span>
    </div>
  </div>

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Client</span>
      <span class="item-title"><?= htmlspecialchars($client['nom']) ?></span>
    </div>
  </div>

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Manager responsable</span>
      <span class="item-title"><?= htmlspecialchars($manager['prenom'] . ' ' . $manager['nom']) ?></span>
    </div>
  </div>

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Quota agents</span>
      <span class="item-title"><?= htmlspecialchars($contrat['quota_agents']) ?></span>
    </div>
  </div>

  <div class="list-item">
    <div class="item-info">
      <span class="item-meta">Date de début</span>
      <span class="item-title"><?= htmlspecialchars($contrat['date_debut']) ?></span>
    </div>
  </div>

  <?php if ($contrat['date_fin']): ?>
  <div class="list-item" style="border-bottom:none;">
    <div class="item-info">
      <span class="item-meta">Date de fin</span>
      <span class="item-title"><?= htmlspecialchars($contrat['date_fin']) ?></span>
    </div>
  </div>
  <?php endif; ?>

</div>

<!-- Section Devis -->
<div class="list-card" style="max-width:700px;">
  <div class="list-header">
    <h3>Devis associés</h3>
    <a href="/NAYLOTH/public/admin/contrat/devis/create?contrat_id=<?= urlencode($contrat['id_contrat']) ?>" class="btn-primary" style="font-size:13px; display:inline-flex; align-items:center; height:32px; padding:0 14px;">+ Nouveau devis</a>
  </div>
  <div class="list-body">

    <?php if (empty($devis)): ?>
      <p class="subtitle" style="padding:16px 0;">Aucun devis pour ce contrat.</p>

    <?php else: ?>
      <table class="list-table">
        <thead>
          <tr>
            <th>Montant HT</th>
            <th>Statut</th>
            <th>Créé le</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($devis as $d): ?>
            <?php
              $devisBadge = match($d['statut_devis']) {
                'accepte' => 'background:#f0fdf4; color:#16a34a;',
                'refuse'  => 'background:#fef2f2; color:#dc2626;',
                default   => 'background:#fff8e1; color:#f57f17;',
              };
            ?>
            <tr>
              <td class="agent-name"><?= number_format($d['montant_ht'], 2, ',', ' ') ?> €</td>
              <td>
                <span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:500; <?= $devisBadge ?>">
                  <?= htmlspecialchars($d['statut_devis']) ?>
                </span>
              </td>
              <td class="agent-email"><?= htmlspecialchars(date('d/m/Y', strtotime($d['cree_le']))) ?></td>
              <td style="display:flex; gap:8px; align-items:center;">
                <a href="/NAYLOTH/public/admin/contrat/devis/edit?id=<?= urlencode($d['id_devis']) ?>" class="btn-icon">Modifier</a>
                <?php if (file_exists(__DIR__ . '/../../storage/pdfs/devis_' . $d['id_devis'] . '.pdf')): ?>
                  <a href="/NAYLOTH/public/admin/pdf?file=devis_<?= urlencode($d['id_devis']) ?>.pdf" target="_blank" class="btn-icon">PDF</a>
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
